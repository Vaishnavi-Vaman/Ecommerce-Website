<?php
session_start();

require_once 'include/keywords.php';
require_once 'include/connection.php';

$id = 25;

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
}

$source = time() . strtoupper(uniqid());

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Customize - <?php echo $site; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/icons/favicon.png" />
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="vendor/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="vendor/MagnificPopup/magnific-popup.css">
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
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

                <div class="col-md-8 col-lg-9 p-b-80">

                    <?php

                    $flag = false;
                    $rescCustCat = mysqli_query($conn, "SELECT * FROM customize_category 
                            WHERE cc_status = 'Active' AND category_id = '$id'");

                    if (mysqli_num_rows($rescCustCat) > 0) {

                        while ($rowcCustCat = mysqli_fetch_assoc($rescCustCat)) {

                            $cid = $rowcCustCat['cc_id'];

                    ?>
                            <div class="p-r-45 p-r-0-lg">
                                <div class="p-b-63">
                                    <div class="row">
                                        <div class="col-8">
                                            <h3 class="ltext-103 cl5"><?php echo $rowcCustCat['cc_name']; ?></h3>
                                        </div>
                                        <div class="col-4">
                                            <label>Choose your own design @ <span style="color:black">Rs. <?php echo $rowcCustCat['default_price']; ?>/- </span></label>
                                            <form id="uploadForm">
                                                <input type="file" id="fileInput" name="image" accept="image/*" onchange="handleFileChange(event,'<?php echo $cid; ?>','<?php echo $source; ?>')">
                                            </form>
                                        </div>
                                    </div>
                                    <div class="flex-w flex-sb-m p-b-52"></div>
                                    <div class="wrap-slick2">
                                        <div class="slick2">

                                            <?php
                                            $resCustItem = mysqli_query($conn, "SELECT * FROM customize_design
                                                        WHERE cc_id = '$rowcCustCat[cc_id]' AND design_status = 'Active'");

                                            if (mysqli_num_rows($resCustItem) > 0) {

                                                while ($rowCate = mysqli_fetch_assoc($resCustItem)) {
                                                    $flag = true;
                                                    $did = $rowCate['design_id'];

                                            ?>
                                                    <div class="item-slick2 border p-l-15 p-r-15 p-t-15 p-b-15 mx-2" id="<?php echo $did; ?>">
                                                        <div class="block2">
                                                            <div class="block2-pic hov-img0">
                                                                <img src="admin/assets/images/design/<?php echo $rowCate['design_image']; ?>" alt="IMG-PRODUCT">
                                                                <button class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04" onclick="selectarea('<?php echo $did; ?>','<?php echo $cid; ?>','<?php echo $source; ?>')">
                                                                    Select
                                                                </button>
                                                            </div>

                                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                                <div class="block2-txt-child1 flex-col-l ">
                                                                    <a class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                                        <?php echo $rowCate['design_name']; ?>
                                                                    </a>

                                                                    <span class="stext-105 cl3">
                                                                        Rs. <?php echo number_format($rowCate['design_price'], 2); ?>
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


                                </div>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <h3>No design found!</h3>
                    <?php
                    }

                    if ($flag) {

                    ?>

                        <div class="flex-c-m flex-w w-full">
                            <a class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04" href="material.php?source=<?php echo $source; ?>">
                                Proceed Next
                            </a>
                        </div>

                    <?php
                    }

                    ?>

                </div>

                <script>
                    function selectarea(did, cid, src) {

                        $.ajax({
                            type: "POST",
                            url: "ajax/insert-temp.php",
                            data: "did=" + did + "&cid=" + cid + "&src=" + src,
                            success: function(data) {
                                const divElement = document.getElementById(did);
                                divElement.className += " border border-danger";
                            }
                        });


                    }
                </script>

                <script>
                    function handleFileChange(event, cid, src) {

                        const fileInput = event.target;
                        const file = fileInput.files[0];

                        if (!file) {
                            return;
                        }

                        uploadImage(file, cid, src);
                    }

                    function uploadImage(file, cid, src) {

                        const formData = new FormData();

                        formData.append('image', file);
                        formData.append('cid', cid);
                        formData.append('src', src);

                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', 'ajax/upload.php', true);
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    alert("File uploaded successfully.")
                                } else {
                                    alert("Error uploading file.")
                                }
                            }
                        };
                        xhr.send(formData);
                    }
                </script>


                <div class="col-md-4 col-lg-3 p-b-80">
                    <div class="side-menu">
                        <?php
                        $resCate = mysqli_query($conn, "SELECT * FROM category_master WHERE category_status = 'Active' AND category_type = 'Customize'");
                        if (mysqli_num_rows($resCate) > 0) { ?>
                            <div>
                                <h4 class="mtext-112 cl2 p-b-33">
                                    Categories
                                </h4>

                                <ul>
                                    <?php
                                    while ($rowCat = mysqli_fetch_assoc($resCate)) { ?>
                                        <li class="bor18">
                                            <a href="?id=<?php echo $rowCat['category_id']; ?>" class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4">
                                                <?php echo $rowCat['category_name']; ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
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
        $('.gallery-lb').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: 'a', // the selector for gallery item
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
    <script src="vendor/sweetalert/sweetalert.min.js"></script>
    <script>
        $('.js-addwish-b2').on('click', function(e) {
            e.preventDefault();
        });

        $('.js-addwish-b2').each(function() {
            var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
            $(this).on('click', function() {
                swal(nameProduct, "is added to wishlist !", "success");

                $(this).addClass('js-addedwish-b2');
                $(this).off('click');
            });
        });

        $('.js-addwish-detail').each(function() {
            var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

            $(this).on('click', function() {
                swal(nameProduct, "is added to wishlist !", "success");

                $(this).addClass('js-addedwish-detail');
                $(this).off('click');
            });
        });

        /*---------------------------------------------*/

        $('.js-addcart-detail').each(function() {
            var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
            $(this).on('click', function() {
                swal(nameProduct, "is added to cart !", "success");
            });
        });
    </script>
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