<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../Assets/frontend/css/style.css">
</head>
<?php
    include '../backend/db.php';
    $db = new DB();

    $id = 2;
    $data = $db::getRows("SELECT * FROM `new` WHERE `id` = ?", [$id]); //вернёт из БД все записи по id

    foreach ($data as $item) {
        print ('
        <div class="blog-post">
            <h2 class="blog-post-title">'.$item['header'].'</h2>
            <hr>
            <img class="" src="http://placehold.jp/400x400.png" alt="фоточка, а на ней красоточка">
            <p>'.$item['body'].'</p>
            <p class="blog-post-meta">Автор статьи: '.$item['author'].'</p>
            <p class="blog-post-meta justy">Просмотры: '.$item['views'].'</p>
            <a href="index.php">Вернуться назад</a>
        </div>');
    }
?>