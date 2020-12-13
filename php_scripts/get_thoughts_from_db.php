<?php
    /**
     * Gets all thoughts from the database in JSON format
     * Author: Joseph Haley
     */

    include("./connect_to_db.php");
    include("./tools.php");

    session_start();

    $thought_set = filter_input(INPUT_GET, "thought_set", FILTER_SANITIZE_SPECIAL_CHARS);
    $order = filter_input(INPUT_GET, "order", FILTER_SANITIZE_SPECIAL_CHARS);
    $order_by = filter_input(INPUT_GET, "order_by", FILTER_SANITIZE_SPECIAL_CHARS);

    // Options: all, user, not_user
    if ($thought_set == null or $thought_set == false and ($thought_set != "user" and $thought_set != "not_user")) {
        $thought_set = "all";
    }

    $order = strtoupper($order);
    // Options: ASC (DEFAULT), DESC, RANDOM
    if ($order == null or $order == false and ($order != "DESC" and $order != "RANDOM")) {
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

    $output = [];
    if (userIsLoggedIn()) {
        switch($thought_set) {
            case "all":
                if ($order == "RANDOM") {
                    $command = "SELECT t.id as thought_id, t.current_owner, t.date_created, t.thought_text, t.huzzahs, u.id as user_id, u.username, u.age
                                FROM thoughts t
                                INNER JOIN users u
                                ON t.current_owner=u.id
                                ORDER BY RAND()";
                } else {
                    $command = "SELECT t.id as thought_id, t.current_owner, t.date_created, t.thought_text, t.huzzahs, u.id as user_id, u.username, u.age
                                FROM thoughts t
                                INNER JOIN users u
                                ON t.current_owner=u.id
                                ORDER BY " . $order_by . " " . $order;
                                    // Not using PDO parameters for ORDER BY and ORDER re: https://stackoverflow.com/questions/5738141/pdo-parameters-not-working-at-all
                }
                $statement = $dbh->prepare($command);
                $was_successful = $statement->execute([]);
        
                if ($was_successful) {
                    $output = $statement->fetchAll();
                }
                break;
            case "user":
                $user_id = get("user_id");
        
                $statement; $was_successful;
                if ($order == "RANDOM") {
                    $command = "SELECT t.id as thought_id, t.current_owner, t.date_created, t.thought_text, t.huzzahs, u.id as user_id, u.username, u.age
                                FROM thoughts t
                                INNER JOIN users u
                                ON t.current_owner=u.id
                                WHERE current_owner = ?
                                ORDER BY RAND()";
                    $statement = $dbh->prepare($command);
                    $was_successful = $statement->execute([$user_id]);
                } else {
                    $command = "SELECT t.id as thought_id, t.current_owner, t.date_created, t.thought_text, t.huzzahs, u.id as user_id, u.username, u.age
                                FROM thoughts t
                                INNER JOIN users u
                                ON t.current_owner=u.id
                                WHERE current_owner = ?
                                ORDER BY " . $order_by . " " . $order;
                    $statement = $dbh->prepare($command);
                    $was_successful = $statement->execute([$user_id]);
                }
                if ($was_successful) {
                    $output = $statement->fetchAll();
                }
                break;
            case "not_user":
                $user_id = get("user_id");
        
                $statement; $was_successful;
                if ($order == "RANDOM") {
                    $command = "SELECT t.id as thought_id, t.current_owner, t.date_created, t.thought_text, t.huzzahs, u.id as user_id, u.username, u.age
                                FROM thoughts t
                                INNER JOIN users u
                                ON t.current_owner=u.id
                                WHERE current_owner != ?
                                ORDER BY RAND()";
                    $statement = $dbh->prepare($command);
                    $was_successful = $statement->execute([$user_id]);
                } else {
                    $command = "SELECT t.id as thought_id, t.current_owner, t.date_created, t.thought_text, t.huzzahs, u.id as user_id, u.username, u.age
                                FROM thoughts t
                                INNER JOIN users u
                                ON t.current_owner=u.id
                                WHERE current_owner != ?
                                ORDER BY " . $order_by . " " . $order;
                    $statement = $dbh->prepare($command);
                $was_successful = $statement->execute([$user_id]);
                }
        
                if ($was_successful) {
                    $output = $statement->fetchAll();
                }
                break;
        }
    } else {
        array_push($output, "You must be logged in.");
    }

    $outputJSON = json_encode($output);
    echo $outputJSON;
?>