<?php
session_start();
require '../backend/db.php';

//$login = $_POST['login']; //поле ввода логина
//$password = $_POST['password']; //поле ввода пароля
$loginIn = $_POST['loginin']; //кнопка войти

if(isset($loginIn)) {
    /*$query = "SELECT * FROM users WHERE login = :login";
    $params = [':login' => $login];
    $data = $db->prepare($query);
    $data->execute($params);
    $row = $data->fetch(PDO::FETCH_ASSOC);
    if($row === false) {
        print('Неправильная комбинация имени пользователя и пароля');
    } else {
        $validPassword = password_verify($password, $row['password']);
        if($validPassword) {
            $_SESSION['login'] = $row['login'];
            header('Location: home.php');
            exit;
        } else {
            print_r('Неправильная комбинация имени пользователя и пароля!');
            var_dump($validPassword,$_SESSION['login']);
        }
    }*/


    $username = !empty($_POST['login']) ? trim($_POST['login']) : null;
    $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $sql = "SELECT id, login, password FROM users WHERE login = :login";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':login', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if($user === false) {
        //Could not find a user with that username!
        die('Incorrect username / password combination!');
    } else{
        //User account found. Check to see if the given password matches the
        //password hash that we stored in our users table.

        //Compare the passwords.
        $validPassword = password_verify($passwordAttempt, $user['password']);

        //If $validPassword is TRUE, the login has been successful.
        if($validPassword) {
            //Provide the user with a login session.
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = time();

            //Redirect to our protected page, which we called home.php
            header('Location: home.php');
            exit;
        } else{
            //$validPassword was FALSE. Passwords do not match.
            die('Incorrect username / password combination!');
        }
    }
}
?>

<form action="login.php" method="POST">
    <input type="text" name="login" value="admin">
    <input type="password" name="password" value="admin">
    <input type="submit" name="loginin" value="Войти">
</form>
<a href="index.php">Вернуться назад</a>
