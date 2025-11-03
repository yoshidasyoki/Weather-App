export class InfoRenderer {
  constructor(params) {
    this.weatherInfo = document.getElementById(params.weatherInfoId);
  }

  display(info) {
    this.weatherInfo.textContent = `${info['cityName']}の${info['start']}から${info['end']}までの天気`;
  }
}
