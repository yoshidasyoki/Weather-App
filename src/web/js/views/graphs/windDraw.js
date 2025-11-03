export function windDraw(labels, wind) {

  if (window.windChart) {
    window.windChart.destroy();
  }

  if (wind === false) {
    return;
  }

  const ctx = document.getElementById('wind').getContext('2d');

  const datasets = [];
  datasets.push({
    label: '平均風速（m/s）',
    data: wind,
    borderColor: 'rgba(81, 110, 255, 1)',
    backgroundColor: 'rgba(0, 0, 0, 0)',
    tension: 0,
    fill: true,
  });

  window.windChart = new Chart(ctx, {
    type: 'line',
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
            text: '平均風速（m/s）'
          },
          beginAtZero: false
        }
      }
    }
  });
}
