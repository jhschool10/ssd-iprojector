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
        <link rel="stylesheet" href="./css/bootstrap.min.css"/>
        <link rel="stylesheet" href="./css/animate.min.css"/>
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
    <body class='bg-secondary'>
        <div class="container-fluid jh-height p-0 m-0">
            <?php
                include("./page_components/header.php");
            ?>
            <div class="jh-height justify-content-center align-items-center p-4 m-0">
                
                <section class="row d-flex flex-column align-items-center h-100 mt-3 p-4 w-100 bg-light rounded shadow text-center">
                    <h2 class="animate__animated animate__fadeOut animate__delay-3s">Goodbye</h2>
                    <div class="w-100 inline animate__animated animate__fadeOut animate__delay-4s">
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
                                echo " You're logged out.";
                            }
                        ?>
                    </div>
                    <div class="col w-50 h-100 d-flex align-items-center">
                        <img src="./images/infinity_mirror.jpg" class="w-100 animate__animated animate__fadeOut animate__delay-5s">
                    </div>
                </section>
            </div>
        </div>
    </body>
</html>