<?php
session_start();
require "../backend/db.php";

$loginIn = $_POST['log']; //кнопка войти

if(isset($loginIn)) {
    $username = $_POST['login']; //поле ввода логина
    $password = $_POST['password']; //поле ввода пароля

    $sql = "SELECT * FROM users WHERE login = :login AND password = :password AND is_admin='1' ";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':login', $username);
    $stmt->bindValue(':password', $password);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_LAZY);
    if ($user == true) {
        $_SESSION['login'] = $user['login'];
        print 'Вы вошли <a href="crud.php">Перейти к админке</a>';
    }
    else
        die ('Ошибка входа!');
}
?>

<form action="index.php" method="post">
    <input type="text" name="login" value="admin">
    <input type="text" name="password" value="admin">
    <input type="submit" name="log" value="Login">
</form>
