<div class="page-wrapper">
	<div class="content">

		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col-sm-12">
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="permissions/permission_list.php" class="nav-link">Permissions </a></li>
						<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
						<li class="breadcrumb-item active">Permissions List</li>
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
										<h3>Permissions List</h3>
										<div class="doctor-search-blk">
											<div class="top-nav-search table-search-blk">
												<form>
													<input type="text" class="form-control" placeholder="Search here">
													<a class="btn"><img src="../assets/img/icons/search-normal.svg" alt=""></a>
												</form>
											</div>
											<div class="add-group">
												<a href="javascript:;" data-bs-toggle="modal" data-bs-target="#addpermissionModal" class="btn btn-primary add-pluss ms-2"><img src="../assets/img/icons/plus.svg" alt=""></a>
												<a href="javascript:;" class="btn btn-primary doctor-refresh ms-2"><img src="../assets/img/icons/re-fresh.svg" alt=""></a>
											</div>
										</div>
									</div>
								</div>
								<div class="col-auto text-end float-end ms-auto download-grp">
									<a href="javascript:;" class=" me-2"><img src="../assets/img/icons/pdf-icon-01.svg" alt="PDF-Icon1"></a>
									<a href="javascript:;" class=" me-2"><img src="../assets/img/icons/pdf-icon-02.svg" alt="PDF-Icon2"></a>
									<a href="javascript:;" class=" me-2"><img src="../assets/img/icons/pdf-icon-03.svg" alt="PDF-Icon3"></a>
									<a href="javascript:;" ><img src="../assets/img/icons/pdf-icon-04.svg" alt="PDF-Icon4"></a>
									
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
										<th colspan="2">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<div class="form-check check-tables">
												<input class="form-check-input" type="checkbox" value="something">
											</div>
										</td>
										<td>1</td>
										<td>John Doe</td>
										<td>9876543210</td>
										<td>john@example.com</td>
										<td>1990-01-01</td>
										<td>Male</td>
										<td>MBBS</td>
										<td>Cardiology</td>
										<td>New York, USA</td>
										<td class="text-end">
											<a class="dropdown-item" href="edit-doctor.php"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>												
										</td>
										<td class="text-end">
											<a class="dropdown-item" onclick="return confirm('Are You sure, you want to delete?')" href="delete-doctor.php"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
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
<?php require_once 'add_permission_model.php'; ?>