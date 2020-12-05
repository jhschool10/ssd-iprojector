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
        <link rel="stylesheet" href="./css/bootstrap.min.css"/>
        <link rel="stylesheet" href="./css/animate.min.css"/>
        <style>
        </style>
    </head>
    <body class='bg-light'>
        <div class="container-fluid p-0 m-0">
            <?php
                include("./page_components/header.php");
            ?>
            <div class="row flex-column justify-content-center align-items-center p-4 m-0">
                <div class="p-4 m-0 mb-4 h-100 w-100 bg-white border rounded shadow">
                    <!-- Options -->
                    <?php
                        if (!userIsLoggedIn()) {
                            echo "<p>You need to be logged in.</p>";
                        } else {
                            echo "<div class='btn-group btn-group-toggle mr-2' data-toggle='buttons'>";
                                echo "<label class='btn btn-secondary active'>";
                                    echo "<input type='radio' name='options-thought-set' id='option_set_AllThoughts' autocomplete='off' checked>";
                                    echo "All thoughts";
                                echo "</label>";
                                echo "<label class='btn btn-secondary'>";
                                    echo "<input type='radio' name='options-thought-set' id='option_set_UserThoughts' autocomplete='off'>";
                                    echo "My thoughts";
                                echo "</label>";
                                echo "<label class='btn btn-secondary'>";
                                    echo "<input type='radio' name='options-thought-set' id='option_set_NotUserThoughts' autocomplete='off'>";
                                    echo "Other thoughts";
                                echo "</label>";
                            echo "</div>";
                            echo "<div class='btn-group btn-group-toggle align-bottom' data-toggle='buttons'>";
                                echo "<label class='btn btn-sm btn-secondary active'>";
                                    echo "<input type='radio' name='options-thought-order' id='option_order_ascending' autocomplete='off' checked>";
                                    echo "Ascending";
                                echo "</label>";
                                echo "<label class='btn btn-sm btn-secondary'>";
                                    echo "<input type='radio' name='options-thought-order' id='option_order_desc' autocomplete='off'>";
                                    echo "Descending";
                                echo "</label>";
                                echo "<label class='btn btn-sm btn-secondary'>";
                                    echo "<input type='radio' name='options-thought-order' id='option_order_random' autocomplete='off'>";
                                    echo "Random";
                                echo "</label>";
                            echo "</div>";
                        }
                    ?>
                </div>
                <div class="d-flex justify-content-center align-content-center p-4 mb-4 h-100 w-100 bg-white border rounded shadow">
                    <p>Click a thought for more details!</p>
                </div>
                <div class="p-4 mb-4 h-100 w-100 bg-white border rounded shadow" id="thought_container">
                </div>
            </div>
        </div>
        <?php
            if (userIsLoggedIn()) {
                echo "<script src='./js_scripts/functions.js'></script>";
                echo "<script src='./js_scripts/all_thoughts.js'></script>";
            }
        ?>
    </body>
</html>