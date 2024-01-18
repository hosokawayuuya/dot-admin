<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理書同意確認</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('oldbook.jpg'); /* 画像のパスを適切なものに変更してください */
            background-size: cover;
            background-position: center;
            text-align: center;
            margin: 50px;
            color: #fff; /* テキストが読みやすいように適切な色を指定してください */
        }

        #adventure-book {
            width: 300px;
            margin: 0 auto;
        }

        #adventure-book select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 16px;
        }

        #agree-checkbox {
            margin-bottom: 20px;
        }

        #submit-button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div id="adventure-book">
        <h2>管理書</h2>
        <form action="../G1-0/title.php" method="get" onsubmit="return validateForm()">
            <label for="chapter">管理書を選んでください:</label>
            <select id="chapter" name="chapter">
                <option value="chapter1">勇者</option>
                <option value="chapter2">仲間</option>
                <option value="chapter3">オブジェクト</option>
            </select>

            <div id="agree-checkbox">
                <input type="checkbox" id="agree" name="agree">
                <label for="agree">同意する</label>
            </div>

            <input type="submit" id="submit-button" value="冒険を始める">
        </form>

        <!-- 音声ファイルを追加 -->
        <audio id="audio" src="stairs-free3.mp3"></audio>

        <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1"></script>
        <script>
            function validateForm() {
                var agreeCheckbox = document.getElementById("agree");

                if (!agreeCheckbox.checked) {
                    alert("同意してください！");
                    return false;
                }

                // アニメーション実行後に音声再生開始
                anime({
                    targets: 'body',
                    backgroundColor: '#000',
                    duration: 1000, // 1秒間かけて暗転
                    easing: 'easeOutQuad',
                    complete: function(anim) {
                        // 音声再生
                        playAudio();
                    }
                });

                return false; // 画面遷移を防ぐために false を返す
            }

            function playAudio() {
                var audio = document.getElementById("audio");
                audio.play();

                // 音声が終わったら画面遷移
                audio.onended = function() {
                    window.location.href = '../G1-2/list.php';
                };
            }
        </script>
    </div>

</body>
</html>
