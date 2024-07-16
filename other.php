<?php
    session_start();
    
    require_once 'include/keywords.php';
    require_once 'include/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Other - <?php echo $site;?></title>
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
<?php
	require_once 'include/add-cart.php';
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

    $page = '1';
    if(!empty($_GET['page'])){

        $page = $_GET['page'];
    }

    $sql = "SELECT * FROM product_master WHERE product_status = 1 AND category_id = 3";
    
    $results_per_page = 9; 
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

    ?>

	<!-- Content page -->
	<section class="bg0 p-t-62">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-lg-9 p-b-80">
					<div class="p-r-45 p-r-0-lg">
						<!-- item blog -->
						<div class="p-b-63">
                        <h3 class="ltext-103 cl5">Best in Crafts</h3>
                        <div class="flex-w flex-sb-m p-b-52"></div>
                        <div class="row isotope-grid">
                        <?php
                        $res2 = mysqli_query($conn, $sql);

                        if(mysqli_num_rows($res2)>0){
                            while($row2 = mysqli_fetch_assoc($res2)){
                                ?>
                                    <div class="col-sm-6 col-md-4 col-lg-4 p-b-35 isotope-item">
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="admin/assets/images/products/<?php echo $row2['product_image'];?>" alt="IMG-PRODUCT">

                                                <form method="post">
                                                    <input type="hidden" name="product_id" value="<?php echo $row2['product_id']; ?>">
                                                    <input type="hidden" name="product_name" value="<?php echo $row2['product_name']; ?>">
                                                    <input type="hidden" name="product_image" value="<?php echo $row2['product_image']; ?>">
                                                    <input type="hidden" name="product_price" value="<?php echo $row2['product_price']; ?>">
                                                    <button class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04" name="add_to_cart">
                                                        Add to Cart <i class="ml-1 zmdi zmdi-shopping-cart"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="product-detail.php?source=<?php echo $row2['product_id'];?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                    <?php echo $row2['product_name'];?>
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        Rs. <?php echo number_format($row2['product_price'], 2);?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                            }   
                        }                 
                    ?>
			        </div>
                </div>

                <!-- Pagination -->
                <div class="flex-l-m flex-w w-full m-lr--7">
                    <?php
                        for($i = 1; $i<= $number_of_page; $i++) {  
                            if($i <= $page+$number_of_page && $i >= $page){
                            
                            
                                echo "<a href='other.php?page=$i' class='flex-c-m how-pagination1 trans-04 m-all-7";
                                if($page==$i){
                                    echo ' active-pagination1';
                                } 
                                echo "'>$i</a></li>";
                            }else if($i >= $page-($number_of_page-1) && $i <= $page){
                                echo "<a href = 'other.php?page=$i' class='flex-c-m how-pagination1 trans-04 m-all-7";
                                if($page==$i){
                                    echo ' active-pagination1';
                                } 
                                echo "'>$i</a>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-3 p-b-80">
            <div class="side-menu">

                <div>
                    <h4 class="mtext-112 cl2 p-b-33">
                        Categories
                    </h4>

                    <ul>
                        <li class="bor18">
                            <a href="frames.php" class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4">
                                Frames
                            </a>
                        </li>

                        <li class="bor18">
                            <a href="crafts.php" class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4">
                                Crafts
                            </a>
                        </li>

                        <li class="bor18">
                            <a href="other.php" class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4">
                                Other
                            </a>
                        </li>
                    </ul>
                </div>
                
                <?php
                $resF = mysqli_query($conn, "SELECT * FROM product_master ORDER BY product_id DESC LIMIT 5");
                if(mysqli_num_rows($resF)>0){?>
                <div class="p-t-65">
                    <h4 class="mtext-112 cl2 p-b-33">
                        Featured Products
                    </h4>

                    <ul>
                        <?php
                            while($rowF = mysqli_fetch_assoc($resF)){?>

                        <li class="flex-w flex-t p-b-30">
                            <a href="product-detail.php?source=<?php echo $rowF['product_id'];?>" class="wrao-pic-w size-214 hov-ovelay1 m-r-20">
                                <img src="admin/assets/images/products/<?php echo $rowF['product_image'];?>" alt="PRODUCT" height="120">
                            </a>

                            <div class="size-215 flex-col-t p-t-8">
                                <a href="product-detail.php?source=<?php echo $rowF['product_id'];?>" class="stext-116 cl8 hov-cl1 trans-04">
                                <?php echo $rowF['product_name'];?>
                                </a>

                                <span class="stext-116 cl6 p-t-20">
                                Rs. <?php echo number_format($rowF['product_price'], 2);?>
                                </span>
                            </div>
                        </li>
                        <?php }?>
                    </ul>
                </div>	
                    <?php }?>
                </div>
            </div>
        </div>
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