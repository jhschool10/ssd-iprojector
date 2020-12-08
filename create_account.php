<?php
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

        $passwordIsValid = true;
        if ($user_password == false or
            $user_password == null or
            strlen($user_password) < 8) {

            $passwordIsValid = false;
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
            $db_call_successful = $statement->execute([$username, $user_password, $user_email, $user_firstname, $user_lastname, $user_age]);
        }
    }
?><!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
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
        </style>
    </head>
    <body class='bg-light'>
        <div class="container-fluid jh-height p-0 m-0">
            <?php
                include("./page_components/header.php");
            ?>
            <div class="jh-height justify-content-center align-items-center p-4 m-0">
                <div class='h-100 w-100 bg-light border rounded shadow p-4' id='content_box'>
                    <h2 class="d-flex w-100 justify-content-center text-center pb-3">Create an account</h2>
                    <div class="row justify-content-center">
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
                        <form method="POST" action="create_account.php" class="d-flex justify-content-center flex-column">
                            <div class="row pb-3 justify-content-center">
                                <label for="username" class="col-sm-3 text-md-left text-center">Username:</label>
                                <input type="text" name="username" class="col-5" required>
                                <div class="text-info col-md text-md-left text-center">(Must be at least five digits; numbers and letters only)</div>
                            </div>
                            <div class="row pb-3 justify-content-center">
                                <label for="user_password" class="col-sm-3 text-md-left text-center">Password:</label>
                                <input type="password" name="user_password" class="col-5" required>
                                <div class="text-info col-md text-md-left text-center">(Must be at least 8 characters)</div>
                            </div>
                            <div class="row pb-3 justify-content-center">
                                <label for="user_password_confirm" class="col-sm-3 text-md-left text-center">Confirm password:</label>
                                <input type="password" name="user_password_confirm" class="col-5" required>
                                <div class="text-info col-md text-md-left text-center"></div>
                            </div>
                            <div class="row pb-3 justify-content-center">
                                <label for="user_email" class="col-sm-3 text-md-left text-center">Email:</label>
                                <input type="email" name="user_email" class="col-5">
                                <div class="text-info col-md text-md-left text-center"></div>
                            </div>
                            <div class="row pb-3 justify-content-center">
                                <label for="user_firstname" class="col-sm-3 text-md-left text-center">First name:</label>
                                <input type="text" name="user_firstname" class="col-5">
                                <div class="text-info col-md text-md-left text-center"></div>
                            </div>
                            <div class="row pb-3 justify-content-center">
                                <label for="user_lastname" class="col-sm-3 text-md-left text-center">Last name:</label>
                                <input type="text" name="user_lastname" class="col-5">
                                <div class="text-info col-md text-md-left text-center"></div>
                            </div>
                            <div class="row pb-3 justify-content-center">
                                <label for="user_age" class="col-sm-3 text-md-left text-center">Age</label>
                                <input type="number" name="user_age" class="col-5" required>
                                <div class="text-info col-md text-md-left text-center">(You must be over 13)</div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-3"></div>
                                <?php
                                    if (userIsLoggedIn()) {
                                        echo "<input type='submit' value='Please log out to create a new account.' id='btn-submit' class='col-5' disabled>";
                                    } else {
                                        echo "<input type='submit' value='Submit' id='btn-submit' class='col-5'>";
                                    }
                                ?>
                                <div class="col-md"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
            if (userIsLoggedIn()) {
                echo "<script src='./libraries/jquery-3.5.1.min.js'></script>";
                echo "<script src='./libraries/bootstrap.bundle.min.js'></script>";
            }
        ?>
    </body>
</html>