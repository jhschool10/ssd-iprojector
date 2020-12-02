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
            figure {
                width: 100%;
            }
                figure > img {
                    width: 100%;
                }
                figure > figcaption {
                    text-align: center;
                    font-size: smaller;
                }
        </style>
    </head>
    <body>
        <?php
            include("./page_components/header.php");
            include("./page_components/nav.php");
        ?>
        <main>
            <h2>Thoughts</h2>
            <section>
                <p>Record your thoughts. See other peoples' thoughts. Shuffle them around. We do the hokey pokey and that's what it's all about.</p>
            </section>
            <figure>
                <img src="./images/monkey-mirror.jpg">
                <figcaption>(This monkey is discovering a new way to look at himself.)</figcaption>
            </figure>
        </main>
        <?php
            include("./page_components/footer.php");
        ?>
    </body>
</html>