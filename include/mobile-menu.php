<div class="menu-mobile">

	<ul class="main-menu-m">
		<li>
			<a href="index.php">Home</a>
		</li>

		<li>
			<a href="shop.php">Shop</a>
		</li>
		<li>
			<a href="customize.php">Customize</a>
		</li>
		<?php
		if (!empty($_SESSION['isLogin'])) {
			echo "<li>
						<a href='profile.php'>Accounts</a>
						<ul class='sub-menu-m'>
						<li><a href='orders.php'>Shopping</a></li>
						<li><a href='customize-orders.php'>Order</a></li>
							<li><a href='profile.php'>Profile</a></li>
							<li><a href='settings.php'>Settings</a></li>
							<li><a href='include/logout.php'>Logout</a></li>
						</ul>
						<span class='arrow-main-menu-m'>
							<i class='fa fa-angle-right' aria-hidden='true'></i>
						</span>
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
			<a href="contact.php">Contact Us</a>
		</li>
	</ul>
</div>