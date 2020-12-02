<?php
    include("./connect_to_db.php");
    include("./tools.php");

    session_start();

    $output = [];
    $for_user = filter_input(INPUT_GET, "for_user", FILTER_VALIDATE_BOOLEAN);
    if (userIsLoggedIn() and $for_user) {
        $user_id = get("user_id");

        $command = "SELECT * FROM thoughts WHERE current_owner = ?";
        $statement = $dbh->prepare($command);
        $was_successful = $statement->execute([$user_id]);

        if ($was_successful) {
            $output = $statement->fetchAll();
        }
    } else {
        $command = "SELECT * FROM thoughts";
        $statement = $dbh->prepare($command);
        $was_successful = $statement->execute([]);

        if ($was_successful) {
            $output = $statement->fetchAll();
        }
    }

    $outputJSON = json_encode($output);
    echo $outputJSON;
?>