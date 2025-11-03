import { Fetch } from "/js/models/Fetch.js";
import { ScreenSwitch } from "/js/views/ScreenSwitch.js";
import { GraphRenderer } from "/js/views/GraphRenderer.js";
import { InfoRenderer } from "/js/views/InfoRenderer.js";
import { FormValidator } from "/js/views/FormValidator.js";
import { FormRenderer } from "/js/views/FormRenderer.js";

export class AppController {
  constructor() {
    this.screenSwitch = new ScreenSwitch();
    this.infoRenderer = new InfoRenderer({
      weatherInfoId: 'weather_info'
    })

    this.form = document.getElementById('dataForm');
    this.validator = new FormValidator(this.form);
    this.formRenderer = new FormRenderer(this.form);
  }

  run() {
    this.#init();
    this.#handleSearch();
  }

  #init() {
    document.addEventListener("DOMContentLoaded", async () => {
      try {
        const result = await Fetch.initRequest();
        this.formRenderer.setSearchDate(result.info.start, result.info.end);
        const graph = new GraphRenderer(result.json);
        graph.render();
        this.infoRenderer.display(result.info);
      } catch (error) {
        alert(error.message);
      }
    });
  }

  #handleSearch() {
    this.form.addEventListener('submit', async (event) => {
      event.preventDefault();

      try {
        const requestJson = this.validator.validateData();
        const result = await Fetch.searchRequest(requestJson);
        const graph = new GraphRenderer(result.json);
        this.screenSwitch.showGraph();
        graph.render();
        this.infoRenderer.display(result.info);
      } catch (error) {
        alert(error.message);
      }
    });
  }
}
