// public/js/prediksi_demand.js

$(document).ready(function () {
    const token = localStorage.getItem("token");
    const predictButton = $("#predictButton"); 
    const loadingOverlay = $("#loadingOverlay");
    const alertContainer = $("#alert-container");
    const echartsWrapper = $("#echartsContainerWrapper"); 

    const demandChartContainerDOM = document.getElementById('demandChartContainer'); 

    const chartFilterControls = $("#chartFilterControls");
    const filterStartYear = $("#filterStartYear");
    const filterStartMonth = $("#filterStartMonth");
    const filterEndYear = $("#filterEndYear");
    const filterEndMonth = $("#filterEndMonth");
    const applyChartFilterButton = $("#applyChartFilterButton");
    const resetChartFilterButton = $("#resetChartFilterButton");

    const productSelectDropdown = $("#productSelectDropdown"); 

    let demandChartInstance = null; 
    let currentFullApiData = [];  
    let availableProductKeys = []; 
    let selectedProductKey = null; 

    
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
    
    function formatNumber(number) {
        if (isNaN(parseFloat(number))) return '0';
        return Number(number).toLocaleString('id-ID');
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

    function populateYearDropdowns() { 
        if (!currentFullApiData || currentFullApiData.length === 0) { 
            filterStartYear.empty().append(new Option("Pilih Tahun", ""));
            filterEndYear.empty().append(new Option("Pilih Tahun", ""));
            return;
        }
        // Asumsi currentFullApiData[i].date adalah YYYY-MM-DD
        const years = [...new Set(currentFullApiData.map(item => new Date(item.date).getFullYear()))].sort((a, b) => a - b); 

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

    function transformHistoricalDbData(dbData) {
        if (!dbData || dbData.length === 0) return [];

        const transformed = {}; // Objek untuk mengelompokkan berdasarkan tanggal: { 'YYYY-MM-DD': { date: ..., Product_A: ..., type: ... }}

        dbData.forEach(item => {
            const dateKey = item.date; // Asumsi YYYY-MM-DD
            if (!transformed[dateKey]) {
                transformed[dateKey] = {
                    date: dateKey,
                    type: item.type // Pertahankan tipe 'historical_db'
                };
            }
            // Buat nama kolom produk sesuai format FastAPI
            const productColumnName = `Product_${item.product_name.replace(/ /g, '_')}`;
            transformed[dateKey][productColumnName] = item.total_quantity;
        });

        // Ubah objek kembali menjadi array
        return Object.values(transformed);
    }

    // --- BARU: Fungsi untuk mengisi dropdown produk ---
    function populateProductDropdown(dataForDropdown) { // `dataForDropdown` bisa dari FastAPI atau hasil transformasi
        if (!dataForDropdown || dataForDropdown.length === 0) {
            productSelectDropdown.empty().append(new Option("Data belum dimuat", ""));
            console.log("populateProductDropdown: No data to populate products from.");
            return;
        }
        const firstItem = dataForDropdown[0];
        console.log("populateProductDropdown: firstItem keys for product discovery:", Object.keys(firstItem));

        availableProductKeys = Object.keys(firstItem)
            .filter(key => key.startsWith('Product_'))
            .sort();
        console.log("populateProductDropdown: availableProductKeys:", availableProductKeys);

        const currentSelected = productSelectDropdown.val();
        productSelectDropdown.empty();

        if (availableProductKeys.length === 0) {
            productSelectDropdown.append(new Option("Tidak ada produk", ""));
            selectedProductKey = null;
            console.log("populateProductDropdown: No 'Product_' keys found after processing. selectedProductKey is null.");
            return;
        }

        availableProductKeys.forEach(productKey => {
            const productName = productKey.substring("Product_".length).replace(/_/g, ' ');
            productSelectDropdown.append(new Option(productName, productKey));
        });

        if (currentSelected && availableProductKeys.includes(currentSelected)) {
            productSelectDropdown.val(currentSelected);
            selectedProductKey = currentSelected;
        } else if (availableProductKeys.length > 0) {
            selectedProductKey = availableProductKeys[0];
            productSelectDropdown.val(selectedProductKey);
        } else {
            selectedProductKey = null;
        }
        console.log("Products populated. Selected product key:", selectedProductKey);
    }



    // --- MODIFIKASI BESAR: Fungsi untuk chart (sekarang initOrUpdateDemandChart) ---
    function initOrUpdateDemandChart(sourceData, isFilterAction = false, isNewDataSource = false) {
        if (isNewDataSource) {
            currentFullApiData = [...sourceData]; // `sourceData` ini HARUS sudah dalam format FastAPI
            console.log("Master DEMAND data UPDATED (currentFullApiData). Count:", currentFullApiData.length);
            populateProductDropdown(currentFullApiData); // Berikan data yang sudah diformat
            populateYearDropdowns();   // Menggunakan currentFullApiData (yang sudah diformat)
            if (!isFilterAction) {
                filterStartMonth.val(1);
                filterEndMonth.val(12);
            }
            chartFilterControls.show();
            productSelectDropdown.closest('.col-md-3').show();
        }

        if (!selectedProductKey && availableProductKeys.length > 0) {
            selectedProductKey = availableProductKeys[0]; // Pastikan ada produk terpilih
            productSelectDropdown.val(selectedProductKey);
        } else if (!selectedProductKey) {
            console.warn("No product selected to display on chart.");
            if (demandChartInstance) { demandChartInstance.dispose(); demandChartInstance = null; }
            echartsWrapper.hide();
            return;
        }

        let dataToRender = [...currentFullApiData]; 

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
                dataToRender = [...currentFullApiData];
            } else {
                dataToRender = currentFullApiData.filter(item => {
                    const itemDate = new Date(item.date); 
                    return itemDate >= startDateFilter && itemDate <= endDateFilter;
                });
            }
        }

        console.log(`Data to render for product ${selectedProductKey} (count):`, dataToRender.length);

        if (!demandChartContainerDOM) { console.error("Demand chart container not found!"); return; }
        if (typeof echarts === 'undefined') { console.error("ECharts not defined!"); return; }
        if (echartsWrapper.is(':hidden') && dataToRender.length > 0) { echartsWrapper.show(); }

        setTimeout(function() {
            if (demandChartInstance) {
                demandChartInstance.dispose();
                demandChartInstance = null;
            }
            try {
                demandChartInstance = echarts.init(demandChartContainerDOM);

                const historicalData = dataToRender.filter(item => item.type && (item.type.startsWith('historical_db') || item.type.startsWith('historical_model')));
                const predictedData = dataToRender.filter(item => item.type && (item.type.startsWith('predicted_model') || item.type.startsWith('predicted')));

                let xAxisCategories = [];
                let seriesHistoricalMapped = [];
                let seriesPredictedMapped = [];

                if (dataToRender.length > 0) {
                    xAxisCategories = [...new Set(dataToRender.map(item => item.date))].sort((a,b) => new Date(a) - new Date(b));

                    seriesHistoricalMapped = xAxisCategories.map(categoryDate => {
                        const foundItem = historicalData.find(hd => hd.date === categoryDate);
                        // AMBIL NILAI DARI KOLOM PRODUK YANG TERPILIH
                        return foundItem ? parseFloat(foundItem[selectedProductKey]) || 0 : null;
                    });
                    seriesPredictedMapped = xAxisCategories.map(categoryDate => {
                        const foundItem = predictedData.find(pd => pd.date === categoryDate);
                        // AMBIL NILAI DARI KOLOM PRODUK YANG TERPILIH
                        return foundItem ? parseFloat(foundItem[selectedProductKey]) || 0 : null;
                    });
                }

                const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                let lastDisplayedMonthYear = null;
                const currentProductNameDisplay = selectedProductKey ? selectedProductKey.substring("Product_".length).replace(/_/g, ' ') : "";

                let formatter_lastLabeledMonthYear = null;


                const option = {
                    tooltip: {
                        trigger: 'axis',
                        formatter: function (params) {
                            if (!params || params.length === 0) return '';
                            let tooltipText = formatDateForDisplay(params[0].name) + '<br/>';
                            params.forEach(function (item) {
                                if (item.value !== undefined && item.value !== null) {
                                    tooltipText += item.marker + item.seriesName + ': ' + formatNumber(item.value) + ' unit<br/>';
                                }
                            });
                            return tooltipText;
                        }
                    },
                    legend: {
                        data: [`Demand Historis ${currentProductNameDisplay}`, `Demand Prediksi ${currentProductNameDisplay}`],
                        bottom: 0
                    },
                    grid: { left: '3%', right: '4%', bottom: '20%', containLabel: true },
                    xAxis: {
                        type: 'category', data: xAxisCategories, boundaryGap: false,
                        axisLabel: {
                            show: true, // Pastikan ini true
                            // interval: 'auto', // Biarkan ECharts memilih tick, atau bisa juga 0 jika data tidak terlalu padat
                                             // Jika 'auto', formatter di bawah akan menyaring duplikasi bulan
                            formatter: function (value, index) { // value adalah tanggal YYYY-MM-DD dari xAxisCategories
                                const date = new Date(value);
                                const year = date.getFullYear();
                                const month = date.getMonth(); // 0-11
                                const currentMonthYearKey = `${year}-${month}`;

                                // Hanya tampilkan label jika ini adalah bulan baru yang belum diberi label
                                if (formatter_lastLabeledMonthYear !== currentMonthYearKey) {
                                    formatter_lastLabeledMonthYear = currentMonthYearKey; // Update bulan terakhir yang diberi label
                                    return monthNames[month] + '\n' + year;
                                }
                                return ''; // Jika bulan sama dengan yang terakhir dilabeli, jangan tampilkan lagi
                            }
                            // Opsional: jika label terlalu panjang atau tumpang tindih
                            // rotate: 30,
                            // textStyle: { fontSize: 10 }
                        },
                        axisTick: {
                            alignWithLabel: true // Sejajarkan tick dengan label
                        }
                    },
                    yAxis: {
                        type: 'value',
                        name: `Permintaan (${currentProductNameDisplay})`, // Label Y Axis dinamis
                        axisLabel: { formatter: function (value) { return Math.round(value); } } // Kuantitas biasanya bulat
                    },
                    series: [
                        { name: `Demand Historis ${currentProductNameDisplay}`, type: 'line', smooth: true, data: seriesHistoricalMapped, itemStyle: { color: '#0d6efd' }, connectNulls: true /* areaStyle opsional */ },
                        { name: `Demand Prediksi ${currentProductNameDisplay}`, type: 'line', smooth: true, data: seriesPredictedMapped, itemStyle: { color: '#198754' }, lineStyle: { width: 2, type: 'dashed' }, connectNulls: true }
                    ]
                };
                
                if (dataToRender.length === 0) {
                    console.warn("No data to render after filtering. Chart will be empty.");
                    option.series[0].data = [];
                    option.series[1].data = [];
                    if (currentFullApiData.length > 0) {
                        const allDatesOriginal = currentFullApiData.map(d => d.date).sort((a,b) => new Date(a) - new Date(b));
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
                
                lastDisplayedMonthYear = null; // Reset untuk formatter xAxis
                demandChartInstance.setOption(option, true);
                console.log(`Demand chart updated for: ${selectedProductKey}`);

            } catch (e) { console.error("Error in ECharts init/setOption:", e); }
        }, 50);

        $(window).off('resize.echarts_demand').on('resize.echarts_demand', function(){ if (demandChartInstance) { demandChartInstance.resize(); } });
    }

    // --- Event Listener untuk Filter Tanggal SAMA ---
    applyChartFilterButton.on("click", function() {
        if (currentFullApiData.length > 0) {
            initOrUpdateDemandChart(currentFullApiData, true, false); 
        } else { showAlert("Tidak ada data untuk difilter.", "info", 3000); }
    });
    resetChartFilterButton.on("click", function() {
        if (currentFullApiData.length > 0) {
            populateYearDropdowns(); filterStartMonth.val(1); filterEndMonth.val(12);
            initOrUpdateDemandChart(currentFullApiData, false, false);
        }
    });

    // --- BARU: Event Listener untuk Dropdown Produk ---
    productSelectDropdown.on("change", function() {
        selectedProductKey = $(this).val();
        if (selectedProductKey && currentFullApiData.length > 0) {
            console.log("Product selection changed to:", selectedProductKey);
            initOrUpdateDemandChart(currentFullApiData, true, false);
        }
    });

    // --- Modifikasi Fungsi AJAX ---
    function loadInitialHistoricalDemandData() { // Ganti nama agar lebih spesifik
        loadingOverlay.removeClass("hidden");
        alertContainer.html('');
        chartFilterControls.hide();
        productSelectDropdown.closest('.col-md-3').hide();
        echartsWrapper.hide();

        $.ajax({
            url: "/api/daily-product-demand-summary",
            method: "GET",
            headers: { "Authorization": `Bearer ${token}`, "Accept": "application/json" },
            success: function (response) {
                if (response.success && response.data && response.data.length > 0) {
                    console.log("Raw historical DB data received:", response.data);
                    const transformedData = transformHistoricalDbData(response.data); // <--- TRANSFORMASI DI SINI
                    console.log("Transformed historical DB data:", transformedData);

                    if (transformedData.length > 0) {
                        initOrUpdateDemandChart(transformedData, false, true);
                    } else {
                        showAlert("Tidak ada data demand historis yang valid setelah transformasi.", "info");
                        console.warn("Transformed historical data is empty.");
                    }
                } else {
                    showAlert(response.message || "Tidak ada data demand historis awal.", "info");
                    console.warn("No initial historical demand data or empty data from API.");
                }
            },
            error: function (xhr) {
                console.error("Failed to fetch initial historical demand data:", xhr.responseText);
                const errorMsg = xhr.responseJSON?.message || xhr.statusText || 'Gagal memuat data demand historis.';
                showAlert(`Error ${xhr.status}: ${errorMsg}`);
                // Biarkan kontrol dan chart tersembunyi
            },
            complete: function () {
                loadingOverlay.addClass("hidden");
            }
        });
    }

    predictButton.on("click", function () {
        if (!token) { showAlert("Token autentikasi tidak ditemukan."); return; }
        alertContainer.html('');
        loadingOverlay.removeClass("hidden");

        $.ajax({
            url: "/api/request-demand-predictions", // Endpoint untuk prediksi dari FastAPI
            method: "GET",
            headers: { "Authorization": `Bearer ${token}`, "Accept": "application/json" },
            success: function (response) {
                if (response.success && response.data && response.data.length > 0) {
                    showAlert("Prediksi demand berhasil diterima!", "success", 5000);
                    // Data dari FastAPI juga berisi SEMUA produk dan kolomnya.
                    initOrUpdateDemandChart(response.data, false, true); // isNewDataSource = true
                } else {
                    showAlert(response.message || "Gagal mendapatkan data prediksi demand atau data kosong.", "warning");
                    if (response.data && response.data.length === 0) {
                        console.warn("Data prediksi demand dari API kosong.");
                        // Mungkin reset ke data historis awal jika ada? Atau biarkan chart kosong.
                        // Untuk sekarang, jika prediksi kosong, chart akan dirender kosong oleh initOrUpdateDemandChart.
                    }
                }
            },
            error: function (xhr) {
                console.error("Failed to get demand predictions:", xhr.responseText);
                const errorMsg = xhr.responseJSON?.message || xhr.statusText || 'Gagal menghubungi layanan prediksi demand.';
                showAlert(`Error ${xhr.status}: ${errorMsg}`);
            },
            complete: function () {
                loadingOverlay.addClass("hidden");
            }
        });
    });


    // Inisialisasi
    if (token) {
        loadInitialHistoricalDemandData(); // Panggil fungsi load yang mungkin tidak langsung memuat chart
        populateMonthDropdown(filterStartMonth);
        populateMonthDropdown(filterEndMonth);
        // filterStartMonth.val(1); 
        // filterEndMonth.val(12);
    } else {
        chartFilterControls.hide();
        productSelectDropdown.closest('.col-md-3').hide();
    }
});