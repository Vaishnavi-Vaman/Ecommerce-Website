<?php
    session_start();
    
    require_once 'include/keywords.php';
    require_once 'include/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Settings - <?php echo $site;?></title>
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
								<a href="contact.php">Contact </a>
							</li>
							<li>
								<a href="include/logout.php">Logout</a>
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
    
    <?php require_once 'include/cart.php';?>

	<!-- Title page -->
	<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
		<h2 class="ltext-105 cl0 txt-center" style="backdrop-filter: blur(5px);">
			Profile
		</h2>
	</section>	

    <?php
                 
				 
		$user_id = 0;

		if(!empty($_SESSION['user_id'])){
			$user_id = $_SESSION['user_id'];
		}

        if(isset($_POST['update'])){

            $name = $_POST['name'];
            $num = $_POST['number'];
            $add1 = $_POST['add1'];
            $add2 = $_POST['add2'];
            $city = $_POST['city'];
            $pin = $_POST['pin'];

            if(mysqli_query($conn, "UPDATE user_master SET user_name = '$name', 
				user_phone_number = '$num', address_line_1 = '$add1', address_line_2  ='$add2', 
				pin_code = '$pin', city = '$city' WHERE user_id = '$user_id'")){
                        
				echo '<script>swal("Yay", "Profile updated successfully !", "success");</script>';    
			} else{
				
				echo '<script>swal("Oops", "Unable to process your request !", "error");</script>';                                                  
			}                                                  
    
        }

		if(!empty($user_id)){
			$res = mysqli_query($conn, "SELECT * FROM user_master WHERE user_id = '$user_id'");
			if(mysqli_num_rows($res)>0){

				$res = mysqli_fetch_assoc($res);
			} else{
				echo '<script>swal("Oops", "Unable to process your request !", "error");</script>';
			}
		}

    ?>


	<!-- Content page -->
	<section class="bg0 p-t-75">
		<div class="container">
		<?php if(!empty($_SESSION['isLogin'])){ ?>
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10 d-flex align-items-center">
                    <div class="card-body text-black">
                        <form method="POST" class="row">
                        <div class="form-outline mb-4 col-lg-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control form-control-lg" name="name" required pattern="^([A-Za-z]+[ ]?|[A-Za-z])+$" title="Only alphabets and space are allowed." value="<?php echo $res['user_name'];?>"/>
                        </div>

                        <div class="form-outline mb-4 col-lg-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control form-control-lg" name="number" required pattern="[0-9]{10}" title="Accept 10 digit numbers only." value="<?php echo $res['user_phone_number'];?>"/>
                        </div>

						<div class="form-outline mb-4 col-lg-6">
                            <label class="form-label">Address Line 1</label>
                            <input type="text" class="form-control form-control-lg" name="add1" required value="<?php echo $res['address_line_1'];?>"/>
                        </div>

						<div class="form-outline mb-4 col-lg-6">
                            <label class="form-label">Address Line 2</label>
                            <input type="text" class="form-control form-control-lg" name="add2" required value="<?php echo $res['address_line_2'];?>"/>
                        </div>

						<div class="form-outline mb-4 col-lg-6">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control form-control-lg" name="city" required value="<?php echo $res['city'];?>"/>
                        </div>

						<div class="form-outline mb-4 col-lg-6">
                            <label class="form-label">PIN Code</label>
                            <input type="text" class="form-control form-control-lg" name="pin" required pattern="[0-9]{6}" title="Accept 10 digit numbers only." value="<?php echo $res['pin_code'];?>"/>
                        </div>

                        <div class="form-outline mb-4 col-lg-12">
                            <button class="btn btn-dark btn-lg btn-block" type="submit" name="update">Update</button>
                        </div>
                        </form>

                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>
			<?php } else{ echo '<script>swal("Oops", "Kindly login to proceed !", "error").then(function() {
					window.location = "login.php?source=profile";
				});</script>';} ?>
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
	<script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
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