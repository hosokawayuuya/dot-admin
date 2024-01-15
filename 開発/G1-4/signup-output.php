<?php
    $pdo=new PDO($connect, USER, PASS);
    $sql=$pdo->prepare('insert into User(user_name, post_name, guild_name) values (?, ?, ?)');
    if(empty($_POST['user_name'])){
        echo '名前を入力してください。';
    }else if(empty($_POST['post_name'])){
        echo '説明文を入力してください。';
    }else if(empty($_POST['guild_name'])){
      echo 'ギルド名を入力してください。';
    }else if($sql->execute([ $_POST['user_name'], $_POST['post_name'],$_POST['guild_name'] ]) ) {
        echo '<font color="red">追加に成功しました。</font>';
    }else{
        echo '<font color="red">追加に失敗しました。</font>';
    }
?>
    <br><hr><br>
    <table class="design">
      <tr>
        <th>名前</th>
        <th>役職</th>
        <th>ギルド名</th>
      </tr>
      <?php
        foreach ($pdo->query( 'select * from User') as $row){
          echo '<tr>';
          echo '<td>',$row['user_name'],'</td>';
          echo '<td>',$row['post_name'],'</td>';
          echo '<td>',$row['guild_name'],'</td>';
          echo '</tr>';
          echo "\n";
        }
      ?>
    </table>