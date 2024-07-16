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


							<div class="row mt-5 table-responsive">
								<table class="table table-hover">
									<tr class="table-dark">
										<th>SL.NO</th>
										<th>Product</th>
										<th>Price</th>
										<th>Quantity</th>
										<th>User Image</th>
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
												echo "<td><a href='assets/images/user-image/$rowProduct[user_image]' download>Download</a></td>";
												echo "</tr>";
												$count++;
											}
										}
									?>									
								</table>
							</div>
                

                        
                

                </main>
            </div>
        </div>
    
<?php


    require_once './assets/pages/admin-footer.php';
?>
