<?php
    session_start();

    if(empty($_SESSION['is_admin_login'])){
        echo "<script>location.href='index.php';</script>";
    }

    require_once '../include/connection.php';
    require_once './assets/pages/admin-link.php';
    require_once './assets/pages/admin-header.php';
?>
    
        <div id="layoutSidenav">
            <?php
                require_once './assets/pages/admin-sidebar.php';
            ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid p-4">
                        <h2>Dashboard</h1>
                        <div class="row mt-4">
                            <div class="col-lg-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Category</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <?php
                                    $result1 = mysqli_query($conn, "SELECT COUNT(*) AS total_category FROM category_master");
                                    $row1 = mysqli_fetch_assoc($result1);
                                    $totalcategory = $row1['total_category'];
                                    ?>
                                    <h3><?php echo $totalcategory; ?></h3>
                                    <a href="category.php" class="text-light" style="font-size: 14px;text-decoration:none">View</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card bg-info text-white mb-4">
                                    <div class="card-body">Total Products</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <?php
                                    $result2 = mysqli_query($conn, "SELECT COUNT(*) AS total_products FROM product_master");
                                    $row2 = mysqli_fetch_assoc($result2);
                                    $totalProducts = $row2['total_products'];
                                    ?>
                                        <h3><?php echo $totalProducts; ?></h3>
                                        <a href="product.php" class="text-light" style="font-size: 14px;text-decoration:none">View</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Total Users</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <?php
                                    $result3 = mysqli_query($conn, "SELECT COUNT(*) AS total_user FROM login_master WHERE user_type = 'User'");
                                    $row3 = mysqli_fetch_assoc($result3);
                                    $totaluser = $row3['total_user'];
                                    ?>
                                    <h3><?php echo $totaluser; ?></h3>
                                    <a href="user.php" class="text-light" style="font-size: 14px;text-decoration:none">View</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Total Orders</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <?php
                                    $result4 = mysqli_query($conn, "SELECT COUNT(*) AS total_order FROM order_master");
                                    $row4 = mysqli_fetch_assoc($result4);
                                    $totalorder = $row4['total_order'];
                                    ?>
                                    <h3><?php echo $totalorder; ?></h3>
                                    <a href="order.php" class="text-light" style="font-size: 14px;text-decoration:none">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-4">
                            <div class="col-xl-6 col-md-6 p-1">
                                <div class="card p-2">
                                    <h6 class="my-2">Recent Products</h6>
                                    <table class="table table-borderless table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Product</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $resd6 = mysqli_query($conn, "SELECT * FROM product_master ORDER BY product_id DESC LIMIT 5");
                                            if (mysqli_num_rows($resd6) > 0) {
            
                                                $count = 1;
                                                while($rowd6 = mysqli_fetch_assoc($resd6)) {
                                                    
                                                    echo "<tr>"; 
                                                    echo "<th>".$count."</th>"; 
                                                    echo "<td><img src='assets/images/products/".$rowd6['product_image']."' class='mr-2' width='70' height='50'></td>";
                                                    echo "<td>".$rowd6['product_name']."</td>";
                                                    echo "<td>".date_format(date_create($rowd6['product_date_create']), 'd M, Y') . "</td>"; 
                                                    echo "</tr>"; 
                                                    $count++;
                                                }
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 p-1">
                                <!-- <div class="card p-2">
                                    <h6 class="my-2">Recent payments</h6>
                                    <table class="table table-borderless table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Transaction Id</th>
                                                <th>Mode</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $resd7 = mysqli_query($conn, "SELECT * FROM payment_master ORDER BY payment_id DESC LIMIT 5");
                                            if (mysqli_num_rows($resd7) > 0) {
                                                $count = 1;
                                                while($rowd7 = mysqli_fetch_assoc($resd7)) {
                                                    
                                                    echo "<tr>"; 
                                                    echo "<th>".$count."</th>";  
                                                    echo "<td>".$rowd7['transaction_id']."</td>";
                                                    echo "<td>".$rowd7['payment_mode']."</td>";
                                                    echo "<td>".number_format($rowd7['amount_paid'],2)."</td>";
                                                    echo "<td>".date_format(date_create($rowd7['date_of_payment']), 'd M, Y h.i A') . "</td>"; 
                                                    echo "</tr>"; 

                                                    $count++;
                                                }
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    
<?php

    require_once './assets/pages/admin-footer.php';
?>
