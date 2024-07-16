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
    <?php
		$user_id = 0;

		if(!empty($_SESSION['user_id'])){
			$user_id = $_SESSION['user_id'];
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
				Orders
			</span>
		</div>
	</div>
		

	<section class="bg0 p-t-50" method="post">
		<div class="container">
            <?php

                $page = '1';
                if(!empty($_GET['page'])){

                    $page = $_GET['page'];
                }

                $sql = "SELECT * FROM custom_order WHERE user_id = '$_SESSION[user_id]' ORDER BY order_id DESC";

                $results_per_page = 6; 
                $result = mysqli_query($conn, $sql);  
                $number_of_result = mysqli_num_rows($result);

                $number_of_page = ceil ($number_of_result / $results_per_page);
                if (empty($_GET['page']) || $_GET['page']<1) {  
                $page = 1;  
                } else if($_GET['page']>=$number_of_page){
                    $page = $number_of_page;
                } else { 
                    $page = $_GET['page'];  
                }  
                $page_first_result = ($page-1) * $results_per_page; 

                $sql .= " LIMIT " . $page_first_result . ',' . $results_per_page;

            
            if(!empty($_SESSION['isLogin'])){ 

                $resOrder = mysqli_query($conn, $sql);
                if(mysqli_num_rows($resOrder)>0){

                    while($rowOrder = mysqli_fetch_assoc($resOrder)){
                        ?>
                            <div class="card mb-5">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-9 col-sm-12 col-md-9 mt-2">
                                            <a href="custom-order-details.php?source=<?php echo $rowOrder['order_number'];?>">#<?php echo $rowOrder['order_number'];?></a>
                                        </div>
                                        <div class="col-lg-3 col-sm-12 col-md-3 text-end">
                                            <span class=""><?php echo date_format(date_create($rowOrder['order_date']), 'd M, Y');?> <?php echo date_format(date_create($rowOrder['order_date']), 'h:i A');?></span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <strong>Order Status : </strong>
                                    <div class="progress mt-3">
                                        <div class="progress-bar" role="progressbar" style="<?php if($rowOrder['order_status']=='Order Placed'){echo 'width: 25%;';}if($rowOrder['order_status']=='Order Shipped'){echo 'width: 50%;';}if($rowOrder['order_status']=='Order Out for delivary'){echo 'width: 75%;';}if($rowOrder['order_status']=='Order Delivered'){echo 'width: 100%;';}?>" aria-valuemin="0" aria-valuemax="100"><?php echo $rowOrder['order_status'];?></div>
                                    </div>
                                </div>
                            </div>
                        <?php 
                    }
                    ?>
                    <div class="flex-l-m flex-w w-full m-lr-7">
                        <?php
                            for($i = 1; $i<= $number_of_page; $i++) {  
                                if($i <= $page+$number_of_page && $i >= $page){
                                
                                
                                    echo "<a href='orders.php?page=$i' class='flex-c-m how-pagination1 trans-04 m-all-7";
                                    if($page==$i){
                                        echo ' active-pagination1';
                                    } 
                                    echo "'>$i</a></li>";
                                }else if($i >= $page-($number_of_page-1) && $i <= $page){
                                    echo "<a href = 'orders.php?page=$i' class='flex-c-m how-pagination1 trans-04 m-all-7";
                                    if($page==$i){
                                        echo ' active-pagination1';
                                    } 
                                    echo "'>$i</a>";
                                }
                            }
                        ?>
                    </div>
                    <?php
                }else{
                    echo "<h5>No order found!</h5>";
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