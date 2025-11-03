import { NetworkError } from "/js/error/NetworkError.js";
import { ResponseError } from "/js/error/ResponseError.js";

export class Fetch {
  static async initRequest() {
    const url = "/init";
    const response = await fetch(url, {
      method: 'POST'
    });

    this.#checkError(response);
    return await response.json();
  }

  static async searchRequest(json) {
    const url = '/search';
    const response = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(json)
    });

    this.#checkError(response);
    const result = await response.json();
    return result;
  }

  static #checkError(response) {
    if (!response.ok) {
      switch (response.status) {
        case 400:
          throw new ResponseError('一致するデータを取得できませんでした。');
        case 403:
          throw new ResponseError('不正な値が入力されました。');
        default:
          throw new NetworkError('サーバーとの接続に失敗しました。');
      }
    }
    return;
  }
}
