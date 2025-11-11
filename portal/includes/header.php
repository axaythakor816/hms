<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from preclinic.dreamstechnologies.com/html/template/add-appointment.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Mar 2025 14:46:36 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png">
    <title>Karn - Hospital</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
	
	<!-- Fontawesome CSS -->
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
	
	<!-- Select2 CSS -->
	<link rel="stylesheet" type="text/css" href="../assets/css/select2.min.css">
	
	<!-- Datepicker CSS -->
	<link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.min.css">
	
	<!-- Feathericon CSS -->
	<link rel="stylesheet" href="../assets/css/feather.css">
	
	<!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
     
</head>

<body>
    <div class="main-wrapper">
        <div class="header">
			<div class="header-left">
				<a href="index.php" class="logo">
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
                    <a href="#" class="dropdown-toggle nav-link user-link" data-bs-toggle="dropdown">
						<div class="user-names">
							<h5>Axay</h5>
                        	<span>Admin</span>
						</div>
						<span class="user-img">
							<img  src="../assets/img/user-06.jpg"  alt="Admin">
						</span>
                    </a>
					
                </li>
				<li class="nav-item ">
                    <a href="settings.php"  class="hasnotifications nav-link"><img src="../assets/img/icons/setting-icon-01.svg" alt=""> </a>
                </li>
            </ul>          
        </div>
<?php
require_once('../layouts/admin_sidebar.php');
?>
