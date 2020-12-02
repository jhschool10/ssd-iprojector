<?php
    include("./php_scripts/tools.php");
    session_start();
?><!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/main.css">
        <style>
            body {
                display: auto;
            }
            main {
                padding: 0;

                border-radius: 1em;

                display: grid;
                grid-template-columns: 1fr 1fr;
                align-items: center;
            }
                section.figure {
                    position: relative;
                    width: 100%;
                    margin-bottom: 0;
                }
                        section.figure:hover {
                            animation: anim-filter infinite alternate 3s;
                        }
                            @keyframes anim-filter {
                                0% {
                                    filter: hue-rotate(0deg);
                                }
                                100% {
                                    filter: hue-rotate(360deg)
                                }
                            }
                        section.figure:hover > aside {
                            animation: anim-font-size 6s forwards;
                        }
                        section.figure:hover > img {
                            opacity: 1;
                        }
                    section.figure > img {
                            width: 100%;
                            margin-bottom: 0;

                            opacity: 0.3;
                            transition: opacity 1s;

                            border-top-left-radius: 1em;
                            border-bottom-left-radius: 1em;

                            display: block;
                        }
                        section.figure > aside {
                            position: absolute;
                            top: 25px;
                            left: 0.5em;

                            white-space: nowrap;
                            overflow: hidden;

                            color: white;
                            font-size: 12pt;
                            /* transition: 6s font-size; */
                        }
                            @keyframes anim-font-size {
                                0% {
                                    font-size: 12pt;
                                }
                                100% {
                                    font-size: 50pt;
                                }
                            }
                section.content {
                    width: 100%;
                    padding: 1em;

                    font-size: medium;
                }
                    section.content > p {
                        margin-left: 3.5em;
                        margin-bottom: 0.5em;
                    }
                    section.content > p:nth-of-type(1) {
                            opacity: 0.2;
                        }
                        section.content > p:nth-of-type(3) {
                            text-align: right;
                            transform: rotate(180deg);
                        }
                        section.content > p:last-of-type {
                            padding-left: 1em;
                        }
                    a.button {
                        display: block;
                        margin-bottom: 0.5em;

                        border-radius: 1em;
                    }
        </style>
    </head>
    <body>
        <div class="container">
            <main>
                <section class="figure">
                    <img src="./images/monkey-mirror.jpg">
                    <aside>iProjector - a new way to look at yourself!</aside>
                </section>
                <section class="content">
                    <p>Record your thoughts.</p>
                    <p>See other peoples' thoughts.</p>
                    <p>Shuffle them around.</p>
                    <p>We do the hokey pokey</p>
                    <p>and that's what it's all about.</p>
                    <a href="./log_in.php" class="button">Log in</a>
                    <a href="./create_account.php" class="button">Create account</a>
                </section>
            </main>
        </div>
    </body>
</html>