<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>

    <!-- User Styles -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav>
        <ul class="navlinks">
            <li><a href="index.php">Вход</a></li>
            <li><a href="registration.php">Регистрация</a></li>
            <li><a href="profile.php">Профиль</a></li>
        </ul>
    </nav>

    <div class="container">
        <!-- Registration Section -->
        <section id="registration">
            <h1>Регистрация</h1>
            <form action="" method="post" class="form-container">
                <input type="text" name="name" placeholder="Ваше имя" class="form-input" required>
                <input type="tel" pattern="\+7\d{10}" name="phone" placeholder="Номер телефона" class="form-input" required>
                <span class="input-description">Формат: +79991234567</span>
                <input type="email" name="email" placeholder="E-mail" class="form-input" required>
                <input type="password" name="password_1" placeholder="Пароль" class="form-input" required>
                <input type="password" name="password_2" placeholder="Повторите пароль" class="form-input" required>
                <button type="submit" name="registration_btn" class="form-btn">Зарегистрироваться</button>
            </form>
        </section>
        <!-- /#registration -->
    </div>
    <!-- /.container -->
</body>
</html>