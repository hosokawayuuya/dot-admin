<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User情報更新</title>
    <style>
        body {
            font-family: 'Georgia', serif;
            background-color: #e0d4b7;
            margin: 0;
            padding: 0;
            background-image: url('map_background.jpg'); /* ふるい地図風の背景画像 */
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        h2 {
            text-align: center;
            color: #1a1a1a;
            margin-bottom: 20px;
        }

        .menu {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .menu a {
            margin: 10px;
            padding: 5px 10px;
            text-decoration: none;
            color: #705539;
            border: 1px solid #705539;
            border-radius: 5px;
            background-color: #fff;
        }

        form {
            width: 80%;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px; /* フォームの上部に余白を追加 */
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #1a1a1a;
        }

        input, select {
            width: calc(100% - 16px);
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #705539;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #543d2b;
        }
    </style>
</head>
<body>
<?php
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

    // ギルド情報取得のクエリを実行
$guild_query = $pdo->query("SELECT guild_id, guild_name FROM Guild");

// ギルド情報を格納する変数の初期化
$user_guild_id = ''; // あるいは適切な初期値

// ユーザーが所属しているギルド情報を取得
if ($user_name) {
    $user_query = $pdo->prepare("SELECT guild_id FROM User WHERE user_name = :user_name");
    $user_query->bindParam(':user_name', $user_name);
    $user_query->execute();

    // ユーザーが存在する場合、ギルドIDを取得
    if ($user_row = $user_query->fetch()) {
        $user_guild_id = $user_row['guild_id'];
    }
}

// ギルド情報のオプションを生成
$guild_options = '';
while ($guild_row = $guild_query->fetch()) {
    $selected = ($user_guild_id === $guild_row['guild_id']) ? 'selected' : '';
    $guild_options .= "<option value='" . $guild_row['guild_id'] . "' $selected>" . $guild_row['guild_name'] . "</option>";
}


    // ユーザーの情報を取得
    $user_info_query = $pdo->prepare("SELECT user_name, post_id, guild_id FROM User WHERE user_name = :user_name");
    $user_info_query->bindParam(':user_name', $user_name);
    $user_info_query->execute();
    $user_info = $user_info_query->fetch();
    $user_post_id = $user_info['post_id'];
    $user_guild_id = $user_info['guild_id'];

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} finally {
    $pdo = null; // データベース接続解除
}
?>

<form action="update-output.php" method="post">
    <h2>勇者情報更新</h2>

    <label for="new_user_name">新しい勇者名：</label>
    <input type="text" id="new_user_name" name="new_user_name" value="<?php echo $user_info['user_name']; ?>" required>

    <label for="new_post_id">新しい役職：</label>
    <select id="new_post_id" name="new_post_id" required>
        <?php echo $post_options; ?>
    </select>

    <label for="new_guild_id">新しいギルド：</label>
    <select id="new_guild_id" name="new_guild_id" required>
        <?php echo $guild_options; ?>
    </select>

    <input type="hidden" name="old_user_name" value="<?php echo $user_name; ?>">
    <input type="hidden" name="old_post_name" value="<?php echo $post_name; ?>">

    <input type="submit" value="更新">
</form>

</body>
</html>
