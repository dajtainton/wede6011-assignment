<?php
  // Starts session
  session_start();

  if (!isset($_SESSION["userId"])) {
    // Checks whether user is logged in and
    // redirects to login page if not logged in
    header("Location: login.php");
    exit;
  }
?>

<!DOCTYPE HTML>
<html>
  <head>
    <title>Checkout</title>
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <script src="js/jquery.min.js"></script>
    
    <script type="text/javascript">
      $(document).ready(function() {
          $(".dropdown img.flag").addClass("flagvisibility");
      
          $(".dropdown dt a").click(function() {
              $(".dropdown dd ul").toggle();
          });
      
          $(".dropdown dd ul li a").click(function() {
              var text = $(this).html();
              $(".dropdown dt a span").html(text);
              $(".dropdown dd ul").hide();
              $("#result").html("Selected value is: " + getSelectedValue("sample"));
          });
      
          function getSelectedValue(id) {
              return $("#" + id).find("dt a span.value").html();
          }
      
          $(document).bind('click', function(e) {
              var $clicked = $(e.target);
              if (! $clicked.parents().hasClass("dropdown"))
                  $(".dropdown dd ul").hide();
          });
      
      
          $("#flagSwitcher").click(function() {
              $(".dropdown img.flag").toggleClass("flagvisibility");
          });
      });
    </script>

    <style>
      .checkout-row {
        display: -ms-flexbox; /* IE10 */
        display: flex;
        -ms-flex-wrap: wrap; /* IE10 */
        flex-wrap: wrap;
        margin: 0 16px;
      }

      .col-25 {
        -ms-flex: 25%; /* IE10 */
        flex: 25%;
      }

      .col-50 {
        -ms-flex: 50%; /* IE10 */
        flex: 50%;
      }

      .col-75 {
        -ms-flex: 75%; /* IE10 */
        flex: 75%;
      }

      .col-25,
      .col-50,
      .col-75 {
        padding: 0 16px;
      }

      .cont {
        background-color: #f2f2f2;
        padding: 5px 20px 15px 20px;
        border: 1px solid lightgrey;
        border-radius: 3px;
      }

      input[type="text"] {
        padding: 10px;
        width: 95%;
        font-size: 0.85em;
        font-family: 'Open Sans', sans-serif;
        margin: 10px 0;
        border: none;
        color: #888;
        background: #F8F8F8;
        float: left;
        outline: none;
        border: 1px solid #DFE0E2;
      }

      input[type="text"]:hover,
      .text input[type="text"],
      .text textarea:hover {
        border-color: #E25050;
      }

      input[type="submit"] {
        color: #FFF;
        font-family: 'Open Sans', sans-serif;
        font-size: 0.95em;
        font-weight: normal;
        padding: 15px 40px;
        text-transform: uppercase;
        background: #E25050;
        display: inline-block;
        -webkit-transition: all 0.3s ease-out;
        -moz-transition: all 0.3s ease-out;
        -ms-transition: all 0.3s ease-out;
        -o-transition: all 0.3s ease-out;
        transition: all 0.3s ease-out;
        font-weight: 100;
        border: none;
        cursor: pointer;
        outline: none;
      }

      input[type="submit"]:hover {
        background: #333;
      }

      label {
        margin-bottom: 10px;
        display: block;
      }

      .icon-container {
        margin-bottom: 20px;
        padding: 7px 0;
        font-size: 24px;
      }

      .btn {
        background-color: #4CAF50;
        color: white;
        padding: 12px;
        margin: 10px 0;
        border: none;
        width: 100%;
        border-radius: 3px;
        cursor: pointer;
        font-size: 17px;
      }

      .btn:hover {
        background-color: #45a049;
      }

      span.price {
        float: right;
        color: grey;
      }

      /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (and change the direction - make the "cart" column go on top) */
      @media (max-width: 800px) {
        .checkout-row {
          flex-direction: column-reverse;
        }
        .col-25 {
          margin-bottom: 20px;
        }
      }
    </style>

  </head>
  <body>

    <?php
      // page header 
      require('header.php');
    ?>

    <div class="main">
      <div class="shop_top">

      <div class="checkout-row">
          <div class="col-75" >
              <form method="post" class="form-submit">
                <div class="checkout-row">
                  <div class="col-50">
                    <h3>Billing Address</h3>
                    <input type="text" id="fname" name="firstname" placeholder="Firstname" required>
                    <input type="text" id="lname" name="lastname" placeholder="Lastname" required>
                    <input type="text" id="adr" name="address" placeholder="Address" reqired>
                    <input type="text" id="city" name="city" placeholder="City" required>
                    <input type="text" id="province" name="province" placeholder="Province" required>
                    <input type="text" id="zip" name="zip" placeholder="Zip Code" required>
                  </div>

                  <div class="col-50">
                    <h3>Payment</h3>
                    <div class="icon-container">
                      <i class="fa fa-cc-visa" style="color:navy;"></i>
                      <i class="fa fa-cc-amex" style="color:blue;"></i>
                      <i class="fa fa-cc-mastercard" style="color:red;"></i>
                      <i class="fa fa-cc-discover" style="color:orange;"></i>
                    </div>
                    <input type="text" id="cname" name="cardname" placeholder="Cardholder Name">
                    <input type="text" id="ccnum" name="cardnumber" placeholder="Card Number">
                    <input type="text" id="expmonth" name="cardexpdate" placeholder="Expiry Date">
                    <input type="text" id="cvv" name="cardcvv" placeholder="CVV">
                  </div>
                </div>
                <input type="submit" name="submit" style="margin: 30px;" value="Place Order">
              </form>
          </div>

          <div class="col-25">
            <div class="cont">
              <h4>Cart 
                <span class="price" style="color:black">
                  <i class="fa fa-shopping-cart"></i> 
                </span>
              </h4>

              <?php
                if(isset($_SESSION['cart_contents']) && !empty($_SESSION['cart_contents'])) {
                  $c_content = $_SESSION['cart_contents'];
                  $total = 0;
                  foreach ($c_content as $key => $c_item) {
                    $total += $c_item['sellPrice'] * $c_item['qty'];

                    echo '<p><a href="#">'.$c_item['description'].'</a> <span class="price">R'. $c_item['sellPrice'] * $c_item['qty'].'</span></p>';
                  }
                  echo '<hr> <p>Total <span class="price" style="color:black"><b>R'.$total.'</b></span></p>';

                } else {
                  echo '<p>Cart is empty</p>';

                }
              ?>
            </div>
          </div>
        </div>

      </div>
    </div>
    <?php
      // footer
      require('footer.php');
    ?>

  </body>
</html>

<?php

  if(isset($_POST['submit'])) {
    include("scripts/dbConn.php");

    $stmt = $DBConnection->prepare("INSERT INTO `tblCustomers` (`userId`, 
        `billingAddress`) VALUE(?, ?)");
  
    // Binds variables to SQL statement
    $stmt->bind_param('ss', $userId, $billingAddress);
    
    if (isset($_SESSION['userId']) && !empty($_SESSION['userId'])) 
      $userId = $_SESSION['userId']; 
    else 
      $userId = null;
    
    $billingAddress = mysqli_real_escape_string($DBConnection, $_POST["address"]);
    $billingAddress .= ', '.mysqli_real_escape_string($DBConnection, $_POST["city"]);
    $billingAddress .= ', '.mysqli_real_escape_string($DBConnection, $_POST["province"]);
    $billingAddress .= ', '.mysqli_real_escape_string($DBConnection, $_POST["zip"]);

    // Executes query
    $stmt->execute();
    $result = $stmt->insert_id;
    $stmt->close();

    $stmt = $DBConnection->prepare("INSERT INTO `tblOrders` (`customerId`, `orderDate`,
        `shippingAddress`) VALUE(?, ?, ?)");
  
    // Binds variables to SQL statement
    $stmt->bind_param('sss', $customerId, $orderDate, $shippingAddress);
    
    $customerId = $result;
    $orderDate = date("Y-m-d H:i:s", time());
    $shippingAddress = mysqli_real_escape_string($DBConnection, $_POST["address"]);
    $shippingAddress .= ', '.mysqli_real_escape_string($DBConnection, $_POST["city"]);
    $shippingAddress .= ', '.mysqli_real_escape_string($DBConnection, $_POST["province"]);
    $shippingAddress .= ', '.mysqli_real_escape_string($DBConnection, $_POST["zip"]);

    // Executes query
    $stmt->execute();
    $orderNum = $stmt->insert_id;
    $stmt->close();

    $cartContents = $_SESSION['cart_contents'];

    foreach ($cartContents as $key => $cartItem) {
      
      ## Inserting ordered items into table ##
      $stmt = $DBConnection->prepare("INSERT INTO `tblOrderItems` (`orderId`, `itemId`,
        `quantity`) VALUE(?, ?, ?)");
  
      // Binds variables to SQL statement
      $stmt->bind_param('sss', $ordId, $itmId, $qty);
      
      $ordId = $orderNum;
      $itmId = $cartItem['itemId'];
      $qty = $cartItem['qty'];

      // Executes query
      $stmt->execute();
      $stmt->close();

      ## Fetching quantity left of item ##
      $stmt = $DBConnection->prepare('SELECT `quantity` FROM tblItems WHERE itemId = ?');
          
      // Binds variables to SQL statement
      $stmt->bind_param('s', $itemId);

      $itemId = $cartItem['itemId'];

      // Executes query
      $stmt->execute();

      $stmt->bind_result($quantity);
      $stmt->fetch();
      
      $stmt->close();

      ## Updating quantity in items table ##
      $stmt = $DBConnection->prepare("UPDATE `tblItems` SET `quantity` = ? WHERE `itemId` = ?");
  
      // Binds variables to SQL statement
      $stmt->bind_param('ss', $qty, $itemId);
      
      $qty = $quantity - $cartItem['qty'];
      $itmId = $cartItem['itemId'];

      // Executes query
      $stmt->execute();
      $stmt->close();

    }


    // Closes connection
    mysqli_close($DBConnection);
    $sessId = session_id();

    $cart->EmptyCart();

    echo "<script type='text/javascript'>window.top.location='checkedout.php?orderNum=$orderNum&sessionId=$sessId';</script>"; 
    exit;

  }

?>