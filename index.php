<?php 
ob_start();
include "includes/db.php";
include "includes/functions.php";
session_start();

/* User Logout */
userLogout();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная</title>

    <!-- User Styles -->
    <link rel="stylesheet" href="css/styles.css">

    <!-- Favicon -->
    <link rel="icon" href="favicon.ico">
</head>
<body>
    <nav>
        <?php 
        /* Check if user is authorized and display proper navigation */
        if (isset($_SESSION['user_id'])) {
            include "includes/nav_authorized.php";
        } else {
            include "includes/nav_not_authorized.php";
        }
        ?>
    </nav>

    <div class="container">  
        <?php 
        /* Check if user is authorized and display proper content */
        if (isset($_SESSION['user_id'])) {
            /* Get user login */
            $session_login = getSessionLogin();
            if (is_null($session_login)) {
                $session_login = "Пользователь";
            }
            /* Display Welcome message */
            displayInfo("Добро пожаловать, {$session_login}!");
        } else {
            userLogin(); 
        }
        ?>
    </div>
    <!-- /.container -->

    <!-- Yandex Smart Captcha Script -->
    <script src="https://smartcaptcha.yandexcloud.net/captcha.js" defer></script>
</body>
</html>