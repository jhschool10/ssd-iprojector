<?php
    function get($command) {

        $value = "";
        switch ($command) {
            case "user_id":
                $value = $_SESSION["user_id"];
                break;
            case "username":
                $value = $_SESSION["username"];
                break;
        }

        return $value;
    }

    function userIsLoggedIn() {
        return isset($_SESSION["user_id"]);
    }

    function logUserIn($id, $username) {
        include("./connect_to_db.php");

        $_SESSION["user_id"] = $id;
        $_SESSION["username"] = $username;

        $command = "UPDATE users SET last_login = current_timestamp() WHERE id = ?";
        $statement = $dbh->prepare($command);
        $was_successful = $statement->execute([$id]);
    }

?>