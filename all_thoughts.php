<?php
    include("./php_scripts/connect_to_db.php");
    include("./php_scripts/tools.php");

    session_start();
?><!DOCTYPE html>
<html>
    <head>
        <title>Your thoughts? Your thoughts!</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./libraries/bootstrap.min.css"/>
        <link rel="stylesheet" href="./libraries/animate.min.css"/>
        <style>
            .thought-container:hover {
                background-color: rgba(0, 123, 255, 0.05);
            }
        </style>
    </head>
    <body class='bg-light'>
        <div class="container-fluid p-0 m-0">
            <?php
                include("./page_components/header.php");
            ?>
            <div class="row flex-column justify-content-center align-items-center p-4 m-0">
                <div class="pt-3 pr-4 pb-4 pl-4 m-0 mb-4 h-100 w-100 bg-white border rounded shadow">
                    <!-- Options -->
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <?php
                            if (!userIsLoggedIn()) {
                                echo "<p>You need to be logged in.</p>";
                            } else {
                                echo "<div class='btn-group btn-group-toggle mr-2 mt-2' data-toggle='buttons'>";
                                    echo "<label class='btn btn-secondary btn-sm active'>";
                                        echo "<input type='radio' name='options-thought-set' id='option_set_AllThoughts' autocomplete='off' checked>";
                                        echo "All thoughts";
                                    echo "</label>";
                                    echo "<label class='btn btn-secondary btn-sm'>";
                                        echo "<input type='radio' name='options-thought-set' id='option_set_UserThoughts' autocomplete='off'>";
                                        echo "My thoughts";
                                    echo "</label>";
                                    echo "<label class='btn btn-secondary btn-sm'>";
                                        echo "<input type='radio' name='options-thought-set' id='option_set_NotUserThoughts' autocomplete='off'>";
                                        echo "Not my thoughts";
                                    echo "</label>";
                                echo "</div>";
                                echo "<div class='btn-group btn-group-toggle align-bottom align-items-start d-flex flex-wrap mt-2' data-toggle='buttons'>";
                                    echo "<label class='btn btn-sm btn-outline-secondary active flex-grow-0'>";
                                        echo "<input type='radio' name='options-thought-order' id='option_order_date_asc' autocomplete='off' checked>";
                                        echo "&uarr; Date";
                                    echo "</label>";
                                    echo "<label class='btn btn-sm btn-outline-secondary flex-grow-0'>";
                                        echo "<input type='radio' name='options-thought-order' id='option_order_date_desc' autocomplete='off'>";
                                        echo "&darr; Date";
                                    echo "</label>";
                                    echo "<label class='btn btn-sm btn-outline-secondary flex-grow-0'>";
                                        echo "<input type='radio' name='options-thought-order' id='option_order_huzzahs_asc' autocomplete='off'>";
                                        echo "&uarr; Huzzahs";
                                    echo "</label>";
                                    echo "<label class='btn btn-sm btn-outline-secondary flex-grow-0'>";
                                        echo "<input type='radio' name='options-thought-order' id='option_order_huzzahs_desc' autocomplete='off'>";
                                        echo "&darr; Huzzahs";
                                    echo "</label>";
                                    echo "<label class='btn btn-sm btn-outline-secondary flex-grow-0'>";
                                        echo "<input type='radio' name='options-thought-order' id='option_order_username_asc' autocomplete='off'>";
                                        echo "&uarr; Username";
                                    echo "</label>";
                                    echo "<label class='btn btn-sm btn-outline-secondary flex-grow-0'>";
                                        echo "<input type='radio' name='options-thought-order' id='option_order_username_desc' autocomplete='off'>";
                                        echo "&darr; Username";
                                    echo "</label>";
                                    echo "<label class='btn btn-sm btn-outline-secondary flex-grow-0'>";
                                        echo "<input type='radio' name='options-thought-order' id='option_order_random' autocomplete='off'>";
                                        echo "&#9736; Random";
                                    echo "</label>";
                                echo "</div>";
                                echo "<div class='mt-2'>";
                                    echo "<button type='button' class='btn btn-primary btn-lg' id='refresh_thought_list'><img src='./images/refresh.png' style='width: 30px; height: 30px;'></button>";
                                echo "</div>";
                            }
                        ?>
                    </div>
                </div>
                <div class="p-4 mb-4 h-100 w-100 bg-white border rounded shadow">
                    <h2 class="mb-4">Thoughts (<span id="num_thoughts"></span>)</h2>
                    <div id="thoughts_container"></div>
                </div>
            </div>
        </div>
        <?php
            if (userIsLoggedIn()) {
                echo "<script>const this_user_id = " . get("user_id") . ";</script>";
                echo "<script src='./libraries/jquery-3.5.1.min.js'></script>";
                echo "<script src='./libraries/bootstrap.bundle.min.js'></script>";
                echo "<script src='./js_scripts/functions.js'></script>";
                echo "<script src='./js_scripts/all_thoughts.js'></script>";
            }
        ?>
    </body>
</html>