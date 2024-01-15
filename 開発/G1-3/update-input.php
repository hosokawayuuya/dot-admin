<?php
require '../others/header.php';
require '../others/menu.php';
require '../others/db-connect.php';
?>
    <table class="design">
      <tr>
        <th>名前</th>
        <th>レベル</th>
        <th>役職</th>
        <th>操作</th>
      </tr>
    <?php
      $pdo=new PDO($connect, USER, PASS);
      foreach ($pdo->query( 'select * from User') as $row){
        echo '<form action="update-output.php" method="post">';
        echo '<tr>';
        echo '<td>','<input type="hidden" name="user_id" value="',$row['user_id'],'">','</td>';
        echo '<td>','<input type="text" name="user_name" value="',$row['user_name'],'">','</td>';
        echo '<td>','<input type="text" name="level" value="',$row['level'],'">','</td>';
        echo '<td>','<input type="text" name="post_id" value="',$row['post_id'],'">','</td>';
        echo '<td>';;
        echo '<button type="submit" class="btn-flat-border">編集</button>';
        echo '</td>';
        echo '</tr>';
        echo '</form>';
        echo "\n";
      }
    ?>
    </table>
<?php require '../others/footer.php'; ?>
