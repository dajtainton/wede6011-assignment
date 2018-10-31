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
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
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

  </head>
  <body>

    <?php
      // page header 
      require('header.php');
    ?>

    <div class="main">
      <div class="shop_top">
        <div class="container">

        <table class="pure-table">
          <thead>
              <tr>
                  <th>Item ID</th>
                  <th>Description</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Total</th>
              </tr>
          </thead>

          <tbody>

            <?php
              include("scripts/DBConn.php");

              ## Fetching quantity left of item ##
              $stmt = $DBConnection->prepare('select oi.itemId, i.description, i.sellprice, oi.quantity 
              from tblorderItems oi
              inner join tblOrders o on o.orderid = oi.orderid
              inner join tblcustomers c on c.customerid = o.customerid
              inner join tblusers u on u.userid = c.userid
              inner join tblitems i on i.itemid = oi.itemid
              where u.userid = ?');
                  
              // Binds variables to SQL statement
              $stmt->bind_param('s', $userId);

              $userId = $_SESSION['userId'];

              // Executes query
              $stmt->execute();

              $stmt->bind_result($itmId, $desc, $price, $quantity);
              //$stmt->fetch();
              
              $res = $stmt->get_result();

              $totalVal = 0;
              while ($row = $res->fetch_assoc()){
                  $totalVal += $row['quantity'] * $row['sellprice'];
                  echo '<tr>';
                  echo '<td>'.$row['itemId'].'</td><td>'.$row['description'].'</td><td>'.$row['quantity']
                        .'</td><td>R'.$row['sellprice'].'</td><td>R'.$row['quantity'] * $row['sellprice'].'</td>';
                  echo '</tr>';
              }

              echo '<tr><td></td><td></td><td></td><td></td><td><b>R'.$totalVal.'</b></td>';

              $stmt->close();
              mysqli_close($DBConnection);
            ?>
          </tbody>
        </table>
          
        </div>
      </div>
    </div>

  <?php
    // footer
    require('footer.php');
  ?>

  </body>
</html>