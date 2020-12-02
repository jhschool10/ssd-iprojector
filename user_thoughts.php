<?php
    include("./php_scripts/connect_to_db.php");
    include("./php_scripts/tools.php");

    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/main.css">
        <style>
        </style>
    </head>
    <body>
        <main>
            <h1>Thought List</h1>
            <?php
                if (!userIsLoggedIn()) {
                    echo "<p>You need to be logged in.</p>";
                } else {
                    echo "<p>Choose between: </p>";
                    echo "<input type='button' value='All thoughts' id='allThoughtsBtn'>";
                    echo "<input type='button' value='" . get("username") . "&lsquo;s thoughts' id='userThoughtsBtn'>";
                    echo "<div id='thoughtListDiv'></div>";
                }
            ?>
        </main>

        <?php
            if (userIsLoggedIn()) {
                echo "<script src='./js_scripts/user_thoughts.js'></script>";
            }
        ?>
    </body>
</html>