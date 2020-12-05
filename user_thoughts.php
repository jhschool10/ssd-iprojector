<?php
    include("./php_scripts/connect_to_db.php");
    include("./php_scripts/tools.php");

    session_start();
?><!DOCTYPE html>
<html>
    <head>
        <title>User thoughts</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/bootstrap.min.css"/>
        <link rel="stylesheet" href="./css/animate.min.css"/>
        <style>
            .jh-height-header {
                height: 10vh;
            }
            #submit_button {
                height: 200px;
                width: 200px;

                border-radius: 50%;
                border: white 2px solid;
                box-shadow: 0.75em 0.75em 0.5em 0 black;
            }
                #submit_button:active {
                    box-shadow: 0.25em 0.25em 0.5em 0 black;
                    transform: translateX(0.5em) translateY(0.5em);
                }
        </style>
    </head>
    <body class='bg-light'>
        <div class="container-fluid p-0 m-0">
            <?php
                include("./page_components/header.php");
            ?>
            <div class="justify-content-center align-items-center p-4 m-0">
                <div class="justify-content-center align-items-center p-4 m-0 h-100 w-100 bg-light border rounded shadow">
                    <div id="success_message" class="text-center mb-2 text-danger"></div>
                    <?php
                        if (!userIsLoggedIn()) {
                            echo "<p>You need to be logged in.</p>";
                        } else {
                            echo "<form id='record_thought' class='justify-content-center'>";
                                echo "<div class='d-flex justify-content-center'>";
                                    echo "<div class='w-75 row'>";
                                        echo "<label for='thought_text' class='col-2 display-3'>I...</label>";
                                        echo "<input type='text' name='thought_text' class='col border-top-0 border-left-0 border-right-0 lead' id='thought_text' placeholder='have a thought and wanna share it' required>";
                                    echo "</div>";
                                echo "</div>";
                                echo "<div class='d-flex justify-content-center w-100'>";
                                    echo "<input type='submit' class='m-4 bg-danger text-white' value='Submit' id='submit_button'>";
                                echo "</div>";
                            echo "</form>";
                        }
                    ?>
                </div>
                <div class="p-4 m-0 mt-4 h-100 w-100 bg-light border rounded shadow">
                    <h2 class="mb-4"><?= get("username"); ?>'s thoughts (<span id="num_thoughts"></span>)</h2>
                    <div id="thought_container" class="d-flex flex-column-reverse">
                            
                    </div>
                </div>
            </div>
            <?php
                if (userIsLoggedIn()) {
                    echo "<script src='./js_scripts/functions.js'></script>";
                    echo "<script src='./js_scripts/user_thoughts.js'></script>";
                }
            ?>
        </div>
    </body>
</html>