<?php
session_start();
require '../backend/db.php';
$db = new DB();

$login = $_POST['login'];
$password = $_POST['password'];
$reg = $_POST['reg'];

if(isset($reg)) {
    //check if username already exists
    $query = "SELECT COUNT(login) AS num FROM users WHERE login = :login";
    $args = ['login' => $login];
    $row = $db->getRow($query, $args);
    if($row['num'] > 0) { //If username already exists - display error
        die('Такой пользователь уже зарегистрирован<br><a href="reg.php">Вернуться назад</a>');
    }
    else {
        $query = "INSERT INTO users (login, password) VALUES (:login, :password)";
        $args = ['login' => $login, 'password' => $password];
        $db::sql($query, $args);
        die("Вы зарегистрировались<br><a href='login.php'>Вернуться назад</a>");
    }
}
?>

<form action="reg.php" method="POST">
    <input type="text" name="login" value="admin">
    <input type="password" name="password" value="admin"><br>
    <input type="submit" name="reg" value="Reg">
</form>

<a href="index.php">Вернуться назад</a>