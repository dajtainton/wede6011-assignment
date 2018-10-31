<?php

class ShoppingCart {

    protected $cart_contents = array();

    
    public function __construct(){
        // get the shopping cart array from the session
        if(!isset($_SESSION['cart_contents'])) {
            $_SESSION['cart_contents'] = array();
        }
    }

    public function destroy(){
        unset($_SESSION['cart_contents']);
    }

    public function AddItem($item) {
        
        $id = $item['itemId'];

        if(isset($_SESSION['cart_contents']) && !empty($_SESSION['cart_contents'])) {
            $content = $_SESSION['cart_contents'];
            $itemAdded = false;

            foreach ($content as $key => $content_item) {
                if($content_item['itemId'] === $item['itemId']) {

                    $_SESSION['cart_contents'][$key]['qty'] += $item['qty'];
                    $itemAdded = true;
                    
                }
            }

            if(!$itemAdded) {
                $temp = array(
                    "itemId" => $item['itemId'],
                    "description" => $item['description'],
                    "qty" => $item['qty'],
                    "sellPrice" => $item['sellPrice']
                );
                array_push($_SESSION['cart_contents'], $temp);
            }

        } else {
            $temp = array(
                "itemId" => $item['itemId'],
                "description" => $item['description'],
                "qty" => $item['qty'],
                "sellPrice" => $item['sellPrice']
            );
            array_push($_SESSION['cart_contents'], $temp);
        }
    }

    public function RemoveItem($itemId) {
        if(isset($_SESSION['cart_contents']) && !empty($_SESSION['cart_contents'])) {
            $content = $_SESSION['cart_contents'];
            $itemAdded = false;

            foreach ($content as $key => $content_item) {
                if($content_item['itemId'] === $itemId) {
                    unset($_SESSION['cart_contents'][$key]);
                }
            }
        } 
    }

    public function Checkout() {
        # code...
    }

    public function EmptyCart() {
        unset($_SESSION['cart_contents']);
    }

    public function Login() {
        # code...
    }

    public function ProcessInput() {
        # code...
    }

    public function DisplayCart() {
        echo '<ul class="icon1 sub-icon1 profile_img">
                <li>
                <a class="active-icon c1" href="#"> </a>
                <ul class="sub-icon1 list">';

        if (isset($_SESSION['cart_contents']) && !empty($_SESSION['cart_contents'])) {
            $cartItems = $_SESSION['cart_contents'];
            
            foreach ($cartItems as $key => $item) {
                echo '<div class="clear"></div>
                    <li class="list_img"><img style="width: 45px;" src="img/'.$item['itemId'].'.jpg" alt=""/></li>
                    <li class="list_desc">
                        <h4><a href="">'.$item['description'].'</a></h4>
                    <span class="actual">'.$item['qty'].' x R '.$item['sellPrice'].'</span>
                    </li>';
            }
        } else {
            echo '<p class="cart">You have no items in your shopping cart.</p>';
        }

        echo '<div class="login_buttons">
                    <div class="check_button"><a href="cart.php">Cart</a></div>
                    <div class="login_button"><a href="checkout.php">Checkout</a></div>
                    <div class="clear"></div>
                </div>
                </ul>
            </li>
            </ul>
            <div class="clear"></div>';
    }

}

?>