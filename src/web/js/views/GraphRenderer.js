import { tempDraw } from '/js/views/graphs/tempDraw.js';
import { precipitationDraw } from '/js/views/graphs/precipitationDraw.js';
import { sunlightDraw } from '/js/views/graphs/sunlightDraw.js';
import { windDraw } from '/js/views/graphs/windDraw.js';

export class GraphRenderer {
  constructor(json) {
    this.labels = json.map(item => item.date);
    this.dataObj = {
      temp: this.#getTempData(json),
      precipitation: this.#getPrecipitationData(json),
      sunlight: this.#getSunlightData(json),
      wind: this.#getWindData(json)
    }

    this.canvasId = {
      temp: document.getElementById('temp'),
      precipitation: document.getElementById('precipitation'),
      sunlight: document.getElementById('sunlight'),
      wind: document.getElementById('wind')
    };

    this.drawFuncs = {
      temp: tempDraw,
      precipitation: precipitationDraw,
      sunlight: sunlightDraw,
      wind: windDraw
    };
  }

  render() {
    Object.entries(this.dataObj).forEach(value => {
      const key = value[0];
      const data = value[1];

      const canvas = this.canvasId[key];
      if (data == false) {
        canvas.classList.add('hidden');
        return;
      }

      canvas.classList.remove('hidden');
      this.drawFuncs[key](this.labels, data);
    });
  }

  #isAllNull(data) {
    return data.every(value => value == null);
  }

  #getTempData(json) {
    const tempObjs = {
      avg_temp: json.map(item => item.avg_temp),
      max_temp: json.map(item => item.max_temp),
      min_temp: json.map(item => item.min_temp)
    };

    const allNull = Object.values(tempObjs).every(temp => this.#isAllNull(temp));
    return allNull ? false : tempObjs;
  }

  #getPrecipitationData(json) {
    const precipitation = json.map(item => item.precipitation);
    return (!this.#isAllNull(precipitation)) ? precipitation : false;
  }

  #getSunlightData(json) {
    const sunlight = json.map(item => item.sunlight_hours);
    return (!this.#isAllNull(sunlight)) ? sunlight : false;
  }

  #getWindData(json) {
    const wind = json.map(item => item.avg_wind_speed);
    return (!this.#isAllNull(wind)) ? wind : false;
  }
}
