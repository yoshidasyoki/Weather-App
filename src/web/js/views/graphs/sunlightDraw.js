export function sunlightDraw(labels, sunlight) {

  if (window.sunlightChart) {
    window.sunlightChart.destroy();
  }

  if (sunlight === false) {
    return;
  }

  const ctx = document.getElementById('sunlight').getContext('2d');

  const datasets = [];
  datasets.push({
    label: '日照時間（h）',
    data: sunlight,
    backgroundColor: 'rgba(255, 224, 141, 1)'
  });

  window.sunlightChart = new Chart(ctx, {
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
            text: '日照時間（h）'
          },
          beginAtZero: false
        }
      }
    }
  });
}
