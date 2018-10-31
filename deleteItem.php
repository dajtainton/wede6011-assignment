<?php
  session_start();
    
  if ($_REQUEST['action'] == 'delete' && !empty($_REQUEST['itemId'])) {
      include("scripts/dbConn.php");

      $stmt = $DBConnection->prepare("DELETE FROM `tblItems` WHERE `itemId` = ?");
  
      // Binds variables to SQL statement
      $stmt->bind_param('s', $itemId);
      
      $itemId = $_REQUEST['itemId'];
      
      // Executes query
      $stmt->execute();

       $result = $stmt->affected_rows;

      $stmt->close();

      // Closes connection
      mysqli_close($DBConnection);

      
      if($result < 1) {
        //
        echo '<script>alert("Could not delete item due to it being used in orders table.");
                      window.location = "admin.php";
              </script>';
        
      } else {
        header("Location: admin.php");
        exit;

      }
      
    }

?>