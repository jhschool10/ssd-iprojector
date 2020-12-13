<?php
    /**
     * Inserts a thought record into the thoughts table
     * Author: Joseph Haley
     */

    include("./connect_to_db.php");
    include("./tools.php");

    session_start();
    
    $output["success"] = false;
    if (userIsLoggedIn()) {
        $thought_text = filter_input(INPUT_GET, "thought_text", FILTER_SANITIZE_SPECIAL_CHARS);
        $user_id = get("user_id");

        $was_successful = false;
        if ($thought_text != "" and $thought_text != false and $thought_text != null) {
            $command = "INSERT INTO thoughts (current_owner, thought_text) VALUES (?, ?)";
            $statement = $dbh->prepare($command);
            $was_successful = $statement->execute([$user_id, $thought_text]);
        }

        // Get the inserted row and return it
        if ($was_successful) {
            $command = "SELECT t.id as thought_id, t.current_owner, t.date_created, t.thought_text, t.huzzahs, u.id as user_id, u.username, u.age FROM thoughts t INNER JOIN users u ON t.current_owner=u.id  WHERE thought_text = ?";
            $statement = $dbh->prepare($command);
            $was_successful = $statement->execute([$thought_text]);

            $output["thought"] = $statement->fetch();
        }
        $output["success"] = $was_successful;
    } else {
        array_push($output, "You must be logged in.");
    }

    $outputJSON = json_encode($output);

    echo $outputJSON;
?>