<div class="header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="header-left">
          <div class="logo">
            <a href="index.php"><img src="img/logo.png" alt=""/></a>
          </div>
          <div class="menu">
            <a class="toggleMenu" href=""><img src="img/nav.png" alt="" /></a>
            <ul class="nav" id="nav">
              <li><a href="index.php">Home</a></li>
              <li><a href="shop.php">Shop</a></li>
              <li><a href="cart.php">Cart</a></li>
              <li><a href="purchase-history.php">Purchase History</a></li>
              <li><a href="admin.php">Admin Page</a></li>
              <?php
                if(isset($_SESSION['userId'])) {
                  echo '<li><a href="logout.php">Logout</a></li>';
                } else {
                  echo '<li><a href="login.php">Login</a></li>';
                }
              ?>
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

          <?php
            include "aShopCart.php";
            $cart = new ShoppingCart;
            $cart->DisplayCart();
          ?>
          
        </div>
      </div>
    </div>
  </div>
</div>