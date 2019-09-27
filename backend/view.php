<?php
session_start();
include '../backend/db.php';

$id = $_GET['id'];
$header = $_POST['header'];
$body = $_POST['body'];

$upd = $_POST['upd']; //кнопка редаттирования
$del = $_POST['del']; //кнопка удаления

if (isset($upd)) { //Редактирование записи
    $query = "UPDATE new SET header = :header, body = :body WHERE id = :id";
    $params = ['id' => $id, 'header' => $header, 'body' => $body];
    $stmt = $db->prepare($query);
    $stmt->execute($params);
}

if (isset($del)) { //Удаление записи
    $query =("DELETE FROM new WHERE id = :id");
    $params = ['id' => $id];
    $stmt = $db->prepare($query);
    $stmt->execute($params);
    header('Location: crud.php');
}

$stmt = $db->prepare("SELECT * FROM new WHERE id = ?");
$stmt->execute([$id]);
while ($row = $stmt->fetch(PDO::FETCH_LAZY)) {
    print ('
            <div class="my-edit">
                <form action="view.php?id='.$row['id'].'" method="POST">
                    <div class="modal-header">
                        <h4 class="modal-title">Редактировать запить ID:'.$row['id'].'</h4>
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
                            <a href="crud.php" class="btn btn-default">Назад</a>
                            <input name="upd" type="submit" class="btn btn-info" value="Сохранить">
                            <input name="del" type="submit" class="btn btn-danger" value="Удалить">
                        </div>
                </form>
            </div>
    ');
}


?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Assets/backend/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="../Assets/backend/js.js"></script>
</head>
