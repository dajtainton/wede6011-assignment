<?php
    // Connects to database
    include("dbConn.php");

    // Checks that connection was made successfully
    if ($DBConnection !== FALSE) {

        // Drops table if it already exists
        $SQLstring = "DROP TABLE IF EXISTS `tblOrderItems`";
        $QueryResult = $DBConnection->query($SQLstring);

        $SQLstring = "DROP TABLE IF EXISTS `tblCustomers`";
        $QueryResult = $DBConnection->query($SQLstring);

        $SQLstring = "DROP TABLE IF EXISTS `tblOrders`";
        $QueryResult = $DBConnection->query($SQLstring);


        ## Customers Table ##
        $TableName = "tblCustomers";

        // Creates table
        $SQLstring = "CREATE TABLE $TableName (
            `customerId` int not null AUTO_INCREMENT,
            `userId` int not null,
            `billingAddress` text not null,
            foreign key (`userId`) references tblUsers(`userId`),
            primary key (`customerId`)
        )";

        $QueryResult = $DBConnection->query($SQLstring);
        
        if ($QueryResult === FALSE) {
            echo "<p>Unable to create table.</p>".
            "<p>Error code ".mysqli_errno($DBConnection).
            ": ".mysqli_error($DBConnection)."</p>";
        } else {
            // Gets file path for the text file
            echo "<p>Successfully created "."$TableName.</p>";
            $filePath = str_replace('\\', '/', dirname(__FILE__))."/customers.txt";

            // Populates database
            $SQLstring = "LOAD DATA LOCAL INFILE '$filePath' 
            INTO TABLE `$TableName` FIELDS TERMINATED BY '|'LINES TERMINATED BY '\n'";
            $QueryResult = $DBConnection->query($SQLstring);
            if($QueryResult === FALSE) {
                echo "users not imported".mysqli_errno($DBConnection).
                ": ".mysqli_error($DBConnection);
            }
        }
        ## Customer Table End ##
        
        ## Orders Table ##
        $TableName = "tblOrders";

        // Drops table if it already exists
        $SQLstring = "DROP TABLE IF EXISTS `$TableName`";
        $QueryResult = $DBConnection->query($SQLstring);

        // Creates table
        $SQLstring = "CREATE TABLE $TableName (
            `orderId` int not null AUTO_INCREMENT,
            `customerId` int not null,
            `orderDate` datetime not null,
            `shippingAddress` text not null,
            foreign key (`customerId`) references tblCustomers(`customerId`),
            primary key (`orderId`)
        )";

        $QueryResult = $DBConnection->query($SQLstring);
        
        if ($QueryResult === FALSE) {
            echo "<p>Unable to create table.</p>".
            "<p>Error code ".mysqli_errno($DBConnection).
            ": ".mysqli_error($DBConnection)."</p>";
        } else {
            // Gets file path for the text file
            echo "<p>Successfully created "."$TableName.</p>";
            $filePath = str_replace('\\', '/', dirname(__FILE__))."/orders.txt";

            // Populates database
            $SQLstring = "LOAD DATA LOCAL INFILE '$filePath' 
            INTO TABLE `$TableName` FIELDS TERMINATED BY '|'LINES TERMINATED BY '\n'";
            $QueryResult = $DBConnection->query($SQLstring);
            if($QueryResult === FALSE) {
                echo "users not imported".mysqli_errno($DBConnection).
                ": ".mysqli_error($DBConnection);
            }
        }
        ## Orders Tables End ##

        ## OrderItems Table ##
        $TableName = "tblOrderItems";

        // Creates table
        $SQLstring = "CREATE TABLE $TableName (
            `orderItemId` int not null AUTO_INCREMENT,
            `orderId` int not null,
            `itemId` varchar(50) not null,
            `quantity` numeric not null,
            foreign key (`orderId`) references tblOrders(`orderId`),
            foreign key (`itemId`) references tblItems(`itemID`),
            primary key (`orderItemId`)
        )";

        $QueryResult = $DBConnection->query($SQLstring);
        
        if ($QueryResult === FALSE) {
            echo "<p>Unable to create table.</p>".
            "<p>Error code ".mysqli_errno($DBConnection).
            ": ".mysqli_error($DBConnection)."</p>";
        } else {
            // Gets file path for the text file
            echo "<p>Successfully created "."$TableName.</p>";
            $filePath = str_replace('\\', '/', dirname(__FILE__))."/orderItems.txt";

            // Populates database
            $SQLstring = "LOAD DATA LOCAL INFILE '$filePath' 
            INTO TABLE `$TableName` FIELDS TERMINATED BY '|'LINES TERMINATED BY '\n'";
            $QueryResult = $DBConnection->query($SQLstring);
            if($QueryResult === FALSE) {
                echo "users not imported".mysqli_errno($DBConnection).
                ": ".mysqli_error($DBConnection);
            }
        }
        ## OrderItems Tables End ##

        // Closes connection
        mysqli_close($DBConnection);
    }
    
?>