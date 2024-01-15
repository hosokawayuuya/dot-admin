<?php
      $pdo=new PDO($connect, USER, PASS);
      $sql=$pdo->prepare(' delete from User where user_id=?');

      if ($sql->execute([$_POST['user_id']])){
        echo '削除に成功しました。';
      }else{
        echo '削除に失敗しました。';
      }
    ?>
    <br><hr><br>
    <table class="design">
      <tr>
        <th><h1>名前</h1></th>
        <th><h1>レベル</h1></th>
        <th><h1>役職</h1></th>
        <th><h1>役割</h1></th>
        <th><h1>特徴</h1></th>
      </tr>
    <?php
      foreach ($pdo->query( 'select * from User') as $row){
        echo '<tr>';
        echo '<td>',$row['user_name'],'</td>';
        echo '<td>',$row['level'],'</td>';
        echo '<td>',$row['post_name'],'</td>';
        echo '<td>',$row['role'],'</td>';
        echo '<td>',$row['features'],'</td>';
        echo '</tr>';
        echo "\n";
      }
    ?>
    </table>