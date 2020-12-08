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
        
        if ($thought_id != "" and $thought_id != false and $thought_id != null) { // Get the thought's owner
            $command = "SELECT current_owner FROM thoughts WHERE id = ?";
            $statement = $dbh->prepare($command);
            $was_successful = $statement->execute([$thought_id]);

            if ($was_successful) {
                $thought_owner = $statement->fetch()["current_owner"];
                
                if ($thought_owner == $user_id) { // Validate ownership of the thought

                    $command = "
                        SELECT t.id, t.current_owner INTO @other_thought_id, @other_owner_id FROM thoughts t WHERE t.current_owner != ? ORDER BY RAND() LIMIT 1;
                        SELECT p.trade_id INTO @last_trade_id FROM projection_log p ORDER BY trade_id DESC LIMIT 1;
                        INSERT INTO projection_log
                                (trade_id, thought_id, new_owner, old_owner)
                            VALUES 	(@last_trade_id + 1, ?, @other_owner_id, ?),
                                (@last_trade_id + 1, @other_thought_id, ?, @other_owner_id);";
                    $statement = $dbh->prepare($command);
                    $was_successful = $statement->execute([ $user_id,
                                                            $thought_id, $user_id,
                                                            $user_id]);

                    if ($was_successful) { // Was the trade successfully made?

                        $command = "
                            SELECT  date as trade_date,
                                    thought_id,
                                    new_owner as new_owner_id,
                                    username as new_owner_username,
                                    age as new_owner_age
                            FROM projection_log p
                            INNER JOIN users u
                            ON p.new_owner = u.id
                            WHERE trade_id = (  SELECT MAX(trade_id) as trade_id FROM projection_log
                                                WHERE new_owner = ?); 
                        ";
                        $statement = $dbh->prepare($command);
                        $was_successful = $statement->execute([$user_id]);

                        if ($was_successful) {
                            $output["success"] = true;
                            $output["message"] = $statement->fetchAll();
                        }
                        
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