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
                        <div class="row">
                            <div class="col-9" >
                                <h3 class="mb-3">Manage payments</h1>
                            </div>

                            <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Transaction Id</th>
                                            <th>Mode</th>
                                            <th>Card Holder Name</th>
                                            <th>Card Number</th>
                                            <th>Expiry Date</th>
                                            <th>Paid Amount</th>
                                            <th>Total Amount</th>
                                            <th>Payment Status</th>
                                            <th>Date of Payment</th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $resData = mysqli_query($conn, "SELECT * FROM payment_master");
                                        if (mysqli_num_rows($resData) > 0) {

                                            $count = 1;
                                            while($rowData = mysqli_fetch_assoc($resData)) {
                                                
                                                echo "<tr>"; 
                                                echo "<th>".$count."</th>"; 
                                                echo "<td>".$rowData['transaction_id']."</td>";
                                                echo "<td>".$rowData['payment_mode']."</td>";
                                                echo "<td>".$rowData['card_holder_name']."</td>";
                                                echo "<td>".$rowData['card_number']."</td>"; 
                                                echo "<td>".number_format($rowData['amount_paid'], 2)."</td>"; 
                                                echo "<td>".number_format($rowData['total_amount'], 2)."</td>"; 
                                                echo "<td>$rowData[card_expiry_date]-$rowData[card_expiry_month]-$rowData[card_expiry_year]</td>";
                                                echo "<td>".$rowData['payment_status']."</td>";
                                                echo "<td>".date_format(date_create($rowData['date_of_payment']), 'd M, Y h.i A') . "</td>";
                                        
                                                echo "</tr>"; 

                                                $count++;

                                                ?>
                                                

                                                    <!-- <div class="modal fade" id="modal<?php echo $rowData['user_id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <form method="POST" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle">Edit Product</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body g-3 row">
                                                                        <div class="col-sm-12 col-lg-12 col-md-12 mt-3">
                                                                            <label class="form-label">Order id</label>
                                                                            <input type="text" class="form-control" required name="order_id" title="Please enter order id" value="<?php echo $rowData['order_id'];?>">
                                                                        </div>
                                                                        <div class="col-sm-12 col-lg-12 col-md-12 mt-3">
                                                                            <label class="form-label">Amount</label>
                                                                            <input type="text" class="form-control" required name="amount" title="Please enter amount" value="<?php echo $rowData['amount'];?>">
                                                                        </div>

                                                                        <div class="col-sm-12 col-lg-6 col-md-6 mt-3">
                                                                            <label class="form-label">Payment_mode</label>
                                                                            <select class="form-control" id="validationCustom04" name="payment_mode" title="Please choose payment mode">
                                                                                <option value=" " <?php if($rowData['payment_mode']){echo 'selected';}?>>Online payment</option>
                                                                                <option value=" " <?php if(!$rowData['payment_mode']){echo 'selected';}?>>cash on delivery</option>
                                                                            </select>
                                                                        </div>

                                                                        <input type="hidden" name="id" value="<?php echo $rowData['user_id'];?>"> -->

                                                                        
                                                                    <!-- </div> -->
                                                                    <!-- <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" href="payment.php" class="btn btn-primary" name="update">Update</button>
                                                                    </div> -->
                                                                <!-- </form> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                            }
                                        }
                                    ?>
                                    </tbody>
                        </table>


                        <style>
                            table, td, th {
                                border: 1px solid #ddd;
                                text-align: left;
                            }

                            table {
                                border-collapse: collapse;
                                width: 100%;
                            }

                                th, td {
                                padding: 15px;
                            }
                        </style>
                        </div>
                    </div>

                </main>
            </div>
        </div>
    
<?php


    require_once './assets/pages/admin-footer.php';
?>
