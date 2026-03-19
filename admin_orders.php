<?php
require 'auth.php';
requireAuth();

require 'db_connect.php';

// Обработка действий
if(isset($_GET['action'])) {
    switch($_GET['action']) {
        case 'add':
            // Добавление заказа
            $query = "INSERT INTO orders (first_name, second_name, third_name, email, address, method_pay, counts, total) 
                      VALUES ($1, $2, $3, $4, $5, $6, $7, $8)";
            pg_query_params($conn, $query, [
                $_POST['first_name'],
                $_POST['second_name'],
                $_POST['third_name'] ?? null,
                $_POST['email'],
                $_POST['address'],
                $_POST['method_pay'],
                $_POST['counts'],
                $_POST['total']
            ]);
            break;
            
        case 'edit':
            // Редактирование заказа
            $query = "UPDATE orders SET 
                      first_name = $1, second_name = $2, third_name = $3, email = $4, 
                      address = $5, method_pay = $6, counts = $7, total = $8 
                      WHERE id = $9";
            pg_query_params($conn, $query, [
                $_POST['first_name'],
                $_POST['second_name'],
                $_POST['third_name'] ?? null,
                $_POST['email'],
                $_POST['address'],
                $_POST['method_pay'],
                $_POST['counts'],
                $_POST['total'],
                $_POST['id']
            ]);
            break;
            
        case 'delete':
            // Удаление заказа
            $id = $_GET['id'] ?? 0;
            $id = (int)$id;
            
            if ($id > 0) {
                $message = "Удаляем заказ с ID: $id";  
                echo "<script type='text/javascript'>alert('$message');</script>";
                
                $query = "DELETE FROM orders WHERE id = $1";
                $result = pg_query_params($conn, $query, [$id]);
                
                if ($result && pg_affected_rows($result) > 0) {
                    echo "<script>alert('Заказ успешно удалён!');</script>";
                } else {
                    $error = pg_last_error($conn);
                    echo "<script>alert('Ошибка при удалении: $error');</script>";
                }
            } else {
                echo "<script>alert('Неверный ID заказа');</script>";
            }
            break;
    }
    header("Location: admin_orders.php");
    exit;
}

// Получение списка заказов
$orders = pg_query($conn, "SELECT * FROM orders ORDER BY id DESC");

// Форма добавления/редактирования
$orderToEdit = null;
if(isset($_GET['edit'])) {
    $orderToEdit = pg_fetch_assoc(pg_query_params($conn, "SELECT * FROM orders WHERE id = $1", [$_GET['edit']]));
}

ob_start();
?>
<div class="admin-panel">
    <h1 class="mb-4"><?= $orderToEdit ? 'Редактировать заказ' : 'Добавить заказ' ?></h1>
    
    <form method="post" action="?action=<?= $orderToEdit ? 'edit' : 'add' ?>">
        <?php if($orderToEdit): ?>
            <input type="hidden" name="id" value="<?= $orderToEdit['id'] ?>">
        <?php endif; ?>
        
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Фамилия</label>
                <input type="text" class="form-control" name="second_name" 
                       value="<?= $orderToEdit['second_name'] ?? '' ?>" required>
            </div>
            <div class="col">
                <label class="form-label">Имя</label>
                <input type="text" class="form-control" name="first_name" 
                       value="<?= $orderToEdit['first_name'] ?? '' ?>" required>
            </div>
            <div class="col">
                <label class="form-label">Отчество</label>
                <input type="text" class="form-control" name="third_name" 
                       value="<?= $orderToEdit['third_name'] ?? '' ?>">
            </div>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" 
                   value="<?= $orderToEdit['email'] ?? '' ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Адрес</label>
            <textarea class="form-control" name="address" rows="2" required><?= $orderToEdit['address'] ?? '' ?></textarea>
        </div>
        
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Способ оплаты</label>
                <select class="form-select" name="method_pay" required>
                    <option value="При получении" <?= ($orderToEdit['method_pay'] ?? '') === 'При получении' ? 'selected' : '' ?>>При получении</option>
                    <option value="Картой онлайн" <?= ($orderToEdit['method_pay'] ?? '') === 'Картой онлайн' ? 'selected' : '' ?>>Картой онлайн</option>
                </select>
            </div>
            <div class="col">
                <label class="form-label">Количество</label>
                <input type="number" class="form-control" name="counts" 
                       value="<?= $orderToEdit['counts'] ?? 1 ?>" min="1" required>
            </div>
            <div class="col">
                <label class="form-label">Сумма (₽)</label>
                <input type="number" class="form-control" name="total" 
                       value="<?= $orderToEdit['total'] ?? 0 ?>" min="0" required>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary"><?= $orderToEdit ? 'Обновить' : 'Добавить' ?></button>
        <?php if($orderToEdit): ?>
            <a href="admin_orders.php" class="btn btn-secondary">Отмена</a>
        <?php endif; ?>
    </form>
    
    <h2 class="mt-5 mb-3">Список заказов</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Клиент</th>
                <th>Email</th>
                <th>Сумма</th>
                <th>Оплата</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php while($order = pg_fetch_assoc($orders)): ?>
            <tr>
                <td><?= $order['id'] ?></td>
                <td><?= htmlspecialchars($order['second_name']) ?> <?= htmlspecialchars($order['first_name']) ?></td>
                <td><?= htmlspecialchars($order['email']) ?></td>
                <td><?= $order['total'] ?> ₽</td>
                <td><?= htmlspecialchars($order['method_pay']) ?></td>
                <td>
                    <a href="admin_orders.php?edit=<?= $order['id'] ?>" class="btn btn-sm btn-warning">Редактировать</a>
                    <a href="admin_orders.php?action=delete&id=<?= $order['id'] ?>" 
                       onclick="return confirm('Вы точно хотите удалить заказ #<?= $order['id'] ?>?')"
                       class="btn btn-sm btn-danger">
                        Удалить
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php
$content = ob_get_clean();
include 'admin.php';