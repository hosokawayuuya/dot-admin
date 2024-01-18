<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ドット管理者</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--==============レイアウトを制御する独自のCSSを読み込み===============-->
<link rel="stylesheet" type="text/css" href="http://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/move02/5-9/css/reset.css">
<link rel="stylesheet" type="text/css" href="http://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/move02/5-9/css/5-9.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
</head>
<body>
<div id="particles-js"></div>
    <audio loop autoplay>
        <source src="titleBGM.mp3">
        ブラウザがオーディオタグをサポートしていません。
    </audio>
<div id="wrapper">
  <!-- 画像要素にIDを追加 -->
  <p>
    <img id="animated-image" src="title.png" alt="Title Image" width="672px" height="320px">
  </p>
  <!-- ボタンに変更 -->
  <p>
    <button id="home-button">一覧画面へ</button>
  </p>
</div>
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script src="http://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/move02/5-9/js/5-9.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  // アニメーション対象の画像要素を取得
  var imageElement = document.getElementById('animated-image'); // 画像のIDに合わせて変更してください

  // ボタンの要素を取得
  var homeButton = document.getElementById('home-button');

  // 効果音の要素を生成
  var clickSound = new Audio('stairs-free3.mp3');

  // BGMの要素を生成
  var bgm = new Audio('titleBGM.mp3'); // BGMのファイル名に合わせて変更してください
  bgm.loop = true; // ループ再生
  bgm.volume = 1.0; // 音量（0.0から1.0の範囲で指定）

  // ページ読み込み時にBGMを再生
  document.addEventListener('DOMContentLoaded', function () {
    bgm.play();
  });

  // アニメーションの設定
  anime({
    targets: imageElement,
    translateY: [
      { value: window.innerHeight, duration: 0 }, // 画面外の初期位置
      { value: 0, duration: 50000, easing: 'easeInOutQuad' } // 画面上部への移動
    ],
    opacity: [
      { value: 0, duration: 0 }, // 透明な初期状態
      { value: 1, duration: 8000, easing: 'easeInOutQuad' } // 不透明への変化
    ],
    delay: 500, // 遅延時間（ミリ秒）
  });

  // ボタンがクリックされた時の処理
  homeButton.addEventListener('click', function() {
    // 効果音再生
    clickSound.play();

    // 画面遷移前の処理（暗転）
    anime({
      targets: 'body',
      backgroundColor: '#000',
      duration: 1500, // 1秒間かけて暗転
      easing: 'easeOutQuad',
      complete: function(anim) {
        // 画面遷移（URLに指定のページへ移動）
        window.location.href = '../G1-2/list.php';
      }
    });
  });

  // ボタンのスタイルと右上への配置
  homeButton.style.position = 'fixed';
  homeButton.style.top = '20px';
  homeButton.style.right = '20px';
  homeButton.style.padding = '10px 20px';
});
</script>
</body>
</html>
