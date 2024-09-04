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
    <title>Вход</title>

    <!-- User Styles -->
    <link rel="stylesheet" href="css/styles.css">
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
        <!-- Login Section -->
        <section id="login">
            <?php 
            /* Check if user is authorized and display proper content */
            if (isset($_SESSION['user_id'])) {
                displayInfo("Добро пожаловать!");
            } else {
                userLogin(); 
            }
            ?>
        </section>
        <!-- /#login -->
    </div>
    <!-- /.container -->
</body>
</html>