<?php
    include("./connect_to_db.php");
    include("./tools.php");

    session_start();

    $output = [];
    $for_user = filter_input(INPUT_GET, "for_user", FILTER_VALIDATE_BOOLEAN);
    $order_by_descending = filter_input(INPUT_GET, "desc", FILTER_VALIDATE_BOOLEAN);

    $order = "DESC";
    if ($order_by_descending == null or $order_by_descending == false) {
        $order = "ASC";
    }

    if (userIsLoggedIn() and $for_user) {
        $user_id = get("user_id");

        $command = "SELECT * FROM thoughts WHERE current_owner = ? ORDER BY date_created " . $order;
        $statement = $dbh->prepare($command);
        $was_successful = $statement->execute([$user_id]);

        if ($was_successful) {
            $output = $statement->fetchAll();
        }
    } else {
        $command = "SELECT t.id as thought_id, t.current_owner, t.date_created, t.thought_text, t.huzzahs, u.id as user_id, u.username, u.age FROM thoughts t INNER JOIN users u ON t.current_owner=u.id ORDER BY date_created " . $order;
        $statement = $dbh->prepare($command);
        $was_successful = $statement->execute([$order]);

        if ($was_successful) {
            $output = $statement->fetchAll();
        }
    }

    $outputJSON = json_encode($output);
    echo $outputJSON;
?>