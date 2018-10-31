<?php
    $DBName = "web_task_two";

    // Opens connection to MySQL database
    $DBConnection = @mysqli_connect("localhost", "root", "");
    
    // Checks that the connection was made successfully
    if ($DBConnection === FALSE)
        echo "<p>Connection error: ". mysqli_error() . "</p>\n";
    else {
        // Creates database if it doesnt exist
        if ($DBConnection->query("use ".$DBName.";") === FALSE) {
            $DBConnection->query("CREATE DATABASE ".$DBName.";");
            $DBConnection->query("use ".$DBName.";");
        }
    }

?>