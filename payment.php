<?php
    session_start();

    // unset($_SESSION['cart_item']);
    
    require_once 'include/keywords.php';
    require_once 'include/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment - <?php echo $site;?></title>
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
		$user_id = 0;
		$OrderId = time(). strtoupper(uniqid());

		if(!empty($_SESSION['user_id'])){
			$user_id = $_SESSION['user_id'];
		}

        if(isset($_POST['payment'])){

			if(mysqli_query($conn, "UPDATE user_master SET user_name = '$_POST[name]', user_phone_number = '$_POST[number]', address_line_1 = '$_POST[add1]', 
				address_line_2 = '$_POST[add2]', pin_code = '$_POST[pin]', city = '$_POST[city]' WHERE user_id = '$user_id'")){

				$insertData = "INSERT INTO order_temp (transaction_id, product_id, product_quantity, product_size) VALUES";
                $i = 0;

                foreach($_SESSION['cart_item'] as $item){

                    if($i > 0){
                        $insertData .= ", ";
                    }

                    $insertData .= "('$OrderId', '$item[productId]', '$item[productQuantity]', '$item[productSize]')";

                    $i++;
                }
				
				if(mysqli_query($conn, $insertData)){

					if(mysqli_query($conn, "INSERT INTO payment_master (card_holder_name, card_number, card_expiry_date, card_expiry_month, card_cvv, 
						date_of_payment, payment_status, card_expiry_year, transaction_id) VALUES ('$_POST[card_holder]', '$_POST[card_number]', '$_POST[card_date]', 
						'$_POST[card_month]', '$_POST[card_cvv]', NOW(), 'Success', '$_POST[card_year]', '$OrderId')")){

							if(mysqli_query($conn, "INSERT INTO order_master (user_id, transaction_id, order_status, order_date) 
								VALUES ('$user_id', '$OrderId', 'Order Placed', NOW())")){

								unset($_SESSION['cart_item']);

								echo '<script>swal("Success", "Your order placed successfully !", "success").then(function() {
									window.location = "orders.php";
								});</script>';
							} else{

								echo '<script>swal("Failed", "Unable to process !", "error");</script>';
							}

					} else{

						echo '<script>swal("Failed", "Unable to process !", "error");</script>';
					}

				} else{

					echo '<script>swal("Failed", "Unable to process !", "error");</script>';
				}

			} else{

				echo '<script>swal("Failed", "Unable to process !", "error");</script>';
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
				Payment
			</span>
		</div>
	</div>
		

	<!-- Shoping Cart -->
	<form class="bg0 p-t-75" method="post">
		<div class="container">
            <?php
            
            if(!empty($_SESSION['isLogin'])){ $user_id = $_SESSION['user_id']; $res = mysqli_query($conn, "SELECT * FROM user_master WHERE user_id = '$user_id'"); $res = mysqli_fetch_assoc($res); ?>
			<div class="row">
				<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
					<span class="stext-110 cl2">
						Personal Information:
					</span>
					<div class="row">
						<div class="col-6">
							<p class="m-t-12"><small>Name</small></p>
							<div class="bor8 bg0 m-b-12">
								<input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="name" placeholder="Your Name" required pattern="^([A-Za-z]+[ ]?|[A-Za-z])+$" title="Only alphabets and space are allowed." value="<?php echo $res['user_name'];?>">
							</div>
						</div>
						<div class="col-6">
							<p class="m-t-12"><small>Phone Number</small></p>
							<div class="bor8 bg0 m-b-22">
								<input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" placeholder="Phone Number" name="number" required pattern="[0-9]{10}" title="Accept 10 digit numbers only." value="<?php echo $res['user_phone_number'];?>">
							</div>
						</div>
					</div>
					<span class="p-t-15 stext-110 cl2">
					Delivery Information:
					</span>
					<div class="row">
						<div class="col-6">
							<p class="m-t-12"><small>Address Line 1</small></p>
							<div class="bor8 bg0 m-b-12">
								<input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" placeholder="Address Line 1" name="add1" required value="<?php echo $res['address_line_1'];?>">
							</div>
						</div>
						<div class="col-6">
							<p class="m-t-12"><small>Address Line 2</small></p>
							<div class="bor8 bg0 m-b-12">
								<input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" placeholder="Address Line 2" name="add2" required value="<?php echo $res['address_line_2'];?>">
							</div>
						</div>
						<div class="col-6">
							<p><small>City</small></p>
							<div class="bor8 bg0 m-b-12">
								<input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" placeholder="Your City" name="city" required value="<?php echo $res['city'];?>">
							</div>
						</div>
						<div class="col-6">
							<p><small>PIN Code</small></p>
							<div class="bor8 bg0 m-b-22">
								<input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" placeholder="PIN Code" name="pin" required pattern="[0-9]{6}" title="Accept 10 digit numbers only." value="<?php echo $res['pin_code'];?>">
							</div>
						</div>
					</div>
					<span class="p-t-15 stext-110 cl2">
					Payment Information:
					</span>
					<div class="row">
						<div class="col-6">
							<p class="m-t-12"><small>Card holder Name</small></p>
							<div class="bor8 bg0 m-b-12">
								<input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" placeholder="Card holder Name" name="card_holder" required pattern="^([A-Za-z]+[ ]?|[A-Za-z])+$" title="Only alphabets and space are allowed.">
							</div>
						</div>
						<div class="col-6">
							<p class="m-t-12"><small>Card Number</small></p>
							<div class="bor8 bg0 m-b-12">
								<input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" placeholder="Card Number" name="card_number" required pattern="[0-9]{16}" title="Accept 16 digit numbers only.">
							</div>
						</div>
						<div class="col-3">
							<p><small>Exp Date</small></p>
							<div class="bor8 bg0 m-b-12">
								<select class="stext-111 cl8 plh3 size-111 p-lr-15" name="card_date" required>
									<option value="">Choose</option>
									<option value="01">01</option>
									<option value="02">02</option>
									<option value="03">03</option>
									<option value="04">04</option>
									<option value="05">05</option>
									<option value="06">06</option>
									<option value="07">07</option>
									<option value="08">08</option>
									<option value="09">09</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
									<option value="15">15</option>
									<option value="16">16</option>
									<option value="17">17</option>
									<option value="18">18</option>
									<option value="19">19</option>
									<option value="20">20</option>
									<option value="21">21</option>
									<option value="22">22</option>
									<option value="23">23</option>
									<option value="24">24</option>
									<option value="25">25</option>
									<option value="26">26</option>
									<option value="27">27</option>
									<option value="28">28</option>
									<option value="29">29</option>
									<option value="30">30</option>
									<option value="31">31</option>
								</select>
							</div>
						</div>
						<div class="col-3">
							<p><small>Exp Month</small></p>
							<div class="bor8 bg0 m-b-12">
								<select class="stext-111 cl8 plh3 size-111 p-lr-15" name="card_month" required>
									<option value="">Choose</option>
									<option value="January">January</option>
									<option value="February">February</option>
									<option value="March">March</option>
									<option value="April">April</option>
									<option value="May">May</option>
									<option value="June">June</option>
									<option value="July">July</option>
									<option value="August">August</option>
									<option value="September">September</option>
									<option value="October">October</option>
									<option value="November">November</option>
									<option value="December">December</option>
								</select>
							</div>
						</div>
						<div class="col-3">
							<p><small>Exp Year</small></p>
							<div class="bor8 bg0 m-b-12">
								<select class="stext-111 cl8 plh3 size-111 p-lr-15" name="card_year" required>
									<option value="">Choose</option>
									<option value="2023">2023</option>
									<option value="2024">2024</option>
									<option value="2025">2025</option>
									<option value="2026">2026</option>
									<option value="2027">2027</option>
									<option value="2028">2028</option>
									<option value="2029">2029</option>
									<option value="2030">2030</option>
								</select>
							</div>
						</div>
						<div class="col-3">
							<p><small>CVV</small></p>
							<div class="bor8 bg0 m-b-12">
								<input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" placeholder="CVV Number" name="card_cvv" required pattern="[0-9]{3}" title="Accept 3 digit numbers only.">
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
					<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
						<h4 class="mtext-109 cl2 p-b-30">
							Payment Gateway
						</h4>

						<div class="flex-w flex-t p-t-27 p-b-33">
							<div class="size-208">
								<span class="mtext-101 cl2">
									Total:
								</span>
							</div>

							<div class="size-209 p-t-1">
								<span class="mtext-110 cl2">
									Rs <?php 
									if(empty($_GET['source'])){
										echo '<script>swal("Oops", "Unable to process your request !", "error").then(function() {
											window.location = "index.php";
										});</script>';
									} else{
										echo number_format($_GET['source'], 2);
									}
									
									?>
								</span>
							</div>
						</div>

						<button type="submit" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer" name="payment">
							Proceed to PAY
						</button>
					</div>
				</div>
			</div>
            <?php } else{ echo '<script>swal("Oops", "Kindly login to proceed !", "error").then(function() {
					window.location = "login.php?source=payment";
				});</script>';} ?>
		</div>
	</form>
		
	
		
	
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