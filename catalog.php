<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TECHOUT | Каталог</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav class="container">
            <div class="logo">
                <a href="index.php"><img src="images/logo.png" alt="logo"></a>
            </div>
            <ul class="menu">
                <li><a href="index.php">Главная</a></li>
                <li class="active"><a href="catalog.php">Каталог</a></li>
                <li><a href="delivery.html">Доставка</a></li>
                <li><a href="order.php">Заказ</a></li>
                <li><a href="contacts.html">Контакты</a></li>
                <li><a href="admin_products.php">Админ</a></li>
            </ul>
        </nav>
    </header>

    <main>
    <!-- <section class="container">
            <div class="catalog">
                <h1>Летние хиты продаж 2026</h1>
                <div class="catalog-items">
                    <a href="#">
                        <div class="tovars-item">
                            <img src="images/siemens_me45.jpg" alt="Siemens ME45">
                            <div class="price">
                                <h4 class="main-price">1357 ₽</h5>
                                <h5 class="old-price">2950 ₽</h6>
                                <h5 class="discount">-54%</h5>
                            </div>
                            <h3 class="name">Siemens ME45</h3>
                            <h5 class="description">Компактный, супер-прочный, водостойкий, быстрый...</h4>
                        </div>
                    </a>
                </div>
            </div>
        </section> -->

        <section class="container">
            <div class="catalog">
                <h1>Летние хиты продаж 2026</h1>
                <div class="catalog-items">
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
                        $productName = htmlspecialchars($row['name']);
                        $productImage = htmlspecialchars($row['image']);
                        $productPrice = htmlspecialchars($row['main_price']);
                        $oldPrice = htmlspecialchars($row['old_price']);
                        $discount = htmlspecialchars($row['discount']);
                        $description = htmlspecialchars($row['description']);
                        
                        echo '
                        <a href="#">
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

<script src="https://kit.fontawesome.com/081ac9223b.js" crossorigin="anonymous"></script>
</html>