<?php
const SMARTCAPTCHA_SERVER_KEY = "ysc2_cFymAvA26EpfsFwY8HlBADEpqknF2FeovKfwASs728a7b64b";

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

/* Display $text on the page. You should create html structure of text in "includes/info_message.php" */
function displayInfo($text) {
    include "includes/info_message.php";
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

/* Start session and, if session was successfully started, create and initialize 'user_id' variable of session */
function my_session_start($user_id) {
    if (session_start()) {
        $_SESSION['user_id'] = $user_id;
    }
}

/* Check if login is already used by another user. $user_id is ID of user who wants to set login $login, put this parameter equal to null if that's a new user. Return true if login isn't used and return false if login is used */
function loginAvailable($login, $user_id) {
    global $connection;

    $user['user_id'] = $user_id;
    $user['login'] = $login;

    /* If it is a new user then set id equal 0 (id = 0 doesn't exist in database) */
    if (is_null($user['user_id'])) {
        $user['user_id'] = 0;
    }
    /* Escape special characters (for sql queries) */
    $user = escapeArray($user);

    /* Validate user id */
    if (!my_is_int($user['user_id'])) {
        return false;
    } else {
        /*Search for user with $login in database */
        $query = "SELECT * FROM users WHERE user_login = '{$user['login']}' AND user_id != {$user['user_id']};";
        $loginExists = mysqli_query($connection, $query);
        validateQuery($loginExists);

        /* Check if user with $login exists */
        $num_rows = mysqli_num_rows($loginExists);

        return $num_rows === 0;
    }
}

/* Check if phone number is already used by another user. $user_id is ID of user who wants to set phone number $phone, put this parameter equal to null if that's a new user. Return true if phone number isn't used and return false if phone number is used */
function phoneAvailable($phone, $user_id) {
    global $connection;

    $user['user_id'] = $user_id;
    $user['phone'] = $phone;

    /* If it is a new user then set id equal 0 (id = 0 doesn't exist in database) */
    if (is_null($user['user_id'])) {
        $user['user_id'] = 0;
    }
    /* Escape special characters (for sql queries) */
    $user = escapeArray($user);

    /* Validate user id */
    if (!my_is_int($user['user_id'])) {
        return false;
    } else {
        /*Search for user with $phone in database */
        $query = "SELECT * FROM users WHERE user_phone = '{$user['phone']}' AND user_id != {$user['user_id']};";
        $phoneExists = mysqli_query($connection, $query);
        validateQuery($phoneExists);

        /* Check if user with $phone exists */
        $num_rows = mysqli_num_rows($phoneExists);

        return $num_rows === 0;
    } 
}

/* Check if e-mail is already used by another user. $user_id is ID of user who wants to set e-mail $email, put this parameter equal to null if that's a new user. Return true if e-mail isn't used and return false if e-mail is used */
function emailAvailable($email, $user_id) {
    global $connection;

    $user['user_id'] = $user_id;
    $user['email'] = $email;

    /* If it is a new user then set id equal 0 (id = 0 doesn't exist in database) */
    if (is_null($user['user_id'])) {
        $user['user_id'] = 0;
    }
    /* Escape special characters (for sql queries) */
    $user = escapeArray($user);

    /* Validate user id */
    if (!my_is_int($user['user_id'])) {
        return false;
    } else {
        /*Search for user with $email in database */
        $query = "SELECT * FROM users WHERE user_email = '{$user['email']}' AND user_id != {$user['user_id']};";
        $emailExists = mysqli_query($connection, $query);
        validateQuery($emailExists);

        /* Check if user with $email exists */
        $num_rows = mysqli_num_rows($emailExists);

        return $num_rows === 0;
    } 
}

/* Check if session is active and if 'user_id' variable of session is set. Then check if user with the value of 'user_id' variable of session exists in database. On success return Id of user, otherwise return false */
function sessionValidation() {
    global $connection;

    if (session_status() !== PHP_SESSION_ACTIVE) {
        return false;
    } elseif (!isset($_SESSION['user_id'])) {
        return false;
    } else {
        $user_id = $_SESSION['user_id'];
        /* Escape special characters (for sql queries) */
        $user_id = mysqli_real_escape_string($connection, $user_id);

        /* Validate user id */
        if (!my_is_int($user_id)) {
            return false;
        } else {
            /*Search for user with $user_id in database */
            $query = "SELECT user_id FROM users WHERE user_id = {$user_id};";
            $sessionValidation = mysqli_query($connection, $query);
            validateQuery($sessionValidation);
    
            /* Check if user with $user_id exists */
            $num_rows = mysqli_num_rows($sessionValidation);
    
            if ($num_rows > 0) {
                return $user_id;
            } else {
                return false;
            }
        }
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

    /* Registration button is clicked */
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

            /* Get id of new user */
            $query = "SELECT user_id FROM users WHERE user_login = '{$user['login']}';";
            $userId = mysqli_query($connection, $query);
            validateQuery($userId);
            if ($row = mysqli_fetch_assoc($userId)) {
                $user_id = $row['user_id'];

                /* Initialize user session */
                my_session_start($user_id);
            }

            /* Redirect to Home Page */
            header("Location: index.php");
        }
    }

    /* Display Registration Form */
    include "includes/registration_form.php";
}

/* Display Login Form and check if login data is correct. If data is correct, then start user session. You should create html structure of Login Form in "includes/login_form.php" */
function userLogin() {
    global $connection;

    /* input data validation: false -> valid, true -> invalid */
    $err_login = ['phone_email'=>false, 'password'=>false, 'captcha'=>false];
    $err_authorization = false;

    /* Login button is clicked */
    if (isset($_POST['login_btn'])) {
        /* Get data from the form */
        $login['phone_email'] = $_POST['phone_email'];
        $login['password'] = $_POST['password'];
        $captcha_token = $_POST['smart-token'];

        /* Escape special characters (for sql queries) */
        $login = escapeArray($login);

        /* Input data validation */
        foreach($err_login as $key=>$value) {
            $err_login[$key] = false;
        }
        $err_authorization = false;
        $err_login['phone_email'] = empty($login['phone_email']);
        $err_login['password'] = empty($login['password']);
        $err_login['captcha'] = !checkCaptcha($captcha_token);
        $err_result = false;
        foreach($err_login as $err_item) {
            $err_result = $err_result || $err_item;
        }
    
        /* Check login data if input data is valid */
        if (!$err_result) {
            /* Search for user in database */
            $query = "SELECT * FROM users WHERE user_phone = '{$login['phone_email']}' OR user_email = '{$login['phone_email']}';";
            $userLogin = mysqli_query($connection, $query);
            validateQuery($userLogin);
            $err_authorization = true;
            if ($row = mysqli_fetch_assoc($userLogin)) {
                /* Get user info from database */
                $user_id = $row['user_id'];
                $user_login = $row['user_login'];
                $user_phone = $row['user_phone'];
                $user_email = $row['user_email'];
                $user_password = $row['user_password'];
                
                /* Login data validation */
                if (($login['phone_email'] === $user_phone || $login['phone_email'] === $user_email) && password_verify($login['password'], $user_password)) {
                    
                    /* Initialize user session */
                    my_session_start($user_id);

                    $err_authorization = false;

                    /* Redirect to Home Page */
                    header("Location: index.php");
                }
            }
        }
    }

    /* Display Login Form */
    include "includes/login_form.php";
}

/* Unset session variables and logout user */
function userLogout() {
    if (isset($_GET['logout'])) {
        $logout = $_GET['logout'];
        if ($logout == "true") {
            session_unset();
        }

        /* Redirect to Home Page */
        header("Location: index.php");
    }
}

/* Display Edit Form and Change Password Form, and Put user data to Profile Edit Form from database. You should create html structure of Edit Profile Form in "includes/edit_profile.php" and Change Password Form in "includes/change_password.php" */
function editProfile() {
    global $connection;

    /* Check is session is active and session parameters are valid. If session validation failed then user logout */
    if (!$user_id = sessionValidation()) {
        header("Location: index.php?logout=true");
    } else {
        /* Escape special characters (for sql queries) */
        $user_id = mysqli_real_escape_string($connection, $user_id);

        /* Get user data from database */
        $query = "SELECT * FROM users WHERE user_id = {$user_id};";
        $editProfile = mysqli_query($connection, $query);
        validateQuery($editProfile);
        if (!$row = mysqli_fetch_assoc($editProfile)) {
            /* Logout if there are no users with such $user_id */
            header("Location: index.php?logout=true");
        } else {
            $user_id = $row['user_id'];
            $login = $row['user_login'];
            $phone = $row['user_phone'];
            $email = $row['user_email'];
            $password = $row['user_password'];

            /* input data validation: false -> valid, true -> invalid */
            $err_edit_profile = ['login_empty'=>false, 'login_used'=>false, 'phone_empty'=>false, 'phone_valid'=>false, 'phone_used'=>false, 'email_empty'=>false, 'email_valid'=>false, 'email_used'=>false];
            $err_edit_password = ['current_password_empty'=>false, 'current_password_valid'=>false, 'new_password_empty'=>false, 'new_password_equal'=>false];

            /* Update user in database */
            $err_edit_profile = updateProfile($user_id, $err_edit_profile);
            /* Update user password in database */
            $err_edit_password = updateUserPassword($user_id, $err_edit_password);

            /* Display Edit Profile Form and Change Password Form */
            include "includes/edit_profile.php";
            include "includes/edit_password.php";
        }
    }
}

/* Get user data from the form and update user with $user_id in database. Make input data validation and set error status in $err_update_profile array. Return error status array */
function updateProfile($user_id, $err_update_profile) {
    global $connection;

    /* Update Profile button is clicked */
    if (isset($_POST['update_profile_btn'])) {
        /* Check is session is active and session parameters are valid. If session validation failed then user logout */
        if (!sessionValidation()) {
            header("Location: index.php?logout=true");
        } else {
            /* Get data from the form */
            $user['user_id'] = $user_id;
            $user['login'] = $_POST['login'];
            $user['phone'] = $_POST['phone'];
            $user['email'] = $_POST['email'];

            /* Escape special characters (for sql queries) */
            $user = escapeArray($user);

            /* Input data validation */
            foreach($err_update_profile as $key=>$value) {
                $err_update_profile[$key] = false;
            }
            $err_update_profile['login_empty'] = empty($user['login']);
            $err_update_profile['login_used'] = !loginAvailable($user['login'], $user['user_id']);
            $err_update_profile['phone_empty'] = empty($user['phone']);
            $err_update_profile['phone_valid'] = !phoneValidation($user['phone']);
            $err_update_profile['phone_used'] = !phoneAvailable($user['phone'], $user['user_id']);
            $err_update_profile['email_empty'] = empty($user['email']);
            $err_update_profile['email_valid'] = !emailValidation($user['email']);
            $err_update_profile['email_used'] = !emailAvailable($user['email'], $user['user_id']);
            $err_result = false;
            foreach($err_update_profile as $err_item) {
                $err_result = $err_result || $err_item;
            }
    
            /* Update user data in database if input data is valid */
            if (!$err_result) {
                /* Query to database */
                $query = "UPDATE users SET ";
                $query .= "user_login = '{$user['login']}', ";
                $query .= "user_phone = '{$user['phone']}', ";
                $query .= "user_email = '{$user['email']}' ";
                $query .= "WHERE user_id = {$user['user_id']};";

                $updateUser = mysqli_query($connection, $query);
                validateQuery($updateUser);

                /* Display success message */
                header("Location: profile.php?source=info");
            }
        }
    }
    return $err_update_profile;
}

/* Get user password from the form. If user put valid current password, update password of user with $user_id in database. Make input data validation and set error status in $err_update_password array. Return error status array */
function updateUserPassword($user_id, $err_update_password) {
    global $connection;

    /* Change Password button is clicked */
    if (isset($_POST['update_password_btn'])) {
        /* Check is session is active and session parameters are valid. If session validation failed then user logout */
        if (!sessionValidation()) {
            header("Location: index.php?logout=true");
        } else {
            /* Get data from the form */
            $user['user_id'] = $user_id;
            $user['current_password'] = $_POST['current_password'];
            $user['new_password_1'] = $_POST['new_password_1'];
            $user['new_password_2'] = $_POST['new_password_2'];

            /* Escape special characters (for sql queries) */
            $user = escapeArray($user);

            /* Get current user password from database */
            $query = "SELECT user_password FROM users WHERE user_id = {$user['user_id']};";
            $userPassword = mysqli_query($connection, $query);
            validateQuery($userPassword);
            if (!$row = mysqli_fetch_assoc($userPassword)) {
                /* Logout if there are no users with such $user_id */
                header("Location: index.php?logout=true");
            } else {
                /* Password from database */
                $db_password = $row['user_password'];

                /* Input data validation */
                foreach($err_update_password as $key=>$value) {
                    $err_update_password[$key] = false;
                }
                $err_update_password['current_password_empty'] = empty($user['current_password']);
                $err_update_password['current_password_valid'] = !password_verify($user['current_password'], $db_password);
                $err_update_password['new_password_empty'] = empty($user['new_password_1']);
                $err_update_password['new_password_equal'] = ($user['new_password_1'] !== $user['new_password_2']);
                $err_result = false;
                foreach($err_update_password as $err_item) {
                    $err_result = $err_result || $err_item;
                }

                /* Change user password in database if input data is valid */
                if (!$err_result) {
                    /* Password Hashing */
                    $user['new_password_1'] = password_hash($user['new_password_1'], PASSWORD_BCRYPT);

                    /* Update user password */
                    $query = "UPDATE users SET user_password = '{$user['new_password_1']}' WHERE user_id = {$user['user_id']};";
                    $changePassword = mysqli_query($connection, $query);
                    validateQuery($changePassword);

                    /* Display success message */
                    header("Location: profile.php?source=info");
                }
            }
        }
    }
    return $err_update_password;
}

/* Check if captcha validation is successful. $token is a parameter which is sent to user after captcha validation (the value of input tag with name="smart-token"). Return true on success or if http query failed, otherwise return false */
function checkCaptcha($token) {
    /* Query to server */
    $ch = curl_init();
    /* Arguments of query */
    $args = http_build_query([
        "secret" => SMARTCAPTCHA_SERVER_KEY,
        "token" => $token
    ]);
    curl_setopt($ch, CURLOPT_URL, "https://smartcaptcha.yandexcloud.net/validate?{$args}");
    /* Server will response with json-object */
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);

    $server_output = curl_exec($ch);
    /* Check if query is successful */
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    /* If query failed, return true */
    if ($httpcode !== 200) {
        return true;
    }

    /* Get values from json-object */
    $resp = json_decode($server_output);
    return $resp->status === "ok";
}
?>