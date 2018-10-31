<?php
  session_start();
  
  if (!isset($_SESSION["userId"])) {
      // Checks whether user is logged in and
      // redirects to login page if not logged in
      header("Location: login.php");
      exit;
  }
  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
    <div class="header">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="header-left">
              <div class="logo">
                <a href="index.php"><img src="img/logo.png" alt=""/></a>
              </div>
              <div class="menu">
                <a class="toggleMenu" href="#"><img src="img/nav.png" alt="" /></a>
                <ul class="nav" id="nav">
                  <li><a href="admin.php">Admin Page</a></li>
                  <li><a href="edit-items.php?action=add">Add Item</a></li>
                  <div class="clear"></div>
                </ul>
                <script type="text/javascript" src="js/responsive-nav.js"></script>
              </div>
              <div class="clear"></div>
            </div>
            <div class="header_right">
              <!-- start search-->
              <div class="search-box">
                <div id="sb-search" class="sb-search">
                  <form>
                    <input class="sb-search-input" placeholder="Enter your search term..." type="search" name="search" id="search">
                    <input class="sb-search-submit" type="submit" value="">
                    <span class="sb-icon-search"> </span>
                  </form>
                </div>
              </div>
              <!--search-scripts-->
              <script src="js/classie.js"></script>
              <script src="js/uisearch.js"></script>
              <script>
                new UISearch( document.getElementById( 'sb-search' ) );
              </script>
              <div class="clear"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="main">
      <div class="shop_top">
        <div class="container">
          <?php
            // Connects to MySQL database
            include "scripts/dbConn.php";
            
            // Fetches the items to be displayed from the database
            $result = $DBConnection->query("SELECT `itemId`, `description`, `sellPrice`  FROM `tblItems`");
            
            // Loop prints out items and html for the items
            while ($row = $result->fetch_assoc()) {
            
                echo '<div class="col-md-3 shop_box">
                      <a href="">';
            
                echo '<img src="img/' . $row['itemId'] . '.jpg" class="img-responsive" alt=""/>';
            
                echo '<span class="new-box">
                      <span class="new-label">New</span>
                      </span>';
            
                echo '<div class="shop_desc">';
            
                echo '<h3><a href=""></a></h3>';
                echo '<p>' . $row['description'] . '</p>';
            
                echo '<span class="actual">R ' . $row['sellPrice'] . '</span><br>';
            
                echo '<ul class="buttons">
                        <li class="cart"><a href="edit-items.php?action=edit&itemId=' . $row['itemId'] . '">Edit</a></li>
                        <li class="shop_btn"><a href="deleteItem.php?action=delete&itemId=' . $row['itemId'] . '">Remove</a></li>
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