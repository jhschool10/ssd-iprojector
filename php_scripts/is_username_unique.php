<?php
    /**
     * Returns whether a username is unique or not in JSON format
     * Author: Joseph Haley
     */

    include("./connect_to_db.php");
    include("./tools.php");

    session_start();

    $output = [];
    $username = filter_input(INPUT_GET, "username", FILTER_SANITIZE_SPECIAL_CHARS);

    if ($username != null and $username != false) {
        $was_successful = "";

        $command = "SELECT id FROM users WHERE username = ?";
        $statement = $dbh->prepare($command);
        $was_successful = $statement->execute([$username]);
        
        if ($was_successful) {
            $output["success"] = count($statement->fetchAll()) == 0;
        }
    }

    $outputJSON = json_encode($output);
    echo $outputJSON;
?>