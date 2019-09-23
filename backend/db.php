<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=project-news', 'root', '');
} catch (PDOException $e) {
    print "Ошибки: " . $e->getMessage();
    die();
}