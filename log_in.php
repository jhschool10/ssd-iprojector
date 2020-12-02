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
            $command = "SELECT id, pass FROM users WHERE username = ?";
            $statement = $dbh->prepare($command);
            $was_successful = $statement->execute([$username]);

            if ($was_successful) {
                $user_info = $statement->fetch();

                if ($user_password == $user_info["pass"]) {
                    logUserIn($user_info["id"], $username);
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
        <link rel="stylesheet" href="./css/main.css">
        <style>

        </style>
    </head>
    <body>
        <main>
            <h1>Log in</h1>
            <?php

                if ($formWasSubmitted) {
                    if (userIsLoggedIn()) {
                        echo "<div class='message-success'>";
                            echo "Hello " . get("username") . ". You are logged in.";
                            var_dump($_SESSION);
                    } else {
                        echo "<div class='message-error'>";
                            echo "Invalid user info.";
                        session_destroy();
                        $_SESSION = [];
                    }
                echo "</div>";
                } else {
                    if (userIsLoggedIn()) {
                        echo "You're already logged in.";
                    } else {
                        echo "<form method='POST' action='log_in.php'>";
                        echo    "<div class='form-chunk'>";
                        echo        "<label for='username'>Username:</label>";
                        echo        "<input type='text' name='username' required>";
                        echo        "<div class='form-message'></div>";
                        echo    "</div>";
                        echo    "<div class='form-chunk'>";
                        echo        "<label for='user_password'>Password:</label>";
                        echo        "<input type='password' name='user_password' required>";
                        echo        "<div class='form-message'></div>";
                        echo    "</div>";
                        echo    "<div class='form-chunk'>";
                        echo        "<input type='submit' value='Submit'>";
                        echo    "</div>";
                        echo "</form>";
                    }
                }
            ?>
        </main>
    </body>
</html>