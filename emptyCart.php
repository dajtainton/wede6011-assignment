<?php
  session_start();
    
  include("aShopCart.php");
  $cart = new ShoppingCart();
  $cart->EmptyCart();
  header("Location: cart.php");

?>
