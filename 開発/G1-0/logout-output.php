<?php session_start(); ?>
<?php require '../others/header.php'; ?>
<?php require '../others/menu.php'; ?>
<?php
if(isset($_SESSION['customer'])){
    unset($_SESSION['customer']);
    echo 'ログアウトしました。';
}else{
    echo 'すでにログアウトしています。';
}
?>
<?php require '../others/footer.php'; ?>