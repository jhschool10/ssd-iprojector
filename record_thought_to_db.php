<?php
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

        $output["success"] = $was_successful;
    }

    $outputJSON = json_encode($output);

    echo $outputJSON;
?>