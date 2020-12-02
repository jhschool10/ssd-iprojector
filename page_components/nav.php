<?php

    echo "<nav>";

    if (userIsLoggedIn()) {
        echo    "<a href='./user_thoughts.php' class='button'>List thoughts</a>";
        echo    "<a href='./record_thought.php' class='button'>Record thoughts</a>";
        echo    "<a href='./log_out.php' class='button'>Log out</a>";
    } else {
        echo    "<a href='./create_account.php' class='button'>Create account</a>";
        echo    "<a href='./log_in.php' class='button'>Log in</a>";
    }

    echo "</nav>";

?>