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
          <div class="row">
            <div class="col-md-12 contact">
              <form method="post" enctype="multipart/form-data" >
                <div class="to">
                  <div class="form-submit">
                    <img id="item-img" style="margin-bottom: 20px;" src="img/placeholder.png" alt="your image" />
                    <input type='file' name="fileToUpload" style="margin: 20px;" id="fileToUpload" onchange="readURL(this);" >
                    <input type="text" class="text" name="itemId" style="margin: 20px;" placeholder="Item ID" id="item-id" value="<?php if(isset($_SESSION['itemId'])) echo $_SESSION['itemId']; ?>" requred>
                    <input type="text" class="text" name="description" style="margin: 20px;" placeholder="Description" id="description" value="<?php if(isset($_SESSION['description'])) echo $_SESSION['description']; ?>" required>
                    <input type="text" class="text" name="costPrice" style="margin: 20px;" placeholder="Cost Price" id="cost-price" value="<?php if(isset($_SESSION['costPrice'])) echo $_SESSION['costPrice']; ?>" required>
                    <input type="text" class="text" name="quantity" style="margin: 20px;" placeholder="Quantity" id="qty" value="<?php if(isset($_SESSION['quantity'])) echo $_SESSION['quantity']; ?>" required>
                    <input type="text" class="text" name="sellPrice" style="margin: 20px;" placeholder="Sell Price" id="sell-price" value="<?php if(isset($_SESSION['sellPrice'])) echo $_SESSION['sellPrice']; ?>" required>
                    <input name="submit" type="submit" id="submit" style="margin: 20px;" value="Submit"><br>
                  </div>
                </div>
                <div class="clear"></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php
      // footer
      require('footer.php');
    ?>
    
    <script>
      function readURL(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
      
              reader.onload = function (e) {
                  $('#item-img')
                      .attr('src', e.target.result)
                      .width(300)
                      .height(300);
              };
      
              reader.readAsDataURL(input.files[0]);
          }
      }
    </script>
  </body>
</html>
<?php
  global $actionFlag;

  if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
  
      if ($_REQUEST['action'] == 'add') {
          echo '<script> document.getElementById("item-id").readOnly = false; </script>';
          $actionFlag = 'add';
      }
  
      if ($_REQUEST['action'] == 'edit' && !empty($_REQUEST['itemId'])) {
        $actionFlag = 'edit';
  
        echo '<script> document.getElementById("item-id").value = "'.$_REQUEST['itemId'].'"; </script>';
        echo '<script> document.getElementById("item-id").readOnly = true; </script>';

        try {

          // Connects to database
          include("scripts/dbConn.php");
          
          // Fetches user data into database using a prepared
          // statement to prevent SQL injection attacks 
          $stmt = $DBConnection->prepare('SELECT `description`, `costPrice`, `quantity`, `sellPrice` FROM tblItems WHERE itemId = ?');
          
          // Binds variables to SQL statement
          $stmt->bind_param('s', $itemId);

          $itemId = $_REQUEST['itemId'];

          // Executes query
          $stmt->execute();

          $stmt->bind_result($description, $costPrice, $quantity, $sellPrice);
          $stmt->fetch();

          echo '<script> document.getElementById("description").value = "'.$description.'"; </script>';
          echo '<script> document.getElementById("cost-price").value = "'.$costPrice.'"; </script>';
          echo '<script> document.getElementById("qty").value = "'.$quantity.'"; </script>';
          echo '<script> document.getElementById("sell-price").value = "'.$sellPrice.'"; </script>';
          
          $stmt->close();
          // Closes connection
          mysqli_close($DBConnection);

        } catch (Exception $e) {
          echo 'An error occurred, please try again.';
          // echo 'Caught exception: '.  $e->getMessage();
        }

      }
  
  }

  // Check if image file is a actual image or fake image
  if (isset($_POST["submit"])) {
    
    if($actionFlag == 'add') {
      include("scripts/dbConn.php");

      $stmt = $DBConnection->prepare("INSERT INTO `tblItems` (`itemId`, 
          `description`, `costPrice`, `quantity`, `sellPrice`) VALUE(?, ?, ?, ?, ?)");
    
      // Binds variables to SQL statement
      $stmt->bind_param('sssss', $itemId, $description, $costPrice, $quantity, $sellPrice);
      
      $itemId = mysqli_real_escape_string($DBConnection, $_POST["itemId"]);
      $description = mysqli_real_escape_string($DBConnection, $_POST["description"]);
      $costPrice = mysqli_real_escape_string($DBConnection, $_POST["costPrice"]);
      $quantity = mysqli_real_escape_string($DBConnection, $_POST["quantity"]);
      $sellPrice = mysqli_real_escape_string($DBConnection, $_POST["sellPrice"]);

      // Executes query
      $stmt->execute();
      $stmt->close();

      // Closes connection
      mysqli_close($DBConnection);
    
      $target_dir = "img/";
      $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if ($check !== false) {
          echo "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
      } else {
          echo "File is not an image.";
          $uploadOk = 0;
      }

      // Check file size
      if ($_FILES["fileToUpload"]["size"] > 5000000) {
          echo "Sorry, your file is too large.";
          $uploadOk = 0;
      }

      // Allow certain file formats
      if ($imageFileType != "jpg") {
          echo "Sorry, only JPG files are allowed.";
          $uploadOk = 0;
      }

      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
          echo "Sorry, your file was not uploaded.";
          // if everything is ok, try to upload file
      } else {
          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $_POST['itemId'].'.jpg')) {
              echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
          } else {
              echo "Sorry, there was an error uploading your file.";
          }
      }

      echo "<script type='text/javascript'>window.top.location='admin.php';</script>";
      exit;

    } else if ($actionFlag == 'edit') {
      
      include("scripts/dbConn.php");

      $stmt = $DBConnection->prepare("UPDATE `tblItems` SET `description` = ?, 
              `costPrice` = ?, `quantity` = ?, `sellPrice` = ?
              WHERE `itemId` = ?");
    
      // Binds variables to SQL statement
      $stmt->bind_param('sssss', $description, $costPrice, $quantity, $sellPrice, $itemId);
      
      $itemId = mysqli_real_escape_string($DBConnection, $_POST["itemId"]);
      $description = mysqli_real_escape_string($DBConnection, $_POST["description"]);
      $costPrice = mysqli_real_escape_string($DBConnection, $_POST["costPrice"]);
      $quantity = mysqli_real_escape_string($DBConnection, $_POST["quantity"]);
      $sellPrice = mysqli_real_escape_string($DBConnection, $_POST["sellPrice"]);

      // Executes query
      $stmt->execute();
      $stmt->close();

      // Closes connection
      mysqli_close($DBConnection);
    
      $target_dir = "img/";
      $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if ($check !== false) {
          echo "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
      } else {
          echo "File is not an image.";
          $uploadOk = 0;
      }

      // Check file size
      if ($_FILES["fileToUpload"]["size"] > 5000000) {
          echo "Sorry, your file is too large.";
          $uploadOk = 0;
      }

      // Allow certain file formats
      if ($imageFileType != "jpg") {
          echo "Sorry, only JPG files are allowed.";
          $uploadOk = 0;
      }

      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
          echo "Sorry, your file was not uploaded.";
          // if everything is ok, try to upload file
      } else {
          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $_POST['itemId'].'.jpg')) {
              echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
          } else {
              echo "Sorry, there was an error uploading your file.";
          }
      }

      echo "<script type='text/javascript'>window.top.location='admin.php';</script>";
      exit;
    }
    
  }

?>