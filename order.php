<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TECHOUT | Заказ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" async></script>
    <script src="script_process_order.js" async></script>

</head>
<body>
    <header>
        <nav class="container">
            <div class="logo">
                <a href="index.php"><img src="images/logo.png" alt="logo"></a>
            </div>
            <ul class="menu">
                <li><a href="index.php">Главная</a></li>
                <li><a href="catalog.php">Каталог</a></li>
                <li><a href="delivery.html">Доставка</a></li>
                <li class="active"><a href="order.php">Заказ</a></li>
                <li><a href="contacts.html">Контакты</a></li>
                <li><a href="admin_products.php">Админ</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="container">
            <div id="form-orders">
                <h1>Для заказа выберите товар и введите данные</h1>
                <div class="choose-catalog-orders">
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
                        
                        while ($row = pg_fetch_assoc($result)) {
                            $productId = htmlspecialchars($row['id']);
                            $productName = htmlspecialchars($row['name']);
                            $productImage = htmlspecialchars($row['image']);
                            $productPrice = htmlspecialchars($row['main_price']);
                            $oldPrice = htmlspecialchars($row['old_price']);
                            $discount = htmlspecialchars($row['discount']);
                            $description = htmlspecialchars($row['description']);
                            
                            echo '
                            <a href="#" class="product-link" data-id="'.$productId.'" onclick="selectProduct(event, '.$productId.')">
                                <div class="tovars-item">
                                    <img src="' . $productImage . '" alt="' . $productName . '">
                                    <div class="price">
                                        <h4 class="main-price">' . $productPrice . ' ₽</h4>
                                        <h5 class="old-price">' . $oldPrice . ' ₽</h5>
                                        <h5 class="discount">-' . $discount . '%</h5>
                                    </div>
                                    <h3 class="name">' . $productName . '</h3>
                                    <h5 class="description">' . $description . '</h5>
                                </div>
                            </a>';
                        }
                        
                        pg_close($conn);
                    ?>
                </div>

                <div class="catalog-data-block">
                    <div class="product-about" id="selected-product-container">
                        <?php
                            $conn = pg_connect("host=localhost port=5432 dbname=test_db user=postgres password=123");
                            $query = "SELECT * FROM products LIMIT 1"; // Получаем первый товар для начального отображения
                            $result = pg_query($conn, $query);
                            $firstProduct = pg_fetch_assoc($result);
                            pg_close($conn);
                        ?>
                        <h3 class="name"><?= htmlspecialchars($firstProduct['name']) ?></h3>
                        <img src="<?= htmlspecialchars($firstProduct['image']) ?>" alt="<?= htmlspecialchars($firstProduct['name']) ?>">
                        <div class="prices">
                            <h4 class="main-price"><?= htmlspecialchars($firstProduct['main_price']) ?> ₽</h4>
                            <h5 class="old-price"><?= htmlspecialchars($firstProduct['old_price']) ?> ₽</h5>
                            <h5 class="discount">-<?= htmlspecialchars($firstProduct['discount']) ?>%</h5>
                        </div>
                        <h4 class="description"><?= htmlspecialchars($firstProduct['description']) ?></h4>
                        <input type="hidden" id="selected-product-id" value="<?= $firstProduct['id'] ?>">
                        <input type="hidden" id="selected-product-price" value="<?= $firstProduct['main_price'] ?>">
                    </div>
                    
                    <div class="catalog-input">
                        <form id="order-form" method="POST" action="process_order.php">
                            <input type="hidden" name="product_id" id="form-product-id" value="<?= $firstProduct['id'] ?>">
                            
                            <div class="catalog-data-form">
                                <label for="first_name">Имя<label class="required-input-star">*</label></label>
                                <input type="text" id="first_name" name="first_name" placeholder="Иван" required>
                            </div>
                            <div class="catalog-data-form">
                                <label for="second_name">Фамилия<label class="required-input-star">*</label></label>
                                <input type="text" id="second_name" name="second_name" placeholder="Иванов" required>
                            </div>
                            <div class="catalog-data-form">
                                <label for="third_name">Отчество</label>
                                <input type="text" id="third_name" name="third_name" placeholder="Иванович">
                            </div>
                            <div class="catalog-data-form">
                                <label for="email">Email<label class="required-input-star">*</label></label>
                                <input type="email" id="email" name="email" placeholder="example@mail.ru" required>
                            </div>
                            <div class="catalog-data-form">
                                <label for="address">Адрес<label class="required-input-star">*</label></label>
                                <input type="text" id="address" name="address" placeholder="г.Москва, ул.Пушкина, д.98, кв.13" required>
                            </div>
                            <div class="method-item">
                                <h4>Способ оплаты:</h4>
                                <div class="radio-btn">
                                    <div class="radio-btn-payment">
                                        <input type="radio" id="payment-cash" name="payment" value="При получении" checked>
                                        <label for="payment-cash">При получении</label>
                                    </div>
                                    <div class="radio-btn-payment">
                                        <input type="radio" id="payment-card" name="payment" value="Картой онлайн">
                                        <label for="payment-card">Картой онлайн</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="quantity-selector">
                                <label for="count-product">Количество:</label>
                                <input type="number" id="count-product" name="quantity" class="quantity-input" value="1" min="1">
                                <label for="count-product">шт.</label>
                            </div>
                            <div class="total-amount-product">
                                <label for="total">Итого:</label>
                                <input type="text" id="total" name="total" value="<?= $firstProduct['main_price'] ?> ₽" readonly>
                            </div>
                            <div class="terms-ok">
                                <input type="checkbox" id="terms" name="terms" required>
                                <label for="terms">Я согласен с условиями <a href="#">Политики конфиденциальности</a><label class="required-input-star">*</label></label>
                            </div>
                            <button type="submit" id="submit-order-ok">Купить</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-left col-md-4 col-sm-6">
            <p class="about">
                <span>О нас</span> С 2018 года помогаем клиентам:
                <br>✔ 10 000+ проданных устройств
                <br>✔ 98% положительных отзывов
                <br>✔ 500+ тонн переработанной электроники
                <br>TECHOUT – техника с историей, но без риска.
            </p>
            <div class="icons">
                <a href="#"><i class="fa fa-vk"></i></a>
                <a href="#"><i class="fa fa-telegram"></i></a>
                <a href="#"><i class="fa fa-google"></i></a>
            </div>
        </div>
        <div class="footer-center col-md-4 col-sm-6">
            <div>
                <i class="fa fa-map-marker"></i>
                <p><span> Главный офис и контакты</span> г.Москва, ул.Пушкина, 18</p>
            </div>
            <div>
                <i class="fa fa-phone"></i>
                <p> +7 (900) 888-23-23</p>
            </div>
            <div>
                <i class="fa fa-envelope"></i>
                <p><a href="#"> techout@company.ru</a></p>
            </div>
        </div>
        <div class="footer-right col-md-4 col-sm-6">
            <img src="images/logo.png" alt="Лого">
            <p class="name"> TECHOUT &copy; 2018</p>
        </div>
    </footer>
</body>
</html>