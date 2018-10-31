<?php
  // Starts session
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Custom favicon -->
    <link href="favicon.ico" rel="icon" type="image/x-icon" />
    <title>Shop</title>
    <!-- Styling for template -->
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
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
      <h1 style="margin-left: 200px; margin-bottom: 30px;">CompuTech eShop</h1>
      <h4 style="margin-left: 225px; margin-bottom: 75px;">The best hardware at the lowest prices.</h4>
        <div class="container">
        
          <?php
            // Connects to MySQL database
            include("scripts/dbConn.php");
            
            // Fetches the items to be displayed from the database
            $result = $DBConnection->query("SELECT `itemId`, `description`, `sellPrice`  FROM `tblItems`");
            
            // Loop prints out items and html for the items
            while ($row =  $result->fetch_assoc()) {
            
              echo '<div class="col-md-3 shop_box">
                    <a href="">';
            
              echo '<img src="img/'.$row['itemId'].'.jpg" class="img-responsive" alt=""/>';
              
              echo '<span class="new-box">
                      <span class="new-label">New</span>
                    </span>';
            
              echo '<div class="shop_desc">';
            
              echo '<h3><a href=""> </a></h3>';
              echo '<p>'.$row['description'].'</p>';
              
              echo '<span class="actual">R '.$row['sellPrice'].'</span><br>';
            
              echo '<ul class="buttons">
                      <li class="cart"><a href="addItemToCart.php?action=addToCart&itemId='.$row['itemId'].'">Add To Cart</a></li>
                      <li class="shop_btn"><a href=""></a></li>
                      <div class="clear"> </div>
                    </ul>';
                    
              echo '</div>';
              echo '</a> </div>';
            
            }
            
            // Closes connection
            mysqli_close($DBConnection);
            
          ?>
        </div>
      </div>
    </div>

    <?php
      // footer
      require('footer.php');
    ?>

  </body>
</html>