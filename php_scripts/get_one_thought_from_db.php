<?php
    include("./connect_to_db.php");
    include("./tools.php");

    session_start();

    /**
     * Security conditions:
     *  - user must be logged in
     *  - user can only get their own thoughts
     */

    $output = [];
    $user_id = get("user_id");
    $thought_text = filter_input(INPUT_GET, "thought_text", FILTER_SANITIZE_SPECIAL_CHARS);

    if (userIsLoggedIn() and $thought_text != null and $thought_text != false) {
        $user_id = get("user_id");

        $command = "SELECT id as thought_id, current_owner, date_created, thought_text, huzzahs, FROM thoughts WHERE thought_text = ? and current_owner = ?";
        $statement = $dbh->prepare($command);
        $was_successful = $statement->execute([$thought_text, $user_id]);

        if ($was_successful) {
            $output = $statement->fetch();
        }
    }

    $outputJSON = json_encode($output);
    echo $outputJSON;
?>