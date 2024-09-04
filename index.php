<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>

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
        <!-- Login Section -->
        <section id="login">
            <h1>Вход</h1>
            <form action="" method="post" class="form-container">
                <input type="text" name="login" placeholder="Логин" class="form-input" required>
                <input type="password" name="password" placeholder="Пароль" class="form-input" required>
                <button type="submit" name="login_btn" class="form-btn">Войти</button>
            </form>
        </section>
        <!-- /#login -->
    </div>
    <!-- /.container -->
</body>
</html>