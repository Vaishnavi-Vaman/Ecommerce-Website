<?php
    session_start();

    if(empty($_SESSION['is_admin_login'])){
        echo "<script>location.href='index.php';</script>";
    }

    require_once '../include/connection.php';
    require_once './assets/pages/admin-link.php';
    require_once './assets/pages/admin-header.php';


    if(isset($_POST['update'])){ 
        $id=$_REQUEST['id'];
        $status=$_REQUEST['status'];


        $update="UPDATE order_master SET 
        order_status='".$status."' where order_id='".$id."'";
            
            if(mysqli_query($conn, $update )){

                echo "<script>iqwerty.toast.toast('Order updated successfully.');</script>";     
            }
            else{

                echo "<script>iqwerty.toast.toast('Unable to update order.');</script>";
            }

    }

?>
    

        <div id="layoutSidenav">
            <?php

                require_once './assets/pages/admin-sidebar.php';
            ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid p-4">
                        <div class="row">
                            <div class="col-9">
                                <h3 class="mb-3">Manage Orders</h1>
                            </div>
                

                        <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Order No</th>
                                            <th>User Name</th>
                                            <th>User Phone</th>
                                            <th>Payment Status</th>
                                            <th>Order Status</th>
                                            <th>Order Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $resData = mysqli_query($conn, "SELECT om.order_id, om.transaction_id,om.order_status,om.order_date,um.user_name,
                                        um.user_phone_number, pm.payment_status FROM order_master om,user_master um, payment_master pm WHERE om.user_id=um.user_id AND pm.transaction_id = om.transaction_id");
                                        if (mysqli_num_rows($resData) > 0) {

                                            $count = 1;
                                            while($rowData = mysqli_fetch_assoc($resData)) {
                                                
                                                echo "<tr>"; 
                                                echo "<th>".$count."</th>";
                                                echo "<td>#".$rowData['transaction_id']."</td>"; 
                                                echo "<td>".$rowData['user_name']."</td>";
                                                echo "<td>".$rowData['user_phone_number']."</td>";
                                                echo "<td>".$rowData['payment_status']."</td>";
                                                echo "<td>".$rowData['order_status']."</td>";

                                                echo "<td>".date_format(date_create($rowData['order_date']), 'd M, Y h.i a') . "</td>";
                                                echo "<td>";
                                                ?>
                                                <form method="POST">
                                                    <a href="view-order.php?source=<?php echo $rowData['transaction_id'];?>"><i class='fa fa-eye'></i></a> | 
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal<?php echo $rowData['order_id'];?>"><i class='fa fa-truck'></i></a>
                                                    <input type="hidden" name="did" value="<?php echo $rowData['order_id'];?>"/>
                                                </form>
                                                <?php
                                                echo "</td>";
                                                echo "</tr>"; 

                                                $count++;

                                                ?>
                                                

                                                    <div class="modal fade" id="modal<?php echo $rowData['order_id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <form method="POST" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle">Update Order Status</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body g-3 row">
                                                                        
                                                                        <input type="hidden" name="id" value="<?php echo $rowData['order_id'];?>">

                                                                        <div class="col-sm-12 col-lg-12 col-md-12 mt-3">
                                                                            <label class="form-label">Status</label>
                                                                            <select class="form-control" id="validationCustom04" name="status" title="Please choose status">
                                                                                <option value="Order Placed" <?php if($rowData['order_status']=='Order Placed'){echo 'selected';}?>>Order Placed</option>
                                                                                <option value="Order Shipped" <?php if($rowData['order_status']=='Order Shipped'){echo 'selected';}?>>Order Shipped</option>
                                                                                <option value="Order Delivered" <?php if($rowData['order_status']=='Order Delivered'){echo 'selected';}?>>Order Delivered</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" href="order.php" class="btn btn-primary" name="update">Update</button>
                                                                    </div>
                                                                </form>
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
                

                </main>
            </div>
        </div>
    
<?php


    require_once './assets/pages/admin-footer.php';
?>
