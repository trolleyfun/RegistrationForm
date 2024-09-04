<?php
/* Check if the query to database is successful. If not, intercept the program and display an error message. $result is output of mysqli_query() function */
function validateQuery($result) {
    global $connection;

    if (!$result) {
        die("Query to database failed. " . mysqli_error($connection));
    }
}

/* Display text of $message as error if $status is true. If $status is false, nothing occurs. You should create html structure of message in "includes/input_invalid.php" */
function displayErrorMessage($status, $message) {
    if ($status) {
        include "includes/input_invalid.php";
    }
}

/* Display text of $message as description if $status is true. If $status is false, nothing occurs. You should create html structure of message in "includes/input_description.php" */
function displayDescriptionMessage($status, $message) {
    if ($status) {
        include "includes/input_description.php";
    }
}

/* Escape special characters in array elements for using in sql queries */
function escapeArray($array) {
    global $connection;

    $escapedArray = $array;
    foreach($escapedArray as $key=>$value) {
        $escapedArray[$key] = mysqli_real_escape_string($connection, $value);
    }

    return $escapedArray;
}

/* Check if $value is unsigned integer or unsigned integer string */
function my_is_int($value) {
    if(is_int($value)) {
        return $value >= 0;
    } else
        return is_numeric($value) && ctype_digit($value);
}

/* Check if login is already used by another user. $user_id is ID of user who wants to set login $login, put this parameter equal to null if that's a new user. Return true if login isn't used and return false if login is used */
function loginAvailable($login, $user_id) {
    global $connection;

    $user['user_id'] = $user_id;
    $user['login'] = $login;
    if (is_null($user['user_id'])) {
        $user['user_id'] = 0;
    }
    $user = escapeArray($user);

    if (my_is_int($user['user_id'])) {
        $query = "SELECT * FROM users WHERE user_login = '{$user['login']}' AND user_id != {$user['user_id']};";
        $loginExists = mysqli_query($connection, $query);
        validateQuery($loginExists);
        $num_rows = mysqli_num_rows($loginExists);
        return $num_rows === 0;
    } else {
        return false;
    }
}

/* Check if phone number is already used by another user. $user_id is ID of user who wants to set phone number $phone, put this parameter equal to null if that's a new user. Return true if phone number isn't used and return false if phone number is used */
function phoneAvailable($phone, $user_id) {
    global $connection;

    $user['user_id'] = $user_id;
    $user['phone'] = $phone;
    if (is_null($user['user_id'])) {
        $user['user_id'] = 0;
    }
    $user = escapeArray($user);

    if (my_is_int($user['user_id'])) {
        $query = "SELECT * FROM users WHERE user_phone = '{$user['phone']}' AND user_id != {$user['user_id']};";
        $phoneExists = mysqli_query($connection, $query);
        validateQuery($phoneExists);
        $num_rows = mysqli_num_rows($phoneExists);
        return $num_rows === 0;
    } else {
        return false;
    }
}

/* Check if e-mail is already used by another user. $user_id is ID of user who wants to set e-mail $email, put this parameter equal to null if that's a new user. Return true if e-mail isn't used and return false if e-mail is used */
function emailAvailable($email, $user_id) {
    global $connection;

    $user['user_id'] = $user_id;
    $user['email'] = $email;
    if (is_null($user['user_id'])) {
        $user['user_id'] = 0;
    }
    $user = escapeArray($user);

    if (my_is_int($user['user_id'])) {
        $query = "SELECT * FROM users WHERE user_email = '{$user['email']}' AND user_id != {$user['user_id']};";
        $emailExists = mysqli_query($connection, $query);
        validateQuery($emailExists);
        $num_rows = mysqli_num_rows($emailExists);
        return $num_rows === 0;
    } else {
        return false;
    }
}

/* Check if user with $user_id exists in database. Return true if user exists */
function userIdValidation($user_id) {
    global $connection;

    $user_id_escaped = mysqli_real_escape_string($connection, $user_id);

    if (my_is_int($user_id_escaped)) {
        $query = "SELECT * FROM users WHERE user_id = {$user_id_escaped};";
        $userValidation = mysqli_query($connection, $query);
        validateQuery($userValidation);

        $num_rows = mysqli_num_rows($userValidation);

        return $num_rows > 0;
    } else {
        return false;
    }
}

/* Check if phone number is valid: it should starts with "+7" and should have 10 digits after "+7". Return true if phone is valid */
function phoneValidation($phone) {
    return preg_match("/^\+7[0-9]{10}$/", $phone);
}

/* Check if e-mail is valid. Return true if e-mail is valid */
function emailValidation($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/* Display Registration Form and Add user to database if input data is valid. You should create html structure of Registration Form in "includes/registration_form.php" */
function userRegistration() {
    global $connection;

    /* input data validation: false -> valid, true -> invalid */
    $err_user_reg = ['login_empty'=>false, 'login_used'=>false, 'phone_empty'=>false, 'phone_valid'=>false, 'phone_used'=>false, 'email_empty'=>false, 'email_valid'=>false, 'email_used'=>false, 'password_empty'=>false, 'password_equal'=>false];

    if (isset($_POST['signup_btn'])) {
        /* Get data from the form */
        $user['login'] = $_POST['login'];
        $user['phone'] = $_POST['phone'];
        $user['email'] = $_POST['email'];
        $user['password_1'] = $_POST['password_1'];
        $user['password_2'] = $_POST['password_2'];

        /* Escape special characters (for sql queries) */
        $user = escapeArray($user);

        /* Input data validation */
        foreach($err_user_reg as $key=>$value) {
            $err_user_reg[$key] = false;
        }
        $err_user_reg['login_empty'] = empty($user['login']);
        $err_user_reg['login_used'] = !loginAvailable($user['login'], null);
        $err_user_reg['phone_empty'] = empty($user['phone']);
        $err_user_reg['phone_valid'] = !phoneValidation($user['phone']);
        $err_user_reg['phone_used'] = !phoneAvailable($user['phone'], null);
        $err_user_reg['email_empty'] = empty($user['email']);
        $err_user_reg['email_valid'] = !emailValidation($user['email']);
        $err_user_reg['email_used'] = !emailAvailable($user['email'], null);
        $err_user_reg['password_empty'] = empty($user['password_1']);
        $err_user_reg['password_equal'] = ($user['password_1'] !== $user['password_2']);
        $err_result = false;
        foreach($err_user_reg as $err_item) {
            $err_result = $err_result || $err_item;
        }

        /* Add new user to database if input data is valid */
        if (!$err_result) {
            /* Password Hashing */
            $user['password_1'] = password_hash($user['password_1'], PASSWORD_BCRYPT);

            /* Query to database */
            $query = "INSERT INTO users(user_login, user_phone, user_email, user_password) VALUES('{$user['login']}', '{$user['phone']}', '{$user['email']}', '{$user['password_1']}');";
            $userReg = mysqli_query($connection, $query);
            validateQuery($userReg);

            /* Redirect to Login Page */
            header("Location: index.php");
        }
    }

    /* Display Registration Form */
    include "includes/registration_form.php";
}
?>