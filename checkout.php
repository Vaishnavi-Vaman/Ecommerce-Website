<?php
    session_start();

    // unset($_SESSION['cart_item']);
    
    require_once 'include/keywords.php';
    require_once 'include/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout - <?php echo $site;?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon-32x32.png"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/slick/slick.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/MagnificPopup/magnific-popup.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/sweetalert/sweetalert.min.js"></script>
<!--===============================================================================================-->
</head>
<body class="animsition">
    <?php
        if(isset($_POST['delete_cart_item'])){

            $prodId = $_POST['pid'];
            unset($_SESSION['cart_item'][$prodId]);

            echo '<script>swal("Success", "Product removed successfully !", "success");</script>';
        }

        if(isset($_POST['add_cart_item'])) {

            foreach ($_SESSION["cart_item"] as $k => $v) {
    
                if($_POST['pid'] == $k) {
        
                    if(empty($_SESSION["cart_item"][$k]["productQuantity"])) {
        
                        $_SESSION["cart_item"][$k]["productQuantity"] = 1;
                    }
                    
                    $_SESSION["cart_item"][$k]["productQuantity"] += 1;
                    
                    echo '<script>swal("Success", "Product updated successfully !", "success");</script>';
                }
            }
        }
    
        if(isset($_POST['remove_cart_item'])){
    
            foreach ($_SESSION["cart_item"] as $k => $v) {
    
                if($_POST['pid'] == $k) {
        
                    if(empty($_SESSION["cart_item"][$k]["productQuantity"])) {
        
                        $_SESSION["cart_item"][$k]["productQuantity"] = 0;
                    }
                    else if ($_SESSION["cart_item"][$k]["productQuantity"] > 1) {
                      $_SESSION["cart_item"][$k]["productQuantity"] -= 1;
                    }
    
                    echo '<script>swal("Success", "Product updated successfully !", "success");</script>';
                }
            }
        }
    ?>
	<!-- Header -->
	<header class="header-v4">
		<!-- Header desktop -->
		<div class="container-menu-desktop">
        <?php require_once 'include/top-bar.php';?>

            <div class="wrap-menu-desktop">
				<nav class="limiter-menu-desktop container">
					
                    <?php require_once 'include/desktop-logo.php';?>

					<!-- Menu desktop -->
					<div class="menu-desktop">
					<ul class="main-menu">
					<li class="active-menu">
								<a href="index.php">Home</a>
							</li>

							<li>
								<a href="shop.php">Shop</a>
							</li>

							
							<?php
							if (!empty($_SESSION['isLogin'])) {
								echo "<li>
									<a href='profile.php'>Accounts</a>
									<ul class='sub-menu'>
										<li><a href='orders.php'>Order</a></li>
										<li><a href='profile.php'>Profile</a></li>
										<li><a href='settings.php'>Settings</a></li>
										<li><a href='include/logout.php'>Logout</a></li>
									</ul>
								</li>";
							} else {
								echo "<li>
										<a href='login.php'>Login</a>
									</li>";
							}
							?>

							<li>
								<a href="about.php">About Us</a>
							</li>

							<li>
								<a href="contact.php">Contact Us</a>
							</li>
                        </ul>

					</div>
                    <?php require_once 'include/cart-search.php';?>
				</nav>
			</div>
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			
            <?php require_once 'include/mobile-logo.php';?>
			<?php require_once 'include/cart-search-mobile.php';?>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>


		

		<?php 
            require_once 'include/mobile-menu.php'; 
            require_once 'include/search-modal.php'; 
        ?>
	</header>
    
    <?php require_once 'include/cart.php';

    $total = 0;

    ?>
		

	<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="index.php" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Shoping Cart
			</span>
		</div>
	</div>
		

	<!-- Shoping Cart -->
	<section class="bg0 p-t-75 p-b-85">
		<div class="container">
            <?php
            
            if(!empty($_SESSION['cart_item'])){ ?>
			<div class="row">
				<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
					<div class="m-l-25 m-r--38 m-lr-0-xl">
						<div class="wrap-table-shopping-cart">
							<table class="table-shopping-cart">
								<tr class="table_head">
									<th class="column-1">Product</th>
									<th class="column-2"></th>
									<th class="column-3">Price</th>
									<th class="column-4">Quantity</th>
									<th class="column-5">Total</th>
									<th></th>
								</tr>

                                <?php

                                    foreach ($_SESSION['cart_item'] as $item) {
                                        
                                        $total += ($item['productPrice'] * $item['productQuantity']);
                                        $amount = ($item['productPrice'] * $item['productQuantity']);
                                        ?>
                                            <tr class="table_row"><form method="POST">
                                                <td class="column-1">
                                                    <div class="how-itemcart1">
                                                        <img src="admin/assets/images/products/<?php echo $item['productImage'];?>" alt="IMG">
                                                    </div>
                                                </td>
                                                <td class="column-2"><?php echo $item['productName']." - ".$item['productSize'];?></td>
                                                <td class="column-3">Rs <?php echo number_format($item['productPrice'], 2);?></td>
                                                <td class="column-4">
                                                    <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                        <button type="submit" class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m" name="remove_cart_item">
                                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                                        </button>

                                                        <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product1" value="<?php echo $item['productQuantity'];?>">

                                                        <button type="submit" class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" name="add_cart_item">
                                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="column-5">
                                                    <?php echo number_format($amount, 2);?>
                                                </td>
                                                <td class="p-3">
                                                    <input type="hidden" name="pid" value="<?php echo $item['productId'].$item['productSize'];?>">
                                                    <button type="submit" name="delete_cart_item" class="bg3 bor14 hov-btn3 p-lr-10 pointer text-light">X</button>
                                                </td></form>
                                            </tr>
                                        <?php
                                    }
                                ?>
							</table>
						</div>
					</div>
				</div>

				<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
					<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
						<h4 class="mtext-109 cl2 p-b-30">
							Cart Totals
						</h4>

						<div class="flex-w flex-t bor12 p-b-13">
							<div class="size-208">
								<span class="stext-110 cl2">
									Subtotal:
								</span>
							</div>

							<div class="size-209">
								<span class="mtext-110 cl2">
									Rs <?php echo number_format($total, 2);?>
								</span>
							</div>
						</div>

						<div class="flex-w flex-t p-t-27 p-b-33">
							<div class="size-208">
								<span class="mtext-101 cl2">
									Total:
								</span>
							</div>

							<div class="size-209 p-t-1">
								<span class="mtext-110 cl2">
									Rs <?php echo number_format($total, 2);?>
								</span>
							</div>
						</div>

						<a href="payment.php?source=<?php echo $total;?>" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
							Proceed to Checkout
                                </a>
					</div>
				</div>
			</div>
            <?php } else{ echo "<h5>Your shopping cart empty.</h5>";} ?>
		</div>
    </section>
		
	
		
	
<?php
    require_once 'include/footer.php';
?>

<!--===============================================================================================-->	
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/slick/slick.min.js"></script>
	<script src="js/slick-custom.js"></script>
<!--===============================================================================================-->
	<script src="vendor/parallax100/parallax100.js"></script>
	<script>
        $('.parallax100').parallax100();
	</script>
<!--===============================================================================================-->
	<script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
	<script>
		$('.gallery-lb').each(function() { // the containers for all your galleries
			$(this).magnificPopup({
		        delegate: 'a', // the selector for gallery item
		        type: 'image',
		        gallery: {
		        	enabled:true
		        },
		        mainClass: 'mfp-fade'
		    });
		});
	</script>
<!--===============================================================================================-->
	<script src="vendor/isotope/isotope.pkgd.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function(){
				ps.update();
			})
		});
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>