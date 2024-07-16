<?php
session_start();

if (empty($_SESSION['is_admin_login'])) {
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
            <div class="container-fluid p-5">

                <div class="text-end">
                    <button class="btn btn-sm btn-danger" onclick="window.print()">Print</button>
                </div>
                <?php

                if (!empty($_GET['source'])) {

                    $total = 0;

                    $transaction_id = $_GET['source'];

                    $resOrder = mysqli_query($conn, "SELECT * from custom_order WHERE order_number = '$transaction_id'");
                    if (mysqli_num_rows($resOrder) > 0) {

                        $resOrder = mysqli_fetch_assoc($resOrder);

                ?>

                        <div class="row mt-4">
                            <div class="col-6">
                                <h5>Order No. #<?php echo $resOrder['order_number']; ?></h5>
                            </div>
                            <div class="col-6 text-end">
                                <span><?php echo date_format(date_create($resOrder['order_date']), 'd M Y h:i A'); ?></span>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-6">
                                <?php $resCustomer = mysqli_query($conn, "SELECT * FROM user_master WHERE user_id = '$resOrder[user_id]'");
                                if (mysqli_num_rows($resCustomer) > 0) {
                                    $resCustomer = mysqli_fetch_assoc($resCustomer); ?>
                                    <span><?php echo $resCustomer['user_name']; ?></span><br> <span>+91 <?php echo $resCustomer['user_phone_number']; ?><br></span><span><?php echo $resCustomer['address_line_1']; ?>, <br><?php echo $resCustomer['address_line_2']; ?>, <br><?php echo $resCustomer['city']; ?><br>PIN: <?php echo $resCustomer['pin_code']; ?></span>
                                <?php } ?>
                            </div>
                            <div class="col-6 text-end">
                                <span class="h5"><?php echo 'Coser'; ?></span><br> <span id="details">Shastha nagar (po)</span><br>Mogral puthur, kasaragod<br>PIN: 671121
                            </div>
                        </div>

                        <div class="row mt-5 table-responsive">
                            <table class="table table-hover">
                                <tr class="table-dark">
                                    <th>SL.NO</th>
                                    <th>Perticulars</th>
                                    <th>Price</th>
                                    <th>Custom</th>
                                </tr>

                                <?php

                                $mtPrice = 0;
                                $tPrice = 0;
                                $count = 1;

                                $resProduct = mysqli_query($conn, "SELECT * FROM design_temp a, customize_category b 
								    WHERE a.cc_id = b.cc_id AND a.order_number = '$resOrder[order_number]'");

                                if (mysqli_num_rows($resProduct) > 0) {

                                    echo "<div class='pricing'>";



                                    while ($row = mysqli_fetch_assoc($resProduct)) {

                                        echo "<tr>";

                                        echo "<td>$count</td>";

                                        if (empty($row['customer_design'])) {

                                            $resC = mysqli_query($conn, "SELECT * FROM customize_design
                                                WHERE design_id = '$row[design_id]'");
                                            if (mysqli_num_rows($resC) > 0) {

                                                $resC = mysqli_fetch_assoc($resC);
                                                $tPrice += $resC['design_price'];
                                ?>
                                                <td><?php echo $row['cc_name']; ?></td>
                                                <td><?php echo number_format($resC['design_price'], 2); ?></td>
                                                <td><a href="assets/images/design/<?php echo $resC['design_image']; ?>" download>Download</a></td>

                                            <?php
                                            }
                                        } else {

                                            $tPrice += $row['default_price'];
                                            ?>

                                            <td><?php echo $row['cc_name']; ?></td>
                                            <td><?php echo number_format($row['default_price'], 2); ?></td>
                                            <?php
                                            $cs = mysqli_query($conn, "SELECT customer_design FROM design_temp
                                                WHERE cc_id = '$row[cc_id]' AND order_number = '$resOrder[order_number]'");
                                            if (mysqli_num_rows($cs) > 0) {

                                                $cs = mysqli_fetch_assoc($cs);
                                            ?>
                                                <td><a href="assets/images/custom/<?php echo $cs['customer_design']; ?>" download>Download</a></td>
                                            <?php
                                            }
                                            ?>



                                    <?php
                                        }

                                        echo "</tr>";
                                        $count++;
                                    }
                                }

                                $res = mysqli_query($conn, "SELECT m.*, mm.* FROM material_temp m, material_master mm 
							WHERE m.material_id = mm.material_id AND m.order_number = '$resOrder[order_number]'");
                                if (mysqli_num_rows($res) > 0) {

                                    $res = mysqli_fetch_assoc($res);

                                    $mtPrice = $res['material_price'];
                                    $tPrice += $mtPrice;
                                    echo "<td>$count</td>";
                                    ?>
                                    <td>Material</td>
                                    <td><?php echo number_format($mtPrice, 2); ?></td>
                                    <td><a href="assets/images/materials/<?php echo $cs['material_image']; ?>" download>Download</a></td>
                                <?php
                                } else {
                                    echo "<td>$count</td>";
                                ?>
                                    <td>Material</td>
                                    <td>0.00</td>
                                    <?php
                                            $cs = mysqli_query($conn, "SELECT material_file FROM material_temp
                                                WHERE order_number = '$resOrder[order_number]'");
                                            if (mysqli_num_rows($cs) > 0) {

                                                $cs = mysqli_fetch_assoc($cs);
                                            ?>
                                                <td><a href="assets/images/material/<?php echo $cs['material_file']; ?>" download>Download</a></td>
                                            <?php
                                            }
                                            ?>
                                <?php
                                }
                                ?>
                            </table>
                        </div>

                        <div class="row p-4">
                            <div class="col-12 text-end">
                                <p>Total Amount: <?php echo number_format($tPrice, 2); ?></p>
                                <?php
                                $paid = 0;
                                $py = mysqli_query($conn, "SELECT amount_paid FROM payment_master 
                                                WHERE transaction_id = '$resOrder[order_number]'");
                                if (mysqli_num_rows($py) > 0) {
                                    $py = mysqli_fetch_assoc($py);
                                    $paid = $py['amount_paid'];
                                    echo "<p>Total Paid: " . $paid . "</p>";
                                }
                                ?>

                            </div>
                            <div class="col-12 text-end">
                                <h5>Credit: <?php echo number_format($tPrice - $paid, 2); ?></h5>
                            </div>
                        </div>
                <?php

                    }
                }
                ?>




        </main>
    </div>
</div>

<?php


require_once './assets/pages/admin-footer.php';
?>