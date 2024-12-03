const configLineChart = {
    type: 'line',
    data: {
        labels: [], 
        datasets: []
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top'
            },
            tooltip: {
                mode: 'index',
                intersect: false
            }
        },
        interaction: {
            mode: 'nearest',
            axis: 'x',
            intersect: false
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Bulan'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Permintaan'
                }
            }
        }
    }
};

const lineChartPrediksi = new Chart(document.getElementById('lineChartPrediksi'), configLineChart);

function updateChart(productName, data) {
    const productData = data.find(item => item.produk === productName);
    if (productData) {
        lineChartPrediksi.data.labels = productData.labels;
        lineChartPrediksi.data.datasets = productData.datasets;
        lineChartPrediksi.update();
    }
}

function loadData(url, productName) {
    fetch(url)
        .then(response => response.json())
        .then(jsonData => {
            updateChart(productName, jsonData);
        })
        .catch(error => console.error('Error loading data:', error));
}

// Initial data load
let currentUrl = 'https://raw.githubusercontent.com/Bizniz-Corp/BizGrow-Website/refs/heads/1302223041_Syahreza/assets/data/prediksi_demand_bulan.json';
const selectElement = document.getElementById('productSelect');

// Load initial chart with default selection
loadData(currentUrl, selectElement.value);

// Event listener untuk dropdown produk
selectElement.addEventListener('change', function() {
    loadData(currentUrl, this.value);
});

// Event listener untuk dropdown waktu
document.getElementById('optionBulan').addEventListener('click', function() {
    currentUrl = 'https://raw.githubusercontent.com/Bizniz-Corp/BizGrow-Website/refs/heads/1302223041_Syahreza/assets/data/prediksi_demand_bulan.json';
    loadData(currentUrl, selectElement.value);
});

document.getElementById('optionHari').addEventListener('click', function() {
    currentUrl = 'https://raw.githubusercontent.com/Bizniz-Corp/BizGrow-Website/refs/heads/1302223041_Syahreza/assets/data/prediksi_demand_hari.json';
    loadData(currentUrl, selectElement.value);
});

const pilihWaktuButton = document.getElementById("pilihWaktuButton");
const optionBulan = document.getElementById("optionBulan");
const optionHari = document.getElementById("optionHari");


optionBulan.addEventListener("click", function() {
    pilihWaktuButton.innerText = "Bulan";
});

optionHari.addEventListener("click", function() {
    pilihWaktuButton.innerText = "Hari";
});



$(document).ready(function () {
    $('.search_select_box select').selectpicker();
})



// Pie chart

const percentageData = {
        datasets: [{
            label: 'Percentage',
            data: [80, 20],
            backgroundColor: [
                'rgb(54, 162, 235)',
                'rgba(211, 211, 211, 0.3)'
            ],
            hoverOffset: 4
        }]
    };

    // Tambahkan konfigurasi untuk teks tengah
    const configDoughnut = {
        type: 'doughnut',
        data: percentageData,
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.raw + '%';
                        }
                    }
                }
            },
            cutout: '70%', 
            elements: {
                center: {
                    text: '80%',  
                    color: '#36A2EB',  
                    fontStyle: 'Arial',
                }
            }
        },
        plugins: [{
            beforeDraw: function(chart) {
                var ctx = chart.ctx;
                ctx.restore();
                var fontSize = (chart.height / 114).toFixed(2);
                ctx.font = fontSize + "em sans-serif";
                ctx.textBaseline = "middle";
                var text = "80%";
                var textX = Math.round((chart.width - ctx.measureText(text).width) / 2);
                var textY = chart.height / 2;
                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }]
    };

    // Tampilkan chart
    const percentageChart = new Chart(
        document.getElementById('percentageChart'),
        configDoughnut
);
    
// buffer stock

const data = {
        labels: ['Ayam', 'Tepung', 'Garam'],
        datasets: [
            {
                label: 'Stok Asli',
                data: [20, 25, 30],
                backgroundColor: 'rgba(54, 162, 235, 0.8)'  // Warna untuk Stok Asli
            },
            {
                label: 'Buffer Stock',
                data: [30, 70, 40],
                backgroundColor: 'rgba(255, 99, 132, 0.5)'  // Warna untuk Buffer Stock
            }
        ]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.raw}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    stacked: true  // Bar pada sumbu x akan bertumpuk
                },
                y: {
                    beginAtZero: true,
                    stacked: true,  // Bar pada sumbu y akan bertumpuk
                    title: {
                        display: true,
                        text: 'Jumlah Stok'
                    }
                }
            }
        }
    };

    // Render chart
    const bufferStockChart = new Chart(
        document.getElementById('bufferStockChart'),
        config
    );