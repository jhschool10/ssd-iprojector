<?php
    function get($command) {

        $output = "";
        switch ($command) {
            case "user_id":
                $output = $_SESSION["user_id"];
                break;
            case "username":
                $output = $_SESSION["username"];
                break;
            case "last_login":
                $output = $_SESSION["last_login"];
                break;
        }

        return $output;
    }

    function userIsLoggedIn() {
        return isset($_SESSION["user_id"]);
    }

    function logUserIn($id, $username, $last_login) {
        include("./php_scripts/connect_to_db.php");

        $_SESSION["user_id"] = $id;
        $_SESSION["username"] = $username;
        $_SESSION["last_login"] = $last_login;

        $command = "UPDATE users SET last_login = current_timestamp() WHERE id = ?";
        $statement = $dbh->prepare($command);
        $was_successful = $statement->execute([$id]);
    }

?>