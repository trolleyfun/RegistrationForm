<?php /* For function editProfile() */ ?>
<!-- Edit Profile Section -->
<section id="edit-profile" class="form-section">
    <h1>Редактировать профиль</h1>
    <form action="" method="post" class="form-container">
        <input type="text" name="login" placeholder="Логин" class="form-input" value="<?=$login;?>" required>
        <?php displayErrorMessage($err_edit_profile['login_empty'], "Это поле не может быть пустым"); ?>
        <?php displayErrorMessage($err_edit_profile['login_used'], "Пользователь с таким логином уже существует. Выберите другой"); ?>
        <input type="tel" pattern="\+7[0-9]{10}" name="phone" placeholder="Номер телефона" class="form-input" value="<?=$phone;?>" required>
        <?php displayDescriptionMessage(true, "Формат: +79991234567"); ?>
        <?php displayErrorMessage($err_edit_profile['phone_empty'], "Это поле не может быть пустым"); ?>
        <?php displayErrorMessage($err_edit_profile['phone_valid'], "Некорректный номер телефона"); ?>
        <?php displayErrorMessage($err_edit_profile['phone_used'], "Пользователь с таким номером телефона уже существует. Используйте другой"); ?>
        <input type="email" name="email" placeholder="E-mail" class="form-input" value="<?=$email;?>" required>
        <?php displayErrorMessage($err_edit_profile['email_empty'], "Это поле не может быть пустым"); ?>
        <?php displayErrorMessage($err_edit_profile['email_valid'], "Некорректный e-mail"); ?>
        <?php displayErrorMessage($err_edit_profile['email_used'], "Пользователь с таким e-mail уже существует. Используйте другой"); ?>
        <button type="submit" name="update_profile_btn" class="form-btn">Сохранить изменения</button>
    </form>
</section>
<!-- /#edit-profile -->