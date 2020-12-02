<?php
    include("./php_scripts/connect_to_db.php");
    include("./php_scripts/tools.php");

    session_start();
?><!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/main.css">
        <link rel="stylesheet" href="./css/thoughts.css">
        <style>
            section:last-of-type {
                background-image: url("./images/people.jpg");
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
                <h2>Record a Thought</h2>
                <section>
                    <div id="success_message"></div>
                    <?php
                        if (!userIsLoggedIn()) {
                            echo "<p>You need to be logged in.</p>";
                        } else {
                            echo "<p>Please remember that you are posting as: " . get("username") . "</p>";
                            echo "<form id='record_thought'>";
                            echo    "<div class='form-chunk'>";
                            echo        "<label for='thought_text'>Thought text:</label>";
                            echo        "<textarea name='thought_text' id='thought_text' required>";
                            echo        "</textarea>";
                            echo        "<div class='form-message'></div>";
                            echo    "</div>";
                            echo    "<input type='hidden' name='user_id' id='user_id' value='" . get("user_id") . "'>";
                            echo    "<div class='form-chunk'>";
                            echo        "<input type='submit' value='Submit' id='btn_submit'>";
                            echo    "</div>";
                            echo "</form>";
                        }
                    ?>
                </section>
                <section>

                </section>
            </main>

            <?php
                if (userIsLoggedIn()) {
                    echo "<script src='./js_scripts/record_thought.js'></script>";
                }
            ?>
                    <?php
                include("./page_components/footer.php");
            ?>
        </div>
    </body>
</html>