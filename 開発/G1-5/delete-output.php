<?php
// delete.php

require '../others/header.php';
require '../others/menu.php';
require '../others/db-connect.php'; // db-connect.php を読み込む

if (isset($_POST['user_name']) && isset($_POST['post_name'])) {
    $user_name = $_POST['user_name'];
    $post_name = $_POST['post_name'];

    try {
        $pdo = new PDO($connect, USER, PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 削除処理を行う SQL 文
        $delete_sql = "DELETE FROM User WHERE user_name = :user_name AND post_id = (SELECT post_id FROM Post WHERE post_name = :post_name)";
        $delete_stmt = $pdo->prepare($delete_sql);
        $delete_stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
        $delete_stmt->bindParam(':post_name', $post_name, PDO::PARAM_STR);
        $delete_stmt->execute();

        echo "削除が完了しました。";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $pdo = null; // データベース接続解除
    }
} else {
    echo "Error: パラメータが不足しています。";
}

?>
<a href="../G1-6/update.php">更新一覧画面へ</a>
<?php require '../others/footer.php'; ?>