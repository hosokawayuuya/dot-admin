document.addEventListener("DOMContentLoaded", function () {
    updateStyle(); // 初回実行
  
    // 1分ごとにスタイルを更新
    setInterval(updateStyle, 60000);
  });
  
  function updateStyle() {
    const tableContainer = document.querySelector(".container");
    const body = document.body;
    const currentTime = new Date();
    const currentHour = currentTime.getHours();
  
    // 明るい感じのスタイルとBGM
    if (currentHour >= 9 && currentHour < 18) {
      tableContainer.classList.remove("nighttime");
      tableContainer.classList.add("daytime");
      body.style.backgroundImage = "url('昼の街.jpg')"; // 画像1のファイルパス
      playBGM("bgm1.mp3"); // 例: BGM1のファイル名
    }
    // 落ち着いた感じのスタイルとBGM
    else {
      tableContainer.classList.remove("daytime");
      tableContainer.classList.add("nighttime");
      body.style.backgroundImage = "url('夜の街.jpg')"; // 画像2のファイルパス
      playBGM("bgm2.mp3"); // 例: BGM2のファイル名
    }
  }
  
  function playBGM(filename) {
    const audio = new Audio(filename);
    audio.loop = true;
    audio.play();
  }
  