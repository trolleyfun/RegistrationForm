<?php /* For function userRegistration() */ ?>
<form action="" method="post" class="form-container">
    <input type="text" name="login" placeholder="Логин" class="form-input" required>
    <input type="tel" pattern="\+7\d{10}" name="phone" placeholder="Номер телефона" class="form-input" required>
    <span class="input-description">Формат: +79991234567</span>
    <input type="email" name="email" placeholder="E-mail" class="form-input" required>
    <input type="password" name="password_1" placeholder="Пароль" class="form-input" required>
    <input type="password" name="password_2" placeholder="Повторите пароль" class="form-input" required>
    <button type="submit" name="signup_btn" class="form-btn">Зарегистрироваться</button>
</form>