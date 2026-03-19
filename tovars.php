<?php
$host = "localhost";
$port = "5432";
$dbname = "test_db";
$user = "postgres";
$password = "123";

try {
    $conn = new PDO("pgsql:host=localhost;dbname=test_db", "postgres", "123");
    echo "Успешное подключение через PDO!";
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}
?>