<?php 
session_start(); 
require '../others/header.php';
require '../others/menu.php';
require '../others/db-connect.php';

try {
    $pdo = new PDO($connect, USER, PASS);
    $sql = $pdo->prepare('
        SELECT u.user_name, u.level, p.post_name, p.role, p.features
        FROM User u
        INNER JOIN Post p ON u.post_id = p.post_id
        WHERE u.user_id = ?
    ');
    $sql->execute([$_GET['user_id']]);
    $user = $sql->fetch(PDO::FETCH_ASSOC); // ユーザーの詳細情報を取得
} catch (PDOException $e) {
    // データベース接続エラーやクエリエラーを処理
    echo "エラー: " . $e->getMessage();
    die();
}
?>

<h1><span class="blue">&lt;</span>Table<span class="blue">&gt;</span> <span class="yellow">Responsive</span></h1>
<h2>Created with love by <a href="https://github.com/pablorgarcia" target="_blank">Pablo García</a></h2>

<table class="container">
    <thead>
        <tr>
            <th><h1>名前</h1></th>
            <th><h1>レベル</h1></th>
            <th><h1>役職</h1></th>
            <th><h1>役割</h1></th>
            <th><h1>特徴</h1></th>
        </tr>
    </thead>
    <tbody>
        <?php if ($user) : ?>
            <tr>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><?php echo htmlspecialchars($user['level']); ?></td>
                <td><?php echo htmlspecialchars($user['position']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
                <td><?php echo htmlspecialchars($user['feature']); ?></td>
            </tr>
        <?php else : ?>
            <tr>
                <td colspan="5">ユーザーが見つかりませんでした</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require '../others/footer.php'; ?>
