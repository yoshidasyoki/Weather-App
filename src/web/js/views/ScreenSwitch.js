export class ScreenSwitch {
  constructor() {
    this.weatherBtn = document.getElementById('weather_item');
    this.searchBtn = document.getElementById('search_item');
    this.graphScreen = document.getElementById('graph');
    this.searchScreen = document.getElementById('search');

    this.fetchBtn = document.getElementById('fetch_btn');
    this.toggleSwitch = document.getElementById('cb_toggle_switch');
    this.graphContentCl = document.querySelector('.graph_content');

    this.#init();
    this.#switchGraphColumn();
  }

  #init() {
    this.weatherBtn.addEventListener("click", this.showGraph.bind(this));
    this.searchBtn.addEventListener("click", this.#showSearch.bind(this));
  }

  showGraph() {
    this.weatherBtn.classList.add('checked');
    this.searchScreen.classList.add('hidden');
    this.searchBtn.classList.remove('checked');
    this.graphScreen.classList.remove('hidden');
  }

  #showSearch() {
    this.searchBtn.classList.add('checked');
    this.graphScreen.classList.add('hidden');
    this.weatherBtn.classList.remove('checked');
    this.searchScreen.classList.remove('hidden');
  }

  #switchGraphColumn() {
    this.toggleSwitch.addEventListener("click", () => {
      if (this.graphContentCl.classList.contains('single-column')) {
        this.graphContentCl.classList.remove('single-column');
        return;
      } else {
        this.graphContentCl.classList.add('single-column');
      }
    });
  }

}
