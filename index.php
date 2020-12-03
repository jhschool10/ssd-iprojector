<?php
    include("./php_scripts/tools.php");
    session_start();
?><!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <style>
            html, body {
                height: 100%;
            }
            @media screen and (min-width: 992px) { /* lg and above */
                .jh-height {
                    height: 100vh;
                }
                #image {
                    background-position: right;
                    background-size: auto 100%;
                }
            }
            @media screen and (max-width: 991px) { /* md and below */
                .jh-height {
                    height: 50vh;
                }
                #image {
                    background-size: 100% auto;
                    background-position: right center;
                }
            }
            @media screen and (max-width: 719px) { /* to fix background image */
                #image {
                    background-position: right;
                    background-size: auto 100%;
                }
            }
            #image {
                background-image: url("./images/monkey-mirror.jpg");
            }
            p:first-of-type {
                margin-left: 2em;
            }
            p:nth-of-type(2) {
                margin-left: 3em;
            }
            p:nth-of-type(3) {
                margin-left: 4em;
            }
            p:nth-of-type(4) {
                margin-left: 5em;
            }
            p:nth-of-type(5) {
                margin-left: 6em;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid jh-height" id="container">
            <div class="row">
                <div class="col-lg jh-height bg-primary" id="image">
                </div>
                <div class="col-lg jh-height row justify-content-center align-items-center p-0 m-0" id="content">
                    <div class="">
                        <h1 class="font-weight-bold">iProjector</h1>
                        <h2>a new way to look at yourself</h2>
                        <p>Record your thoughts.</p>
                        <p>See other peoples' thoughts.</p>
                        <p>Shuffle them around.</p>
                        <p>We do the hokey pokey</p>
                        <p>and that's what it's all about.</p>
                        <div class="row">
                            <a href="./log_in.php" class="col p-2 text-center rounded-pill mr-1 bg-secondary text-white">Log in</a>
                            <a href="./create_account.php" class=" col p-2 text-center rounded-pill bg-primary text-white">Create account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>