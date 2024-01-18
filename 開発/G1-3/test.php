<?php
// delete.php

require '../others/header.php';
require '../others/menu.php';
require '../others/db-connect.php';

if (isset($_GET['user_name']) && isset($_GET['post_name'])) {
    // URL パラメータからユーザー名とポスト名を取得
    $user_name = $_GET['user_name'];
    $post_name = $_GET['post_name'];

    // データベースから削除するデータを取得
    try {
        $pdo = new PDO($connect, USER, PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM User WHERE user_name = :user_name AND post_id = (SELECT post_id FROM Post WHERE post_name = :post_name)");
        $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
        $stmt->bindParam(':post_name', $post_name, PDO::PARAM_STR);
        $stmt->execute();

        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // URL パラメータが不足している場合、エラーメッセージを表示
    echo "Error: パラメータが不足しています。";
}

// 削除確認画面を表示
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User情報削除</title>
</head>
<body>
    <h2>User情報削除確認</h2>
    <?php if (isset($user_data) && !empty($user_data)): ?>
        <p>以下のユーザー情報を削除しますか？</p>
        <p>ユーザー名: <?php echo htmlspecialchars($user_data['user_name']); ?></p>
        <p>レベル: <?php echo htmlspecialchars($user_data['level']); ?></p>
        <p>ポスト名: <?php echo htmlspecialchars($post_name); ?></p>
        <form action="delete-output.php" method="post">
            <input type="hidden" name="user_name" value="<?php echo htmlspecialchars($user_data['user_name']); ?>">
            <input type="hidden" name="post_name" value="<?php echo htmlspecialchars($post_name); ?>">
            <input type="submit" value="削除する">
        </form>
    <?php else: ?>
        <p>ユーザー情報が見つかりません。</p>
    <?php endif; ?>
    <a href="../G1-6/update.php">戻る</a>
</body>
</html>
