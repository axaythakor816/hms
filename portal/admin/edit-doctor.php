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
								<li class="breadcrumb-item"><a href="doctors.php">Doctors </a></li>
								<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
								<li class="breadcrumb-item active">Edit Doctor</li>
							</ul>
						</div>
					</div>
				</div>

				<?php 
    			
				$id=$_GET['id'];
				$select="SELECT * FROM doctor WHERE id='$id'";
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
												<h4>Doctor Details</h4>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-4">  
											<div class="input-block local-forms">
												<label >First Name <span class="login-danger">*</span></label>
												<input value="<?php echo $row['dfname']?>" name="dfname" class="form-control" type="text" placeholder="" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-4">
											<div class="input-block local-forms">
												<label >Last Name <span class="login-danger">*</span></label>
												<input value="<?php echo $row['dlname']?>" name="dlname" class="form-control" type="text" placeholder="" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-4">
											<div class="input-block local-forms">
												<label >User Name <span class="login-danger">*</span></label>
												<input value="<?php echo $row['duname']?>" name="duname" class="form-control" type="text" placeholder="" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Mobile <span class="login-danger">*</span></label>
												<input value="<?php echo $row['dnumber']?>" name="dnumber" class="form-control" type="text" placeholder="" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Email <span class="login-danger">*</span></label>
												<input value="<?php echo $row['demail']?>" name="demail" class="form-control" type="email" placeholder="" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Password <span class="login-danger">*</span></label>
												<input value="<?php echo $row['dpassword']?>" name="dpassword" class="form-control" type="password" placeholder="" >
											</div>
										</div>
										<!--
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Confirm Password <span class="login-danger">*</span></label>
												<input class="form-control" type="password" placeholder="" >
											</div>
										</div>-->
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms cal-icon">
												<label >Date Of Birth  <span class="login-danger">*</span></label>
												<input value="<?php echo $row['ddob']?>" name="ddob" class="form-control datetimepicker" type="text"  placeholder="" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block select-gender">
												<label class="gen-label">Gender<span class="login-danger">*</span></label>
												<div class="form-check-inline">
													<label class="form-check-label">
														<input type="radio" value="Male" name="dgender" class="form-check-input mt-0">Male
													</label>
												</div>
												<div class="form-check-inline">
													<label class="form-check-label">
														<input type="radio" value="Female" name="dgender" class="form-check-input mt-0">Female
													</label>
												</div>
												<div class="form-check-inline">
													<label class="form-check-label">
														<input type="radio" value="other" name="dgender" class="form-check-input mt-0">other
													</label>
												</div>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-4">
											<div class="input-block local-forms">
												<label >Education <span class="login-danger">*</span></label>
												<input value="<?php echo $row['dedu']?>" name="dedu" class="form-control" type="text" placeholder="" >
											</div>
										</div>
										<!--
										<div class="col-12 col-md-6 col-xl-4">
											<div class="input-block local-forms">
												<label >Designation <span class="login-danger">*</span></label>
												<input class="form-control" type="text" placeholder="" >
											</div>
										</div>-->
										<div class="col-12 col-md-6 col-xl-4">
											<div class="input-block local-forms">
												<label >Department <span class="login-danger">*</span></label>
												<select  name="ddepart" class="form-control select">
												<option value="">Select Doctor </option>
											<option value="Orthopedist">Orthopedist</option>
											<option value="skin Specialist">skin Specialist</option>
											<option value="Psychology">Psychology</option>
											<option value="Neurologist">Neurologist</option>
											<option value="Dentist">Dentist</option>
											<option value="Cardiologist">Cardiologist</option>
											<option value="Gynecologist">Gynecologist</option>
											<option value="Neurologist">Neurologist</option>
												 
												  </select>
											</div>
										</div>
										<div class="col-12 col-sm-12">
											<div class="input-block local-forms">
												<label>Address  <span class="login-danger">*</span></label>
												<textarea  name="daddress" class="form-control" rows="3" cols="30"></textarea>
											</div>
										</div>
										<!--
										<div class="col-12 col-md-6 col-xl-3">
											<div class="input-block local-forms">
												<label >City <span class="login-danger">*</span></label>
												<select class="form-control select">
													<option>Select City</option>
													<option>Alaska</option>
													<option>Los Angeles</option>
												  </select>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-3">
											<div class="input-block local-forms">
												<label >Country  <span class="login-danger">*</span></label>
												<select class="form-control select">
													<option>Select Country </option>
													<option>Usa</option>
													<option>Uk</option>
													<option>Italy</option>
												  </select>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-3">
											<div class="input-block local-forms">
												<label >State/Province <span class="login-danger">*</span></label>
												<select class="form-control select">
													<option>Select State</option>
													<option>Alaska</option>
													<option>California</option>
												  </select>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-3">
											<div class="input-block local-forms">
												<label >Postal Code <span class="login-danger">*</span></label>
												<input class="form-control" type="text" placeholder="" >
											</div>
										</div>
										<div class="col-12 col-sm-12">
											<div class="input-block local-forms">
												<label>Start Biography  <span class="login-danger">*</span></label>
												<textarea class="form-control" rows="3" cols="30"></textarea>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-top-form">
												<label class="local-top">Avatar <span class="login-danger">*</span></label>
												<div class="settings-btn upload-files-avator">
													<input type="file" accept="image/*" name="image" id="file" onchange="if (!window.__cfRLUnblockHandlers) return false; loadFile(event)" class="hide-input" data-cf-modified-3361286fab073aa18b96d427-="">
													<label for="file" class="upload">Choose File</label>
												</div>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block select-gender">
												<label class="gen-label">Status <span class="login-danger">*</span></label>
												<div class="form-check-inline">
													<label class="form-check-label">
														<input type="radio" name="gender" class="form-check-input mt-0">Active
													</label>
												</div>
												<div class="form-check-inline">
													<label class="form-check-label">
														<input type="radio" name="gender" class="form-check-input mt-0">In Active
													</label>
												</div>
											</div>
										</div>-->
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
                                    $dfname=$_POST['dfname'];
									$dlname=$_POST['dlname'];
									$duname=$_POST['duname'];
                                    $dnumber=$_POST['dnumber'];
                                    $demail=$_POST['demail'];
									$dpassword=$_POST['dpassword'];
                
                                    $ddob=$_POST['ddob'];
                                    $dgender=$_POST['dgender'];
                                    $dedu=$_POST['dedu'];
                                    $ddepart=$_POST['ddepart'];
									$daddress=$_POST['daddress'];


                                $update="UPDATE doctor SET dfname='$dfname',dlname='$dlname', duname='$duname',dnumber='$dnumber',demail='$demail',dpassword='$dpassword',ddob='$ddob',dgender='$dgender',dedu='$dedu',ddepart='$ddepart',daddress='$daddress' WHERE id='$id'";

								
                                $data=mysqli_query($conn,$update);
                                if($data){
                                    ?>
                                    <script type="text/javascript">
                                        alert("data update successfully");
                                        window.open("doctors.php","_self");
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