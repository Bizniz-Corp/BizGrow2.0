// public/js/prediksi_profit.js

$(document).ready(function () {
    const token = localStorage.getItem("token");
    const profitTableBody = $("#profitTableBody");
    const predictButton = $("#predictButton");
    const loadingOverlay = $("#loadingOverlay");
    const alertContainer = $("#alert-container");
    const echartsWrapper = $("#echartsContainerWrapper");
    const profitChartContainerDOM = document.getElementById('profitChartContainer');

    const chartFilterControls = $("#chartFilterControls");
    const filterStartYear = $("#filterStartYear");
    const filterStartMonth = $("#filterStartMonth");
    const filterEndYear = $("#filterEndYear");
    const filterEndMonth = $("#filterEndMonth");
    const applyChartFilterButton = $("#applyChartFilterButton");
    const resetChartFilterButton = $("#resetChartFilterButton");

    let profitChartInstance = null;
    let currentChartData = []; 

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
        dataItems.sort((a, b) => new Date(a.date) - new Date(b.date)); // Asumsi a.date adalah YYYY-MM-DD
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

    function populateMonthDropdown(selectElement) {
        const months = [
            { value: 1, name: 'Januari' }, { value: 2, name: 'Februari' },
            { value: 3, name: 'Maret' }, { value: 4, name: 'April' },
            { value: 5, name: 'Mei' }, { value: 6, name: 'Juni' },
            { value: 7, name: 'Juli' }, { value: 8, name: 'Agustus' },
            { value: 9, name: 'September' }, { value: 10, name: 'Oktober' },
            { value: 11, name: 'November' }, { value: 12, name: 'Desember' }
        ];
        const currentValue = selectElement.val(); // Simpan nilai saat ini jika ada
        selectElement.empty();
        months.forEach(month => {
            selectElement.append(new Option(month.name, month.value));
        });
        if(currentValue) selectElement.val(currentValue); // Kembalikan nilai jika ada
    }

    function populateYearDropdowns() { // Menggunakan currentChartData secara global
        if (!currentChartData || currentChartData.length === 0) {
            filterStartYear.empty().append(new Option("Pilih Tahun", ""));
            filterEndYear.empty().append(new Option("Pilih Tahun", ""));
            return;
        }
        // Asumsi currentChartData[i].date adalah YYYY-MM-DD
        const years = [...new Set(currentChartData.map(item => new Date(item.date).getFullYear()))].sort((a, b) => a - b);

        const currentStartYear = filterStartYear.val();
        const currentEndYear = filterEndYear.val();

        filterStartYear.empty();
        filterEndYear.empty();

        if (years.length > 0) {
            years.forEach(year => {
                filterStartYear.append(new Option(year, year));
                filterEndYear.append(new Option(year, year));
            });
            filterStartYear.val(currentStartYear || years[0]);
            filterEndYear.val(currentEndYear || years[years.length - 1]);
        } else {
            filterStartYear.append(new Option("Pilih Tahun", ""));
            filterEndYear.append(new Option("Pilih Tahun", ""));
        }
    }

    function initOrUpdateProfitChart(sourceData, isFilterAction = false, isNewDataSource = false) {
        if (isNewDataSource) {
            currentChartData = [...sourceData]; 
            console.log("Master chart data UPDATED. Count:", currentChartData.length);
            populateYearDropdowns(); 
            if (!isFilterAction) {
                filterStartMonth.val(1);
                filterEndMonth.val(12);
            }
            chartFilterControls.show();
        }

        let dataToRender = [...currentChartData];

        const startYearVal = filterStartYear.val();
        const startMonthVal = filterStartMonth.val();
        const endYearVal = filterEndYear.val();
        const endMonthVal = filterEndMonth.val();

        if (startYearVal && startMonthVal && endYearVal && endMonthVal) {
            const startYear = parseInt(startYearVal);
            const startMonth = parseInt(startMonthVal);
            const endYear = parseInt(endYearVal);
            const endMonth = parseInt(endMonthVal);

            const startDateFilter = new Date(startYear, startMonth - 1, 1);
            const endDateFilter = new Date(endYear, endMonth, 0); 

            console.log("Filter Range: ", startDateFilter.toLocaleDateString(), "-", endDateFilter.toLocaleDateString());

            if (startDateFilter > endDateFilter) {
                if (isFilterAction) {
                    showAlert("Rentang filter tidak valid: Tanggal akhir harus setelah atau sama dengan tanggal mulai.", "warning", 5000);
                }
                dataToRender = [...currentChartData];
            } else {
                dataToRender = currentChartData.filter(item => {
                    const itemDate = new Date(item.date); 
                    return itemDate >= startDateFilter && itemDate <= endDateFilter;
                });
            }
        }
        
        console.log("Data to render in chart (count):", dataToRender.length);

        if (!profitChartContainerDOM) { console.error("Chart container not found!"); return; }
        if (typeof echarts === 'undefined') { console.error("ECharts not defined!"); return; }
        if (echartsWrapper.is(':hidden') && dataToRender.length > 0) { echartsWrapper.show(); }


        setTimeout(function() {
            if (profitChartInstance) {
                profitChartInstance.dispose();
                profitChartInstance = null;
            }
            try {
                profitChartInstance = echarts.init(profitChartContainerDOM);

                const historicalData = dataToRender.filter(item => item.type && (item.type.startsWith('historical_db') || item.type.startsWith('historical_model')));
                const predictedData = dataToRender.filter(item => item.type && (item.type.startsWith('predicted_model') || item.type.startsWith('predicted')));

                // historicalData.sort((a, b) => new Date(a.date) - new Date(b.date));
                // predictedData.sort((a, b) => new Date(a.date) - new Date(b.date));

                const seriesHistoricalData = historicalData.map(item => [item.date, parseFloat(item.Profit_Per_Day) || 0]);
                const seriesPredictedData = predictedData.map(item => [item.date, parseFloat(item.Profit_Per_Day) || 0]);

                let xAxisCategories = []; // Ini akan berisi tanggal YYYY-MM-DD untuk setiap titik data
                let seriesHistoricalMapped = [];
                let seriesPredictedMapped = [];

                if (dataToRender.length > 0) {
                    // 1. Dapatkan semua tanggal unik dari data yang akan dirender, diurutkan
                    xAxisCategories = [...new Set(dataToRender.map(item => item.date))].sort((a,b) => new Date(a) - new Date(b));

                    // 2. Petakan data historis dan prediksi ke xAxisCategories
                    seriesHistoricalMapped = xAxisCategories.map(categoryDate => {
                        const foundItem = historicalData.find(hd => hd.date === categoryDate);
                        return foundItem ? parseFloat(foundItem.Profit_Per_Day) || 0 : null;
                    });
                    seriesPredictedMapped = xAxisCategories.map(categoryDate => {
                        const foundItem = predictedData.find(pd => pd.date === categoryDate);
                        return foundItem ? parseFloat(foundItem.Profit_Per_Day) || 0 : null;
                    });
                }
                const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                let lastDisplayedMonthYear_intervalTracker = {};
                let lastDisplayedMonthYear = null;

                const option = {
                    tooltip: {
                        trigger: 'axis',
                        formatter: function (params) {
                            if (!params || params.length === 0) return '';
                            let tooltipText = formatDateForDisplay(params[0].name) + '<br/>';
                            params.forEach(function (item) {
                                if (item.value !== undefined && item.value !== null) {
                                    tooltipText += item.marker + item.seriesName + ': ' + formatCurrency(item.value) + '<br/>';
                                }
                            });
                            return tooltipText;
                        }
                    },
                    legend: { data: ['Profit Historis', 'Profit Prediksi'], bottom: 0 },
                    grid: { left: '3%', right: '4%', bottom: '20%', containLabel: true },
                    xAxis: {
                        type: 'category',
                        data: xAxisCategories,
                        boundaryGap: false,
                        axisLabel: {
                            show: true,
                            interval: function (index, value) {
                                const date = new Date(value);
                                const year = date.getFullYear(); // Deklarasikan year di sini
                                const month = date.getMonth();   // Deklarasikan month di sini
                                const day = date.getDate();
                                const currentMonthYearKey = `${year}-${month}`;

                                // Logika untuk menampilkan label hanya sekali per bulan, idealnya di awal bulan
                                // atau pada titik yang representatif jika awal bulan tidak ada.
                                if (!lastDisplayedMonthYear_intervalTracker[currentMonthYearKey]) {
                                     // Jika data point pertama, atau tanggal 1, atau awal dari data jika bulan belum dilabeli
                                    if (index === 0 || day === 1) {
                                        return true;
                                    }
                                    // Jika ini adalah data terakhir dan bulan ini belum dilabeli, tampilkan
                                    if (index === xAxisCategories.length - 1) {
                                        return true;
                                    }
                                    if (day === 1) return true;
                                    if (index === 0) return true;
                                    if (index === xAxisCategories.length - 1 && xAxisCategories.length > 1) { 
                                        // Cek apakah bulan terakhir ini sudah diwakili oleh label tanggal 1
                                        let foundLabelForLastMonth = false;
                                        for(let i=0; i < index; i++){
                                            const d = new Date(xAxisCategories[i]);
                                            if(d.getFullYear() === year && d.getMonth() === month && d.getDate() === 1){
                                                foundLabelForLastMonth = true;
                                                break;
                                            }
                                        }
                                        return !foundLabelForLastMonth;
                                    }

                                    return false; // Sembunyikan label lainnya secara default
                                }
                                return false; // Bulan sudah ditandai oleh interval tracker
                            },
                            formatter: function (value) { // value adalah tanggal YYYY-MM-DD
                                const date = new Date(value);
                                const year = date.getFullYear();
                                const month = date.getMonth();
                                const currentMonthYearKey = `${year}-${month}`;

                                // `lastDisplayedMonthYear` (dari scope luar setTimeout) akan digunakan di sini
                                // untuk memastikan teks label hanya dibuat sekali per bulan.
                                if (lastDisplayedMonthYear !== currentMonthYearKey) {
                                    lastDisplayedMonthYear = currentMonthYearKey;
                                    return monthNames[month] + '\n' + year;
                                }
                                return '';
                            }
                        },
                        axisTick: {
                            alignWithLabel: true
                        }
                    },
                    yAxis: { type: 'value', name: 'Profit (Rp)', axisLabel: { formatter: function (value) { return 'Rp' + (value / 1000) + 'K'; } } },
                    series: [
                        { name: 'Profit Historis', type: 'line', smooth: true, data: seriesHistoricalMapped, itemStyle: { color: '#0d6efd' }, areaStyle: { color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{ offset: 0, color: 'rgba(13, 110, 253, 0.3)' }, { offset: 1, color: 'rgba(13, 110, 253, 0)' }]) }, connectNulls: true },
                        { name: 'Profit Prediksi', type: 'line', smooth: true, data: seriesPredictedMapped, itemStyle: { color: '#198754' }, lineStyle: { width: 2, type: 'dashed' }, connectNulls: true }
                    ]
                };
                
                if(dataToRender.length === 0){
                    console.warn("No data to render after filtering. Chart will be empty.");
                    option.series[0].data = [];
                    option.series[1].data = [];
                    if (currentChartData.length > 0) {
                        const allDatesOriginal = currentChartData.map(d => d.date).sort((a,b) => new Date(a) - new Date(b));
                        option.xAxis.min = allDatesOriginal[0];
                        option.xAxis.max = allDatesOriginal[allDatesOriginal.length - 1];
                    } else { 
                        const today = new Date();
                        const yesterday = new Date(today);
                        yesterday.setDate(today.getDate() -1);
                        option.xAxis.min = yesterday.toISOString().split('T')[0];
                        option.xAxis.max = today.toISOString().split('T')[0];
                    }
                }
                
                lastDisplayedMonthYear = null;
                profitChartInstance.setOption(option, true);
                console.log("ECharts option set/updated.");

            } catch (e) { console.error("Error in ECharts init/setOption:", e); }
        }, 50);

        $(window).off('resize.echarts').on('resize.echarts', function(){ if (profitChartInstance) { profitChartInstance.resize(); } });
    }

    applyChartFilterButton.on("click", function() {
        if (currentChartData.length > 0) {
            initOrUpdateProfitChart(currentChartData, true, false); 
        } else {
            showAlert("Tidak ada data untuk difilter.", "info", 3000);
        }
    });

    resetChartFilterButton.on("click", function() {
        if (currentChartData.length > 0) {
            populateYearDropdowns(); // Ini akan set default tahun
            filterStartMonth.val(1);
            filterEndMonth.val(12);
            initOrUpdateProfitChart(currentChartData, false, false); // isFilterAction=false, isNewDataSource=false
        }
    });


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
                        initOrUpdateProfitChart(response.data, false, true);
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
                chartFilterControls.hide();
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
                        initOrUpdateProfitChart(response.data, false, true); // Update chart dengan data baru
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
        populateMonthDropdown(filterStartMonth);
        populateMonthDropdown(filterEndMonth);
        filterStartMonth.val(1); // Default Januari
        filterEndMonth.val(12); // Default Desember
    } else {
        showAlert("Token autentikasi tidak ditemukan. Tidak dapat memuat data.");
        profitTableBody.html('<tr><td colspan="4">Silakan login untuk melihat data.</td></tr>');
        loadingOverlay.addClass("hidden");
        echartsWrapper.hide();
    }
});