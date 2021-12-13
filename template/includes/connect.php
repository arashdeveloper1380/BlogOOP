<?php
try {
    $connection = new PDO('mysql:host=localhost;dbname=blog;charset=utf8','root','');
} catch (PDOException $e) {
    echo "Connection Error Is : ".$e->getMessage();
}