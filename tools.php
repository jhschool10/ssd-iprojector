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

?>