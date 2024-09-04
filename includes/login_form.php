<?php /* For function userLogin() */ ?>
<h1>Вход</h1>
<form action="" method="post" class="form-container">
    <input type="text" name="phone_email" placeholder="Номер телефона или e-mail" class="form-input" required>
    <?php displayDescriptionMessage(true, "Формат: +79991234567"); ?>
    <?php displayErrorMessage($err_login['phone_email'], "Это поле не может быть пустым"); ?>
    <?php displayErrorMessage($err_authorization, "Неверный номер телефона, e-mail или пароль"); ?>
    <input type="password" name="password" placeholder="Пароль" class="form-input" required>
    <?php displayErrorMessage($err_login['password'], "Это поле не может быть пустым"); ?>
    <button type="submit" name="login_btn" class="form-btn">Войти</button>
</form>