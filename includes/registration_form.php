<?php /* For function userRegistration() */ ?>
<form action="" method="post" class="form-container">
    <input type="text" name="login" placeholder="Логин" class="form-input" required>
    <?php displayErrorMessage($err_user_reg['login_empty'], "Это поле не может быть пустым"); ?>
    <?php displayErrorMessage($err_user_reg['login_used'], "Пользователь с таким логином уже существует. Выберите другой"); ?>
    <input type="tel" pattern="\+7\d{10}" name="phone" placeholder="Номер телефона" class="form-input" required>
    <?php displayDescriptionMessage(true, "Формат: +79991234567"); ?>
    <?php displayErrorMessage($err_user_reg['phone_empty'], "Это поле не может быть пустым"); ?>
    <?php displayErrorMessage($err_user_reg['phone_valid'], "Некорректный номер телефона"); ?>
    <?php displayErrorMessage($err_user_reg['phone_used'], "Пользователь с таким номером телефона уже существует. Используйте другой"); ?>
    <input type="email" name="email" placeholder="E-mail" class="form-input" required>
    <?php displayErrorMessage($err_user_reg['email_empty'], "Это поле не может быть пустым"); ?>
    <?php displayErrorMessage($err_user_reg['email_valid'], "Некорректный e-mail"); ?>
    <?php displayErrorMessage($err_user_reg['email_used'], "Пользователь с таким e-mail уже существует. Используйте другой"); ?>
    <input type="password" name="password_1" placeholder="Пароль" class="form-input" required>
    <?php displayErrorMessage($err_user_reg['password_empty'], "Это поле не может быть пустым"); ?>
    <?php displayErrorMessage($err_user_reg['password_equal'], "Пароли должны совпадать"); ?>
    <input type="password" name="password_2" placeholder="Повторите пароль" class="form-input" required>
    <button type="submit" name="signup_btn" class="form-btn">Зарегистрироваться</button>
</form>