<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TECHOUT | Главная страница</title>
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
                <li class="active"><a href="index.php">Главная</a></li>
                <li><a href="catalog.php">Каталог</a></li>
                <li><a href="delivery.html">Доставка</a></li>
                <li><a href="order.php">Заказ</a></li>
                <li><a href="contacts.html">Контакты</a></li>
                <li><a href="admin_products.php">Админ</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="container">
            <div class="block-news">
                <img class="news-phone" src="images/news phone.png" alt="old phone">
                <div class="news">
                    <div class="title-news">
                        <h1>Новости</h1>
                    </div>
                    <div class="news-main-block">
                        <a href="#">
                            <div class="news-item">
                                <h4>Вся правда о современных телефонах</h4>
                                <h5>Всем привет! Сегодня детально расскажу и покажу всю поднаготную современных технологий...</h5>
                                <h6>26.06.2026</h6>
                            </div>
                        </a>
                        <a href="#">
                            <div class="news-item">
                                <h4>Топовые мобильники на лето</h4>
                                <h5>Каждый год удивляюсь летней жаре, не понимая, как такое вообще возможно...</h5>
                                <h6>25.06.2026</h6>
                            </div>
                        </a>
                        <a href="#">
                            <div class="news-item">
                                <h4>Бабушкино счастье</h4>
                                <h5>Недавно от своей бабушки получил посылку со стареньким Nokia. Сразу включил его...</h5>
                                <h6>24.06.2026</h6>
                            </div>
                        </a>
                        <a href="#">
                            <div class="news-item">
                                <h4>Кот нажал</h4>
                                <h5>Потерял свой YesKia пару лет назад. Было странно, когда я не обнаружил его на привычном месте...</h5>
                                <h6>24.06.2026</h6>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </section>

        

        <section class="container about-block">
            <h2 class="about">
                Современные модели телефонов одинаковые и скучные? Ты попал в правильное место! В TECHOUT ты можешь приобрести телефоны 2000-х годов по самой низкой цене.
                <br>Также у нас есть офисы в городах - Москва, Санкт-Петербург, Пермь, Саратов. Закажи доставку прямо сейчас!
            </h2>
            <a href="delivery.html"><button id="index-submit-delivery">Заказать доставку</button></a>
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
