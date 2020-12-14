<?php
    /**
     * This page allows people to create a user account
     * Author: Joseph Haley
     */
    include("./php_scripts/tools.php");
    include("./php_scripts/connect_to_db.php");

    session_start();
    $formWasSubmitted = count($_POST) != 0;
    if (!userIsLoggedIn() and $formWasSubmitted) {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $user_password = filter_input(INPUT_POST, "user_password", FILTER_SANITIZE_SPECIAL_CHARS);
        $user_email = filter_input(INPUT_POST, "user_email", FILTER_SANITIZE_EMAIL);
        $user_firstname = filter_input(INPUT_POST, "user_firstname", FILTER_SANITIZE_SPECIAL_CHARS);
        $user_lastname = filter_input(INPUT_POST, "user_lastname", FILTER_SANITIZE_SPECIAL_CHARS);
        $user_age = filter_input(INPUT_POST, "user_age", FILTER_VALIDATE_INT);

        // Validate input
        $usernameIsValid = true;
        if ($username == false or
            $username == null or
            strlen($username) < 5) {

            $usernameIsValid = false;
        }

        $hash;
        $passwordIsValid = true;
        if ($user_password == false or
            $user_password == null or
            strlen($user_password) < 8) {

            $passwordIsValid = false;
        } else {
            $hash = password_hash($user_password, PASSWORD_DEFAULT);
        }

        $ageIsValid = true;
        if ($user_age == false or
            $user_age == null or
            $user_age < 13) {

            $ageIsValid = false;
        }
        
        // Convert null or false values to empty strings
        if ($user_email == false or $user_email == null) {
            $user_email = "";
        }
        if ($user_firstname == false or $user_firstname == null) {
            $user_firstname = "";
        }
        if ($user_lastname == false or $user_lastname == null) {
            $user_lastname = "";
        }

        if ($usernameIsValid and $passwordIsValid and $ageIsValid) {
            $command = "INSERT INTO users (username, pass, email_address, first_name, last_name, age) VALUE (?, ?, ?, ?, ?, ?)";
            $statement = $dbh->prepare($command);
            $db_call_successful = $statement->execute([$username, $hash, $user_email, $user_firstname, $user_lastname, $user_age]);
        }
    }
?><!DOCTYPE html>
<html>
    <head>
        <title>Create account? Create account!</title>
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
        </style>
    </head>
    <body class='bg-light d-flex flex-column w-100 justify-content-center'>
        <?php
            include("./page_components/header.php");
        ?>
        <div class="w-100 d-flex justify-content-center">
            <div class="container-lg jh-height p-0 m-0">
                <div class="justify-content-center align-items-center p-4 m-0">
                    <div class='h-100 w-100 bg-white border rounded shadow p-4' id='content_box'>
                        <h2 class="d-flex w-100 justify-content-center text-center pb-3">Create an account</h2>
                        <div class="row justify-content-center">
                            <form method="POST" action="create_account.php" class="d-flex justify-content-center flex-column pl-3 pr-3 w-100">
                                <div class="row pb-3 justify-content-center">
                                    <?php
                                        if (userIsLoggedIn()) {
                                            echo "<p>";
                                            echo    "Hello " . get("username");
                                            echo "</p>";
                                        } else if ($formWasSubmitted) {
                                            if ($usernameIsValid and $passwordIsValid and $ageIsValid) {
                                                if ($db_call_successful) {
                                                    echo "<div class='text-success pb-4'>";
                                                        echo "Account created. Please log in.";
                                                } else {
                                                    echo "<div class='text-danger pb-4'>";
                                                        echo "Error creating account. Please try a new username.";
                                                }
                                            } else {
                                                echo "<div class='text-danger pb-4'>";
                                                    if (!$usernameIsValid) echo "Invalid username.";
                                                    if (!$passwordIsValid) echo "Invalid password.";
                                                    if (!$ageIsValid) echo "Invalid age. You must be at least 13.";
                                            }
                                            echo "</div>";
                                        }
                                    ?>
                                </div>
                                <div class="mb-1">
                                    <div class="form-row">
                                        <span class="jh-tick col-2 h2 text-muted text-center" id="usernameTick">&#9744;</span>
                                        <input  type="text"
                                                name="username"
                                                class="col-9"
                                                pattern='[a-z0-9]{5,}'
                                                title='(At least five digits; numbers and letters; lowercase)'
                                                id="usernameTxt"
                                                placeholder="Username (required)"
                                                required>
                                    </div>
                                    <div class="form-row">
                                        <span class="jh-tick col-2 h2 text-white text-center">&#9744;</span>
                                        <small class="col-9">
                                            <span id="usernameInstr">(At least five digits; numbers and letters; lowercase)</span>
                                            <span class="text-danger d-none" id="usernameMsg">Username taken</span>
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div class="form-row">
                                        <span class="jh-tick col-2 h2 text-muted text-center" id="passwordTick">&#9744;</span>
                                        <input  type="password"
                                                name="user_password"
                                                class="col-9"
                                                pattern='\S{8,}'
                                                title='(At least 8 characters; no whitespace)'
                                                id="passwordTxt"
                                                placeholder="Password (required)"
                                                required>
                                    </div>
                                    <div class="form-row">
                                        <span class="jh-tick col-2 h2 text-white text-center">&#9744;</span>
                                        <small class="col-9">
                                            <span class="">(At least 8 characters; no whitespace)</span>
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div class="form-row">
                                        <span class="jh-tick col-2 h2 text-muted text-center" id="passwordConfirmTick">&#9744;</span>
                                        <input  type="password"
                                                name="user_password_confirm"
                                                class="col-9"
                                                pattern='\S{8,}'
                                                title='(8 or more characters; alphanumeric only)'
                                                id="passwordConfirmTxt"
                                                placeholder="Confirm Password (required)"
                                                required>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div class="form-row">
                                        <span class="jh-tick col-2 h2 text-white text-center" id="emailTick">&#9744;</span>
                                        <input  type="email"
                                                name="user_email"
                                                class="col-9"
                                                id="emailTxt"
                                                placeholder="email@website.com">
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div class="form-row">
                                        <span class="jh-tick col-2 h2 text-white text-center" id="firstnameTick">&#9744;</span>
                                        <input  type="text"
                                                name="user_firstname"
                                                class="col-9"
                                                pattern='[A-Z][a-z]+'
                                                placeholder="First name"
                                                id="firstnameTxt"
                                                title='Letters only. Proper capitalization please.'>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div class="form-row">
                                        <span class="jh-tick col-2 h2 text-white text-center" id="lastnameTick">&#9744;</span>
                                        <input  type="text"
                                                name="user_lastname"
                                                class="col-9"
                                                pattern='[A-Z][a-z]+'
                                                placeholder="Last name"
                                                id="lastnameTxt"
                                                title='Letters only. Proper capitalization please.'>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div class="form-row">
                                        <span class="jh-tick col-2 h2 text-muted text-center" id="ageTick">&#9744;</span>
                                        <input  type="text"
                                                name="user_age"
                                                class="col-9"
                                                id="ageTxt"
                                                placeholder="Age (required)"
                                                required>
                                    </div>
                                    <div class="form-row">
                                        <span class="jh-tick col-2 h2 text-white text-center">&#9744;</span>
                                        <small class="col-9">
                                            <span class="">(You must be 13 or over)</span>
                                        </small>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div class="form-row">
                                        <div class="col-2"></div>
                                        <?php
                                            if (userIsLoggedIn()) {
                                                echo "<input class='col-9' type='submit' value='Please log out to create a new account.' id='submitBtn' disabled>";
                                            } else {
                                                echo "<input class='col-9' type='submit' value='Submit' id='submitBtn' disabled>";
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
            } else {
                echo "<script src='./js_scripts/functions.js'></script>";
                echo "<script src='./js_scripts/create_account.js'></script>";
            }
        ?>
    </body>
</html>