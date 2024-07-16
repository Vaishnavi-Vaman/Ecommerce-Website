<?php
session_start();

require_once 'include/keywords.php';
require_once 'include/connection.php';

if (empty($_GET['source'])) {
	echo "<script>location.href='index.php';</script>";
}

$source = $_GET['source'];

$res = mysqli_query($conn, "SELECT * FROM product_master WHERE product_id = '$source'");

if (mysqli_num_rows($res) > 0) {

	$res = mysqli_fetch_assoc($res);
} else {

	echo "<script>location.href='index.php';</script>";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo $res['product_name']; ?> - <?php echo $site; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon-32x32.png" />
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

	if (isset($_POST['add_to_cart'])) {

		$product_id = $_POST['product_id'];
		$product_name = $_POST['product_name'];
		$product_price = $_POST['product_price'];
		$product_image = $_POST['product_image'];
		$product_qty = $_POST['product_qty'];
		$size = $_POST['size'];

		$itemArray = array(
			$product_id => array(
				'productId' => $product_id,
				'productName' => $product_name,
				'productQuantity' => $product_qty,
				'productPrice' => $product_price,
				'productImage' => $product_image,
				'productSize' => $size,
			)
		);

		if (empty($_SESSION["cart_item"])) {

			$_SESSION["cart_item"] = $itemArray;

			echo '<script>swal("Success", "Product added to cart !", "success");</script>';
		} else {

			if (in_array($product_id, array_keys($_SESSION["cart_item"]))) {

				foreach ($_SESSION["cart_item"] as $k => $v) {

					if ($product_id == $k) {
						if (empty($_SESSION["cart_item"][$k]["productQuantity"])) {
							$_SESSION["cart_item"][$k]["productQuantity"] = $product_qty;
						}
						$_SESSION["cart_item"][$k]["productQuantity"] += $product_qty;

						echo '<script>swal("Success", "Product added to cart !", "success");</script>';
					}
				}
			} else {

				$_SESSION["cart_item"] += $itemArray;

				echo '<script>swal("Success", "Product added to cart !", "success");</script>';
			}
		}
	}
	?>
	<!-- Header -->
	<header class="header-v4">
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<?php require_once 'include/top-bar.php'; ?>

			<div class="wrap-menu-desktop">
				<nav class="limiter-menu-desktop container">

					<?php require_once 'include/desktop-logo.php'; ?>

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
					<?php require_once 'include/cart-search.php'; ?>
				</nav>
			</div>
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">

			<?php require_once 'include/mobile-logo.php'; ?>
			<?php require_once 'include/cart-search-mobile.php'; ?>

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

	?>

	<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="index.php" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				<?php echo $res['product_name']; ?>
			</span>
		</div>
	</div>

	<!-- Product Detail -->
	<section class="sec-product-detail bg0 p-t-65">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-7 p-b-30">
					<div class="p-l-25 p-r-30 p-lr-0-lg">
						<div class="wrap-slick3 flex-sb flex-w">
							<div class="wrap-slick3-dots"></div>
							<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

							<div class="slick3 gallery-lb">
								<div class="item-slick3" data-thumb="admin/assets/images/products/<?php echo $res['product_image']; ?>">
									<div class="wrap-pic-w pos-relative">
										<img src="admin/assets/images/products/<?php echo $res['product_image']; ?>" alt="IMG-PRODUCT">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="admin/assets/images/products/<?php echo $res['product_image']; ?>">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>

								<div class="item-slick3" data-thumb="admin/assets/images/products/<?php echo $res['product_image_2']; ?>">
									<div class="wrap-pic-w pos-relative">
										<img src="admin/assets/images/products/<?php echo $res['product_image_2']; ?>" alt="IMG-PRODUCT">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="admin/assets/images/products/<?php echo $res['product_image_2']; ?>">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>

								<div class="item-slick3" data-thumb="admin/assets/images/products/<?php echo $res['product_image_3']; ?>">
									<div class="wrap-pic-w pos-relative">
										<img src="admin/assets/images/products/<?php echo $res['product_image_3']; ?>" alt="IMG-PRODUCT">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="admin/assets/images/products/<?php echo $res['product_image_3']; ?>">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6 col-lg-5 p-b-30">
					<div class="p-r-50 p-t-5 p-lr-0-lg">
						<h4 class="mtext-105 cl2 js-name-detail p-b-14">
							<?php echo $res['product_name']; ?>
						</h4>

						<span class="mtext-106 cl2">
							Rs. <?php echo number_format($res['product_price'], 2); ?>
						</span>

						<p class="stext-102 cl3 p-t-23">
							<?php echo $res['product_description']; ?>
						</p>

						<div class="p-t-33">
							<div class="p-b-10">
								<div class="size-204">
									<form method="post">
										<div class="row">
											<div class="col-lg-6">
												<div class="wrap-num-product flex-w m-r-20">
													<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m" onclick="removeQty()">
														<i class="fs-16 zmdi zmdi-minus"></i>
													</div>

													<input class="mtext-104 cl3 txt-center num-product" type="number" name="product_qty" value="1" id="num_qty" min="1">

													<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" onclick="addQty()">
														<i class="fs-16 zmdi zmdi-plus"></i>
													</div>
												</div>
											</div>
											<div class="col-lg-6">
											<?php

												$category = $res['category_id'];

												if ($category === "26" || $category === "27") {
													echo '<div class="rs1-select2 bor8 bg0">';
													echo '<select required style="height: 45px;border: none;outline: none;border-radius: 0px;position: relative;font-family: Poppins-Regular;font-size: 14px;color: #555;padding-left: 20px;background-color: transparent;" name="size" required>';
													echo '<option value="">Choose Size</option>';

													if ($category === "26") {
														echo '<option value="S">Size S</option>';
														echo '<option value="M">Size M</option>';
														echo '<option value="L">Size L</option>';
														echo '<option value="XL">Size XL</option>';
														echo '<option value="XXL">Size XXL</option>';
													} elseif ($category === "27") {
														for ($i = 1; $i <= 10; $i++) {
															echo '<option value="' . $i . '">Size ' . $i . '</option>';
														}
													}

													echo '</select>';
													echo '</div>';
												}

											?>


											</div>
										</div>

										<input type="hidden" name="product_id" value="<?php echo $res['product_id']; ?>">
										<input type="hidden" name="product_name" value="<?php echo $res['product_name']; ?>">
										<input type="hidden" name="product_image" value="<?php echo $res['product_image']; ?>">
										<input type="hidden" name="product_price" value="<?php echo $res['product_price']; ?>">
										<button class="mt-3 flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04" name="add_to_cart">
											Add to Cart <i class="ml-1 zmdi zmdi-shopping-cart"></i>
										</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

		<!-- Related Products -->
	<section class="sec-relate-product bg0 p-t-45 p-b-105">
		<div class="container">
			<div class="p-b-45">
				<h3 class="ltext-106 cl5 txt-center">
					Related Products
				</h3>
			</div>

			<!-- Slide2 -->
			<div class="wrap-slick2">
				<div class="slick2">
				<?php
				$sql3 = "SELECT * FROM product_master WHERE product_status = 'Active' AND category_id = '{$res['category_id']}' AND type = '{$res['type']}' AND gender = '{$res['gender']}' AND NOT product_id = '{$res['product_id']}'";
				$res2 = mysqli_query($conn, $sql3);

                if (mysqli_num_rows($res2) > 0) {
                    while ($row1 = mysqli_fetch_assoc($res2)) {

                ?>
					<div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
						<!-- Block2 -->
						<div class="block2">
							<div class="block2-pic hov-img0">
								<a href="product-detail.php?source=<?php echo $row1['product_id']; ?>">
									<img src="admin/assets/images/products/<?php echo $row1['product_image']; ?>" alt="IMG-PRODUCT">
								</a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="product-detail.php?source=<?php echo $row1['product_id']; ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										<?php echo $row1['product_name']; ?>
									</a>

									<span class="stext-105 cl3">
										Rs. <?php echo number_format($row1['product_price'], 2); ?>
									</span>
								</div>

								<?php
								$category = $row1['category_id'];
                                        if ($category === "26") {
                                            ?>
                                            <div class="block2-txt-child2 flex-r p-t-3">
                                                <select required name="size" style="padding: 0.2rem 0.35rem;font-size: .9rem;color: #495057;background-color: #fff;border: 1px solid rgba(0,0,0,.15);border-radius: 0.25rem;">
                                                    <option value="">Size</option>
                                                    <option value="S">S</option>
                                                    <option value="M">M</option>
                                                    <option value="L">L</option>
                                                    <option value="XL">XL</option>
                                                    <option value="XXL">XXL</option>
                                                </select>
                                            </div>
                                            <?php
                                        } elseif ($category === "27") {
                                            ?>
                                            <div class="block2-txt-child2 flex-r p-t-3">
                                                <select required name="size" style="padding: 0.2rem 0.35rem;font-size: .9rem;color: #495057;background-color: #fff;border: 1px solid rgba(0,0,0,.15);border-radius: 0.25rem;">
                                                    <option value="">Size</option>
                                                    <?php
                                                    // Displaying shoe sizes from 1 to 10
                                                    for ($i = 1; $i <= 10; $i++) {
                                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <?php
                                        }
                                    ?>
							</div>
						</div>
					</div>
					<?php
						}
					}
					?>

				</div>
			</div>
		</div>
	</section>

	<script>
		function addQty() {
			var inp = document.getElementById("num_qty");
			inp.value = parseInt(inp.value) + 1;
		}

		function removeQty() {
			var inp = document.getElementById("num_qty");
			if (parseInt(inp.value) > 1) {
				inp.value = parseInt(inp.value) - 1;
			}

		}
	</script>


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
		$(".js-select2").each(function() {
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
		$('.gallery-lb').each(function() {
			$(this).magnificPopup({
				delegate: 'a',
				type: 'image',
				gallery: {
					enabled: true
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
		$('.js-pscroll').each(function() {
			$(this).css('position', 'relative');
			$(this).css('overflow', 'hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function() {
				ps.update();
			})
		});
	</script>
	<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>

</html>