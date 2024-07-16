<?php

if(isset($_POST['add_to_cart'])) {
        
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $size = $_POST['size'];

    $itemArray = array(
        $product_id.$size => array(
            'productId' => $product_id, 
            'productName' => $product_name, 
            'productQuantity' => 1, 
            'productPrice' => $product_price,
            'productImage' => $product_image,
            'productSize' => $size,
        )
    );

    if (empty($_SESSION["cart_item"])) {
        
        $_SESSION["cart_item"] = $itemArray;

        echo '<script>swal("Success", "Product added to cart !", "success");</script>'; 
    } else {
        
        if (in_array($product_id.$size, array_keys($_SESSION["cart_item"]))) {
            
            foreach($_SESSION["cart_item"] as $k => $v) {

                if($product_id.$size == $k) {
                    
                    if(empty($_SESSION["cart_item"][$k]["productQuantity"])) {
                        $_SESSION["cart_item"][$k]["productQuantity"] = 0;
                    }
                    $_SESSION["cart_item"][$k]["productQuantity"] += 1;

                    echo '<script>swal("Success", "Product added to cart !", "success");</script>'; 

                }
            }
        } else {
            
            $_SESSION["cart_item"] += $itemArray;
            
            echo '<script>swal("Success", "Product added to cart !", "success");</script>'; 

        }
    }
}
