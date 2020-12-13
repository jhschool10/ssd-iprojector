<?php
    /**
     * Gets a thought's trade history from the database in JSON format
     * Author: Joseph Haley
     */

    include("./connect_to_db.php");
    include("./tools.php");

    session_start();

    /**
     * Security conditions:
     *  - user must be logged in
     */

    $output = [];
    $user_id = get("user_id");
    $thought_id = filter_input(INPUT_GET, "thought_id", FILTER_VALIDATE_INT);
    
    if (userIsLoggedIn()) {
        if ($thought_id != null and $thought_id != false) {
            $command = "
                SELECT p.id as projection_id, p.trade_id, p.date as trade_date, p.thought_id, th.thought_text, p.new_owner as new_owner_id, u1.username as new_owner_username, p.old_owner as old_owner_id, u2.username as old_owner_username
                    FROM projection_log p
                        INNER JOIN thoughts th
                            ON p.thought_id = th.id
                        INNER JOIN users u1
                            ON p.new_owner = u1.id
                        INNER JOIN users u2
                            ON p.old_owner = u2.id
                    WHERE thought_id = ?
                    ORDER BY date DESC
            ";
            $statement = $dbh->prepare($command);
            $was_successful = $statement->execute([$thought_id]);

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