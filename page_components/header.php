<?php

    echo "<header class='row w-100 m-0 p-0 pb-2 border-bottom bg-white'>";

        echo "<h1 class='col-md-4 text-center w-100 p-0 m-0 mt-3'><a class='' href='./log_in.php'>iProjector</a></h1>";

        echo "<ul class='col-md nav w-100 justify-content-end align-items-baseline mt-4'>";
            if (userIsLoggedIn()) {
                echo "<li class='nav-item'>";
                    echo "<div class='nav-link disabled'>USER: " . get("username") . "</div>";
                echo "</li>";
                echo "<li class='nav-item'>";
                    echo "<a href='./user_thoughts.php'";
                    echo        "class='nav-link active'";
                    echo        "style='background-image: url(./images/icon_person_small.png); background-position: center; background-repeat: no-repeat;'>";
                        echo "<span class='p-2' style='background-color: rgba(255, 255, 255, 0.9);'>Think</span>";
                    echo "</a>";
                echo "</li>";
                echo "<li class='nav-item'>";
                    echo "<a href='./all_thoughts.php'";
                    echo        "class='nav-link active'";
                    echo        "style='background-image: url(./images/icon_people_small.png); background-position: center; background-repeat: no-repeat;'>";
                        echo "<span class='p-2' style='background-color: rgba(255, 255, 255, 0.9);'>Look</span>";
                    echo "</a>";
                echo "</li>";
                echo "<li class='nav-item'>";
                    echo "<a href='./log_out.php' class='nav-link active'>Log out</a>";
                echo "</li>";
            } else {
                echo "<li class='nav-item'>";
                    echo "<div class='nav-link disabled'>Please log in</div>";
                echo "</li>";
                echo "<li class='nav-item'>";
                    echo "<a href='./create_account.php' class='nav-link active'>Create account</a>";
                echo "</li>";
                echo "<li class='nav-item'>";
                    echo "<a href='./log_in.php' class='nav-link active'>Log in</a>";
                echo "</li>";
            }
        echo "</nav>";
    
    echo "</header>";

?>