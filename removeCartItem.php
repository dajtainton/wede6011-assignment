<?php
  session_start();

  if(isset($_REQUEST['itemId']) && !empty($_REQUEST['itemId'])) {
    include("aShopCart.php");
    $cart = new ShoppingCart();
    $cart->__construct();

    $cart->RemoveItem($_REQUEST['itemId']);

  }
  header("Location: cart.php");
?>