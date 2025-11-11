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
								<li class="breadcrumb-item"><a href="patients.php">Patients </a></li>
								<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
								<li class="breadcrumb-item active">Edit Patient</li>
							</ul>
						</div>
					</div>
				</div>
				<?php 
    			
				$id=$_GET['id'];
				$select="SELECT * FROM patient WHERE id='$id'";
				$data=mysqli_query($conn,$select);
				$row=mysqli_fetch_array($data);

				?>
				<!-- /Page Header -->
				<div class="row">
					<div class="col-sm-12">
					
						<div class="card">
						<div class="card-body">
								<form action="#" method="POST">
									<div class="row">
										<div class="col-12">
											<div class="form-heading">
												<h4>Update Patinets Details</h4>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-4">  
											<div class="input-block local-forms">
												<label >First Name <span class="login-danger">*</span></label>
												<input value="<?php echo $row['fname']?>" name="fname" class="form-control" type="text" placeholder="" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-4">
											<div class="input-block local-forms">
												<label >Last Name <span class="login-danger">*</span></label>
												<input value="<?php echo $row['lname']?>" name="lname" class="form-control" type="text" placeholder="" >
											</div>
										</div>
                                        <div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms cal-icon">
												<label >Admit Date <span class="login-danger">*</span></label>
												<input value="<?php echo $row['admit']?>" name="admit" class="form-control datetimepicker" type="text"  placeholder="" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-4">
											<div class="input-block local-forms">
												<label >User Name <span class="login-danger">*</span></label>
												<input value="<?php echo $row['uname']?>" name="uname" class="form-control" type="text" placeholder="" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Mobile <span class="login-danger">*</span></label>
												<input value="<?php echo $row['number']?>" name="number" class="form-control" type="text" placeholder="" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Email <span class="login-danger">*</span></label>
												<input value="<?php echo $row['email']?>" name="email" class="form-control" type="email" placeholder="" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Password <span class="login-danger">*</span></label>
												<input value="<?php echo $row['password']?>" name="password" class="form-control" type="password" placeholder="" >
											</div>
										</div>
										
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms cal-icon">
												<label >Date Of Birth  <span class="login-danger">*</span></label>
												<input value="<?php echo $row['dob']?>" name="dob" class="form-control datetimepicker" type="text"  placeholder="" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block select-gender">
												<label class="gen-label">Gender<span class="login-danger">*</span></label>
												<div class="form-check-inline">
													<label class="form-check-label">
														<input type="radio" value="male" name="gender" class="form-check-input">Male
													</label>
												</div>
												<div class="form-check-inline">
													<label class="form-check-label">
														<input type="radio" value="male" name="gender" class="form-check-input">Female
													</label>
												</div>
											</div>
										</div>

										<div class="col-12 col-md-6 col-xl-4">
											<div class="input-block local-forms">
												<label >Select Status <span class="login-danger">*</span></label>
												<select name="status" class="form-control select">
												<option value="">Select Status</option>
													<option value="Admit">Admit</option>
											<option value="Descharge">Descharge</option>
											
												  </select>
											</div>
										</div>
									
										<div class="col-12 col-md-6 col-xl-4">
											<div class="input-block local-forms">
												<label >Department And Doctor <span class="login-danger">*</span></label>
												<select name="doctor" class="form-control select">

												<option value="">Department And Doctor</option>
											<option value="skin Specialist - Madeleine - Smith">skin Specialist - Madeleine - Smith</option>
											<option value="Psychology - Savannah Smith">Psychology - Savannah Smith</option>
											<option value="Neurologist - smith Johnsonh">Neurologist - smith Johnsonh</option>
											<option value="Dentist - Bella Smith">Dentist - Bella Smith</option>
											<option value="Cardiologist - John Smith">Cardiologist - John Smith</option>
											<option value="Gynecologist - Ana Smith">Gynecologist - Ana Smith</option>
											<option value="Neurologist - James Williams">Neurologist - James Williams</option>
												  </select>
											</div>
										</div>
										<div class="col-12 col-sm-12">
											<div class="input-block local-forms">
												<label>Address  <span class="login-danger">*</span></label>
												<textarea name="address" class="form-control" rows="3" cols="30"></textarea>
											</div>
										</div>
										
										</div>
										<div class="col-12">
											<div class="doctor-submit text-end">
												<button type="submit" name="update" class="btn btn-primary submit-form me-2">Submit</button>
												
											</div>
										</div>
									</div>
								</form>
								<?php
                                if (isset($_POST['update']))
                                {
                                    $fname=$_POST['fname'];
									$lname=$_POST['lname'];
                                    $admit=$_POST['admit'];
									$uname=$_POST['uname'];
                                    $number=$_POST['number'];
                                    $email=$_POST['email'];
									$password=$_POST['password'];
                
                                    $dob=$_POST['dob'];
                                    $gender=$_POST['gender'];
									$status=$_POST['status'];
                                    $doctor=$_POST['doctor'];
                                    
									$address=$_POST['address'];


                                $update="UPDATE patient SET fname='$fname',lname='$lname',admit='$admit', uname='$uname',number='$number',email='$email',password='$password',dob='$dob',gender='$gender',status='$status',doctor='$doctor',address='$address' WHERE id='$id'";

								
                                $data=mysqli_query($conn,$update);
                                if($data){
                                    ?>
                                    <script type="text/javascript">
                                        alert("data update successfully");
                                        window.open("patients.php","_self");
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
					</div>					
				</div>
            </div>
     
        </div>
		<div id="delete_patient" class="modal fade delete-modal" role="dialog">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-body text-center">
						<img src="assets/img/sent.png" alt="" width="50" height="46">
						<h3>Are you sure want to delete this ?</h3>
						<div class="m-t-20"> <a href="#" class="btn btn-white" data-bs-dismiss="modal">Close</a>
							<button type="submit" class="btn btn-danger">Delete</button>
						</div>
					</div>
				</div>
			</div>
			
		</div>
<?php 
require_once('includes/footer.php');
?>