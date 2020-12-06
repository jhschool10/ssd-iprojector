<?php
    include("./connect_to_db.php");
    include("./tools.php");

    session_start();

    $output = [];
    $for_user = filter_input(INPUT_GET, "for_user", FILTER_VALIDATE_BOOLEAN);
    $order = filter_input(INPUT_GET, "order", FILTER_SANITIZE_SPECIAL_CHARS);
    $order_by = filter_input(INPUT_GET, "order_by", FILTER_SANITIZE_SPECIAL_CHARS);

    $order = strtoupper($order);
    // Options: ASC (DEFAULT), DESC, RANDOM
    if ($order == null or $order == false or ($order != "DESC" and $order != "RANDOM")) {
        $order = "ASC";
    }

    // Options: date (DEFAULT), huzzahs, username
    if ($order_by == "huzzahs") {
        $order_by = "t.huzzahs";
    } else if ($order_by == "username") {
        $order_by = "u.username";
    } else {
        $order_by = "t.date_created";
    }

    if (userIsLoggedIn() and $for_user) {
        $user_id = get("user_id");

        if ($order != "RANDOM") {
            $command = "SELECT t.id as thought_id, t.current_owner, t.date_created, t.thought_text, t.huzzahs, u.id as user_id, u.username, u.age FROM thoughts t INNER JOIN users u ON t.current_owner=u.id WHERE current_owner = ? ORDER BY ? " . $order;
        } else {
            $command = "SELECT t.id as thought_id, t.current_owner, t.date_created, t.thought_text, t.huzzahs, u.id as user_id, u.username, u.age FROM thoughts t INNER JOIN users u ON t.current_owner=u.id WHERE current_owner = ? ORDER BY RAND()";
        }
        $statement = $dbh->prepare($command);
        $was_successful = $statement->execute([$user_id, $order_by]);

        if ($was_successful) {
            $output = $statement->fetchAll();
        }
    } else if (userIsLoggedIn()) {
        if ($order != "RANDOM") {
            $command = "SELECT t.id as thought_id, t.current_owner, t.date_created, t.thought_text, t.huzzahs, u.id as user_id, u.username, u.age FROM thoughts t INNER JOIN users u ON t.current_owner=u.id ORDER BY ? " . $order;
        } else {
            $command = "SELECT t.id as thought_id, t.current_owner, t.date_created, t.thought_text, t.huzzahs, u.id as user_id, u.username, u.age FROM thoughts t INNER JOIN users u ON t.current_owner=u.id ORDER BY RAND()";
        }
        $statement = $dbh->prepare($command);
        $was_successful = $statement->execute([$order_by]);

        if ($was_successful) {
            $output = $statement->fetchAll();
        }
    }

    $outputJSON = json_encode($output);
    echo $outputJSON;
?>