<?php
    echo "<footer>";

    echo    "<div>";
                if (userIsLoggedIn()) {
                    $username = get("username");
                    echo "You are logged in as: " . $username;
                } else {
                    echo "Please log in.";
                }
                echo "<br>Copyright forever.";
    echo    "</div>";

    echo "</footer>";

?>