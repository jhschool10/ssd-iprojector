<?php
    include("./php_scripts/tools.php");

    session_start();
    if (userIsLoggedIn()) {
        session_destroy();
        $_SESSION = [];
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Log out? Log out!</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./libraries/bootstrap.min.css"/>
        <link rel="stylesheet" href="./libraries/animate.min.css"/>
        <style>
            @media screen and (min-width: 768px) { /* md and above */
                .jh-height {
                    height: 66vh;
                }
            }
            @media screen and (max-width: 767px) { /* sm and below */
                .jh-height {
                    height: 45vh;
                }
            }
            .jh-height-header {
                height: 10vh;
            }
        </style>
    </head>
    <body class='bg-light d-flex flex-column w-100 justify-content-center'>
        <?php
            include("./page_components/header.php");
        ?>
        <div class="w-100 d-flex justify-content-center">
            <div class="container-lg jh-height p-0 m-0">
                <div class="jh-height justify-content-center align-items-center p-4 m-0 animate__animated animate__fadeOut animate__delay-5s">
                    
                    <section class="d-flex flex-column align-items-center mt-3 p-4 w-100 bg-white rounded shadow text-center">
                        <h2 class="animate__animated animate__fadeOut animate__delay-2s">Goodbye</h2>
                        <div class="w-100 mb-2 inline animate__animated animate__fadeOut animate__delay-3s">
                            <?php
                                if (userIsLoggedIn()) {
                                    echo "Username: " . get("username") . " wants to leave.";

                                    if (!userIsLoggedIn()) {
                                        echo "You've been logged out.";
                                    } else {
                                        echo "Uh oh, error logging out. I don't know how to fix this";
                                    }
                                } else {
                                    echo " You're logged out.";
                                }
                            ?>
                        </div>
                        <div class="w-50 d-flex align-items-center">
                            <img src="./images/infinity_mirror.jpg" class="w-100 animate__animated animate__fadeOut animate__delay-4s">
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <?php
            if (userIsLoggedIn()) {
                echo "<script src='./libraries/jquery-3.5.1.min.js'></script>";
                echo "<script src='./libraries/bootstrap.bundle.min.js'></script>";
            }
        ?>
    </body>
</html>