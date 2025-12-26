<?php
require_once '../../../core/init.php';

require_login();

// if(!has_permission('permissions', 'can_view')) {
// 	showalert("error", "Access Denine");
// 	exit;
// }

// require_role([1]);

?>
        <div class="page-wrapper">
            <div class="content">
			
                <div class="row">
                    <div class="col-sm-7 col-6">
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a class="nav-link" href="settings/settings.php">Settings </a></li>
							<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
							<li class="breadcrumb-item active">My Profile</li>
						</ul>
                    </div>
                   
                    <div class="col-sm-5 col-6 text-end m-b-30">
                        <a href="settings/edit-profile.php" class="btn btn-primary btn-rounded"><i class="fa fa-plus"></i> Edit Profile</a>
                    </div>
                </div>

                <div class="card-box profile-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-view">
                                <div class="profile-img-wrap">
                                    <div class="profile-img">
                                        <a href="#"><img class="avatar" src="../assets/img/user-06.jpg" alt=""></a>
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0"><?php echo ucfirst($_SESSION['first_name']); echo " "; echo ucfirst($_SESSION['last_name']);?></h3>
                                                
                                                <div class="staff-id">Employee ID : <?php echo $_SESSION['user_id'];?></div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <span class="title">Phone:</span>
                                                    <span class="text"><?php echo $_SESSION['mobile_number'];?></span>
                                                </li>
                                                <li>
                                                    <span class="title">Email:</span>
                                                    <span class="text"><?php echo $_SESSION['email_id'];?></span></a></span>
                                                </li>
                                                <li>
                                                    <span class="title">Birthday:</span>
                                                    <span class="text"><?php echo $_SESSION['dob'];?></span>
                                                </li>
                                                <li>
                                                    <span class="title">Address:</span>
                                                    <span class="text">xyz</span>
                                                </li>
                                                <li>
                                                    <span class="title">Gender:</span>
                                                    <span class="text"><?php echo $_SESSION['gender'];?></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>                        
                        </div>
                    </div>
                </div>
				
            </div>
      
        </div>
