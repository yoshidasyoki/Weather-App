export function tempDraw(labels, temps) {

  if (window.tempChart) {
    window.tempChart.destroy();
  }

  if (temps === false) {
    return;
  }

  const ctx = document.getElementById('temp').getContext('2d');
  const avg_temp = temps.avg_temp;
  const max_temp = temps.max_temp;
  const min_temp = temps.min_temp;

  const datasets = [];
  if (hasData(avg_temp)) {
    datasets.push({
      label: '平均気温（℃）',
      data: avg_temp,
      borderColor: 'rgba(255, 209, 81, 1)',
      backgroundColor: 'rgba(0, 0, 0, 0)',
      tension: 0,
      fill: true,
    });
  }

  if (hasData(max_temp)) {
    datasets.push({
      label: '最高気温（℃）',
      data: max_temp,
      borderColor: 'rgba(254, 108, 108, 1)',
      backgroundColor: 'rgba(0, 0, 0, 0)',
      tension: 0,
      fill: true
    });
  }

  if (hasData(min_temp)) {
    datasets.push({
      label: '最低気温（℃）',
      data: min_temp,
      borderColor: 'rgba(75, 192, 192, 1)',
      backgroundColor: 'rgba(0, 0, 0, 0)',
      tension: 0,
      fill: true
    });
  }


  window.tempChart = new Chart(ctx, {
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
            text: '気温（℃）'
          },
          beginAtZero: false
        }
      }
    }
  });

  function hasData(array) {
    let hasFlag = false;
    hasFlag = array.some((value) => {
      return (value !== null && value !== undefined && value !== '');
    });
    return hasFlag;
  }
}
