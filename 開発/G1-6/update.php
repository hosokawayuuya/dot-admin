<?php
require '../others/header.php';
require '../others/menu.php';
require '../others/db-connect.php';
?>

  <h2>User情報更新</h2>
  <table border="1">
    <tr>
      <th>勇者名</th>
      <th>level</th>
      <th>役職</th>
      <th>操作</th>
    </tr>
    <?php
      try {
        $pdo = new PDO($connect, USER, PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // ユーザーテーブルとポストテーブルを結合してデータを取得
        $sql = "SELECT User.user_name, User.level, Post.post_name FROM User JOIN Post ON User.post_id = Post.post_id";
        $stmt = $pdo->query($sql);

        while ($row = $stmt->fetch()) {
          echo "<tr>";
          echo "<td>" . $row["user_name"]. "</td>";
          echo "<td>" . $row["level"]. "</td>";
          echo "<td>" . $row["post_name"]. "</td>";
          echo "<td><a href='update-input.php?user_name=" . $row["user_name"] . "&post_name=" . $row["post_name"] . "'>更新</a> | <a href='update-output.php?user_name=" . $row["user_name"] . "&post_name=" . $row["post_name"] . "'>削除</a></td>";
          echo "</tr>";
        }
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }

      $pdo = null; // データベース接続解除
    ?>
  </table>
<?php require '../others/footer.php'; ?>
