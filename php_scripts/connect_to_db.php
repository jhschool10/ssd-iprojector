<?php
    /*
        Author: Joseph Haley, 000820709

        This script connects to the database.

        I, Joseph Haley, student number 000820709, certify that this material is my original work.
        No other person's work has been used without due acknowledgment and I have not made my work
        available to anyone else.
    */

    try {
        $dbh = new PDO("mysql:host=localhost;dbname=josephha_iprojector",
            "josephha_iprojector_admin", "SuperSecretPassword");
    } catch (Exception $e) {
        die("Error: Couldn't connect. {$e->getMessage()}");
    }
?>
