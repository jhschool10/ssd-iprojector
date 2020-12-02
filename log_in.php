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
        <link rel="stylesheet" href="./css/main.css">
        <link rel="stylesheet" href="./css/log_in_log_out.css">
        <style>
            section:last-of-type {
                background-image: url("./images/infinity_mirror.jpg");
            }
        </style>
    </head>
    <body>
        <div class="container">
            <?php
                include("./page_components/header.php");
                include("./page_components/nav.php");
            ?>
            <main>
                <h2>Log in</h2>
                <section>
                    <?php
                        if ($formWasSubmitted and !userIsLoggedIn()) {
                            echo "<div class='message-error'>";
                                echo "Incorrect user information.";
                            echo "</div>";
                            session_destroy();
                            $_SESSION = [];
                        } else {
                            if (userIsLoggedIn()) {
                                echo "<p>";
                                    echo "Welcome.<br>" . $last_login;
                                echo "</p>";
                            } else {
                                echo "<form method='POST' action='log_in.php'>";
                                echo    "<div class='form-chunk'>";
                                echo        "<label for='username'>Username:</label>";
                                echo        "<input type='text' name='username' required>";
                                echo    "</div>";
                                echo    "<div class='form-chunk'>";
                                echo        "<label for='user_password'>Password:</label>";
                                echo        "<input type='password' name='user_password' required>";
                                echo    "</div>";
                                echo    "<div class='form-chunk'>";
                                echo        "<input type='submit' value='Submit'>";
                                echo    "</div>";
                                echo "</form>";
                            }
                        }
                    ?>
                </section>
                <section>
                    <p>(Credit: https://commons.wikimedia.org/wiki/File:Infinity_Mirror_Effect.jpg)</p>
                </section>
            </main>
            <?php
                include("./page_components/footer.php");
            ?>
        </div>
    </body>
</html>