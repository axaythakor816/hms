<?php
require_once('includes/auth_check.php');
require_once('includes/header.php');
require_once('includes/sidebar.php');
?>
        <div class="page-wrapper">
            <div class="content">
			
                <div class="row">
                    <div class="col-sm-7 col-6">
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="index.html">Dashboard </a></li>
							<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
							<li class="breadcrumb-item active">My Profile</li>
						</ul>
                    </div>
                   
                    <div class="col-sm-5 col-6 text-end m-b-30">
                        <a href="edit-profile.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-rounded"><i class="fa fa-plus"></i> Edit Profile</a>
                       
                    </div>
                </div>

                <div class="card-box profile-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-view">
                                <div class="profile-img-wrap">
                                    <div class="profile-img">
                                        <a href="#"><img class="avatar" src="assets/img/user-06.jpg" alt=""></a>
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0"><?php echo $row['admin_name']; echo " "; echo $row['lname'];?></h3>
                                                
                                                <div class="staff-id">Employee ID : <?php echo $row['id'];?></div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <span class="title">Phone:</span>
                                                    <span class="text"><?php echo $row['mnumber'];?></span>
                                                </li>
                                                <li>
                                                    <span class="title">Email:</span>
                                                    <span class="text"><?php echo $row['email'];?></span></a></span>
                                                </li>
                                                <li>
                                                    <span class="title">Birthday:</span>
                                                    <span class="text"><?php echo $row['dob'];?></span>
                                                </li>
                                                <li>
                                                    <span class="title">Address:</span>
                                                    <span class="text"><?php echo $row['address'];?></span>
                                                </li>
                                                <li>
                                                    <span class="title">Gender:</span>
                                                    <span class="text"><?php echo $row['gender'];?></span>
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
<?php 
require_once('includes/footer.php');
?>