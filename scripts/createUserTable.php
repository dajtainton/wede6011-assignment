<?php
    // Connects to database
    include("dbConn.php");
    
    // Checks that connection was made successfully
    if ($DBConnection !== FALSE) {

        $TableName = "tblUsers";

        // Drops table if it already exists
        $SQLstring = "DROP TABLE IF EXISTS `tblCustomers`";
        $QueryResult = $DBConnection->query($SQLstring);

        $SQLstring = "DROP TABLE IF EXISTS `$TableName`";
        $QueryResult = $DBConnection->query($SQLstring);

        // Creates table
        $SQLstring = "CREATE TABLE `$TableName` (
            userId int not null AUTO_INCREMENT,
            firstname varchar(50) not null,
            lastname varchar(50) not null,
            email varchar(100) not null,
            passwordHash varchar(1000) not null,
            primary key (userId),
            unique (email)
        )";
        
        $QueryResult = $DBConnection->query($SQLstring);

        if ($QueryResult === FALSE) {
            echo "<p>Unable to create table.</p>".
            "<p>Error code ".mysqli_errno($DBConnection).
            ": ".mysqli_error($DBConnection)."</p>";
        } else {
            // Gets file path for the text file
            echo "<p>Successfully created "."$TableName.</p>";
            $filePath = str_replace('\\', '/', dirname(__FILE__))."/users.txt";

            // Populates database
            $SQLstring = "LOAD DATA LOCAL INFILE '$filePath' 
            INTO TABLE `$TableName` FIELDS TERMINATED BY '|'LINES TERMINATED BY '\n'";
            $QueryResult = $DBConnection->query($SQLstring);
            if($QueryResult === FALSE) {
                echo "users not imported".mysqli_errno($DBConnection).
                ": ".mysqli_error($DBConnection);
            }
        }
        
        // Closes connection
        mysqli_close($DBConnection);
    }
    
?>