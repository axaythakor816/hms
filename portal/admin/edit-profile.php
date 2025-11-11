<?php
require_once('includes/auth_check.php');
require_once('includes/header.php');
require_once('includes/sidebar.php');
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
                <?php 
    		
				$id=$_GET['id'];
				$select="SELECT * FROM admin WHERE id='$id'";
				$data=mysqli_query($conn,$select);
				$row=mysqli_fetch_array($data);

				?>
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
                                                <input name="admin_name" type="text" class="form-control floating" value="<?php echo $row['admin_name']?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-block local-forms">
                                                <label class="focus-label">Last Name</label>
                                                <input name="lname" type="text" class="form-control floating" value="<?php echo $row['lname']?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-block local-forms ">
                                                <label class="focus-label">Birth Date</label>
                                                <div class="cal-icon">
                                                    <input name="dob" class="form-control floating datetimepicker" type="text" value="<?php echo $row['dob']?>">
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
                                    <input name="address" type="text" class="form-control floating" value="<?php echo $row['address']?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-block local-forms">
                                    <label class="focus-label">Mobile Number</label>
                                    <input name="mnumber" type="mnumber" class="form-control floating" value="<?php echo $row['mnumber']?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-block local-forms">
                                    <label class="focus-label">Email</label>
                                    <input name="email" type="text" class="form-control floating" value="<?php echo $row['email']?>">
                                </div>
                            </div>
                            
                    <div class="text-center ">
                        <button type="submit" name="update" class="btn btn-primary submit-btn mb-4" >Save</button>
                    </div>
                </form>
                <?php
                                if (isset($_POST['update']))
                                {
                                    $admin_name=$_POST['admin_name'];
									$lname=$_POST['lname'];
                                    $dob=$_POST['dob'];
									$gender=$_POST['gender'];
                                    $address=$_POST['address'];
                                    $mnumber=$_POST['mnumber'];
									$email=$_POST['email'];
                


                                $update="UPDATE admin SET admin_name='$admin_name',lname='$lname',dob='$dob', gender='$gender',address='$address',mnumber='$mnumber',email='$email' WHERE id='$id'";

								
                                $data=mysqli_query($conn,$update);
                                if($data){
                                    ?>
                                    <script type="text/javascript">
                                        alert("data update successfully");
                                        window.open("profile.php","_self");
                                    </script>
                                    <?php
                                }else{
                                    ?>
                                    <script type="text/javascript">
                                        alert("please try again");
                                    </script>
                                    <?php
                                }
                            }
							?>


            </div>

        </div>
<?php 
require_once('includes/footer.php');
?>