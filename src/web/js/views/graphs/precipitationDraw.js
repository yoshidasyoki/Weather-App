export function precipitationDraw(labels, precipitation) {

  if (window.precipitationChart) {
    window.precipitationChart.destroy();
  }

  if (precipitation === false) {
    return;
  }

  const ctx = document.getElementById('precipitation').getContext('2d');

  const datasets = [];
  datasets.push({
    label: '降水量（mm）',
    data: precipitation,
    backgroundColor: 'rgba(111, 225, 253, 1)'
  });

  window.precipitationChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: datasets
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: true
        },
        tooltip: {
          mode: 'index',
          intersect: false
        }
      },
      scales: {
        x: {
          title: {
            display: true,
            text: '日付'
          }
        },
        y: {
          title: {
            display: true,
            text: '気温（℃）'
          },
          beginAtZero: false
        }
      }
    }
  });
}
