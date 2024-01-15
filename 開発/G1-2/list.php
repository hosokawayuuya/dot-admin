<?php
require '../others/header.php';
require '../others/menu.php';
require '../others/db-connect.php';

    try {
        $pdo = new PDO($connect, USER, PASS);
        $sql = $pdo->prepare('
            SELECT u.user_name, u.level, p.post_name, p.role, p.features
            FROM User u
            INNER JOIN Post p ON u.post_id = p.post_id
        ');
        $sql->execute();
        $users = $sql->fetchAll(PDO::FETCH_ASSOC); // ユーザーの詳細情報を取得
    } catch (PDOException $e) {
        // データベース接続エラーやクエリエラーを処理
        echo "エラー: " . $e->getMessage();
        die();
    }
    ?>

    <h1><span class="blue">&lt;</span>一覧<span class="blue">&gt;</span> <span class="yellow">勇者はこちら</span></h1>
    <h2>Created by <a href="https://github.com/pablorgarcia" target="_blank">dot admin</a></h2>

    <form action="../G1-6/update-input.php" method="post">
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
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['level']); ?></td>
                        <td><?php echo htmlspecialchars($user['post_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td><?php echo htmlspecialchars($user['features']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div style="text-align: center">
            <button type="button" onclick="history.back()">戻る</button>
        </div>
    </form>
<?php require '../others/footer.php'; ?>
