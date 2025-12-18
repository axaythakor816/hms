        <?php
require_once '../../../core/init.php';
        
        ?>
        <div class="page-wrapper">
            <div class="content">
                <!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col-sm-12">
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Dashboard </a></li>
								<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
								<li class="breadcrumb-item active">Edit Profile</li>
							</ul>
						</div>
					</div>
				</div>
              
				<!-- /Page Header -->
                <form action="#" method="POST">
                    <div class="card-box">
                        <h3 class="card-title">Basic Informations</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="profile-img-wrap">
                                    <img class="inline-block" src="assets/img/user.jpg" alt="user">
                                    <div class="fileupload btn">
                                        <span class="btn-text">edit</span>
                                        <input name="img" class="upload" type="file">
                                    </div>
                                </div>
                                
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-block local-forms">
                                                <label class="focus-label">First Name</label>
                                                <input name="admin_name" type="text" class="form-control floating" value="<?php echo $_SESSION['first_name']?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-block local-forms">
                                                <label class="focus-label">Last Name</label>
                                                <input name="lname" type="text" class="form-control floating" value="<?php echo $_SESSION['last_name']?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-block local-forms ">
                                                <label class="focus-label">Birth Date</label>
                                                <div class="cal-icon">
                                                    <input name="dob" class="form-control floating datetimepicker" type="text" value="<?php echo $_SESSION['dob']?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-block local-forms">
												<label class="focus-label">Gendar</label>
												<select name="gender" class="form-control select">
													<option>Select  Gendar</option>
													<option value="male" >Male</option>
													<option value="female" selected>Female</option>
												 </select>
											</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-box">
                        <h3 class="card-title">Contact Informations</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-block local-forms">
                                    <label class="focus-label">Address</label>
                                    <input name="address" type="text" class="form-control floating" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-block local-forms">
                                    <label class="focus-label">Mobile Number</label>
                                    <input name="mnumber" type="mnumber" class="form-control floating" value="<?php echo $_SESSION['mobile_number']?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-block local-forms">
                                    <label class="focus-label">Email</label>
                                    <input name="email" type="text" class="form-control floating" value="<?php echo $_SESSION['email_id']?>">
                                </div>
                            </div>
                            
                    <div class="text-center ">
                        <button type="submit" name="update" class="btn btn-primary submit-btn mb-4" >Save</button>
                    </div>
                </form>
            </div>

        </div>
