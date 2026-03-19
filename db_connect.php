<?php
    $conn = pg_connect("host=localhost port=5432 dbname=test_db user=postgres password=123");
    if (!$conn) {
        die("Ошибка подключения: " . pg_last_error());
    }
    
    $query = "SELECT * FROM products";
    $result = pg_query($conn, $query);
    
    if (!$result) {
        die("Ошибка запроса: " . pg_last_error());
    }
?>