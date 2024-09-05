<?php 
ob_start();
include "includes/db.php";
include "includes/functions.php";
session_start();

/* This page is only for authorized users */
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
}
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
        /* GET variable value */
        if (isset($_GET['source'])) {
            $source = $_GET['source'];
        } else {
            $source = "";
        }

        /* Display content according to GET variable value */
        switch($source) {
            case "info":
                displayInfo("Изменения успешно сохранены");
                break;
            default:
                editProfile();
                break;
        }
        ?>
    </div>
    <!-- /.container -->
</body>
</html>