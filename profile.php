<?php 
ob_start();
include "includes/db.php";
include "includes/functions.php";
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>

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
        <!-- Edit Profile Section -->
        <section id="edit-profile">
            <h1>Редактировать профиль</h1>
            <form action="" method="post" class="form-container">
                <input type="text" name="login" placeholder="Логин" class="form-input" required>
                <input type="tel" pattern="\+7\d{10}" name="phone" placeholder="Номер телефона" class="form-input" required>
                <span class="input-description">Формат: +79991234567</span>
                <input type="email" name="email" placeholder="E-mail" class="form-input" required>
                <button type="submit" name="edit_profile_btn" class="form-btn">Сохранить изменения</button>
            </form>
        </section>
        <!-- /#edit-profile -->

        <!-- Edit Password Section -->
        <section id="edit-password">
            <h1>Изменить пароль</h1>
            <form action="" method="post" class="form-container">
                <input type="password" name="current_password" placeholder="Старый пароль" class="form-input" required>    
                <input type="password" name="new_password_1" placeholder="Новый пароль" class="form-input" required>
                <input type="password" name="new_password_2" placeholder="Повторите новый пароль" class="form-input" required>
                <button type="submit" name="edit_password_btn" class="form-btn">Изменить пароль</button>
            </form>
        </section>
        <!-- /#edit-password -->
    </div>
    <!-- /.container -->
</body>
</html>