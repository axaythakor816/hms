<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('manage users', 'can_view')) {
	showalert("error", "Access Denine");
	exit;
}

require_role([1]);

?>

<div class="page-wrapper">
	<div class="content">
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col-sm-12">
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="settings/manageusers/user_list.php" class="nav-link">User </a></li>
						<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
						<li class="breadcrumb-item active">User List</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- /Page Header -->

		<?php require_once '../setting_nav.php'; ?>
	
		<div class="row">
			<div class="col-sm-12">
			
				<div class="card card-table show-entire">
					<div class="card-body">
					
						<!-- Table Header -->
						<div class="page-table-header mb-2">
							<div class="row align-items-center">
								<div class="col">
									<div class="user-table-blk">
										<h3>User List</h3>
										<div class="user-search-blk">
											<div class="top-nav-search table-search-blk">
												<form>
													<input type="text" class="form-control" placeholder="Search here" id="searchInput">
													<a class="btn"><img src="../assets/img/icons/search-normal.svg" alt=""></a>
												</form>
											</div>
											<div class="add-group">
												<?php if(has_permission('manage users', 'can_add')): ?>
												<a href="#" data-bs-toggle="modal" data-bs-target="#addUserModal" class="btn btn-primary add-pluss ms-2"><img src="../assets/img/icons/plus.svg" alt=""></a>
												<?php endif; ?>
												<a href="javascript:;" class="btn btn-primary user-refresh ms-2"><img src="../assets/img/icons/re-fresh.svg" alt=""></a>
												<?php if(has_permission('manage users', 'can_delete')): ?>
												<a href="javascript:;" id="deleteSelected" class="btn btn-primary user-delete ms-2 disabled"><img src="../assets/img/icons/trash.svg" alt=""></a>
												<?php endif; ?>
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
							<input type="hidden" id="user_csrf_token" value="<?php echo csrf_token(); ?>">

							<table class="table border-0 custom-table comman-table datatable mb-0" id="user_table">
								<thead>
									<tr>
										<th>
											<div class="form-check check-tables">
												<input class="form-check-input" type="checkbox" id="checkAll" value="something">
											</div>
										</th>
										<th data-column="user_id">Sr_No</th>
										<th data-column="uuid">User UID</th>
										<th data-column="first_name">First Name</th>
										<th data-column="last_name">Last Name</th>
										<th data-column="email">Email Address</th>
										<th data-column="phone">Phone Number</th>
										<th data-column="role_id">Role</th>
										<th data-column="gender">Gender</th>
										<th data-column="dob">Date Of Birth</th>
										<th data-column="status">Status</th>
										<th data-column="created_at">created Date</th>
										<th data-column="updated_at">Updated Date</th>
										<th colspan="2" class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<!-- data inserted dynemically -->
								</tbody>
							</table>
						</div>
						<div class="row align-items-center px-2 py-2">
							<div class="col-sm mt-2 text-muted" id="user_InfoText" style="font-size:13px;">
								<!-- information inserted dynamically -->
							</div>

							<div class="col-sm-auto">
								<ul class="pagination my-2" id="user_Pagination">
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
	if(has_permission('manage users', 'can_add')) {
		require_once 'add_user_model.php'; 
	}
	if(has_permission('manage users', 'can_edit')) {
		require_once 'edit_user_model.php';
	}
	if(has_permission('manage users', 'can_delete')) {
		require_once 'delete_user_model.php';
	}
?>

<script src="../assets/ajax/manageusers.js"></script>

<script>
	loadpagedata();
</script>
