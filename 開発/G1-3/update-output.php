<?php
require '../others/header.php';
require '../others/menu.php';
require '../others/db-connect.php';
?>
    <form action="signup-input.php" method="post">
    <?php
      $pdo=new PDO($connect, USER, PASS);
      $sql=$pdo->prepare(' update User set user_name=?,level=?,post_id=? where user_id=?');

      if (empty($_POST['user_name'])){
        echo '名前を入力してください。';
      }else if (empty($_POST['level'])){
        echo 'レベルを入力してください。';
      }else if ((empty($_POST['view']))){
        echo '役職を入力してください。';
      }else

      if ($sql->execute([htmlspecialchars($_POST['user_name']), $_POST['level'],$_POST['user_id']])){
        echo '更新に成功しました。';
      } else {
        echo '更新に失敗しました。';
      }
    ?>
        <hr>
        <table class="design">
        <tr>
          <th>名前</th>
          <th>レベル</th>
          <th>役職</th>
          <th>操作</th>
        </tr>
      <?php
      foreach ($pdo->query( 'select * from User') as $row){
        echo '<tr>';
        echo '<td>',$row['user_name'],'</td>';
        echo '<td>',$row['level'],'</td>';
        echo '<td>',$row['post_id'],'</td>';
        echo '<td>';
        echo '</td>';
        echo '</tr>';
        echo "\n";
      }
    ?>
    </table>
    </form>