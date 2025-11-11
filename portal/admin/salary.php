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
								<li class="breadcrumb-item"><a href="salary.php">Payroll </a></li>
								<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
								<li class="breadcrumb-item active">Empoyee Salary</li>
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
												<h3>Empoyee Salary</h3>
												<div class="doctor-search-blk">
													<div class="top-nav-search table-search-blk">
														<form>
															<input type="text" class="form-control" placeholder="Search here">
															<a class="btn"><img src="assets/img/icons/search-normal.svg" alt=""></a>
														</form>
													</div>
													<div class="add-group">
														<a href="add-salary.php" class="btn btn-primary add-pluss ms-2"><img src="assets/img/icons/plus.svg" alt=""></a>
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
								<div class="staff-search-table">
									<form>
										<div class="row">
											<div class="col-12 col-md-6 col-xl-4">  
												<div class="input-block local-forms">
													<label >Employee Name </label>
													<input class="form-control" type="text"  >
												</div>
											</div>
											<div class="col-12 col-md-6 col-xl-4">
												<div class="input-block local-forms">
													<label >Role </label>
													<select class="form-control select">
														<option>Select Role</option>
														<option>Accountant</option>
														<option>Nurse</option>
														<option>Pharmacist	</option>
													  </select>
												</div>
											</div>
											<div class="col-12 col-md-6 col-xl-4">
												<div class="input-block local-forms">
													<label >Leave Status </label>
													<select class="form-control select">
														<option>Select Leave Status</option>
														<option>Pending</option>
														<option>Approved</option>
														<option>Rejected</option>
													  </select>
												</div>
											</div>
											<div class="col-12 col-md-6 col-xl-4">
												<div class="input-block local-forms cal-icon">
													<label >From </label>
													<input class="form-control datetimepicker" type="text"   >
												</div>
											</div>
											<div class="col-12 col-md-6 col-xl-4">
												<div class="input-block local-forms cal-icon">
													<label >To </label>
													<input class="form-control datetimepicker" type="text"   >
												</div>
											</div>
											<div class="col-12 col-md-6 col-xl-4">
												<div class="doctor-submit">
													<button type="submit" class="btn btn-primary submit-list-form me-2">Search</button>
												</div>
											</div>
										</div>
									</form>
								</div>
								
								<div class="table-responsive">
									<table class="table border-0 custom-table comman-table datatable mb-0">
										<thead>
											<tr>
												<th>
													<div class="form-check check-tables">
														<input class="form-check-input" type="checkbox" value="something">
													</div>
												</th>
												<th>Employee ID</th>
												<th>Employee Name</th>
												<th>Email</th>
												<th>Joining Date</th>
												<th>Role</th>
												<th>Salary</th>
												<th>Status</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<div class="form-check check-tables">
														<input class="form-check-input" type="checkbox" value="something">
													</div>
												</td>
												<td>EID-001</td>
												<td class="profile-image"><a href="profile.php"><img width="28" height="28" src="assets/img/profiles/avatar-01.jpg" class="rounded-circle m-r-5" alt=""> Andrea Lalema</a></td>
												<td><a href="../../cdn-cgi/l/email-protection.php" class="__cf_email__" data-cfemail="f6938e979b869a93b6919b979f9ad895999b">[email&#160;protected]</a>	</td>
												<td>01.05.2020</td>
												<td>
													<div class="dropdown action-label">
														<a class="custom-badge status-purple dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
															Nurse
														</a>
														<div class="dropdown-menu dropdown-menu-end status-staff">
															<a class="dropdown-item" href="javascript:;">Nurse</a>
															<a class="dropdown-item" href="javascript:;">Accountant</a>
															<a class="dropdown-item" href="javascript:;">Pharmacist</a>
														</div>
													</div>
												</td>
												<td>$1000</td>
												<td>
													<a class="btn btn-sm btn-primary" href="salary-view.php">Generate Slip</a>
												</td>
												<td class="text-end">
													<div class="dropdown dropdown-action">
														<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
														<div class="dropdown-menu dropdown-menu-end">
															<a class="dropdown-item" href="edit-salary.php"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
															<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_patient"><i class="fa fa-trash-alt m-r-5"></i> Delete</a>
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-check check-tables">
														<input class="form-check-input" type="checkbox" value="something">
													</div>
												</td>
												<td>EID-002</td>
												<td class="profile-image"><a href="profile.html"><img width="28" height="28" src="assets/img/profiles/avatar-03.jpg" class="rounded-circle m-r-5" alt="">William Stephin</a></td>
												<td><a href="../../cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="6d08150c001d01082d0a000c0401430e0200">[email&#160;protected]</a>	</td>
												<td>03.05.2020</td>
												<td>
													<div class="dropdown action-label">
														<a class="custom-badge status-purple dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
															Accountant
														</a>
														<div class="dropdown-menu dropdown-menu-end status-staff">
															<a class="dropdown-item" href="javascript:;">Nurse</a>
															<a class="dropdown-item" href="javascript:;">Accountant</a>
															<a class="dropdown-item" href="javascript:;">Pharmacist</a>
														</div>
													</div>
												</td>
												<td>$2000</td>
												<td>
													<a class="btn btn-sm btn-primary" href="salary-view.html">Generate Slip</a>
												</td>
												<td class="text-end">
													<div class="dropdown dropdown-action">
														<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
														<div class="dropdown-menu dropdown-menu-end">
															<a class="dropdown-item" href="edit-salary.html"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
															<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_patient"><i class="fa fa-trash-alt m-r-5"></i> Delete</a>
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-check check-tables">
														<input class="form-check-input" type="checkbox" value="something">
													</div>
												</td>
												<td>EID-003</td>
												<td class="profile-image"><a href="profile.html"><img width="28" height="28" src="assets/img/profiles/avatar-02.jpg" class="rounded-circle m-r-5" alt="">Smith Bruklin</a></td>
												<td><a href="../../cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="23465b424e534f4663444e424a4f0d404c4e">[email&#160;protected]</a>	</td>
												<td>04.05.2020</td>
												<td>
													<div class="dropdown action-label">
														<a class="custom-badge status-purple dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
															Pharmacist
														</a>
														<div class="dropdown-menu dropdown-menu-end status-staff">
															<a class="dropdown-item" href="javascript:;">Nurse</a>
															<a class="dropdown-item" href="javascript:;">Accountant</a>
															<a class="dropdown-item" href="javascript:;">Pharmacist</a>
														</div>
													</div>
												</td>
												<td>$1500</td>
												<td>
													<a class="btn btn-sm btn-primary" href="salary-view.html">Generate Slip</a>
												</td>
												<td class="text-end">
													<div class="dropdown dropdown-action">
														<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
														<div class="dropdown-menu dropdown-menu-end">
															<a class="dropdown-item" href="edit-salary.html"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
															<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_patient"><i class="fa fa-trash-alt m-r-5"></i> Delete</a>
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-check check-tables">
														<input class="form-check-input" type="checkbox" value="something">
													</div>
												</td>
												<td>EID-004</td>
												<td class="profile-image"><a href="profile.html"><img width="28" height="28" src="assets/img/profiles/avatar-04.jpg" class="rounded-circle m-r-5" alt=""> Bernardo James</a></td>
												<td><a href="../../cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="27425f464a574b4267404a464e4b0944484a">[email&#160;protected]</a>	</td>
												<td>06.06.2020</td>
												<td>
													<div class="dropdown action-label">
														<a class="custom-badge status-purple dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
															Nurse
														</a>
														<div class="dropdown-menu dropdown-menu-end status-staff">
															<a class="dropdown-item" href="javascript:;">Nurse</a>
															<a class="dropdown-item" href="javascript:;">Accountant</a>
															<a class="dropdown-item" href="javascript:;">Pharmacist</a>
														</div>
													</div>
												</td>
												<td>$3000</td>
												<td>
													<a class="btn btn-sm btn-primary" href="salary-view.html">Generate Slip</a>
												</td>
												<td class="text-end">
													<div class="dropdown dropdown-action">
														<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
														<div class="dropdown-menu dropdown-menu-end">
															<a class="dropdown-item" href="edit-salary.html"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
															<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_patient"><i class="fa fa-trash-alt m-r-5"></i> Delete</a>
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-check check-tables">
														<input class="form-check-input" type="checkbox" value="something">
													</div>
												</td>
												<td>EID-005</td>
												<td class="profile-image"><a href="profile.html"><img width="28" height="28" src="assets/img/profiles/avatar-06.jpg" class="rounded-circle m-r-5" alt="">Cristina Groves</a></td>
												<td><a href="../../cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="7e1b061f130e121b3e19131f1712501d1113">[email&#160;protected]</a>	</td>
												<td>13.05.2020</td>
												<td>
													<div class="dropdown action-label">
														<a class="custom-badge status-purple dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
															Accountant
														</a>
														<div class="dropdown-menu dropdown-menu-end status-staff">
															<a class="dropdown-item" href="javascript:;">Nurse</a>
															<a class="dropdown-item" href="javascript:;">Accountant</a>
															<a class="dropdown-item" href="javascript:;">Pharmacist</a>
														</div>
													</div>
												</td>
												<td>$5000</td>
												<td>
													<a class="btn btn-sm btn-primary" href="salary-view.html">Generate Slip</a>
												</td>
												<td class="text-end">
													<div class="dropdown dropdown-action">
														<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
														<div class="dropdown-menu dropdown-menu-end">
															<a class="dropdown-item" href="edit-salary.html"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
															<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_patient"><i class="fa fa-trash-alt m-r-5"></i> Delete</a>
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-check check-tables">
														<input class="form-check-input" type="checkbox" value="something">
													</div>
												</td>
												<td>EID-006</td>
												<td class="profile-image"><a href="profile.html"><img width="28" height="28" src="assets/img/profiles/avatar-05.jpg" class="rounded-circle m-r-5" alt=""> Mark Hay Smith</a></td>
												<td><a href="../../cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="b0d5c8d1ddc0dcd5f0d7ddd1d9dc9ed3dfdd">[email&#160;protected]</a>	</td>
												<td>11.12.2020</td>
												<td>
													<div class="dropdown action-label">
														<a class="custom-badge status-purple dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
															Pharmacist
														</a>
														<div class="dropdown-menu dropdown-menu-end status-staff">
															<a class="dropdown-item" href="javascript:;">Nurse</a>
															<a class="dropdown-item" href="javascript:;">Accountant</a>
															<a class="dropdown-item" href="javascript:;">Pharmacist</a>
														</div>
													</div>
												</td>
												<td>$2000</td>
												<td>
													<a class="btn btn-sm btn-primary" href="salary-view.html">Generate Slip</a>
												</td>
												<td class="text-end">
													<div class="dropdown dropdown-action">
														<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
														<div class="dropdown-menu dropdown-menu-end">
															<a class="dropdown-item" href="edit-salary.html"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
															<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_patient"><i class="fa fa-trash-alt m-r-5"></i> Delete</a>
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-check check-tables">
														<input class="form-check-input" type="checkbox" value="something">
													</div>
												</td>
												<td>EID-007</td>
												<td class="profile-image"><a href="profile.html"><img width="28" height="28" src="assets/img/profiles/avatar-01.jpg" class="rounded-circle m-r-5" alt=""> Andrea Lalema</a></td>
												<td><a href="../../cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="5a3f223b372a363f1a3d373b333674393537">[email&#160;protected]</a>	</td>
												<td>01.05.2020</td>
												<td>
													<div class="dropdown action-label">
														<a class="custom-badge status-purple dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
															Accountant
														</a>
														<div class="dropdown-menu dropdown-menu-end status-staff">
															<a class="dropdown-item" href="javascript:;">Nurse</a>
															<a class="dropdown-item" href="javascript:;">Accountant</a>
															<a class="dropdown-item" href="javascript:;">Pharmacist</a>
														</div>
													</div>
												</td>
												<td>$1000</td>
												<td>
													<a class="btn btn-sm btn-primary" href="salary-view.html">Generate Slip</a>
												</td>
												<td class="text-end">
													<div class="dropdown dropdown-action">
														<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
														<div class="dropdown-menu dropdown-menu-end">
															<a class="dropdown-item" href="edit-salary.html"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
															<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_patient"><i class="fa fa-trash-alt m-r-5"></i> Delete</a>
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-check check-tables">
														<input class="form-check-input" type="checkbox" value="something">
													</div>
												</td>
												<td>EID-008</td>
												<td class="profile-image"><a href="profile.html"><img width="28" height="28" src="assets/img/profiles/avatar-02.jpg" class="rounded-circle m-r-5" alt=""> Smith Bruklin</a></td>
												<td><a href="../../cdn-cgi/l/email-protection.html" class="__cf_email__" data-cfemail="bdd8c5dcd0cdd1d8fddad0dcd4d193ded2d0">[email&#160;protected]</a>	</td>
												<td>01.05.2020</td>
												<td>
													<div class="dropdown action-label">
														<a class="custom-badge status-purple dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
															Nurse
														</a>
														<div class="dropdown-menu dropdown-menu-end status-staff">
															<a class="dropdown-item" href="javascript:;">Nurse</a>
															<a class="dropdown-item" href="javascript:;">Accountant</a>
															<a class="dropdown-item" href="javascript:;">Pharmacist</a>
														</div>
													</div>
												</td>
												<td>$2000</td>
												<td>
													<a class="btn btn-sm btn-primary" href="salary-view.html">Generate Slip</a>
												</td>
												<td class="text-end">
													<div class="dropdown dropdown-action">
														<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
														<div class="dropdown-menu dropdown-menu-end">
															<a class="dropdown-item" href="edit-salary.html"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
															<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_patient"><i class="fa fa-trash-alt m-r-5"></i> Delete</a>
														</div>
													</div>
												</td>
											</tr>
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
<?php 
require_once('includes/footer.php');
?>