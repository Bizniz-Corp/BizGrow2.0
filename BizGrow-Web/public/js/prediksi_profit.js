// public/js/prediksi_profit.js

$(document).ready(function () {
    const token = localStorage.getItem("token");
    const profitTableBody = $("#profitTableBody");
    const predictButton = $("#predictButton");
    const loadingOverlay = $("#loadingOverlay");
    const alertContainer = $("#alert-container");
    // const chartContainer = $("#chartContainer"); // Komentari atau hapus jika tidak digunakan lagi
    const echartsWrapper = $("#echartsContainerWrapper"); // Wrapper div untuk chart ECharts
    const profitChartContainerDOM = document.getElementById('profitChartContainer'); // DOM elemen untuk ECharts

    let profitChartInstance = null; // Variabel untuk menyimpan instance chart

    // ... (fungsi showAlert, formatDateForDisplay, formatCurrency, renderProfitTable tetap sama) ...
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

    function formatDateForDisplay(dateString) {
        if (!dateString) return '-';
        try {
            const parts = dateString.split('-');
            if (parts.length !== 3) return dateString;
            return `${parts[2]}-${parts[1]}-${parts[0]}`;
        } catch (e) {
            console.warn("Error formatting date:", dateString, e);
            return dateString;
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
            } else if (item.type === 'predicted_model' || item.type === 'predicted') { // Menyesuaikan dengan kemungkinan type
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

    // --- FUNGSI BARU UNTUK ECHARTS ---
    function initOrUpdateProfitChart(chartData) {
        console.log("initOrUpdateProfitChart CALLED with data:", chartData);
        if (!profitChartContainerDOM) {
            console.error("Elemen kontainer chart ECharts tidak ditemukan!");
            return;
        }
        if (typeof echarts === 'undefined') {
            console.error("ECharts library is NOT defined at the moment of initOrUpdateProfitChart call!"); // DEBUG
            return;
        }

        // Olah data untuk ECharts
        // ECharts membutuhkan array tanggal untuk xAxis dan array nilai untuk series.data
        const dates = chartData.map(item => item.date); // Format YYYY-MM-DD
        const profits = chartData.map(item => parseFloat(item.Profit_Per_Day) || 0);

        console.log("Chart Dates:", dates); // DEBUG
        console.log("Chart Profits:", profits); // DEBUG

        const option = {
            tooltip: {
                trigger: 'axis', // Tooltip muncul saat hover di sumbu/data point
                formatter: function (params) { // Kustomisasi format tooltip
                    let tooltipText = formatDateForDisplay(params[0].name) + '<br/>'; // params[0].name adalah tanggal
                    params.forEach(function (item) {
                        tooltipText += item.marker + item.seriesName + ': ' + formatCurrency(item.value) + '<br/>';
                    });
                    return tooltipText;
                }
            },
            grid: { // Memberi padding agar label tidak terpotong
                left: '3%',
                right: '4%',
                bottom: '10%', // Beri ruang lebih untuk dataZoom nanti
                containLabel: true
            },
            xAxis: {
                type: 'category',
                boundaryGap: false, // Garis mulai dari tepi
                data: dates,
                axisLabel: {
                    show: false // Sembunyikan label sumbu X untuk sementara (sesuai permintaan)
                }
            },
            yAxis: {
                type: 'value',
                name: 'Profit (Rp)',
                axisLabel: {
                    formatter: function (value) {
                        return 'Rp' + (value / 1000) + 'K'; // Format nilai Y (misal: Rp100K)
                    }
                }
            },
            series: [
                {
                    name: 'Profit Harian',
                    type: 'line',
                    smooth: true, // Membuat garis lebih halus
                    data: profits,
                    itemStyle: { // Warna garis
                        color: '#0d6efd' // Biru Bootstrap primer
                    },
                    areaStyle: { // Memberi sedikit area di bawah garis (opsional)
                        color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                            offset: 0,
                            color: 'rgba(13, 110, 253, 0.3)'
                        }, {
                            offset: 1,
                            color: 'rgba(13, 110, 253, 0)'
                        }])
                    }
                }
            ],
            // Kita akan tambahkan dataZoom di sini nanti untuk filter & zoom
        };



        if (!profitChartInstance) {
            console.log("Initializing new ECharts instance..."); // DEBUG
            try {
                profitChartInstance = echarts.init(profitChartContainerDOM);
            } catch (e) {
                console.error("Error initializing ECharts:", e); // DEBUG
                return;
            }
        } else {
            console.log("Updating existing ECharts instance..."); // DEBUG
        }
        // Set opsi ke chart (akan merender atau mengupdate)
        try {
            profitChartInstance.setOption(option);
            console.log("ECharts option set successfully."); // DEBUG
        } catch (e) {
            console.error("Error setting ECharts option:", e); // DEBUG
            return;
        }

        // Tampilkan container chart
        // echartsWrapper.show();
        console.log("echartsContainerWrapper shown."); // DEBUG

        // Handle window resize untuk chart responsif
        $(window).on('resize', function(){
            if (profitChartInstance) {
                profitChartInstance.resize();
            }
        });
    }
    // --- AKHIR FUNGSI BARU UNTUK ECHARTS ---


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
                    // Panggil fungsi untuk render chart dengan data historis awal
                    if (response.data.length > 0) {
                        initOrUpdateProfitChart(response.data);
                    } else {
                        echartsWrapper.hide(); // Sembunyikan chart jika tidak ada data
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
        // echartsWrapper.hide(); // Untuk sementara, jangan sembunyikan chart saat prediksi

        $.ajax({
            url: "/api/request-profit-predictions",
            method: "GET",
            headers: { "Authorization": `Bearer ${token}`, "Accept": "application/json" },
            success: function (response) {
                if (response.success && response.data) {
                    showAlert("Prediksi berhasil diterima!", "success", 5000);
                    renderProfitTable(response.data);
                    // Untuk step ini, kita BELUM mengupdate chart dengan data prediksi
                    // Jika Anda ingin chart tetap menampilkan data historis awal:
                    // 1. Pastikan data historis awal tersimpan di variabel global jika perlu.
                    // 2. Atau, jika initOrUpdateProfitChart dipanggil hanya sekali di loadInitialDailyProfitData, chart akan tetap.
                    // Untuk sekarang, chart akan tetap menampilkan data dari loadInitialDailyProfitData.
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