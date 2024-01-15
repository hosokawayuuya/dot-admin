<form action="delete-output.php" method="post">
    <table class="design">
    <tr>
      <th><h1>名前</h1></th>
      <th><h1>レベル</h1></th>
      <th><h1>役職</h1></th>
      <th><h1>役割</h1></th>
      <th><h1>特徴</h1></th>
      <th><h1>操作</h1></th>
    </tr>
    <?php
      $pdo=new PDO($connect, USER, PASS);
      foreach ($pdo->query('SELECT u.user_id, u.user_name, u.level, p.post_name FROM User u INNER JOIN Post p ON u.post_id = p.post_id') as $row) {
        echo '<tr>';
        echo '<td>',$row['user_name'],'</td>';
        echo '<td>',$row['level'],'</td>';
        echo '<td>',$row['post_name'],'</td>';
        echo '<td>',$row['role'],'</td>';
        echo '<td>',$row['features'],'</td>';
        echo '<td>';
        echo '<input type="hidden" name="id" value="',$row['user_id'], '">';
        echo '<button type="submit">削除</button>';
        echo '</td>';
        echo '</tr>';
        echo "\n";
      }
    ?>
    </table>
</form>