<?php
    include("./connect_to_db.php");
    include("./tools.php");

    session_start();

    $output = [];
    $thought_id = filter_input(INPUT_GET, "thought_id", FILTER_VALIDATE_INT);
    if (userIsLoggedIn() and $thought_id) {
        $user_id = get("user_id");

        $command = "SELECT * FROM thoughts WHERE id = ?";
        $statement = $dbh->prepare($command);
        $was_successful = $statement->execute([$thought_id]);

        if ($was_successful) {
            $thoughtExists = count($statement->fetchAll()) != 0;

            if ($thoughtExists) {
                $command = "UPDATE thoughts SET huzzahs = huzzahs + 1 WHERE id = ?";
                $statement = $dbh->prepare($command);
                $was_successful = $statement->execute([$thought_id]);

                if ($was_successful) {
                    $output["success"] = true;
                }
            } else {
                $output["success"] = false;
                $output["message"] = "Invalid thought_id.";
            }
        }
    } else {
        $output["success"] = false;
        $output["message"] = "User not logged in or no thought_id given.";
    }

    $outputJSON = json_encode($output);
    echo $outputJSON;
?>