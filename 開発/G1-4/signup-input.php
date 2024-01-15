
<?php
require '../others/header.php';
require '../others/menu.php';
require '../others/db-connect.php';
?>
    <div style="text-align: center">
      <form action="signup-output.php" method="post">
        <p>名前<input type="text" name="user_name"></p>
        <p>役職<input type="text" name="post_name"></p>
        <p>ギルド名<input type="text" name="guild_name"></p>
      </form>
    </div>
<?php require '../others/footer.php'; ?>

