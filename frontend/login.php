<?php
session_start();
require '../backend/db.php';

$loginIn = $_POST['loginin']; //кнопка войти

if(isset($loginIn)) {
    $username = $_POST['login']; //поле ввода логина
    $passwordAttempt = $_POST['password']; //поле ввода пароля

    $sql = "SELECT id, login, password FROM users WHERE login = :login AND password = :password";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':login', $username);
    $stmt->bindValue(':password', $passwordAttempt);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_LAZY);
    if ($user == true) {
        $_SESSION['login'] = $user['login'];
        print('Вы вошли как: '.$_SESSION['login']);
    }
    else print 'Ошибка входа!';
}
?>

<form action="login.php" method="POST">
    <input type="text" name="login" value="admin">
    <input type="text" name="password" value="admin">
    <input type="submit" name="loginin" value="Войти">
</form>
<a href="index.php">Вернуться назад</a>
