<?php
session_start();
require '../backend/db.php';

$login = $_POST['login'];
$password = $_POST['password'];
$reg = $_POST['reg'];

if(isset($reg)) {
    $query = "SELECT COUNT(login) AS num FROM users WHERE login = :login";
    $params = [':login' => $login];
    $data = $db->prepare($query);
    $data->execute($params);

    $row = $data->fetch(PDO::FETCH_ASSOC);
    if($row['num'] > 0) {
        die('Пользователь уже существует!');
    }

    $passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));

    $query = "INSERT INTO users (login, password) VALUES (:login, :password)";
    $params = [':login' => $login, ':password' => $passwordHash];
    $data = $db->prepare($query);
    $data->execute($params);

    if($data) {
        echo 'Вы зарегистрировались';
        var_dump($query, $params);
    }
}
?>

<form action="reg.php" method="POST">
    <input type="text" name="login" value="admin">
    <input type="password" name="password" value="admin"><br>
    <input type="submit" name="reg" value="Reg">
</form>

<a href="index.php">Вернуться назад</a>