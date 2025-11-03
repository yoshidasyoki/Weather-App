export class FormRenderer {
  constructor(form) {
    this.form = form;
    this.startInput = this.form.querySelector("input[name='start']");
    this.endInput = this.form.querySelector("input[name='end']");
  }

  setSearchDate(start, end) {
    this.startInput.value = start;
    this.endInput.value = end;
  }
}
