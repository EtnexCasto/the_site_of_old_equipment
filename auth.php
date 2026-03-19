<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$valid_credentials = [
    'admin' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' // пароль: password
];

if (!function_exists('checkSessionTimeout')) {
    function checkSessionTimeout() {
        $timeout = 1800; // 30 минут
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
            session_unset();
            session_destroy();
            header("Location: login.php?timeout=1");
            exit;
        }
        $_SESSION['last_activity'] = time();
    }
}

if (!function_exists('requireAuth')) {
    function requireAuth() {
        if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
            header("Location: login.php");
            exit;
        }
        checkSessionTimeout();
    }
}


// Обработка входа
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (array_key_exists($username, $valid_credentials) && 
        password_verify($password, $valid_credentials[$username])) {
        
        $_SESSION['authenticated'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['last_activity'] = time();
        
        // Редирект на защищенную страницу
        header("Location: admin_products.php");
        exit;
    } else {
        $_SESSION['login_error'] = 'Неверные учетные данные';
        header("Location: login.php");
        exit;
    }
}

// Выход из системы
if (isset($_GET['logout'])) {
    $_SESSION = [];
    session_destroy();
    header("Location: login.php");
    exit;
}
?>