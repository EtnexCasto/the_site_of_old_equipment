<?php
header('Content-Type: application/json');

$conn = pg_connect("host=localhost port=5432 dbname=test_db user=postgres password=123");
if (!$conn) {
    die(json_encode(['error' => 'Ошибка подключения: ' . pg_last_error()]));
}

$productId = $_GET['id'] ?? 0;
$query = "SELECT * FROM products WHERE id = $1";
$result = pg_query_params($conn, $query, [$productId]);

if (!$result) {
    die(json_encode(['error' => 'Ошибка запроса: ' . pg_last_error()]));
}

$product = pg_fetch_assoc($result);
pg_close($conn);

if (!$product) {
    die(json_encode(['error' => 'Товар не найден']));
}

echo json_encode([
    'id' => $product['id'],
    'name' => $product['name'],
    'image' => $product['image'],
    'main_price' => $product['main_price'],
    'old_price' => $product['old_price'],
    'discount' => $product['discount'],
    'description' => $product['description']
]);
?>