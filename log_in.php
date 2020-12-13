<?php
    include("./php_scripts/connect_to_db.php");
    include("./php_scripts/tools.php");

    session_start();

    $formWasSubmitted = count($_POST) != 0;
    if (!userIsLoggedIn() && $formWasSubmitted) {

        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $user_password = filter_input(INPUT_POST, "user_password", FILTER_SANITIZE_SPECIAL_CHARS);

        // Validate input
        $usernameIsValid = true;
        if ($username == false or
            $username == null or
            strlen($username) < 5) {

            $usernameIsValid = false;
        }

        $passwordIsValid = true;
        if ($user_password == false or
            $user_password == null) {

            $passwordIsValid = false;
        }

        $user_logged_in = false;
        if ($usernameIsValid and $passwordIsValid) {
            $command = "SELECT id, pass as hash_pass, last_login FROM users WHERE username = ?";
            $statement = $dbh->prepare($command);
            $was_successful = $statement->execute([$username]);

            if ($was_successful) {
                $user_info = $statement->fetch();

                if (password_verify($user_password, $user_info["hash_pass"])) {
                    logUserIn($user_info["id"], $username, $user_info["last_login"]);
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            <?php 
            if (userIsLoggedIn()) {
                echo "Logged in as: " . get("username");
            } else {
                echo "Log in? Log in!";
            }
            ?>
        </title>
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
                    height: 45vh;
                }
            }
            .jh-height-header {
                height: 10vh;
            }
            #head_image {
                background-image: url("./images/head.png");
                background-size: 80% auto;
                background-position: center;
                background-repeat: no-repeat;
            }
                #head_image:hover {
                    background-image: url("./images/head_open.png");
                }
            #globe_image {
                background-image: url("./images/globe.png");
                background-size: 80% auto;
                background-position: center;
                background-repeat: no-repeat;
            }
                #globe_image:hover {
                    background-image: url("./images/globe_open.png");
                }
            #mirror_image {
                background-image: url("./images/infinity_mirror_02.jpg");
                /* background-size: 100%; */
                background-position: center;
                background-repeat: no-repeat;

                opacity: 0.5;
                transition: opacity 1s ease-in;
            }
                #mirror_image:hover {
                    opacity: 1;
                }
        </style>
    </head>
    <body class='bg-light d-flex flex-column w-100 justify-content-center'>
        <?php // Header and Nav
            include("./page_components/header.php");
        ?>
        <div class="w-100 d-flex justify-content-center">
            <div class="container-lg jh-height p-0 m-0">
                <div class="row jh-height justify-content-center p-4 m-0">
                    
                    <?php
                        if (userIsLoggedIn()) { // Successful login
                            // LANDING PAGE
                            echo "<section class='d-flex flex-column mt-2 mb-2 p-4 w-100 bg-white rounded shadow text-center'>";
                                if (get("last_login") == "") {
                                    echo "<p class='p-0 m-0'>Since this is your first time, please read the instructions.</p>";
                                } else {
                                    echo "<p>Your last login was: " . get("last_login") . "</p>";
                                }
                            echo "</section>";
                            echo "<section class='d-flex flex-column mt-4 p-4 w-100 bg-white rounded shadow text-center'>";
                                echo "<h2 class='display-4'>Instructions</h2>";
                                echo "<p class='lead'>This is a random thought:</p>";
                                echo "<div id='random_thought' class='text-center'></div>";
                                echo "<p class='lead'>You can record your own thoughts.</p>";
                                echo "<p class='lead'>When you get tired of them, project them onto other users.</p>";
                                echo "<p class='lead'>But be careful.</p>";
                                echo "<p class='lead'>You'll get one of their thoughts in return.</p>";
                                echo "<p class='lead'>Click a thought to get more information about it.</p>";
                                echo "<p class='lead'>One day it could be yours.</p>";
                                echo "<p class='lead'>Huzzah thoughts for whatever reason.</p>";
                                echo "<p class='lead'>But please, be reasonable. Only one per second.</p>";
                                echo "<div class='d-flex justify-content-center'>";
                                    echo "<iframe class='mb-2' width='300' height='169' src='https://www.youtube.com/embed/gazIa2IibZA' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
                                echo "</div>";
                            echo "</section>";
                        } else {
                            echo "<section class='col-md mt-2'>";
                                echo "<form method='POST' action='log_in.php' class='h-100 w-100 d-flex flex-column justify-content-center align-items-center p-4 bg-light border rounded shadow'>";
                                    echo "<div class='row w-50'>";
                                        echo "<input type='text' name='username' class='col mb-2' pattern='\w{5,}' title='(5 or more characters; alphanumeric only)' placeholder='Username' required>";
                                    echo "</div>";
                                    echo "<div class='row w-50'>";
                                        echo "<input type='password' name='user_password' class='col mb-4' placeholder='Password' required>";
                                    echo "</div>";
                                    echo "<div class='row w-50'>";
                                        echo "<input type='submit' value='Submit' class='col'>";
                                    echo "</div>";
                                    if ($formWasSubmitted) { // Unsuccessful login
                                        echo "<div class='text-danger'>";
                                            echo "(Invalid user information)";
                                        echo "</div>";
                                        session_destroy();
                                        $_SESSION = [];
                                    }
                                echo "</form>";
                            echo "</section>";
                        }
                    ?>
                    <?php // Second column (only for log-in image)
                        if (!userIsLoggedIn()) {
                            echo "<section class='col-md h-100 mt-2'>";
                                echo "<div class='h-100 w-100 bg-light rounded shadow' id='mirror_image'>";
                                echo "</div>";
                            echo "</section>";
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php
            if (userIsLoggedIn()) {
                echo "<script src='./libraries/jquery-3.5.1.min.js'></script>";
                echo "<script src='./libraries/bootstrap.bundle.min.js'></script>";
                echo "<script src='./js_scripts/functions.js'></script>";
                echo "<script src='./js_scripts/log_in.js'></script>";
            }
        ?>
    </body>
</html>