<?php
    session_start();

    if(empty($_SESSION['is_admin_login'])){
        echo "<script>location.href='index.php';</script>";
    }

    require_once '../include/connection.php';
    require_once './assets/pages/admin-link.php';
    require_once './assets/pages/admin-header.php';

    $total = 0;

    if(!empty($_GET['source'])){

        $transaction_id = $_GET['source'];

        $resOrder = mysqli_query($conn, "SELECT * from order_master WHERE transaction_id = '$transaction_id'");
        if(mysqli_num_rows($resOrder)>0){

            $resOrder = mysqli_fetch_assoc($resOrder);
        }else{

            echo "<script>alert('Unable to process!');location.href='order.php';</script>";
        }
    } else{

        echo "<script>alert('Unable to process!');location.href='order.php';</script>";
    }

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

                        <div class="row mt-4">
								<div class="col-6">
									<h5>Order No. #<?php echo $resOrder['transaction_id'];?></h5>
								</div>
								<div class="col-6 text-end">
									<span><?php echo date_format(date_create($resOrder['order_date']), 'd M Y h:i A');?></span>
								</div>
							</div>
							
							<div class="row mt-5">
								<div class="col-6">
									<?php $resCustomer = mysqli_query($conn, "SELECT * FROM user_master WHERE user_id = '$resOrder[user_id]'"); if(mysqli_num_rows($resCustomer)>0){ $resCustomer = mysqli_fetch_assoc($resCustomer);?>
									<span><?php echo $resCustomer['user_name'];?></span><br> <span>+91 <?php echo $resCustomer['user_phone_number'];?><br></span><span><?php echo $resCustomer['address_line_1'];?>, <br><?php echo $resCustomer['address_line_2'];?>, <br><?php echo $resCustomer['city'];?><br>PIN: <?php echo $resCustomer['pin_code'];?></span>
									<?php }?>
								</div>
								<div class="col-6 text-end">
									<span class="h5"><?php echo 'Coser';?></span><br> <span id="details">Shastha nagar (po)</span><br>Mogral puthur, kasaragod<br>PIN: 671121
								</div>
							</div>

							<div class="row mt-5 table-responsive">
								<table class="table table-hover">
									<tr class="table-dark">
										<th>SL.NO</th>
										<th>Product</th>
										<th>Price</th>
										<th>Quantity</th>
										<th>Total</th>
									</tr>

									<?php
										$resProduct = mysqli_query($conn, "SELECT pm.*, tm.* FROM product_master pm, order_temp tm WHERE pm.product_id = tm.product_id AND tm.transaction_id = '$resOrder[transaction_id]'");
										if(mysqli_num_rows($resProduct)>0){
											
											echo "<div class='pricing'>";
											$finalPrice = 0;
											$count = 1;
											
											while($rowProduct = mysqli_fetch_assoc($resProduct)){

												$amount = $rowProduct['product_price'] * $rowProduct['product_quantity'];
												$total+=$amount;

												echo "<tr>";
												echo "<td>$count</td>";
												echo "<td>$rowProduct[product_name]</td>";
												echo "<td>".number_format($rowProduct['product_price'], 2)."</td>";
												echo "<td>$rowProduct[product_quantity]</td>";
												echo "<td>".number_format($amount, 2)."</td>";
												echo "</tr>";
												$count++;
											}
										}
									?>									
								</table>
							</div>

							<div class="row p-4">
								<div class="col-12 text-end">
										<h5>Grand Total: <?php echo number_format($total, 2);?></h5>
								</div>
							</div>
                

                        
                

                </main>
            </div>
        </div>
    
<?php


    require_once './assets/pages/admin-footer.php';
?>
