
<div class="wrap-icon-header flex-w flex-r-m">
	
<ul class="main-menu">

<li class="active-menu">
	<a href="settings.php" 'active'>Setting </a>
	</li>
	</ul>	
	<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
		<i class="zmdi zmdi-search"></i>
	</div>

	<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="<?php if (!empty($_SESSION['cart_item'])) {echo sizeof($_SESSION['cart_item']);} else {echo "0";}?>">
		<i class="zmdi zmdi-shopping-cart"></i>
	</div>
</div>