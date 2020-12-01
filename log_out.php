<?php
    include("./tools.php");

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
            <h1>Goodbye</h1>
            <div>
                <?php
                    if (userIsLoggedIn()) {
                        echo "Username: " . get("username") . " wants to leave.";
                        session_destroy();
                        $_SESSION = [];
                        if (!userIsLoggedIn()) {
                            echo "You've been logged out.";
                        } else {
                            echo "Uh oh, error logging out. I don't know how to fix this";
                        }
                    } else {
                        echo "Logging out, if you're not already logged in, sounds a little too menacing for this system.";
                    }
                ?>
            </div>
        </main>
    </body>
</html>