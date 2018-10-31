<?php
  // Starts session
  session_start();
?>

<!DOCTYPE HTML>
<html>
  <head>
    <title>Checkout</title>
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <script src="https://code.jquery.com/jquery-2.2.4.js" charset="utf-8"></script>
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
      @import url(https://fonts.googleapis.com/css?family=Roboto:300,400,500);

      * {
        box-sizing: border-box;
      }

      html,
      body {
        width: 100%;
        height: 100%;
        margin: 0;
        font-family: 'Roboto', sans-serif;
      }

      .shopping-cart {
        width: 90%;
        margin: 80px auto;
        background: #FFFFFF;
        box-shadow: 1px 2px 3px 0px rgba(0,0,0,0.10);
        border-radius: 6px;
        display: flex;
        flex-direction: column;
      }

      .title {
        height: 60px;
        border-bottom: 1px solid #E1E8EE;
        padding: 20px 30px;
        color: #5E6977;
        font-size: 18px;
        font-weight: 400;
      }

      .item {
        padding: 20px 30px;
        height: 120px;
        display: flex;
      }

      .item:nth-child(3) {
        border-top:  1px solid #E1E8EE;
        border-bottom:  1px solid #E1E8EE;
      }

      /* Buttons -  Delete and Like */
      .buttons {
        position: relative;
        padding-top: 30px;
        margin-right: 60px;
      }

      .delete-btn {
        display: inline-block;
        cursor: pointer;
        width: 18px;
        height: 17px;
        background: url("img/delete-icn.svg") no-repeat center;
        margin-right: 20px;
      }

      .like-btn {
        position: absolute;
        top: 9px;
        left: 15px;
        display: inline-block;
        background: url('twitter-heart.png');
        width: 60px;
        height: 60px;
        background-size: 2900%;
        background-repeat: no-repeat;
        cursor: pointer;
      }

      .is-active {
        animation-name: animate;
        animation-duration: .8s;
        animation-iteration-count: 1;
        animation-timing-function: steps(28);
        animation-fill-mode: forwards;
      }

      @keyframes animate {
        0%   { background-position: left;  }
        50%  { background-position: right; }
        100% { background-position: right; }
      }

      /* Product Image */

      .responsive-img {
        width: auto;
        max-height: 80px;
      }

      /* Product Description */
      .description {
        margin-right: 60px;
        width: 115px;
      }

      .description span {
        display: block;
        font-size: 14px;
        color: #43484D;
        font-weight: 400;
      }

      .description span:first-child {
        margin-bottom: 5px;
      }
      .description span:last-child {
        font-weight: 300;
        margin-top: 8px;
        color: #86939E;
      }

      /* Product Quantity */
      .quantity {
        margin-right: 60px;
      }

      .quantity input {
        -webkit-appearance: none;
        border: none;
        text-align: center;
        width: 32px;
        font-size: 16px;
        color: #43484D;
        font-weight: 300;
      }

      button[class*=btn] {
        width: 30px;
        height: 30px;
        background-color: #E1E8EE;
        border-radius: 6px;
        border: none;
        cursor: pointer;
      }
      .minus-btn img {
        margin-bottom: 3px;
      }
      .plus-btn img {
        margin-top: 2px;
      }
      button:focus,
      input:focus {
        outline:0;
      }

      /* Total Price */
      .total-price {
        width: 83px;
        padding-top: 10px;
        text-align: center;
        font-size: 16px;
        color: #43484D;
        font-weight: 300;
      }

      /* Responsive */
      @media (max-width: 800px) {
        .shopping-cart {
          width: 100%;
          height: auto;
          overflow: hidden;
        }
        .item {
          height: auto;
          flex-wrap: wrap;
          justify-content: center;
        }
        .image img {
          
        }

        .quantity,
        .description {
          width: 100%;
          text-align: center;
          margin: 6px 0;
        }
        .buttons {
          margin-right: 20px;
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
        <div class="container">
          <div class="shopping-cart">
            
            <!-- Title -->
            <div class="title">
              Shopping Cart
            </div>

              <?php
                
                //get cart items from session
                if (isset($_SESSION['cart_contents']) && !empty($_SESSION['cart_contents'])) {
                  $cartItems = $_SESSION['cart_contents'];
                
                  foreach ($cartItems as $key => $item) {
                    echo '<div class="item">
                            <div class="image">
                              <img style="width:45px; height: 45px; margin-right: 100px;" class="responsive-img" src="img/'. $item['itemId'] .'.jpg" alt="" />
                            </div>';

                    echo '<div class="description">
                            <span>'. $item['description'] .'</span>
                          </div>';

                    echo '<div class="quantity">
                            <button class="plus-btn" type="button" name="button">
                              <img src="img/plus.svg" alt="" />
                            </button>
                            <input name="name" value="' .$item['qty']. '">
                            <button class="minus-btn" type="button" name="button">
                              <img src="img/minus.svg" alt="" />
                            </button>
                          </div>';
                    
                    echo '<div class="total-price">R '. $item['sellPrice'] .'</div>';
                    echo '<div class="total-price"><a href="removeCartItem.php?itemId='.$item['itemId'].'">Remove</a></div>';

                    echo '</div>';
                  }
                } else {
                  echo '<p class="cart">You have no items in your shopping cart.<br/>
                        Click<a href="shop.php"> here</a> to continue shopping</p>';
                }
              ?>
          </div>

          <form action="emptyCart.php">
            <div class="form-submit" style="float: left;">
              <input name="empty-cart" type="submit" value="Empty Cart">
            </div>
          </form>

          <form action="checkout.php">
            <div class="form-submit" style="float: right;">
              <input name="checkout" type="submit" value="Checkout">
            </div>
          </form>
        </div>
      </div>
    </div>

    <?php
      // footer
      require('footer.php');
    ?>

    <script type="text/javascript">
      $('.minus-btn').on('click', function(e) {
    		e.preventDefault();
    		var $this = $(this);
    		var $input = $this.closest('div').find('input');
    		var value = parseInt($input.val());

    		if (value > 1) {
    			value = value - 1;
    		} else {
    			value = 0;
    		}

        $input.val(value);

    	});

    	$('.plus-btn').on('click', function(e) {
    		e.preventDefault();
    		var $this = $(this);
    		var $input = $this.closest('div').find('input');
    		var value = parseInt($input.val());

    		if (value < 100) {
      		value = value + 1;
    		} else {
    			value = 100;
    		}

    		$input.val(value);


    	});

      $('.like-btn').on('click', function() {
        $(this).toggleClass('is-active');
      });

    </script>

  </body>
</html>