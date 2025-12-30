<?php
require_once '../../../core/init.php';

require_login();

if(!has_permission('doctors', 'can_view')) {
	showalert("error", "Access Denied You Are Not Authorize Persion");	
	exit;
}

?>
<div class="page-wrapper">
	<div class="content">

		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col-sm-12">
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="doctors/doctor_list.php" class="nav-link">Doctors </a></li>
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
													<input type="text" id="searchInput" class="form-control" placeholder="Search here">
													<a class="btn"><img src="../assets/img/icons/search-normal.svg" alt=""></a>
												</form>
											</div>
                                            <div class="add-group">
											<?php if(has_permission('doctors', 'can_add')) { ?>
												<a href="add-department.php" data-bs-toggle="modal" data-bs-target="#addDoctorModal" class="btn btn-primary add-pluss ms-2"><img src="../assets/img/icons/plus.svg" alt=""></a>
											<?php } ?>
												<a href="javascript:;" class="btn btn-primary doctor-refresh ms-2"><img src="../assets/img/icons/re-fresh.svg" alt=""></a>
											<?php if(has_permission('doctors', 'can_delete')) { ?>
												<a href="javascript:;" id="deleteSelected" class="btn btn-primary doctor-delete ms-2 disabled"><img src="../assets/img/icons/trash.svg" alt=""></a>
											<?php } ?>
												<select id="RecordsPerPage" class="form-select form-select-sm w-auto ms-2">
													<option value="10"></option>
													<option value="5">5</option>
													<option value="10">10</option>
													<option value="25">25</option>
													<option value="50">50</option>
													<option value="100">100</option>
												</select>
											</div>
											
										</div>
									</div>
								</div>
								<div class="col-auto text-end float-end ms-auto download-grp">
									<a href="javascript:;" class=" me-2 exportdata" data-type="pdf" data-csrf="<?php echo csrf_token(); ?>"><img src="../assets/img/icons/pdf-icon-01.svg" alt=""></a>
									<a href="javascript:;" class=" me-2 exportdata" data-type="txt" data-csrf="<?php echo csrf_token(); ?>"><img src="../assets/img/icons/pdf-icon-02.svg" alt=""></a>
									<a href="javascript:;" class=" me-2 exportdata" data-type="csv" data-csrf="<?php echo csrf_token(); ?>"><img src="../assets/img/icons/pdf-icon-03.svg" alt=""></a>
									<a href="javascript:;" class="exportdata" data-type="xlsx" data-csrf="<?php echo csrf_token(); ?>"><img src="../assets/img/icons/pdf-icon-04.svg" alt=""></a>
								</div>
							</div>
						</div>
						<!-- /Table Header -->
						
						<div class="table-responsive">
							<input type="hidden" id="docor_csrf_token" value="<?php echo csrf_token(); ?>">

							<table class="table border-0 custom-table comman-table datatable mb-0" id="doctor_table">
								<thead>
									<tr>
										<th>
											<div class="form-check check-tables">
												<input id="checkAll" class="form-check-input" type="checkbox" value="something">
											</div>
										</th>
										<th data-column="doctor_id">Sr_No</th>
										<th data-column="first_name">Name</th>
										<th data-column="phone">Mobile</th>
										<th data-column="email">Email</th>
										<th data-column="dob">Date Of Birth</th>
										<th data-column="gender">Gender</th>
                                        <th data-column="status">Account Status</th>
                                        <th data-column="specialty">Specialty</th>
                                        <th data-column="sub_specialty">Sub Specialty</th>
                                        <th data-column="qualification">Qualification</th>
                                        <th>Experience</th>
                                        <th>Department</th>
                                        <th>Medical License No</th>
                                        <th>Consultation Fee</th>
                                        <th>Available Days</th>
                                        <th>Available Time</th>
                                        <th>Languages Spoken</th>
                                        <th>Bio</th>
                                        <th>Doctor Status</th>
										<th>Address</th>

                                        <th>Created At</th>
                                        <th>Updated At</th>
										
										<?php if(has_permission('doctors', 'can_edit') || has_permission('doctors', 'can_delete')) : ?>
										<th colspan="2" class="text-center">Action</th>
										<?php endif ?>
									</tr>
								</thead>
								<tbody>
																			
								</tbody>
							</table>
						</div>
                        <div class="row align-items-center px-2 py-2">
							<div class="col-sm mt-2 text-muted" id="doctor_InfoText" style="font-size:13px;">
								<!-- information inserted dynamically -->
							</div>

							<div class="col-sm-auto">
								<ul class="pagination my-2" id="doctor_Pagination">
									<!-- pagignation inserted dynamically -->
								</ul>
							</div>

						</div>
					</div>
				</div>							
			</div>					
		</div>
	</div>
</div>


<?php
if(has_permission('doctors', 'can_add')) {
	require_once 'add_doctor_model.php';
}

// if(has_permission('doctors', 'can_edit')) {
// 	require_once 'edit_doctor_model.php';
// }

// if(has_permission('doctors', 'can_delete')) {
// 	require_once 'delete_doctor_model.php';
// }

?>

<script src="../assets/ajax/doctors.js"></script>

