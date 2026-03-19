<?php
require 'auth.php';
requireAuth();

require 'db_connect.php'; // Файл с подключением к БД


// Обработка действий
if(isset($_GET['action'])) {
    switch($_GET['action']) {
        case 'add':
            // Добавление товара
            $query = "INSERT INTO products (name, category, main_price, old_price, discount, description, image) 
                      VALUES ($1, $2, $3, $4, $5, $6, $7)";
            pg_query_params($conn, $query, [
                $_POST['name'],
                $_POST['category'],
                $_POST['main_price'],
                $_POST['old_price'] ?? null,
                $_POST['discount'] ?? null,
                $_POST['description'],
                $_POST['image']
            ]);
            break;
            
        case 'edit':
            // Редактирование товара
            $query = "UPDATE products SET 
                      name = $1, category = $2, main_price = $3, old_price = $4, 
                      discount = $5, description = $6, image = $7 
                      WHERE id = $8";
            pg_query_params($conn, $query, [
                $_POST['name'],
                $_POST['category'],
                $_POST['main_price'],
                $_POST['old_price'] ?? null,
                $_POST['discount'] ?? null,
                $_POST['description'],
                $_POST['image'],
                $_POST['id']
            ]);
            break;
            
        case 'delete':
            // Получаем ID из GET-параметра
            $id = $_GET['id'] ?? 0;
            $id = (int)$id; // Приводим к целому числу
            
            // Проверяем, что ID валиден
            if ($id > 0) {
                $message = "Удаляем товар с ID: $id";  
                echo "<script type='text/javascript'>alert('$message');</script>";
                
                // Удаляем товар
                $query = "DELETE FROM products WHERE id = $1";
                $result = pg_query_params($conn, $query, [$id]);
                
                // Проверяем результат
                if ($result && pg_affected_rows($result) > 0) {
                    echo "<script>alert('Товар успешно удалён!');</script>";
                } else {
                    $error = pg_last_error($conn);
                    echo "<script>alert('Ошибка при удалении: $error');</script>";
                }
            } else {
                echo "<script>alert('Неверный ID товара');</script>";
            }
            break;
            }
    header("Location: admin_products.php");
    exit;
}

// Получение списка товаров
$products = pg_query($conn, "SELECT * FROM products");

// Форма добавления/редактирования
$productToEdit = null;
if(isset($_GET['edit'])) {
    $productToEdit = pg_fetch_assoc(pg_query_params($conn, "SELECT * FROM products WHERE id = $1", [$_GET['edit']]));
}

ob_start();
?>
<div class="admin-panel">
    <h1 class="mb-4"><?= $productToEdit ? 'Редактировать товар' : 'Добавить товар' ?></h1>
    
    <form method="post" action="?action=<?= $productToEdit ? 'edit' : 'add' ?>">
        <?php if($productToEdit): ?>
            <input type="hidden" name="id" value="<?= $productToEdit['id'] ?>">
        <?php endif; ?>
        
        <div class="mb-3">
            <label class="form-label">Название</label>
            <input type="text" class="form-control" name="name" value="<?= $productToEdit['name'] ?? '' ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Категория</label>
            <input type="text" class="form-control" name="category" value="<?= $productToEdit['category'] ?? '' ?>" required>
        </div>
        
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Цена</label>
                <input type="number" class="form-control" name="main_price" value="<?= $productToEdit['main_price'] ?? '' ?>" required>
            </div>
            <div class="col">
                <label class="form-label">Старая цена</label>
                <input type="number" class="form-control" name="old_price" value="<?= $productToEdit['old_price'] ?? '' ?>">
            </div>
            <div class="col">
                <label class="form-label">Скидка (%)</label>
                <input type="number" class="form-control" name="discount" value="<?= $productToEdit['discount'] ?? '' ?>">
            </div>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Описание</label>
            <textarea class="form-control" name="description" rows="3"><?= $productToEdit['description'] ?? '' ?></textarea>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Изображение (путь)</label>
            <input type="text" class="form-control" name="image" value="<?= $productToEdit['image'] ?? '' ?>" required>
        </div>
        
        <button type="submit" class="btn btn-primary"><?= $productToEdit ? 'Обновить' : 'Добавить' ?></button>
        <?php if($productToEdit): ?>
            <a href="admin_products.php" class="btn btn-secondary">Отмена</a>
        <?php endif; ?>
    </form>
    
    <h2 class="mt-5 mb-3">Список товаров</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Цена</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php while($product = pg_fetch_assoc($products)): ?>
            <tr>
                <td><?= $product['id'] ?></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= $product['main_price'] ?> ₽</td>
                <td>
                    <a href="admin_products.php?edit=<?= $product['id'] ?>" class="btn btn-sm btn-warning">Редактировать</a>
                    <a href="admin_products.php?action=delete&id=<?= $product['id'] ?>" 
                    onclick="return confirm('Вы точно хотите удалить товар <?= htmlspecialchars($product['name'], ENT_QUOTES) ?>?')"
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