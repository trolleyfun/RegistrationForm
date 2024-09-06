<?php /* For function editProfile() */ ?>
<!-- Edit Password Section -->
<section id="edit-password" class="form-section">
    <h1>Изменить пароль</h1>
    <form action="#edit-password" method="post" class="form-container">
        <input type="password" name="current_password" placeholder="Старый пароль" class="form-input" required>
        <?php displayErrorMessage($err_edit_password['current_password_empty'], "Это поле не может быть пустым"); ?>
        <?php displayErrorMessage($err_edit_password['current_password_valid'], "Неверный пароль"); ?>    
        <input type="password" name="new_password_1" placeholder="Новый пароль" class="form-input" required>
        <?php displayErrorMessage($err_edit_password['new_password_empty'], "Это поле не может быть пустым"); ?>
        <?php displayErrorMessage($err_edit_password['new_password_equal'], "Пароли должны совпадать"); ?>
        <input type="password" name="new_password_2" placeholder="Повторите новый пароль" class="form-input" required>
        <button type="submit" name="update_password_btn" class="form-btn">Изменить пароль</button>
    </form>
</section>
<!-- /#edit-password -->