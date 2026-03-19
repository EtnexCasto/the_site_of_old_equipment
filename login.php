<?php

// Если уже авторизован, перенаправить в админку
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    header("Location: admin_products.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в админ-панель</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2 class="text-center mb-4">Вход в админ-панель</h2>
            
            <?php if (isset($_SESSION['login_error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['login_error'] ?></div>
                <?php unset($_SESSION['login_error']); ?>
            <?php endif; ?>
            
            <form method="POST" action="auth.php">
                <div class="mb-3">
                    <label for="username" class="form-label">Логин</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <button type="submit" name="login" class="btn btn-primary w-100">Войти</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>