<?php
    /**
     * This script contains functions which are used across multiple pages
     * Author: Joseph Haley
     */

    /**
     * Returns information associated with the user
     *  (a nicer way of accessing the $_SESSION variable)
     * @param String $command The information about the user to be returned (one of: user_id, username, last_login)
     * @return String The piece of information about the user
     */
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

    /**
     * Returns whether the user is logged in or not
     * @return Boolean Whether the user is logged in or not
     */
    function userIsLoggedIn() {
        return isset($_SESSION["user_id"]);
    }

    /**
     * "Logs a user in": adds data identifying the user to the $_SESSION variable
     * @param Int $id the user's ID
     * @param String $username the user's username
     * @param String $last_login the last time the user logged in
     */
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