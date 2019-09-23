<?php
session_start();
require "../backend/db.php"
?>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../Assets/frontend/css/style.css">
</head>
<body>
    <div class="container">
        <header class="blog-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <div class="col-4 pt-1">
                    <a class="text-muted" href="#">Logo</a>
                </div>
                <div class="col-4 text-center">
                    <a class="blog-header-logo text-dark" href="">NEWS</a>
                 </div>
                <div class="col-4 d-flex justify-content-end align-items-center">
                    <div><?php var_dump($_SESSION['id']);?></div>
                    <a class="btn btn-sm btn-outline-secondary" href="login.php">Войти</a>&nbsp;
                    <a class="btn btn-sm btn-outline-secondary" href="reg.php">Регистрация</a>
                </div>
            </div>
        </header><br><br>
        <div class="d-flex flex-wrap">
            <?php
            $data = $db->query("SELECT * FROM new")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $row) {
                print('
                <div class="col-lg-6">
                    <div class="card flex-md-row mb-4 shadow-sm h-md-250">
                        <div class="card-body d-flex flex-column align-items-start">
                            <h3 class="mb-0">
                                <a class="text-dark" href="view.php?id='.$row['id'].'">'.$row['header'].'</a>
                            </h3>
                            <p class="card-text mb-auto">'.$row['body'].'</p>
                            <div class="mb-1 text-muted">Автор: '.$row['author'].'</div>
                            <div class="mb-1 text-muted">Просмотров: '.$row['views'].'</div>
                            <a href="view.php?id='.$row['id'].'">Перейти к новости</a>
                        </div>
                        <img class="card-img-right flex-auto d-none d-lg-block" src="'.$row['img'].'" alt="*">
                    </div>
                </div>
                ');
            }
            ?>
        </div>
    </div>

    <footer class="blog-footer">
        <p>NEWS SITE</p>
    </footer>
</body>