<?php require '../others/header.php'; ?>
<?php require '../others/menu.php'; ?>
<form action="login-output.php" method="post">
ログイン名<input type="text" name="login"><br>
パスワード<input type="password" name="password"><br>
<input type="submit" value="ログイン">
</form>
<?php require '../others/footer.php'; ?>