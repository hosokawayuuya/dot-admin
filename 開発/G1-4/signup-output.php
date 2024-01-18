<?php
require '../others/header.php';
require '../others/menu.php';
require '../others/db-connect.php';

// エラーメッセージの初期化
$errors = [];

// フォームが送信された場合の処理
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // GETリクエストからデータを取得
    $user_name = $_GET['user_name'];
    $post_name = $_GET['post_name'];
    $guild_name = isset($_GET['guild_name']) ? $_GET['guild_name'] : null;

    // 入力内容の確認
    echo "<h2>勇者登録完了</h2>";
    echo "<p1>ユーザー名: " . htmlspecialchars($user_name) . "</p1>";
    echo "<br>";
    echo "<p1>ポスト名: " . htmlspecialchars($post_name) . "</p1>";
    echo "<br>";

    // ギルド名が存在する場合のみ表示
    if ($guild_name !== null) {
        echo "<p1>ギルド名: " . htmlspecialchars($guild_name) . "</p1>";
        echo "<br>";

        // データベースに挿入
        try {
            $pdo = new PDO($connect, USER, PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // User テーブルにデータを挿入
            $stmt = $pdo->prepare("INSERT INTO User (user_name, post_id, guild_id) VALUES (:user_name, (SELECT post_id FROM Post WHERE post_name = :post_name), (SELECT guild_id FROM Guild WHERE guild_name = :guild_name))");
            $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
            $stmt->bindParam(':post_name', $post_name, PDO::PARAM_STR);
            $stmt->bindParam(':guild_name', $guild_name, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "データベースエラー: " . $e->getMessage();
        } finally {
            $pdo = null; // データベース接続解除
        }
    }

    echo "<p1>登録が完了しました。</p1>";
    echo "<br>";
    echo "<a href='signup-input.php'>新規登録画面へ</a>";
}

require '../others/footer.php';
?>
