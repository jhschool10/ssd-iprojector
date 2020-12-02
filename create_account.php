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
        <link rel="stylesheet" href="./css/main.css">
    </head>
    <body>
        <?php
            include("./page_components/header.php");
            include("./page_components/nav.php");
        ?>
        <main>
            <h2>Create an account</h2>
            <?php
                if (userIsLoggedIn()) {
                    echo "<p>";
                    echo    "Hello " . get("username");
                    echo "</p>";
                } else if ($formWasSubmitted) {
                    if ($usernameIsValid and $passwordIsValid and $ageIsValid) {
                        if ($db_call_successful) {
                            echo "<div class='message-success'>";
                                echo "Account created. Please log in.";
                        } else {
                            echo "<div class='message-error'>";
                                echo "Error creating account. Please refresh and try again.";
                        }
                    } else {
                        echo "<div class='message-error'>";
                            if (!$usernameIsValid) echo "Invalid username.";
                            if (!$passwordIsValid) echo "Invalid password.";
                            if (!$ageIsValid) echo "Invalid age. You must be at least 13.";
                    }
                    echo "</div>";
                }
            ?>
            <form method="POST" action="create_account.php">
                <div class="form-chunk">
                    <label for="username">Username:</label>
                    <input type="text" name="username" required>
                    <div class="form-message">(Must be at least five digits; numbers and letters only)</div>
                </div>
                <div class="form-chunk">
                    <label for="user_password">Password:</label>
                    <input type="password" name="user_password" required>
                    <div class="form-message">(Must be at least 8 characters)</div>
                </div>
                <div class="form-chunk">
                    <label for="user_password_confirm">Confirm password:</label>
                    <input type="password" name="user_password_confirm" required>
                    <div class="form-message"></div>
                </div>
                <div class="form-chunk">
                    <label for="user_email">Email:</label>
                    <input type="email" name="user_email">
                    <div class="form-message"></div>
                </div>
                <div class="form-chunk">
                    <label for="user_firstname">First name:</label>
                    <input type="text" name="user_firstname">
                    <div class="form-message"></div>
                </div>
                <div class="form-chunk">
                    <label for="user_lastname">Last name:</label>
                    <input type="text" name="user_lastname">
                    <div class="form-message"></div>
                </div>
                <div class="form-chunk">
                    <label for="user_age">Age</label>
                    <input type="number" name="user_age" required>
                    <div class="form-message">(You must be over 13)</div>
                </div>
                <div class="form-chunk">
                    <?php
                        if (userIsLoggedIn()) {
                            echo "<input type='submit' value='Please log out to create a new account.' id='btn-submit' disabled>";
                        } else {
                            echo "<input type='submit' value='Submit' id='btn-submit'>";
                        }
                    ?>
                </div>
            </form>
        </main>
        <?php
            include("./page_components/footer.php");
        ?>
    </body>
</html>