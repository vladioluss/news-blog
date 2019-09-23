<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../Assets/frontend/css/style.css">
</head>
<div class="container">
<?php
require '../backend/db.php';
$id = $_GET['id'];

$views = $_GET['views'];

$r = $_GET['rating'];

$dislike = $_POST['dislike']; //кнопка дизлайк
$like = $_POST['like']; //кнопка лайк

$textArea = $_POST['comment']; //поле ввода для комментария
$sendComm = $_POST['send_comm']; //кнопка отправить комментарий

    $data = $db->prepare("SELECT * FROM new WHERE id = ?"); //вернёт из БД все записи по id
    $data->execute([$id]);
    foreach ($data as $row) {
        print ('
                <h2 class="blog-post-title">'.$row['header'].'</h2>
                <hr>
                <img src="'.$row['img'].'" alt="*"><br><br>
                <p>'.$row['body'].'</p>
                <p class="blog-post-meta">Просмотры: '.$row['views'].'</p>
                <form action="view.php?id='.$id.'" method="POST">
                    <textarea name="comment" id="" cols="30" rows="" placeholder="Введите комментарий..."></textarea><br>
                    <input type="submit" name="send_comm" id="" value="Отправить"><br><br>
                    
        <a href="index.php">Вернуться назад</a><br><br>
        ');
    }

//--------система рейтинга
$d = $db->prepare("SELECT * FROM new WHERE id = ?"); //вывод комментов
$d->execute([$id]);
print ('<h5>Рейтинг:</h5><input type="submit" name="dislike" id="" value="-">');
foreach ($d as $r) {
    print ('<span> '.$r['rating'].' </span>');
}
print ('<input type="submit" name="like" id="" value="+"></form><br>');


if (isset($like)) { //алгоритм кнопки лайк
    $query = "UPDATE new SET rating = rating+1 WHERE id = :id";
    $params = [':id' => $id];
    $stmt = $db->prepare($query);
    $stmt->execute($params);
}
if (isset($dislike)) { //алгоритм кнопки дизлайк
    $query = "UPDATE new SET rating = rating-1 WHERE id = :id";
    $params = [':id' => $id];
    $stmt = $db->prepare($query);
    $stmt->execute($params);
}
//--------система комментов
if (isset($sendComm) && !empty($textArea)) { //добавить новый коммент
        $query = "INSERT INTO comments (text, news) VALUES (:textArea, :news)";
        $params = [':textArea' => $textArea, ':news' => $id];
        $data = $db->prepare($query);
        $data->execute($params);
    }

print ('<h5>Комментарии:</h5>');
$d = $db->prepare("SELECT * FROM comments WHERE news = ?"); //вывод комментов
$d->execute([$id]);
foreach ($d as $r) {
        print ($r['text'].'<br>');
}

//--------система просмотров
$query = "UPDATE new SET views = views+1 WHERE id = :id";
$params = [':id' => $id];
$stmt = $db->prepare($query);
$stmt->execute($params);
?>
</div><!--.container-->