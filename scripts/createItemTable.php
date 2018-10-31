<?php
    // Connects to database
    include("dbConn.php");

    // Checks that connection was made successfully
    if ($DBConnection !== FALSE) {

        $TableName = "tblItems";
        // Drops table if it already exists

        $SQLstring = "DROP TABLE IF EXISTS `tblOrderItems`;";
        $QueryResult = $DBConnection->query($SQLstring);

        $SQLstring = "DROP TABLE IF EXISTS `tblOrders`;";
        $QueryResult = $DBConnection->query($SQLstring);

        $SQLstring = "DROP TABLE IF EXISTS `$TableName`;";
        $QueryResult = $DBConnection->query($SQLstring);

        // Creates table
        $SQLstring = "CREATE TABLE `$TableName` (
            `itemId` varchar(50) not null,
            `description` varchar(2000) not null,
            `costPrice` numeric(15,2) not null,
            `quantity` numeric not null,
            `sellPrice` numeric(15,2) not null,
            primary key (`itemId`)
        )";
        $QueryResult = $DBConnection->query($SQLstring);
        
        if ($QueryResult === FALSE) {
            echo "<p>Unable to create table.</p>".
            "<p>Error code ".mysqli_errno($DBConnection).
            ": ".mysqli_error($DBConnection)."</p>";
        } else {
            // Gets file path for the text file
            echo "<p>Successfully created "."$TableName.</p>";
            $filePath = str_replace('\\', '/', dirname(__FILE__))."/items.txt";

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