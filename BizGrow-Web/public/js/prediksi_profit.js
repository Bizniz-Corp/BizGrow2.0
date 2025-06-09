// public/js/prediksi_profit.js

$(document).ready(function () {
    const token = localStorage.getItem("token");
    const profitTableBody = $("#profitTableBody");
    const predictButton = $("#predictButton");
    const loadingOverlay = $("#loadingOverlay");
    const alertContainer = $("#alert-container");
    const echartsWrapper = $("#echartsContainerWrapper");
    const profitChartContainerDOM = document.getElementById('profitChartContainer');

    let profitChartInstance = null;
    let currentChartData = []; // Untuk menyimpan data yang sedang ditampilkan di chart

    function showAlert(message, type = 'danger', duration = 0) {
        alertContainer.html('');
        const alertId = 'alert-' + Date.now();
        const alertHtml = `<div class="alert alert-${type} alert-dismissible fade show" role="alert" id="${alertId}">
                            ${message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                         </div>`;
        alertContainer.append(alertHtml);
        if (duration > 0) {
            setTimeout(() => {
                $(`#${alertId}`).alert('close');
            }, duration);
        }
    }

    // Fungsi ini untuk menampilkan tanggal di tooltip (dd-mm-yyyy)
    // Asumsi input dateString adalah YYYY-MM-DD
    function formatDateForDisplay(dateString_YYYY_MM_DD) {
        if (!dateString_YYYY_MM_DD) return '-';
        try {
            const parts = dateString_YYYY_MM_DD.split('-'); // [YYYY, MM, DD]
            if (parts.length !== 3) return dateString_YYYY_MM_DD; // Format tidak sesuai
            return `${parts[2]}-${parts[1]}-${parts[0]}`; // dd-mm-yyyy
        } catch (e) {
            console.warn("Error formatting date for display:", dateString_YYYY_MM_DD, e);
            return dateString_YYYY_MM_DD;
        }
    }

    function formatCurrency(number) {
        if (isNaN(parseFloat(number))) return 'Rp0';
        return 'Rp' + Number(number).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
    }

    function renderProfitTable(dataItems) {
        profitTableBody.empty();
        if (!dataItems || dataItems.length === 0) {
            profitTableBody.html('<tr><td colspan="4">Tidak ada data untuk ditampilkan.</td></tr>');
            return;
        }
        let rows = "";
        // Sort data by date, JavaScript Date object akan mem-parse YYYY-MM-DD dengan benar
        dataItems.sort((a, b) => new Date(a.date) - new Date(b.date));
        dataItems.forEach((item, index) => {
            const profit = item.Profit_Per_Day;
            let statusText = 'Data';
            let statusClass = 'secondary';
            if (item.type === 'historical_db') {
                statusText = 'Historis (DB)';
                statusClass = 'historical-db';
            } else if (item.type === 'historical_model') {
                statusText = 'Historis (Model)';
                statusClass = 'historical-model';
            } else if (item.type === 'predicted_model' || item.type === 'predicted') {
                statusText = 'Prediksi (Model)';
                statusClass = 'predicted';
            }
            rows += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${formatDateForDisplay(item.date)}</td>
                    <td>${formatCurrency(profit)}</td>
                    <td><span class="badge bg-${statusClass}">${statusText}</span></td>
                </tr>
            `;
        });
        profitTableBody.html(rows);
    }

    function initOrUpdateProfitChart(newChartData) {
        currentChartData = newChartData; // Simpan data terbaru
        console.log("initOrUpdateProfitChart CALLED with new data count:", newChartData.length);

        if (!profitChartContainerDOM) {
            console.error("Elemen kontainer chart ECharts (#profitChartContainer) tidak ditemukan!");
            return;
        }
        if (typeof echarts === 'undefined') {
            console.error("ECharts library is NOT defined!");
            return;
        }

        if (echartsWrapper.is(':hidden')) {
            console.log("Showing echartsContainerWrapper BEFORE init...");
            echartsWrapper.show();
        }

        setTimeout(function() {
            console.log("Attempting to init/update ECharts inside setTimeout...");

            if (profitChartInstance) {
                profitChartInstance.dispose();
                profitChartInstance = null;
                console.log("Previous ECharts instance disposed for update.");
            }

            try {
                profitChartInstance = echarts.init(profitChartContainerDOM);
                console.log("ECharts instance created/recreated inside setTimeout.");

                // Asumsi newChartData.date adalah YYYY-MM-DD
                const historicalData = newChartData.filter(item => item.type && (item.type.startsWith('historical_db') || item.type.startsWith('historical_model')));
                const predictedData = newChartData.filter(item => item.type && (item.type.startsWith('predicted_model') || item.type.startsWith('predicted')));

                historicalData.sort((a, b) => new Date(a.date) - new Date(b.date));
                predictedData.sort((a, b) => new Date(a.date) - new Date(b.date));
                
                // Siapkan data untuk ECharts: array [tanggal, nilai]
                // Ini lebih robust jika ada missing dates di salah satu series
                const seriesHistoricalData = historicalData.map(item => [item.date, parseFloat(item.Profit_Per_Day) || 0]);
                const seriesPredictedData = predictedData.map(item => [item.date, parseFloat(item.Profit_Per_Day) || 0]);

                console.log("Historical Series Data Points:", seriesHistoricalData.length);
                console.log("Predicted Series Data Points:", seriesPredictedData.length);

                const option = {
                    tooltip: {
                        trigger: 'axis',
                        formatter: function (params) {
                            if (!params || params.length === 0 || !params[0].value) return ''; // params[0].value adalah [tanggal, nilai]
                            let tooltipText = formatDateForDisplay(params[0].value[0]) + '<br/>'; // Ambil tanggal dari value
                            params.forEach(function (item) {
                                if(item.value && item.value[1] !== undefined && item.value[1] !== null){ // Hanya tampilkan jika ada nilai
                                    tooltipText += item.marker + item.seriesName + ': ' + formatCurrency(item.value[1]) + '<br/>'; // Ambil nilai profit
                                }
                            });
                            return tooltipText;
                        }
                    },
                    legend: {
                        data: ['Profit Historis', 'Profit Prediksi'],
                        bottom: 0
                    },
                    grid: {
                        left: '3%', right: '4%', bottom: '15%', containLabel: true
                    },
                    xAxis: {
                        type: 'time', // Gunakan tipe 'time' karena data kita punya tanggal spesifik
                        boundaryGap: false,
                        axisLabel: {
                            show: false // Sembunyikan label sumbu X (sesuai permintaan awal)
                                        // Nanti bisa dikonfigurasi untuk format tanggal
                        }
                        // 'data' tidak diperlukan jika type: 'time' dan series.data adalah [tanggal, nilai]
                    },
                    yAxis: {
                        type: 'value',
                        name: 'Profit (Rp)',
                        axisLabel: {
                            formatter: function (value) { return 'Rp' + (value / 1000) + 'K'; }
                        }
                    },
                    series: [
                        {
                            name: 'Profit Historis',
                            type: 'line',
                            smooth: true,
                            data: seriesHistoricalData, // Format: [[date1, value1], [date2, value2], ...]
                            itemStyle: { color: '#0d6efd' },
                            areaStyle: {
                                color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                                    offset: 0, color: 'rgba(13, 110, 253, 0.3)'
                                }, {
                                    offset: 1, color: 'rgba(13, 110, 253, 0)'
                                }])
                            },
                            connectNulls: true
                        },
                        {
                            name: 'Profit Prediksi',
                            type: 'line',
                            smooth: true,
                            data: seriesPredictedData, // Format: [[date1, value1], [date2, value2], ...]
                            itemStyle: { color: '#198754' },
                            lineStyle: {
                                width: 2,
                                type: 'dashed'
                            },
                            connectNulls: true
                        }
                    ]
                };

                if(seriesHistoricalData.length === 0 && seriesPredictedData.length === 0){
                    console.warn("Both historical and predicted data are empty. Chart might not render series.");
                }

                profitChartInstance.setOption(option, true);
                console.log("ECharts option set successfully with historical and predicted series (time axis).");

            } catch (e) {
                console.error("Error during ECharts init/setOption inside setTimeout:", e);
            }
        }, 50);

        $(window).off('resize.echarts').on('resize.echarts', function(){
            if (profitChartInstance) {
                profitChartInstance.resize();
            }
        });
    }


    function loadInitialDailyProfitData() {
        loadingOverlay.removeClass("hidden");
        alertContainer.html('');
        $.ajax({
            url: "/api/daily-sales-summary",
            method: "GET",
            headers: { "Authorization": `Bearer ${token}`, "Accept": "application/json" },
            success: function (response) {
                if (response.success && response.data) {
                    renderProfitTable(response.data);
                    if (response.data.length > 0) {
                        initOrUpdateProfitChart(response.data);
                    } else {
                        echartsWrapper.hide();
                    }
                } else {
                    showAlert(response.message || "Gagal memuat data profit historis awal.");
                    profitTableBody.html('<tr><td colspan="4">Gagal memuat data.</td></tr>');
                    echartsWrapper.hide();
                }
            },
            error: function (xhr) {
                console.error("Failed to fetch daily profit summary:", xhr.responseText);
                const errorMsg = xhr.responseJSON?.message || xhr.statusText || 'Tidak dapat mengambil data profit historis.';
                showAlert(`Error ${xhr.status}: ${errorMsg}`);
                profitTableBody.html(`<tr><td colspan="4">Error memuat data: ${errorMsg}</td></tr>`);
                echartsWrapper.hide();
            },
            complete: function () {
                loadingOverlay.addClass("hidden");
            }
        });
    }

    predictButton.on("click", function () {
        if (!token) {
            showAlert("Token autentikasi tidak ditemukan. Silakan login kembali.");
            return;
        }
        alertContainer.html('');
        loadingOverlay.removeClass("hidden");

        $.ajax({
            url: "/api/request-profit-predictions",
            method: "GET",
            headers: { "Authorization": `Bearer ${token}`, "Accept": "application/json" },
            success: function (response) {
                if (response.success && response.data) {
                    showAlert("Prediksi berhasil diterima!", "success", 5000);
                    renderProfitTable(response.data); // Update tabel
                    if (response.data.length > 0) {
                        initOrUpdateProfitChart(response.data); // Update chart dengan data baru
                    } else {
                        console.warn("Data prediksi kosong, chart tidak diupdate dengan data baru.");
                        // Jika ingin chart dikosongkan/disembunyikan saat data prediksi kosong:
                        // if (profitChartInstance) { profitChartInstance.dispose(); profitChartInstance = null; }
                        // echartsWrapper.hide();
                    }
                } else {
                    showAlert(response.message || "Gagal mendapatkan prediksi.");
                }
            },
            error: function (xhr) {
                console.error("Failed to get predictions:", xhr.responseText);
                const errorMsg = xhr.responseJSON?.message || xhr.statusText || 'Gagal menghubungi layanan prediksi.';
                showAlert(`Error ${xhr.status}: ${errorMsg}`);
            },
            complete: function () {
                loadingOverlay.addClass("hidden");
            }
        });
    });

    // Inisialisasi
    if (token) {
        loadInitialDailyProfitData();
    } else {
        showAlert("Token autentikasi tidak ditemukan. Tidak dapat memuat data.");
        profitTableBody.html('<tr><td colspan="4">Silakan login untuk melihat data.</td></tr>');
        loadingOverlay.addClass("hidden");
        echartsWrapper.hide();
    }
});