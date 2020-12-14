<?php
    /**
     * This web page allows a user to change information in their account
     * Author: Joseph Haley
     */
    
    include("./php_scripts/tools.php");
    include("./php_scripts/connect_to_db.php");

    session_start();
    $form_data; // user's info., retrieved from database, to populate fields
    
    if (userIsLoggedIn()) {
        $user_id = get("user_id");
        $form_was_submitted = count($_POST) != 0;
        if ($form_was_submitted) {

            $user_old_password = filter_input(INPUT_POST, "user_old_password", FILTER_SANITIZE_SPECIAL_CHARS);
            $command = "SELECT pass as hash_pass FROM users WHERE id = ?";
            $statement = $dbh->prepare($command);
            $db_call_successful = $statement->execute([$user_id]);
    
            $old_password_is_valid = false;
            if ($db_call_successful) {
                $result = $statement->fetch();
                if (password_verify($user_old_password, $result["hash_pass"])) {
                    $old_password_is_valid = true;
                }
            }
    
            if ($old_password_is_valid) {
                $user_new_password = filter_input(INPUT_POST, "user_new_password", FILTER_SANITIZE_SPECIAL_CHARS);
                $user_new_email = filter_input(INPUT_POST, "user_new_email", FILTER_SANITIZE_EMAIL);
                $user_new_firstname = filter_input(INPUT_POST, "user_new_firstname", FILTER_SANITIZE_SPECIAL_CHARS);
                $user_new_lastname = filter_input(INPUT_POST, "user_new_lastname", FILTER_SANITIZE_SPECIAL_CHARS);
                $user_new_age = filter_input(INPUT_POST, "user_new_age", FILTER_VALIDATE_INT);
    
                $columns = "";
                $password_changed; // not set! (important for determining whether an attempted password change was made)
                if ($user_new_password != null) {
                    $hash = password_hash($user_new_password, PASSWORD_DEFAULT);
                    $command = "UPDATE users SET pass = ? WHERE id = ?";
                    $statement = $dbh->prepare($command);
                    $db_call_successful = $statement->execute([$hash, $user_id]);
    
                    if ($db_call_successful) {
                        $password_changed = true;
                    } else {
                        $password_changed = false;
                    }
                }
                
                $email_changed; // not set!
                if ($user_new_email != null && $user_new_email != false) {
                    $command = "UPDATE users SET email_address = ? WHERE id = ?";
                    $statement = $dbh->prepare($command);
                    $db_call_successful = $statement->execute([$user_new_email, $user_id]);
    
                    if ($db_call_successful) {
                        $email_changed = true;
                    } else {
                        $email_changed = false;
                    }
                }
    
                $firstname_changed; // not set! 
                if ($user_new_firstname != null) {
                    $command = "UPDATE users SET first_name = ? WHERE id = ?";
                    $statement = $dbh->prepare($command);
                    $db_call_successful = $statement->execute([$user_new_firstname, $user_id]);
    
                    if ($db_call_successful) {
                        $firstname_changed = true;
                    } else {
                        $firstname_changed = false;
                    }
                }
    
                $lastname_changed; // not set! 
                if ($user_new_lastname != null) {
                    $command = "UPDATE users SET last_name = ? WHERE id = ?";
                    $statement = $dbh->prepare($command);
                    $db_call_successful = $statement->execute([$user_new_lastname, $user_id]);
    
                    if ($db_call_successful) {
                        $lastname_changed = true;
                    } else {
                        $lastname_changed = false;
                    }
                }
    
                $age_changed; // not set! 
                if ($user_new_age != null and $user_new_age != false) {
                    $command = "UPDATE users SET age = ? WHERE id = ?";
                    $statement = $dbh->prepare($command);
                    $db_call_successful = $statement->execute([$user_new_age, $user_id]);
    
                    if ($db_call_successful) {
                        $age_changed = true;
                    } else {
                        $age_changed = false;
                    }
                }
            }        
        }

        // Get user's information (to populate fields)
        $command = "SELECT email_address as email, first_name as firstname, last_name as lastname, age FROM users WHERE id = ?";
        $statement = $dbh->prepare($command);
        $db_call_successful = $statement->execute([$user_id]);

        if ($db_call_successful) {
            $form_data = $statement->fetchAll()[0];
        }
    }
    
    function printMessage($message, $success) {
        if ($success) {
            echo "<div class='text-success'>";
            echo $message . " successfully changed.";
        } else {
            echo "<div class='text-danger'>";
            echo $message . " not changed.";
        }
        echo "</div>";
    }
?><!DOCTYPE html>
<html>
    <head>
        <title>My profile? My profile!</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./libraries/bootstrap.min.css"/>
        <link rel="stylesheet" href="./libraries/animate.min.css"/>
        <style>
            @media screen and (min-width: 768px) { /* md and above */
                    .jh-height {
                        height: 90vh;
                    }
                }
            @media screen and (max-width: 767px) { /* sm and below */
                .jh-height {
                    height: auto;
                }
            }
            .jh-height-header {
                height: 10vh;
            }
            .jh-tick {
                font-family: "Segoi UI Symbol";
            }
            #avatar_img {
                width: 75px;
                height: 75px;
            }
        </style>
    </head>
    <body class='bg-light d-flex flex-column w-100 justify-content-center'>
        <?php
            include("./page_components/header.php");
        ?>
        <div class="w-100 d-flex justify-content-center">
            <div class="container-lg p-0 m-0">
                <div class="justify-content-center align-items-center p-4 m-0">
                    <div class='h-100 w-100 bg-white border rounded shadow p-4' id='content_box'>
                        <h2 class="d-flex w-100 justify-content-center text-center">Update Your Profile</h2>
                        <div class="row justify-content-center">
                            <form method="POST" action="user_profile.php" class="col col-sm-10 d-flex justify-content-center flex-column pl-3">

                                <div class="row d-flex flex-column text-center mb-2">
                                    <?php
                                        if (!userIsLoggedIn()) {

                                        } else if ($form_was_submitted) {
                                            if ($old_password_is_valid) {
                                                if (isset($password_changed)) {
                                                    if ($password_changed) {
                                                        printMessage("Password", true);
                                                    } else {
                                                        printMessage("Password", false);
                                                    }
                                                }
                                                if (isset($email_changed)) {
                                                    if ($email_changed) {
                                                        printMessage("Email", true);
                                                    } else {
                                                        printMessage("Email", false);
                                                    }
                                                }
                                                if (isset($firstname_changed)) {
                                                    if ($firstname_changed) {
                                                        printMessage("First name", true);
                                                    } else {
                                                        printMessage("First name", false);
                                                    }
                                                }
                                                if (isset($lastname_changed)) {
                                                    if ($lastname_changed) {
                                                        printMessage("Last name", true);
                                                    } else {
                                                        printMessage("Last name", false);
                                                    }
                                                }
                                                if (isset($age_changed)) {
                                                    if ($age_changed) {
                                                        printMessage("Age", true);
                                                    } else {
                                                        printMessage("Age", false);
                                                    }
                                                }
                                            } else {
                                                echo "<div class='text-danger pb-4'>";
                                                    echo "Current password invalid. No changes were made.";
                                                echo "</div>";
                                            }
                                        }
                                    ?>
                                </div>


                                <div class="p-4 mb-4 alert w-100" id="oldPasswordBox">
                                    <div class="text-center mb-4">
                                        <span class="text-dark text-left lead">Enter old password for changes to take effect:</span>
                                    </div>
                                    <div class="form-row">
                                        <span   class="jh-tick col-2 h2 text-center"
                                                id="oldPasswordTick">&nbsp;</span>
                                        <input  type="password"
                                                name="user_old_password"
                                                class="col-8"
                                                id="oldPasswordTxt"
                                                placeholder="(required)">
                                        </div>
                                    </div>
                                </div>

                                <div class="border-top border-bottom p-4">
                                    <div class="h4 text-center">
                                        Avatar
                                    </div>
                                    <div class="row">
                                        <div class="d-flex justify-content-center col-2 w-100">
                                            <img src="./images/icon_avatar.png" id="avatar_img" class="rounded-circle bg-light">
                                        </div>
                                        <div>
                                            <p>(Not implemented :-( )</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-bottom p-4">
                                    <div class="h4 text-center">
                                        Password
                                    </div>
                                    <div class="mb-1">
                                        <div class="form-row">
                                            <span   class="jh-tick col-2 h2 text-muted text-center"
                                                    id="passwordTick">&#9744;</span>
                                            <input  type="password"
                                                    name="user_new_password"
                                                    class="col-9"
                                                    pattern='\S{8,}'
                                                    title='(At least 8 characters; no whitespace)'
                                                    id="passwordTxt"
                                                    placeholder="New Password">
                                        </div>
                                        <div class="form-row">
                                            <span class="jh-tick col-2 h2 text-white text-center">&#9744;</span>
                                            <small class="col-9">
                                                <span class="">(At least 8 characters; no whitespace)</span>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="form-row">
                                            <span   class="jh-tick col-2 h2 text-muted text-center"
                                                    id="passwordConfirmTick">&#9744;</span>
                                            <input  type="password"
                                                    class="col-9"
                                                    pattern='\S{8,}'
                                                    title='(8 or more characters; alphanumeric only)'
                                                    id="passwordConfirmTxt"
                                                    placeholder="Confirm Password">
                                        </div>
                                    </div>
                                </div>
                                <div class="border-bottom pb-0 pt-4 pl-4 pr-4">
                                    <div class="h4 text-center">
                                        Other
                                    </div>
                                    <div class="mb-1">
                                        <div class="form-row">
                                            <span class="jh-tick col-2 h2 text-muted text-center" id="emailTick">&#9744;</span>
                                            <input  type="email"
                                                    name="user_new_email"
                                                    class="col-9"
                                                    <?php
                                                        if (isset($form_data["email"]) and $form_data["email"] != "") {
                                                            echo "placeholder='Current email: " . $form_data["email"] . "'";
                                                        } else {
                                                            echo "placeholder='Add an email address (format: dieter@whatever.com)'";
                                                        }
                                                    ?>
                                                    id="emailTxt">
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div class="form-row">
                                            <span class="jh-tick col-2 h2 text-muted text-center" id="firstnameTick">&#9744;</span>
                                            <input  type="text"
                                                    name="user_new_firstname"
                                                    class="col-9"
                                                    <?php
                                                        if (isset($form_data["firstname"]) and $form_data["firstname"] != "") {
                                                            echo "placeholder='Current first name: " . $form_data["firstname"] . "'";
                                                        } else {
                                                            echo "placeholder='Add a first name (format: Anastasia)'";
                                                        }
                                                    ?>
                                                    pattern='[A-Z][a-z]+'
                                                    id="firstnameTxt"
                                                    title='Letters only. Proper capitalization please.'>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div class="form-row">
                                            <span class="jh-tick col-2 h2 text-muted text-center" id="lastnameTick">&#9744;</span>
                                            <input  type="text"
                                                    name="user_new_lastname"
                                                    class="col-9"
                                                    <?php
                                                        if (isset($form_data["lastname"]) and $form_data["lastname"] != "") {
                                                            echo "placeholder='Current last name: " . $form_data["lastname"] . "'";
                                                        } else {
                                                            echo "placeholder='Add a last name (format: Kirkpatrick)'";
                                                        }
                                                    ?>
                                                    pattern='[A-Z][a-z]+'
                                                    id="lastnameTxt"
                                                    title='Letters only. Proper capitalization please.'>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div class="form-row">
                                            <span class="jh-tick col-2 h2 text-muted text-center" id="ageTick">&#9744;</span>
                                            <input  type="text"
                                                    name="user_new_age"
                                                    class="col-9"
                                                    <?php
                                                        if (isset($form_data["age"]) and $form_data["age"] != "") {
                                                            echo "placeholder='Current age: " . $form_data[3] . "'";
                                                        } else {
                                                            echo "placeholder='Add your age'";
                                                        }
                                                    ?>
                                                    id="ageTxt">
                                        </div>
                                        <div class="form-row">
                                            <span class="jh-tick col-2 h2 text-white text-center">&#9744;</span>
                                            <small class="col-9">
                                                <span class="">(You must be 13 or over)</span>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 mt-4">
                                    <div class="form-row">
                                        <div class="col-2"></div>
                                        <?php
                                            if (userIsLoggedIn()) {
                                                echo "<input class='col-9' type='submit' value='Submit Changes' id='submitBtn' disabled>";
                                            } else {
                                                echo "<input class='col-9' type='submit' value='Please log in to make changes to an account.' id='submitBtn' disabled>";
                                            }
                                        ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            echo "<script src='./libraries/jquery-3.5.1.min.js'></script>";
            if (userIsLoggedIn()) {
                echo "<script src='./libraries/bootstrap.bundle.min.js'></script>";
                echo "<script src='./js_scripts/functions.js'></script>";
                echo "<script src='./js_scripts/user_profile.js'></script>";
            }
        ?>
    </body>
</html>