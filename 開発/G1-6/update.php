<?php
require '../others/db-connect.php';
// 新しいギルドを追加する処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['guild_name'])) {
        $guildName = $_POST['guild_name'];

        try {
            $pdo = new PDO($connect, USER, PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // ギルド名が被っていないか確認
            $checkDuplicate = $pdo->prepare("SELECT COUNT(*) FROM Guild WHERE guild_name = :guild_name");
            $checkDuplicate->bindParam(':guild_name', $guildName);
            $checkDuplicate->execute();

            if ($checkDuplicate->fetchColumn() == 0) {
                // ギルドが存在しない場合、新しいギルドを追加
                $insertGuild = $pdo->prepare("INSERT INTO Guild (guild_name) VALUES (:guild_name)");
                $insertGuild->bindParam(':guild_name', $guildName);
                $insertGuild->execute();

                // ギルドが追加されたら、メッセージを表示
                echo "ギルドが追加されました。";
            } else {
                echo "同じ名前のギルドが既に存在します。";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $pdo = null; // データベース接続解除
    }
}
require '../others/header.php';
require '../others/menu.php';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>dot admin</title>
  <style>
    body {
      font-family: 'Georgia', serif;
      background-color: #e0d4b7;
      margin: 0;
      padding: 0;
      background-image: url('map_background.jpg');
      background-size: cover;
      background-position: center;
    }

    #wrapper {
      width: 80%;
      margin: auto;
      background-color: rgba(255, 255, 255, 0.8);
      padding: 20px;
      margin-top: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #705539;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    a {
      text-decoration: none;
      color: #705539;
    }

    a:hover {
      text-decoration: underline;
    }

    #quest-board {
      width: 80%;
      margin: auto;
      background-color: rgba(255, 255, 255, 0.8);
      padding: 20px;
      margin-top: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    #quest-list {
      list-style-type: none;
      padding: 0;
    }

    .quest {
      border-bottom: 1px solid #ddd;
      padding: 10px 0;
    }

    .quest h3 {
      margin: 0;
      color: #1a1a1a;
    }

    .quest p {
      margin-top: 5px;
      margin-bottom: 10px;
      color: #333;
    }

    #add-quest-form {
      margin-top: 20px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      color: #1a1a1a;
    }

    input, textarea {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      box-sizing: border-box;
    }

    button {
      background-color: #705539;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background-color: #543d2b;
    }
  </style>
</head>
<body>

<div id="particles-js">
  <div id="wrapper">
    <h2>勇者情報更新</h2>
    <table>
      <tr>
        <th>勇者名</th>
        <th>level</th>
        <th>役職</th>
        <th>ギルド名</th>
        <th>操作</th>
      </tr>
      <?php
        try {
            $pdo = new PDO($connect, USER, PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // User テーブル、Post テーブル、Guild テーブルを結合してデータを取得
            $sql = "SELECT User.user_name, User.level, Post.post_name, Guild.guild_name 
                    FROM User 
                    JOIN Post ON User.post_id = Post.post_id
                    LEFT JOIN Guild ON User.guild_id = Guild.guild_id"; // ユーザーがギルドに所属している場合を考慮して LEFT JOIN を使用
            $stmt = $pdo->query($sql);

          while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td>" . $row["user_name"]. "</td>";
            echo "<td>" . $row["level"]. "</td>";
            echo "<td>" . $row["post_name"]. "</td>";
            echo "<td>" . $row["guild_name"]. "</td>";
            echo "<td><a href='../G1-6/update-input.php?user_name=" . $row["user_name"] . "&post_name=" . $row["post_name"] . "'>更新</a> | <a href='../G1-5/delete-input.php?user_name=" . $row["user_name"] . "&post_name=" . $row["post_name"] . "'>削除</a></td>";
            echo "</tr>";
          }
        } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
        }

        $pdo = null; // データベース接続解除
      ?>
    </table>
  </div>
</div>

<div id="quest-board">
  <h2 style="text-align: center; color: #1a1a1a;">冒険者ギルド掲示板</h2>

  <ul id="quest-list">
    <!-- Quests will be dynamically added here -->
  </ul>

  <div id="add-quest-form">
    <h3 style="color: #1a1a1a;">新しいギルドを追加</h3>
    <form method="post" action="">
        <label for="guild-name">ギルド名:</label>
        <input type="text" id="guild-name" name="guild_name" required>

        <button type="submit">ギルドを追加</button>
    </form>
  </div>
</div>

<script>
  function addQuest() {
    const title = document.getElementById('quest-title').value;
    const description = document.getElementById('quest-description').value;

    if (title && description) {
      const questList = document.getElementById('quest-list');

      const questItem = document.createElement('li');
      questItem.classList.add('quest');

      const questTitle = document.createElement('h3');
      questTitle.textContent = title;

      const questDescription = document.createElement('p');
      questDescription.textContent = description;

      questItem.appendChild(questTitle);
      questItem.appendChild(questDescription);

      questList.appendChild(questItem);

      // 清空表单
      document.getElementById('quest-title').value = '';
      document.getElementById('quest-description').value = '';
    } else {
      alert('ギルド名と詳細を入力してください！');
    }
  }
</script>

</body>
</html>
