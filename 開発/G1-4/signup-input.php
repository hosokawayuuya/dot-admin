<?php

// エラーメッセージの初期化
$errors = [];

// フォームが送信された場合の処理
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // フォームから送信されたデータを取得
    $user_name = $_POST['user_name'];
    $post_name = $_POST['post_name'];
    $guild_name = $_POST['guild_name'];

    // 入力チェック
    if (empty($user_name) || empty($post_name)) {
        $errors[] = "ユーザー名とポスト名は必須項目です。";
    }

    // エラーがなければ次のページにリダイレクト
    if (empty($errors)) {
        header("Location: signup-output.php?user_name=$user_name&post_name=$post_name&guild_name=$guild_name");
        exit();
    }
}

require '../others/header.php';
require '../others/menu.php';
require '../others/db-connect.php';

// ユーザー名、ポスト名の選択肢を取得するためのクエリ
try {
    $pdo = new PDO($connect, USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ポストテーブルからポスト名を取得
    $post_query = $pdo->query("SELECT post_name FROM Post");
    $post_options = "";
    while ($post_row = $post_query->fetch()) {
        $post_options .= "<option value='" . $post_row['post_name'] . "'>" . $post_row['post_name'] . "</option>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} finally {
    $pdo = null; // データベース接続解除
}
?>

<h2>User新規登録</h2>

<?php
// エラーメッセージがある場合は表示
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color: red;'>{$error}</p>";
    }
}
?>

<form action="" method="post">
    <label for="user_name">ユーザー名：</label>
    <input type="text" id="user_name" name="user_name" required><br>

    <label for="post_name">ポスト名：</label>
    <!-- ポスト名をプルダウンで選択 -->
    <select id="post_name" name="post_name" required>
        <?php echo $post_options; ?>
    </select><br>

    <label for="guild_name">ギルド名：</label>
    <input type="text" id="guild_name" name="guild_name"><br>

    <input type="submit" value="登録">
</form>

<?php require '../others/footer.php'; ?>
