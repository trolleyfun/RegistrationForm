<?php
/* Check if the query to database is successful. If not, intercept the program and display an error message. $result is output of mysqli_query() function */
function validateQuery($result) {
    global $connection;

    if (!$result) {
        die("Query to database failed. " . mysqli_error($connection));
    }
}

/* Echo text from $message if $status is true. If $status is false, nothing occurs*/
function displayMessage($status, $message) {
    if ($status) {
        echo $message;
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
?>