<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>天気分析アプリ</title>
  <link rel="stylesheet" href="css/vendor/sanitize.css">
  <link rel="stylesheet" href="css/index.css">
</head>

<body>
  <div class="content">
    <div class="article">
      <div class="sidebar">
        <div class="sidebar_content">
          <h2 class="sidebar_content_title">天気分析アプリ</h2>

          <div class="section_content">
            <div class="section">
              <h3 class="section_title">見る</h3>
              <div class="item checked" id="weather_item">
                <img class="item_icon" src="images/icons/weather_icon.png" alt="">
                <p class="item_label">天気の推移</p>
              </div>
            </div>

            <div class="section">
              <h3 class="section_title">設定</h3>
              <div class="item" id="search_item">
                <img class="item_icon" src="images/icons/search_icon.png" alt="">
                <p class="item_label">検索する</p>
              </div>
            </div>
          </div>

        </div>
      </div>

      <main>
        <div id="graph">
          <div class="header">
            <h2>天気の記録</h2>
            <p id="weather_info"></p>

            <div class="main_content">
              <div class="option">
                <div class="toggle_switch">
                  <input type="checkbox" name="expand_trigger" id="cb_toggle_switch">
                  <label for="cb_toggle_switch"></label>
                  <span>拡大して表示</span>
                </div>

              </div>

              <div class="graph_content">
                <canvas id="temp" class="hidden"></canvas>
                <canvas id="precipitation"></canvas>
                <canvas id="sunlight"></canvas>
                <canvas id="wind"></canvas>
              </div>
            </div>
          </div>

        </div>

        <div id="search" class="hidden">
          <div class="header">
            <h2>検索条件の設定</h2>
            <p>表示させたいデータを選択</p>
          </div>

          <div class="main_content">
            <form id="dataForm">

              <div class="main_section">
                <section>
                  <div class="location">
                    <div class="sub_title">
                      <h3>1. 地点の選択</h3>
                      <p>検索したい地点を1ヶ所選択します</p>
                    </div>
                    <div class="location_map">
                      <img src="images/japan_map.png" alt="">

                      <label for="1" class="pointer_location pointer_1">
                        <input name="location" value="1" id="1" type="radio">
                        <span class="label_1">札幌</span>
                      </label>

                      <label for="2" class="pointer_location pointer_2">
                        <input name="location" value="2" id="2" type="radio" checked>
                        <span class="label_2">名古屋</span>
                      </label>

                      <label for="3" class="pointer_location pointer_3">
                        <input name="location" value="3" id="3" type="radio">
                        <span class="label_3">那覇</span>
                      </label>
                    </div>
                  </div>
                </section>

                <section>
                  <div class="selection">
                    <div class="sub_title">
                      <h3>2. データの選択</h3>
                      <p>表示させたい統計データを選択します</p>
                    </div>

                    <div class="select_data">
                      <div class="date">
                        <span>日時</span>
                        <div class="input_date">
                          <div class="start_date">
                            <input type="date" name="start">　から
                          </div>
                          <div class="end_date">
                            <input type="date" name="end">　まで
                          </div>
                        </div>
                      </div>

                      <div class="data">
                        <span>データ</span>

                        <label class="checkbox">
                          <input type="checkbox" name="search[avg_temp]" value="1" checked>
                          <span>平均気温</span>
                        </label>

                        <label class="checkbox">
                          <input type="checkbox" name="search[max_temp]" value="1" checked>
                          <span>最高気温</span>

                        </label>
                        <label class="checkbox">
                          <input type="checkbox" name="search[min_temp]" value="1" checked>
                          <span>最低気温</span>

                        </label>
                        <label class="checkbox">
                          <input type="checkbox" name="search[precipitation]" value="1" checked>
                          <span>降水量</span>

                        </label>
                        <label class="checkbox">
                          <input type="checkbox" name="search[sunlight_hours]" value="1" checked>
                          <span>日照時間</span>

                        </label>
                        <label class="checkbox">
                          <input type="checkbox" name="search[avg_wind_speed]" value="1" checked>
                          <span>風速</span>
                        </label>
                      </div>

                      <div class="search_btn">
                        <button type="submit">
                          <a id="fetch_btn">
                            <img src="/images/icons/search_btn.png" alt="">
                            <span>検索</span>
                          </a>
                        </button>
                      </div>
                    </div>
                  </div>
                </section>
              </div>
            </form>

          </div>
        </div>
      </main>
    </div>
  </div>

  <script src="/js/vendor/chart.js"></script>
  <script type="module" src="/js/main.js"></script>
</body>

</html>
