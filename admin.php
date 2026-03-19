<?php
require 'auth.php';
requireAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TECHOUT | Администрирование</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav class="container">
            <div class="logo">
                <h1 id="logo-admin">Админ-панель</h1>
            </div>
            <ul class="menu-admin">
                <li><a href="index.php">Назад</a></li>
                <li><a href="admin_products.php">Товары</a></li>
                <li><a href="admin_orders.php">Заказы</a></li>
                <li><a href="?logout" class="text-danger">Выйти (<?= $_SESSION['username'] ?? '' ?>)</a></li>
            </ul>
        </nav>
    </header>

    <section class="container mt-4">
        <?= $content ?? '' ?>
    </section>
</body>
</html>