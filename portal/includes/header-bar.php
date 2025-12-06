<div class="main-wrapper">
	<!-- Preloader -->
	<div id="preloader">
		<div class="ecg-loader"></div>
	</div>


	<div class="header">
		<div class="header-left">
			<a href="home.php" class="nav-link logo">
				<img src="../assets/img/logo.png" width="35" height="35" alt=""> <span>Karn Hospital</span>
			</a>
		</div>
		<a id="toggle_btn" href="javascript:void(0);"><img src="../assets/img/icons/bar-icon.svg"  alt=""></a>
		<a id="mobile_btn" class="mobile_btn float-start" href="#sidebar"><img src="../assets/img/icons/bar-icon.svg"  alt=""></a>
		<div class="top-nav-search mob-view">
			<form>
				<input type="text" class="form-control" placeholder="Search here">
				<a class="btn" ><img src="../assets/img/icons/search-normal.svg" alt=""></a>
			</form>
		</div>
		<ul class="nav user-menu float-end">
			<li class="nav-item dropdown has-arrow user-profile-list">
				<a href="settings/profile.php" class="dropdown-toggle nav-link user-link" data-bs-toggle="dropdown">
					<div class="user-names">
						<h5><?php echo ucwords($_SESSION['first_name']); ?></h5>
						<span>Admin</span>
					</div>
					<span class="user-img">
						<img  src="../assets/img/user-06.jpg"  alt="Admin">
					</span>
				</a>
				
			</li>
			<li class="nav-item ">
				<a href="settings/settings.php"  class="hasnotifications nav-link"><img src="../assets/img/icons/setting-icon-01.svg" alt=""> </a>
			</li>
		</ul>          
	</div>
        
<?php
require_once('sidebar.php');
?>