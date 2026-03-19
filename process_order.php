<?php
header('Content-Type: application/json');

$conn = pg_connect("host=localhost port=5432 dbname=test_db user=postgres password=123");
if (!$conn) {
    echo json_encode(['success' => false, 'error' => 'Ошибка подключения к базе данных']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$firstName = pg_escape_string($conn, $data['first_name']);
$secondName = pg_escape_string($conn, $data['second_name']);
$thirdName = isset($data['third_name']) ? pg_escape_string($conn, $data['third_name']) : null;
$email = pg_escape_string($conn, $data['email']);
$address = pg_escape_string($conn, $data['address']);
$paymentMethod = pg_escape_string($conn, $data['payment']);
$quantity = (int)$data['quantity'];
$total = (int)$data['total'];
$productId = (int)$data['product_id'];

$query = "INSERT INTO orders (
    first_name, 
    second_name, 
    third_name, 
    email, 
    address, 
    method_pay, 
    counts, 
    total,
    product_id
) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9) RETURNING id";

$result = pg_query_params($conn, $query, [
    $firstName,
    $secondName,
    $thirdName,
    $email,
    $address,
    $paymentMethod,
    $quantity,
    $total,
    $productId
]);

if ($result) {
    $orderId = pg_fetch_result($result, 0, 0);
    echo json_encode(['success' => true, 'order_id' => $orderId]);
} else {
    echo json_encode(['success' => false, 'error' => pg_last_error($conn)]);
}

pg_close($conn);
?>