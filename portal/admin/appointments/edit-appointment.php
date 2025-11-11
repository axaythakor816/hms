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
								<li class="breadcrumb-item"><a href="appointments.php">Appointment </a></li>
								<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
								<li class="breadcrumb-item active">Edit Appointment</li>
							</ul>
						</div>
					</div>
				</div>

                <?php
                   
                    $id=$_GET['id'];
                    $select="SELECT * FROM appointment WHERE id='$id'";
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
												<h4>Update Patient Details</h4>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-4">  
											<div class="input-block local-forms">
												<label >Full Name <span class="login-danger">*</span></label>
												<input value="<?php echo $row['name']?>" class="form-control" name="name" type="text" >
											</div>
										</div>
										
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Select Gender <span class="login-danger">*</span></label>
												<select class="form-control select" value="<?php echo $row['gender']?>" name="gender">
                                                <option value="">Select Gender </option>
											    <option value="male">Male</option>
				                                <option value="female">Female</option>
				                                <option value="other">Other</option>
												  </select>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Mobile <span class="login-danger">*</span></label>
												<input class="form-control" value="<?php echo $row['number']?>" type="text" name="number" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Email <span class="login-danger">*</span></label>
												<input class="form-control" value="<?php echo $row['email']?>" type="email" name="email" >
											</div>
										</div>
										<div class="col-12 col-sm-12">
											<div class="input-block local-forms">
												<label>Address  <span class="login-danger">*</span></label>
												<textarea class="form-control" rows="3" value="<?php echo $row['address']?>" cols="30" name="address"></textarea>
											</div>
										</div>
										<div class="col-12">
											<div class="form-heading">
												<h4>Update Appointment Details</h4>
											</div>
										</div>

                                        <div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >select Doctor <span class="login-danger">*</span></label>
												<select value="<?php echo $row['doctor']?>" class="form-control select" name="doctor">
                                                <option value="">Select Doctor </option>
											<option value="Orthopedist - Henry Jones">Orthopedist - Henry Jones</option>
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

										<div class="col-12 col-md-6 col-xl-4">
											<div class="input-block local-forms cal-icon">
												<label >Date of Appointment <span class="login-danger">*</span></label>
												<input value="<?php echo $row['date']?>" class="form-control datetimepicker" type="text" name="date"  >
											</div>
										</div>
										
										<div class="col-12 col-sm-12">
											<div class="input-block local-forms">
												<label>Notes  <span class="login-danger">*</span></label>
												<textarea value="<?php echo $row['note']?>" class="form-control" rows="3" cols="30" name="note"></textarea>
											</div>
										</div>
										
										<div class="col-12">
											<div class="doctor-submit text-end">
												<button type="submit" name="update" class="btn btn-primary submit-form me-2">Update</button>
												
											</div>
										</div>
									</div>
								</form>


                                <?php
                                if (isset($_POST['update']))
                                {
                                    $name=$_POST['name'];
                                    $gender=$_POST['gender'];
                                    $number=$_POST['number'];
                                    $email=$_POST['email'];
                                    $address=$_POST['address'];
                                    $doctor=$_POST['doctor'];
                                    $date=$_POST['date'];
                                    $note=$_POST['note'];

                                $update="UPDATE appointment SET name='$name',gender='$gender', number='$number',email='$email',address='$address',doctor='$doctor',date='$date',note='$note' WHERE id='$id'";
                                $data=mysqli_query($conn,$update);
                                if($data){
                                    ?>
                                    <script type="text/javascript">
                                        alert("data update successfully");
                                        window.open("appointments.php","_self");
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