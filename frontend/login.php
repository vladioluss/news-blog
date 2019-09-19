<?php
session_start();
require '../backend/db.php';
$db = new DB();

$login = $_POST['login'];
$password = $_POST['password'];
$loginIn = $_POST['loginin']; //кнопка войти

if(isset($loginIn)) {
    $query = "SELECT * FROM users WHERE login = :login AND password = :password";
    $args = ['login'=>$login, 'password'=>$password];
    $row = $db::getRows($query, $args);
    if ($row == true) {
        $_SESSION['login'] = $row['login'];
        print(' Вы вошли в аккаунт как: ');
        var_dump('session: ',$_SESSION['login'],'login: ',$row['login']);
    }
    else print 'Ошибка входа!';
}
?>

<form action="login.php" method="POST">
    <input type="text" name="login" value="admin">
    <input type="password" name="password" value="admin">
    <input type="submit" name="loginin" value="Войти">
</form>
<a href="index.php">Вернуться назад</a>
