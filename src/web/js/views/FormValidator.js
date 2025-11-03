import { ValidateError } from "/js/error/ValidateError.js"

export class FormValidator {
  constructor(form) {
    this.form = form;
  }

  validateData() {
    const location = this.form.location.value;
    if (location == '') {
      throw new ValidateError('検索地点を入力してください。');
    }

    const start = this.form['start'].value;
    const end = this.form['end'].value;

    if (start == '' || end == '') {
      throw new ValidateError('検索日時を入力してください。');
    }
    if (start > end) {
      throw new ValidateError('日付の入力が無効です。');
    }

    const search = {
      avg_temp: this.form['search[avg_temp]'].checked,
      max_temp: this.form['search[max_temp]'].checked,
      min_temp: this.form['search[min_temp]'].checked,
      precipitation: this.form['search[precipitation]'].checked,
      sunlight_hours: this.form['search[sunlight_hours]'].checked,
      avg_wind_speed: this.form['search[avg_wind_speed]'].checked,
    }

    const hasSearchFlag = this.#hasSearchLists(search);
    if (!hasSearchFlag) {
      throw new ValidateError('取得したい検索リストを入力してください');
    }

    return {
      location: location,
      start: start,
      end: end,
      search: search
    };
  }

  #hasSearchLists(search) {
    let hasSearchFlag = false;
    Object.entries(search).forEach(([label, flag]) => {
      if (flag == true) hasSearchFlag = true;
    });
    return hasSearchFlag;
  }
}
