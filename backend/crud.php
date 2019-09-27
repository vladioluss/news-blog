<?php
session_start();
include '../backend/db.php';

$id = $_POST['id'];
$header = $_POST['header'];
$body = $_POST['body'];

$add = $_POST['ok']; //кнопка создания

if (isset($add)) { //Создание записи
    $query = "INSERT INTO new (header,body) VALUES (:header,:body)";
    $params = ['header' => $header, 'body' => $body];
    $stmt = $db->prepare($query);
    $stmt->execute($params);
}

$username = $_SESSION['login']; //LOGIN ADMIN

$sql = "SELECT * FROM users WHERE login = :login AND is_admin='1' "; //проверка на админа
$stmt = $db->prepare($sql);
$stmt->bindValue(':login', $username);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_LAZY);
if ($user == false) {
    $_SESSION['login'] = $user['login'];
    header('location: index.php'); //если не админ, то кинет на авторизацию
}
else
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD system</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Assets/backend/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="../Assets/backend/js.js"></script>
</head>
<body>
<div class="container">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Редактирование записей</h2>
                </div>
                <div class="col-sm-6">
                    <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Добавить новую запись</span></a>
                    <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Удалить</span></a>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>
                    <span class="custom-checkbox">
                        <input type="checkbox" id="selectAll">
                        <label for="selectAll"></label>
                    </span>
                </th>
                <th>ID</th>
                <th>Заголовок</th>
                <th>Текст статьи</th>
                <th>Просмотры</th>
                <th>Действия</th>
            </tr>
            </thead>
            <?php
            $data = $db->query("SELECT * FROM new")->fetchAll(PDO::FETCH_ASSOC); //вернёт из БД все записи
            foreach ($data as $row) {
                print ('
                <tbody>
                    <tr>
                        <td>
                            <span class="custom-checkbox">
                                <input type="checkbox" id="checkbox1" name="options[]" value="1">
                                <label for="checkbox1"></label>
                            </span>
                        </td>
                        <td>'.$row['id'].'</td>
                        <td>'.$row['header'].'</td>
                        <td>'.$row['body'].'</td>
                        <td>'.$row['views'].'</td>
                        <td>
                            <!--<a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Редактирование">&#xE254;</i></a>
                            <a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Удаление">&#xE872;</i></a>-->
                            <a href="view.php?id='.$row['id'].'" class="edit"><i class="material-icons" data-toggle="tooltip" title="Редактирование">&#xE254;</i></a>
                        </td>
                    </tr>
                </tbody>');
            } ?>
        </table>
    </div>
</div>

<!-- Edit Modal HTML 'ADD' -->
<div id="addEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="crud.php" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title">Содать запись</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Заголовок</label>
                        <input name="header" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Текст статьи</label>
                        <textarea name="body" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Отменить">
                    <input name="ok" type="submit" class="btn btn-success" value="Добавить">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal HTML 'UPDATE' -->
<!--<div id="editEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="crud.php" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title">Редактировать запить</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Заголовок</label>
                        <input name="header" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Текст статьи</label>
                        <textarea name="body" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Отменить">
                    <input name="upd" type="submit" class="btn btn-info" value="Сохранить">
                </div>
            </form>
        </div>
    </div>
</div>-->

<!-- Delete Modal HTML 'DELETE' -->
<!--<div id="deleteEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="crud.php" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title">Удалить запись</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Вы уверены что хотите удалить данную запить?</p>
                    <p class="text-warning"><small>Это действие необратимо!</small></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input name="del" type="submit" class="btn btn-danger" value="Удалить">
                </div>
            </form>
        </div>
    </div>
</div> -->
</body>
</html>