const ctx = document.getElementById('demandChart').getContext('2d');
const demandChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGU', 'SEP', 'OKT', 'NOV', 'DES'],
    datasets: [{
      label: 'Hari Ini',
      data: [0, 100, 500, 1000, 500, 100, 2000, 8000, 10000, 9500, 10200, 11000],
      borderColor: '#2D2D51',
      borderWidth: 2,
      pointRadius: 5,
      pointBackgroundColor: '#2D2D51',
      fill: false,
      tension: 0.3
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true,
        title: {
          display: true,
          text: 'pcs'
        }
      }
    }
  }
});
