<?php
    /**
     * Gets one thought from the database in JSON format
     * Author: Joseph Haley
     */

    include("./connect_to_db.php");
    include("./tools.php");

    session_start();

    /**
     * Security conditions:
     *  - user must be logged in
     *  - user can only get their own thoughts
     */

    $output = [];
    $thought_id = filter_input(INPUT_GET, "thought_id", FILTER_SANITIZE_SPECIAL_CHARS);

    if ($thought_id != "random") {
        $thought_id = filter_input(INPUT_GET, "thought_id", FILTER_VALIDATE_INT);
    }
    
    if (userIsLoggedIn()) {  
        if ($thought_id != null and $thought_id != false) {
            $was_successful = "";

            if ($thought_id == "random") {
                $command = "SELECT t.id as thought_id, t.current_owner, t.date_created, t.thought_text, t.huzzahs, u.id as user_id, u.username, u.age FROM thoughts t INNER JOIN users u ON t.current_owner=u.id ORDER BY RAND() LIMIT 1";
                $statement = $dbh->prepare($command);
                $was_successful = $statement->execute([]);
            } else {
                $command = "SELECT t.id as thought_id, t.current_owner, t.date_created, t.thought_text, t.huzzahs, u.id as user_id, u.username, u.age FROM thoughts t INNER JOIN users u ON t.current_owner=u.id WHERE t.id = ?";
                $statement = $dbh->prepare($command);
                $was_successful = $statement->execute([$thought_id]);
            }

            if ($was_successful) {
                $output = $statement->fetchAll();
            }
        }
    } else {
        array_push($output, "You must be logged in.");
    }

    $outputJSON = json_encode($output);
    echo $outputJSON;
?>