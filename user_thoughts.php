<?php
    /**
     * This page allows a user to record a thought
     * Author: Joseph Haley
     */
    
    include("./php_scripts/connect_to_db.php");
    include("./php_scripts/tools.php");

    session_start();
?><!DOCTYPE html>
<html>
    <head>
        <title>My thoughts? My thoughts!</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./libraries/bootstrap.min.css"/>
        <link rel="stylesheet" href="./libraries/animate.min.css"/>
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
                #submit_button:hover {
                    box-shadow: 0.5em 0.5em 0.5em 0 black;
                    transform: translateX(0.25em) translateY(0.25em);
                }
                #submit_button:active {
                    box-shadow: 0.25em 0.25em 0.5em 0 black;
                    transform: translateX(0.5em) translateY(0.5em);
                }
            #loader {
                display: inline-block;
                animation: twirl linear infinite 4s;
            }
                @keyframes twirl {
                    0% {transform: rotate(0deg)}
                    100% {transform: rotate(360deg)}
                }
        </style>
    </head>
    <body class='bg-light d-flex flex-column w-100 justify-content-center'>
        <?php
            include("./page_components/header.php");
        ?>
        <div class="w-100 d-flex justify-content-center">
            <div class="container-lg jh-height p-0 m-0">
                <div class="justify-content-center align-items-center p-4 m-0">

                    <!-- SECTION: Record thought box -->
                    <div class="justify-content-center align-items-center p-4 m-0 h-100 w-100 bg-white border rounded shadow">
                        <div id="success_message" class="text-center mb-2 text-danger"></div>
                        <?php
                            if (!userIsLoggedIn()) {
                                echo "<p>You need to be logged in to see a user's thoughts.</p>";
                            } else {
                                echo "<form id='record_thought' class='justify-content-center'>";
                                    echo "<div class='d-flex justify-content-center'>";
                                        echo "<div class='w-100 row align-items-end'>";
                                            echo "<label for='thought_text' class='col-2 display-4 mb-0'>I...</label>";
                                            echo "<input    type='text'
                                                            id='thoughtTxt'
                                                            name='thought_text'
                                                            class='col border-top-0 border-left-0 form-control-lg border-right-0 lead mb-2'
                                                            placeholder='have a thought and wanna share it'
                                                            required>";
                                        echo "</div>";
                                    echo "</div>";
                                    echo "<div class='d-flex justify-content-center w-100'>";
                                        echo "<input type='submit' class='m-4 bg-danger text-white' value='Submit' id='submit_button'>";
                                    echo "</div>";
                                echo "</form>";
                            }
                        ?>
                    </div>

                    <!-- SECTION: List user's thoughts box -->
                    <?php
                        if (userIsLoggedIn()) {
                            echo "<div class='p-4 m-0 mt-4 h-100 w-100 bg-white border rounded shadow'>";
                                echo "<h2 class='mb-4'>" . get('username') . "'s thoughts (<span id='num_thoughts'><div id='loader'>&orarr;</div></span>)</h2>";
                                echo "<div id='thoughts_container' class='d-flex flex-column'>";
                                echo "</div>";
                            echo "</div>";
                        }
                    ?>
                </div>
                <?php
                    if (userIsLoggedIn()) {
                        echo "<script src='./libraries/jquery-3.5.1.min.js'></script>";
                        echo "<script src='./libraries/bootstrap.bundle.min.js'></script>";
                        echo "<script src='./js_scripts/functions.js'></script>";
                        echo "<script src='./js_scripts/user_thoughts.js'></script>";
                    }
                ?>
            </div>
        </div>
    </body>
</html>