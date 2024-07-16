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
			Change password
		</h2>
	</section>	

    <?php
                                            
        if(isset($_POST['update'])){

            $password = $_POST['pass'];
            $confirm = $_POST['cpass'];
            $user_id = $_SESSION['user_id'];

            if($password == $confirm){

                $resCheck = mysqli_query($conn, "SELECT lm.login_password, lm.login_id FROM user_master um, login_master lm 
                    WHERE lm.user_type = 'User' AND lm.user_email_id = um.user_email_id AND um.user_id = '$user_id' 
                    AND um.user_status = 1");

                $resCheck = mysqli_fetch_assoc($resCheck);

                if($resCheck['login_password']==$password){
                    

                    echo '<script>swal("Oops", "Your new password cannot be the same as your current password!", "error");</script>';                
                } else{
        
                    if(mysqli_query($conn, "UPDATE login_master SET login_password = '$password' WHERE login_id = '$resCheck[login_id]'")){
                        
                        echo '<script>swal("Yay", "Your password updated successfully !", "success");</script>';    
                    } else{
                        
                        echo '<script>swal("Oops", "Unable to process your request !", "error");</script>';                                                  
                    }
                }
            }else{

                echo '<script>swal("Oops", "Password confirmation doesnt match !", "error");</script>';
            }                                                    
    
        }

    ?>


	<!-- Content page -->
	<section class="bg0 p-t-75">
		<div class="container">
		<?php if(!empty($_SESSION['isLogin'])){ ?>
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6 d-flex align-items-center">
                    <div class="card-body text-black">
                        <form method="POST">
                        <div class="form-outline my-4">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control form-control-lg" name="pass" required/>
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control form-control-lg" name="cpass" required minlength="6" title="Must contain at least 6 or more characters"/>
                        </div>

                        <div class="pt-1">
                            <button class="btn btn-dark btn-lg btn-block" type="submit" name="update">Update</button>
                        </div>
                        </form>

                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>
			<?php } else{ 
				
				echo '<script>swal("Oops", "Kindly login to proceed !", "error").then(function() {
					window.location = "login.php?source=settings";
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