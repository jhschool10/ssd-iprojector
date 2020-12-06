<?php
    include("./php_scripts/connect_to_db.php");
    include("./php_scripts/tools.php");

    session_start();

    $last_login = "";

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
            $command = "SELECT id, pass, last_login FROM users WHERE username = ?";
            $statement = $dbh->prepare($command);
            $was_successful = $statement->execute([$username]);

            if ($was_successful) {
                $user_info = $statement->fetch();

                if ($user_password == $user_info["pass"]) {
                    logUserIn($user_info["id"], $username);
                    $last_login = "You last logged in: " . $user_info["last_login"];
                }
            }
        }
    }
?>
<!DOCTYPE html>
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
    <body class='bg-light'>
        <div class="container-fluid jh-height p-0 m-0">
            <?php // Header and Nav
                include("./page_components/header.php");
            ?>
            <div class="row jh-height justify-content-center align-items-center p-4 m-0">
                <section class="col-md h-100 mt-3">
                    <?php
                        if (userIsLoggedIn()) { // Successful login
                            // LANDING PAGE
                            echo    "<div class='h-100 w-100 bg-light border rounded shadow' id='head_image'>";
                            echo        "<a href='./user_thoughts.php' class='d-inline-block w-100 h-100 pt-5 pl-5'><span class='border border p-2 rounded bg-primary text-white'>My thoughts</span></a>";
                            echo    "</div>";
                        } else {
                            echo "<form method='POST' action='log_in.php' class='h-100 w-100 d-flex flex-column justify-content-center align-items-center p-4 bg-light border rounded shadow'>";
                                echo "<div class='row w-50'>";
                                    echo "<label for='username' class='col text-center mb-0'>Username:</label>";
                                    echo "<input type='text' name='username' class='col mb-2' required>";
                                echo "</div>";
                                echo "<div class='row w-50'>";
                                    echo "<label for='user_password' class='col text-center mb-0'>Password:</label>";
                                    echo "<input type='password' name='user_password' class='col mb-4' required>";
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
                        }
                    ?>
                </section>
                <section class="col-md h-100 mt-3">
                    <?php
                        if (userIsLoggedIn()) {
                            echo "<div class='h-100 w-100 bg-light border rounded shadow' id='globe_image'>";
                                echo "<a href='./all_thoughts.php' class='d-inline-block w-100 h-100 pt-5 pl-5'>";
                                    echo "<span class='border border p-2 rounded bg-primary text-white'>Other thoughts</span>";
                                echo "</a>";
                            echo "</div>";
                        } else {
                            echo "<div class='h-100 w-100 bg-light rounded shadow' id='mirror_image'>";
                            echo "</div>";
                        }
                    ?>
                </section>
            </div>
        </div>
    </body>
</html>