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
								<li class="breadcrumb-item active">Doctors List</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				
				<div class="row">
					<div class="col-sm-12">
					
						<div class="card card-table show-entire">
							<div class="card-body">
							
								<!-- Table Header -->
								<div class="page-table-header mb-2">
									<div class="row align-items-center">
										<div class="col">
											<div class="doctor-table-blk">
												<h3>Doctors List</h3>
												<div class="doctor-search-blk">
													<div class="top-nav-search table-search-blk">
														<form>
															<input type="text" class="form-control" placeholder="Search here">
															<a class="btn"><img src="assets/img/icons/search-normal.svg" alt=""></a>
														</form>
													</div>
													<div class="add-group">
														<a href="javascript:;" data-bs-toggle="modal" data-bs-target="#addDoctorModal" class="btn btn-primary add-pluss ms-2"><img src="assets/img/icons/plus.svg" alt=""></a>
														<a href="javascript:;" class="btn btn-primary doctor-refresh ms-2"><img src="assets/img/icons/re-fresh.svg" alt=""></a>
													</div>
												</div>
											</div>
										</div>
										<div class="col-auto text-end float-end ms-auto download-grp">
											<a href="javascript:;" class=" me-2"><img src="assets/img/icons/pdf-icon-01.svg" alt=""></a>
											<a href="javascript:;" class=" me-2"><img src="assets/img/icons/pdf-icon-02.svg" alt=""></a>
											<a href="javascript:;" class=" me-2"><img src="assets/img/icons/pdf-icon-03.svg" alt=""></a>
											<a href="javascript:;" ><img src="assets/img/icons/pdf-icon-04.svg" alt=""></a>
											
										</div>
									</div>
								</div>
								<!-- /Table Header -->
								
								<div class="table-responsive">
									<table class="table border-0 custom-table comman-table datatable mb-0">
										<thead>
											<tr>
												<th>
													<div class="form-check check-tables">
														<input class="form-check-input" type="checkbox" value="something">
													</div>
												</th>
												<th>Sr_No</th>
												<th>Name</th>
												<th>Mobile</th>
												<th>Email</th>
												<th>Date Of Birth</th>
												<th>Gender</th>
												<th>Degree</th>
												<th>Department</th>
												
												<th>Address</th>
												<th ></th>
											</tr>
										</thead>
										<tbody>
												
										<?php
										 
										
											$query="SELECT * FROM doctor";
											$data=mysqli_query($conn,$query);
											$result=mysqli_num_rows($data);
											if($result){
                                                $sr=1;

												while($row=mysqli_fetch_array($data)){
													?>
                                            <tr>
												<td>
													<div class="form-check check-tables">
														<input class="form-check-input" type="checkbox" value="something">
													</div>
												</td>

												<td><?php echo $sr; ?></td>
												<td><?php echo $row['dfname'], $row['dlname']; ?></td>
												<td><?php echo $row['dnumber']; ?></td>
												<td><?php echo $row['demail']; ?></td>
												<td><?php echo $row['ddob']; ?></td>
												<td><?php echo $row['dgender']; ?></td>
												<td><?php echo $row['dedu']; ?></td>
												<td><?php echo $row['ddepart']; ?></td>
												<td><?php echo $row['daddress']; ?></td>
												
												
											
												<td class="text-end">
													
														
														
															<a class="dropdown-item" href="edit-doctor.php?id=<?php echo $row['id']; ?>"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                                                            
													
												</td>
                                                <td class="text-end">
                                                <a class="dropdown-item" onclick="return confirm('Are You sure, you want to delete?')" href="delete-doctor.php?id=<?php echo $row['id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
															
                                                </td>
											</tr>
											<?php
                                            $sr++;
												}	
											}else{
                                                echo"No Record Found" ;
                                            }
												?>
											
										</tbody>
									</table>
								</div>
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
		<!-- Add Doctor Modal -->
		<div class="modal fade" id="addDoctorModal" tabindex="-1" aria-labelledby="addDoctorLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg"> <!-- modal-xl for large form -->
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addDoctorLabel">Add New Doctor</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											
					</div>

					<div class="modal-body">
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
												<input name="dfname" class="form-control" type="text" placeholder="" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-4">
											<div class="input-block local-forms">
												<label >Last Name <span class="login-danger">*</span></label>
												<input name="dlname" class="form-control" type="text" placeholder="" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-4">
											<div class="input-block local-forms">
												<label >User Name <span class="login-danger">*</span></label>
												<input name="duname" class="form-control" type="text" placeholder="" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Mobile <span class="login-danger">*</span></label>
												<input name="dnumber" class="form-control" type="text" placeholder="" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Email <span class="login-danger">*</span></label>
												<input name="demail" class="form-control" type="email" placeholder="" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Password <span class="login-danger">*</span></label>
												<input name="dpassword" class="form-control" type="password" placeholder="" >
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
												<input name="ddob" class="form-control datetimepicker" type="text"  placeholder="" >
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
												<input name="dedu" class="form-control" type="text" placeholder="" >
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
												<select name="ddepart" class="form-control select">
													<option value="">Select Department</option>
													<option value="Orthopedist">Orthopedist</option>
													<option value="Skin Specialist">Skin Specialist</option>
													<option value="Psychology">Psychology</option>
													<option value="Neurologist">Neurologist</option>
													<option value="Dentist">Dentist</option>
													<option value="Cardiologist">Cardiologist</option>
													<option value="Gynecologist">Gynecologist</option>
												</select>

											</div>
										</div>
										<div class="col-12 col-sm-12">
											<div class="input-block local-forms">
												<label>Address  <span class="login-danger">*</span></label>
												<textarea name="daddress" class="form-control" rows="3" cols="30"></textarea>
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
												<button type="submit" name="sub" class="btn btn-primary submit-form me-2">Submit</button>
												
											</div>
										</div>
									</div>
								</form>
					</div>
				</div>
			</div>
		</div>

<?php 
require_once('includes/footer.php');
?>