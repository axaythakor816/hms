<?php
require_once '../../../core/init.php';

require_login();

if(!has_permission('departments', 'can_view')) {
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
						<li class="breadcrumb-item"><a href="departments/department_list.php" class="nav-link">Department </a></li>
						<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
						<li class="breadcrumb-item active">Department List</li>
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
									<div class="department-table-blk">
										<h3>Department List</h3>
										<div class="department-search-blk">
											<div class="top-nav-search table-search-blk">
												<form>
													<input type="text" class="form-control" placeholder="Search here" id="searchInput">
													<a class="btn"><img src="../assets/img/icons/search-normal.svg" alt=""></a>
												</form>
											</div>
											<div class="add-group">
											<?php if(has_permission('departments', 'can_add')) { ?>
												<a href="add-department.php" data-bs-toggle="modal" data-bs-target="#addDepatmentModal" class="btn btn-primary add-pluss ms-2"><img src="../assets/img/icons/plus.svg" alt=""></a>
											<?php } ?>
												<a href="javascript:;" class="btn btn-primary department-refresh ms-2"><img src="../assets/img/icons/re-fresh.svg" alt=""></a>
											<?php if(has_permission('departments', 'can_delete')) { ?>
												<a href="javascript:;" id="deleteSelected" class="btn btn-primary department-delete ms-2 disabled"><img src="../assets/img/icons/trash.svg" alt=""></a>
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
							<input type="hidden" id="department_csrf_token" value="<?php echo csrf_token(); ?>">

							<table class="table border-0 custom-table comman-table datatable mb-0" id="department_table">
								<thead>
									<tr>
										<th>
											<div class="form-check check-tables">
												<input class="form-check-input" type="checkbox" id="checkAll" value="something">
											</div>
										</th>
										<th data-column="department_id">Sr_No</th>
										<th data-column="department_name">Department</th>
										<th data-column="department_head_id">Department Head</th>
										<th>Department Description</th>
										<th data-column="created_at">Ceated Date</th>
										<th data-column="updated_at">Updated Date</th>
										<?php if(has_permission('departments', 'can_edit') || has_permission('departments', 'can_delete')) : ?>
										<th colspan="2" class="text-center">Action</th>
										<?php endif ?>
									</tr>
								</thead>
								<tbody>
									<!-- data inserted dynemically -->
								</tbody>
							</table>
						</div>
						<div class="row align-items-center px-2 py-2">
							<div class="col-sm mt-2 text-muted" id="Department_InfoText" style="font-size:13px;">
								<!-- information inserted dynamically -->
							</div>

							<div class="col-sm-auto">
								<ul class="pagination my-2" id="department_Pagination">
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
if(has_permission('departments', 'can_add')) {
	require_once 'add_department_model.php';
}

if(has_permission('departments', 'can_edit')) {
	require_once 'edit_department_model.php';
}

if(has_permission('departments', 'can_delete')) {
	require_once 'delete_department_model.php';
}

?>

<script src="../assets/ajax/departments.js"></script>
<!-- <script>
	loadpagedata();
</script> -->