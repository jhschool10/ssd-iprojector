<?php
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
        <link rel="stylesheet" href="./css/log_in_log_out.css">
        <style>
            section:last-of-type {
                background-image: url("./images/infinity_mirror_02.jpeg");
            }
        </style>
    </head>
    <body>
        <div class="container">
            <?php
                include("./page_components/header.php");
                include("./page_components/nav.php");
            ?>
            <main>
                <h2>Goodbye</h2>
                <section>
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
                </section>
                <section>

                </section>
            </main>
            <?php
                include("./page_components/footer.php");
            ?>
        </div>
    </body>
</html>