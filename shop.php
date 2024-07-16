<?php
session_start();

require_once 'include/keywords.php';
require_once 'include/connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Shop - <?php echo $site; ?></title>
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
    <style>
        .col-lg-2-4 {
            flex: 0 0 20%;
            max-width: 20%;
        }

        @media (max-width: 1199.98px) {
            .col-lg-2-4 {
                flex: 0 0 33.333333%;
                max-width: 33.333333%;
            }
        }

        @media (max-width: 991.98px) {
            .col-lg-2-4 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        @media (max-width: 767.98px) {
            .col-lg-2-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>
</head>

<body class="animsition">
    <?php
    require_once 'include/add-cart.php';
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
                                <a href="include/logout.php">Logout </a>
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

    <?php
    require_once 'include/cart.php';

    $page = '1';
    if (!empty($_GET['page'])) {
        $page = $_GET['page'];
    }
    $cid = 1;
    if (!empty($_GET['id'])) {
        $cid = $_GET['id'];
    }

    $sql = "SELECT * FROM product_master WHERE product_status = 'Active' AND category_id = '$cid'";

    $results_per_page = 9;
    $result = mysqli_query($conn, $sql);
    $number_of_result = mysqli_num_rows($result);

    $number_of_page = ceil($number_of_result / $results_per_page);
    if (empty($_GET['page']) || $_GET['page'] < 1) {
        $page = 1;
    } else if ($_GET['page'] >= $number_of_page) {
        $page = $number_of_page;
    } else {
        $page = $_GET['page'];
    }
    $page_first_result = ($page - 1) * $results_per_page;

    $sql .= " LIMIT " . $page_first_result . ',' . $results_per_page;
    ?>

    <!-- Product -->
    <div class="bg0 m-t-23 p-b-140">
        <div class="container">
            <div class="flex-w flex-sb-m p-b-52">
                <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                    <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" onclick="filterProducts('All Products')">
                        All Products
                    </button>
                    <?php
                    $resCate = mysqli_query($conn, "SELECT * FROM category_master WHERE category_status = 'Active' AND category_type = 'Shopping'");
                    if (mysqli_num_rows($resCate) > 0) {
                        while ($rowCat = mysqli_fetch_assoc($resCate)) {
                    ?>
                            <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" onclick="filterProducts('<?php echo $rowCat['category_name']; ?>')">
                                <?php echo $rowCat['category_name']; ?>
                            </button>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="row isotope-grid" id="productContainer">
                <?php
                $sql3 = "SELECT * FROM product_master WHERE product_status = 'Active'";
                $res2 = mysqli_query($conn, $sql3);

                if (mysqli_num_rows($res2) > 0) {
                    while ($row1 = mysqli_fetch_assoc($res2)) {
                        $sql1 = "SELECT category_name from category_master where category_id  = $row1[category_id]";
                        $res3 = mysqli_query($conn, $sql1);
                        if ($res3) {
                            if ($row2 = mysqli_fetch_assoc($res3)) {
                                $category = $row2['category_name'];
                            }
                        }
                ?>
                        <div class="col-sm-6 col-md-4 col-lg-2-4 p-b-35 isotope-item <?php echo $category; ?>">
                            <form method="post" class="block2">
                                <div class="block2-pic hov-img0">
                                    <img src="admin/assets/images/products/<?php echo $row1['product_image']; ?>" alt="IMG-PRODUCT" style="width:240px; height:224px;">
                                    <input type="hidden" name="product_id" value="<?php echo $row1['product_id']; ?>">
                                    <input type="hidden" name="product_name" value="<?php echo $row1['product_name']; ?>">
                                    <input type="hidden" name="product_image" value="<?php echo $row1['product_image']; ?>">
                                    <input type="hidden" name="product_price" value="<?php echo $row1['product_price']; ?>">
                                    <button class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04" name="addToCart">
                                        Add to cart
                                    </button>
                                </div>

                                <div class="block2-txt flex-w flex-t p-t-14">
                                    <div class="block2-txt-child1 flex-col-l ">
                                        <a href="product-detail.php?id=<?php echo $row1['product_id']; ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                            <?php echo $row1['product_name']; ?>
                                        </a>

                                        <span class="stext-105 cl3">
                                            Rs. <?php echo number_format($row1['product_price'], 2); ?>
                                        </span>
                                    </div>
                                    <?php
                                    if ($category === "Clothes") {
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
                                    } elseif ($category === "Shoes") {
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
                            </form>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <?php
    require_once 'include/footer.php';
    ?>

    <script>
        function filterProducts(category) {
            var products = document.querySelectorAll('.isotope-item');

            products.forEach(function(product) {
                if (category === 'All Products' || product.classList.contains(category)) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        }
    </script>

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
