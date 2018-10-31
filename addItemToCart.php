<?php
  session_start();

  if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {

    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['itemId'])) {
      include("aShopCart.php");
      include("scripts/dbConn.php");
      $cart = new ShoppingCart();
      $cart->__construct();
  
      // Fetches user data into database using a prepared
      // statement to prevent SQL injection attacks 
      $stmt = $DBConnection->prepare('SELECT `itemId`, `description`, `sellPrice`  FROM `tblItems` WHERE itemId = ?');
      
      // Binds variables to SQL statement
      $stmt->bind_param('s', $itemId);
  
      $itemId = $_REQUEST['itemId'];
          
      // Executes query
      $stmt->execute();
  
      $stmt->bind_result($id, $description, $sellPrice);
      $stmt->fetch();
  
      $itemData = array(
        'itemId' => $id,
        'description' => $description,
        'sellPrice' => $sellPrice,
        'qty' => 1
      );
      
      $cart->AddItem($itemData);
  
      mysqli_close($DBConnection);
    }
    header("Location: shop.php");
  }
?>