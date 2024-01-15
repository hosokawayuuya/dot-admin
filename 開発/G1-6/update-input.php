<?php
require '../others/header.php';
require '../others/menu.php';
require '../others/db-connect.php';

// URLパラメータから受け取ったユーザー名とポスト名を取得
$user_name = $_GET['user_name'];
$post_name = $_GET['post_name'];

// データベース接続処理
try {
    $pdo = new PDO($connect, USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ポストテーブルからポスト名を取得
    $post_query = $pdo->query("SELECT post_id, post_name FROM Post");
    $post_options = '';
    while ($post_row = $post_query->fetch()) {
        $selected = ($post_name === $post_row['post_name']) ? 'selected' : '';
        $post_options .= "<option value='" . $post_row['post_id'] . "' $selected>" . $post_row['post_name'] . "</option>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} finally {
    $pdo = null; // データベース接続解除
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User情報更新</title>
</head>
<body>
    <h2>User情報更新</h2>
    <form action="update-output.php" method="post">
        <label for="new_user_name">新しいユーザー名：</label>
        <input type="text" id="new_user_name" name="new_user_name" value="<?php echo $user_name; ?>" required><br>

        <label for="new_post_id">新しいポスト：</label>
        <select id="new_post_id" name="new_post_id" required>
            <?php echo $post_options; ?>
        </select><br>

        <input type="hidden" name="old_user_name" value="<?php echo $user_name; ?>">
        <input type="hidden" name="old_post_name" value="<?php echo $post_name; ?>">

        <input type="submit" value="更新">
    </form>
</body>
</html>
