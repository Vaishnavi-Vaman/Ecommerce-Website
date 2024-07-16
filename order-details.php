<?php
    session_start();

    // unset($_SESSION['cart_item']);
    
    require_once 'include/keywords.php';
    require_once 'include/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Orders - <?php echo $site;?></title>
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
    
    <?php 
	require_once 'include/cart.php';

	if (isset($_POST['cancel'])) {
		$transaction_id = $_GET['source'];

		if (mysqli_query($conn, "UPDATE order_master SET order_status = 'Order Cancelled' WHERE transaction_id = '$transaction_id'")) {
	
			echo "<script>iqwerty.toast.toast('Order cancelled successfully.');</script>";
		} else {
	
			echo "<script>iqwerty.toast.toast('Unable to process your request.');</script>";
		}
	}
	

    ?>
		

	<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="index.php" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Orders
			</span>
		</div>
	</div>
		

	<!-- Shoping Cart -->
	<section class="bg0 p-t-50" method="post">
		<div class="container card p-5">
			<h3 class="ltext-103 cl5 text-center">Invoice</h3>
            <?php

            if(!empty($_SESSION['isLogin'])){ 

                if(!empty($_GET['source'])){

					$total = 0;

                    $transaction_id = $_GET['source'];

                    $resOrder = mysqli_query($conn, "SELECT * from order_master WHERE transaction_id = '$transaction_id'");
                    if(mysqli_num_rows($resOrder)>0){

                        $resOrder = mysqli_fetch_assoc($resOrder);
                        
                            ?>
							<div class="row mt-5">
								<div class="col-6">
									<span>Order No. #<?php echo $resOrder['transaction_id'];?></span>
								</div>
								<div class="col-6 text-right">
									<span><?php echo date_format(date_create($resOrder['order_date']), 'd M Y h:i A');?></span>
								</div>
							</div>
							
							<div class="row mt-5">
								<div class="col-6">
									<?php $resCustomer = mysqli_query($conn, "SELECT * FROM user_master WHERE user_id = '$_SESSION[user_id]'"); if(mysqli_num_rows($resCustomer)>0){ $resCustomer = mysqli_fetch_assoc($resCustomer);?>
									<span><?php echo $resCustomer['user_name'];?></span><br> <span>+91 <?php echo $resCustomer['user_phone_number'];?><br></span><span><?php echo $resCustomer['address_line_1'];?>, <br><?php echo $resCustomer['address_line_2'];?>, <br><?php echo $resCustomer['city'];?><br>PIN: <?php echo $resCustomer['pin_code'];?></span>
									<?php }?>
								</div>
								<div class="col-6 text-right">
									<span class="h5"><?php echo $site;?></span><br> <span id="details">Address1</span><br>Address2<br>PIN: 2222222
								</div>
							</div>

							<div class="row mt-5 table-responsive">
								<table class="table table-hover">
									<tr class="table-dark">
										<th>SL.NO</th>
										<th>Product</th>
										<th>Price</th>
										<th>Quantity</th>
										<th>Total</th>
									</tr>

									<?php
										$resProduct = mysqli_query($conn, "SELECT pm.*, tm.* FROM product_master pm, order_temp tm WHERE pm.product_id = tm.product_id AND tm.transaction_id = '$resOrder[transaction_id]'");
										if(mysqli_num_rows($resProduct)>0){
											
											echo "<div class='pricing'>";
											$finalPrice = 0;
											$count = 1;
											
											while($rowProduct = mysqli_fetch_assoc($resProduct)){

												$amount = $rowProduct['product_price'] * $rowProduct['product_quantity'];
												$total+=$amount;

												echo "<tr>";
												echo "<td>$count</td>";
												echo "<td>$rowProduct[product_name] - $rowProduct[product_size]</td>";
												echo "<td>".number_format($rowProduct['product_price'], 2)."</td>";
												echo "<td>$rowProduct[product_quantity]</td>";
												echo "<td>".number_format($amount, 2)."</td>";
												echo "</tr>";
												$count++;
											}
										}
									?>									
								</table>
							</div>

							<div class="row p-4">
								<div class="col-12 text-right">
										<h5>Grand Total: <?php echo number_format($total, 2);?></h5>
								</div>
							</div>
							<form method="POST" class="row p-4 <?php if($resOrder['order_status'] == 'Order Cancelled' || $resOrder['order_status'] == 'Order Delivered') { echo "d-none";} ?>">
								<div class="col-12 text-left">
									<button class="btn btn-danger" type="submit" name="cancel" onclick="return confirm('Are you sure you want to cancel?')">Cancel order</button>
								</div>
							</form>
							<?php
							if($resOrder['order_status'] == 'Order Cancelled'){
								echo "<div class='row p-4'><h3 style='color:red;'>Your Order has been cancelled</h3></div>";
							}
							?>

                            <?php 
                            
                    }else{

                        echo '<script>swal("Oops", "Unable to process !", "error").then(function() {
                            window.location = "orders.php";
                        });</script>';
                    }
                } else{
                    echo '<script>swal("Oops", "Unable to process !", "error").then(function() {
                        window.location = "orders.php";
                    });</script>';
                }
            } else{ 

                echo '<script>swal("Oops", "Kindly login to proceed !", "error").then(function() {
					window.location = "login.php?source=orders";
				});</script>';
            } ?>
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