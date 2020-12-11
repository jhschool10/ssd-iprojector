<?php
    include("./php_scripts/tools.php");
    session_start();
?><!DOCTYPE html>
<html>
    <head>
        <title>My thoughts? Your thoughts? iProjector!</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./libraries/bootstrap.min.css"/>
        <link rel="stylesheet" href="./libraries/animate.min.css"/>
        <style>
            html, body {
                height: 100%;
            }
            @media screen and (min-width: 992px) { /* lg and above */
                .jh-height {
                    height: 100vh;
                }
                #content_image {
                    background-position: right;
                    background-size: auto 100%;
                }
            }
            @media screen and (max-width: 991px) { /* md and below */
                .jh-height {
                    height: 50vh;
                }
                #content {
                    flex-direction: column-reverse;
                }
                #content_image {
                    background-size: 100% auto;
                    background-position: right center;
                }
            }
            @media screen and (max-width: 719px) { /* sm and below */
                #content_text {
                    height: 65vh;
                    padding: 1em;
                }
                #content_image {
                    background-position: center top;
                    background-size: cover;
                    height: 35vh;
                }
            }
            #content_image {
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
        <div class="container-fluid jh-height animate__animated animate__fadeIn animate__delay-1s w-100" id="container">
            <div class="row" id="content">
                <div class="col-lg jh-height bg-primary p-0 m-0" id="content_image">
                </div>
                <div class="col-lg jh-height row justify-content-center align-items-center p-md-0 m-0" id="content_text">
                    <div class="">
                        <h1 class="font-weight-bold ">iProjector</h1>
                        <h2>a new way to look at yourself</h2>
                        <p>Record your thoughts.</p>
                        <p>Project them onto others.</p>
                        <p>Return the favour.</p>
                        <p>We do the hokey pokey</p>
                        <p>and that's what it's all about.</p>
                        <div class="row">
                            <a href="./log_in.php" class="col p-2 text-center rounded-pill mr-1 bg-secondary text-white">Log in</a>
                            <a href="./create_account.php" class="col p-2 text-center rounded-pill bg-primary text-white">Create account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>