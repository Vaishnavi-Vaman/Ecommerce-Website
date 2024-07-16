<?php
session_start();

require_once 'include/keywords.php';
require_once 'include/connection.php';

if (!empty($_GET['source'])) {
    $source = $_GET['source'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Material - <?php echo $site; ?></title>
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

    <section class="bg0 p-t-62">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-12">
                    <div class="p-r-45 p-r-0-lg">
                        <!-- item blog -->
                        <div class="p-b-63">
                            <div class="row">
                                <div class="col-8">
                                    <h3 class="ltext-103 cl5">Material Just for you</h3>
                                </div>
                                <div class="col-4">
                                    <label>Have your own material</label>
                                    <form id="uploadForm">
                                        <input type="file" id="fileInput" name="image" accept="image/*" onchange="handleFileChange(event,'<?php echo $source; ?>')">
                                    </form>
                                </div>
                            </div>
                            <div class="flex-w flex-sb-m p-b-52"></div>
                            <div class="row isotope-grid">

                                <?php
                                $res = mysqli_query($conn, "SELECT * FROM material_master
                                        WHERE material_status = 'Active'");

                                if (mysqli_num_rows($res) > 0) {

                                    while ($row = mysqli_fetch_assoc($res)) {

                                ?>
                                        <div class="col-sm-6 col-md-4 col-lg-4 p-b-35 isotope-item">
                                            <form method="post" class="block2">
                                                <div class="block2-pic hov-img0">
                                                    <img src="admin/assets/images/materials/<?php echo $row['material_image']; ?>" alt="IMG-PRODUCT" style="width:300px; height:200px;">
                                                    <a href="customize-payment.php?mid=<?php echo $row['material_id']; ?>&source=<?php echo $source; ?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04" name="add_to_cart">
                                                        Select
                                                    </a>
                                                </div>

                                                <div class="block2-txt flex-w flex-t p-t-14">
                                                    <div class="block2-txt-child1 flex-col-l ">
                                                        <a class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                            <?php echo $row['material_name']; ?>
                                                        </a>

                                                        <span class="stext-105 cl3">
                                                            Rs. <?php echo number_format($row['material_price'], 2); ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    <?php
                                    }
                                } else {

                                    ?>
                                    <h3>No material found</h3>
                                <?php
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function handleFileChange(event, src) {

            const fileInput = event.target;
            const file = fileInput.files[0];

            if (!file) {
                return;
            }

            const fileExtension = file.name.split('.').pop();
            const currentTimeInMillis = Date.now();

            const newFileName = `${currentTimeInMillis}.${fileExtension}`;

            uploadImage(file, src, newFileName);
        }

        function uploadImage(file, src, name) {

            const formData = new FormData();

            formData.append('image', file);
            formData.append('src', src);
            formData.append('name', name);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'ajax/upload-material.php', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {

                        const url = `customize-payment.php?mfile=${name}&source=${src}`;
                        
                        location.href=url;
                    } else {
                        // alert("Error uploading file.")
                    }
                }
            };
            xhr.send(formData);
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
    <script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
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