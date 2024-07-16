	<div class="wrap-header-cart js-panel-cart">
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-65 p-r-25">
			<div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					Your Cart
				</span>

				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>

			<div class="header-cart-content flex-w js-pscroll">

				<?php

				if (!empty($_SESSION['cart_item'])) {
					$total = 0;
				?>

					<ul class="header-cart-wrapitem w-full">
						<?php

						foreach ($_SESSION['cart_item'] as $item) {

							$total += ($item['productPrice'] * $item['productQuantity']);

						?>
							<li class="header-cart-item flex-w flex-t m-b-12">
								<div class="header-cart-item-img">
									<img src="admin/assets/images/products/<?php echo $item['productImage']; ?>" alt="IMG">
								</div>

								<div class="header-cart-item-txt p-t-8">
									<a href="product-detail.php?source=<?php echo $item['productId']; ?>" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
										<?php echo $item['productName']." - ".$item['productSize']; ?>
									</a>

									<span class="header-cart-item-info">
										<?php echo $item['productQuantity']; ?> x <?php echo number_format($item['productPrice'], 2); ?>
									</span>
								</div>
							</li>
						<?php
						}
						?>
					</ul>

					<div class="w-full">
						<div class="header-cart-total w-full p-tb-40">
							Total: Rs <?php echo number_format($total, 2); ?>
						</div>

						<div class="header-cart-buttons flex-w w-full">

							<a href="checkout.php" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
								Check Out
							</a>
						</div>
					</div>

				<?php

				}  else {
					echo "Your shopping cart empty.";
				}
				?>
			</div>
		</div>
	</div>