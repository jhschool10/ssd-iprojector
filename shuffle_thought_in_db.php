<?php
    include("./connect_to_db.php");
    include("./tools.php");

    session_start();
    
    $output["success"] = false;
    if (userIsLoggedIn()) {
        $user_id = get("user_id");
        $thought_id = filter_input(INPUT_GET, "thought_id", FILTER_VALIDATE_INT);

        $was_successful = false;
        $belongs_to_user = false;
        // Validate thought_id passed to script
        if ($thought_id != "" and $thought_id != false and $thought_id != null) {
            $command = "SELECT current_owner FROM thoughts WHERE id = ?";
            $statement = $dbh->prepare($command);
            $was_successful = $statement->execute([$thought_id]);

            if ($was_successful) {
                $thought_owner = $statement->fetch()["current_owner"];
                // Does the user own the thought they're trying to shuffle?
                if ($thought_owner == $user_id) {

                    $command = "
                        SELECT t.id, t.current_owner INTO @other_thought_id, @other_owner_id FROM thoughts t WHERE t.current_owner != 2 ORDER BY RAND() LIMIT 1;
                        INSERT INTO shuffle_log
                                (thought_id, new_owner)
                        VALUES 	(?, @other_owner_id),
                                (@other_thought_id, ?);";
                    $statement = $dbh->prepare($command);
                    $was_successful = $statement->execute([$thought_id, $user_id]);

                    if ($was_successful) {
                        $output["success"] = true;
                    } else {
                        $output["message"] = "Error accessing database on SELECT-INSERT.";
                    }

                } else {
                    $output["message"] = "User does not own this thought!";
                }
            } else {
                $output["message"] = "Error accessing database on SELECT.";
            }
        } else {
            $output["message"] = "No valid thought_id passed to script";
        }
    } else {
        $output["message"] = "User not logged in.";
    }

    $outputJSON = json_encode($output);

    echo $outputJSON;
?>