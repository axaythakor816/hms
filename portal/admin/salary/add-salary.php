<?php
require_once('includes/auth_check.php');
require_once('includes/header.php');
require_once('includes/sidebar.php');
?>
        <div class="page-wrapper">
	<!-- <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete_patient">
	Open Delete Modal
	</button> -->
            <div class="content">
						
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col-sm-12">
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="salary.php">Payroll </a></li>
								<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
								<li class="breadcrumb-item active">Add Employee Salary</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<div class="row">
					<div class="col-sm-12">
					
						<div class="card">
							<div class="card-body">
								<form>
									<div class="row">
										<div class="col-12">
											<div class="form-heading">
												<h4>Add Employee Salary</h4>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Select Staff </label>
												<select class="form-control select">
													<option>Select Staff</option>
													<option>Williams Bruk</option>
													<option>Galaviz Lalema</option>
												  </select>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">  
											<div class="input-block local-forms">
												<label >Net Salary </label>
												<input class="form-control" type="text" >
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-12 col-md-6 col-xl-6">  
											<div class="pay-head-roll">
												<h5>Earnings</h5>
											</div>
											<div class="input-block local-forms">
												<label >Basic Salary </label>
												<input class="form-control" type="text" >
											</div>
											<div class="input-block local-forms">
												<label >DA (40%) </label>
												<input class="form-control" type="text" >
											</div>
											<div class="input-block local-forms">
												<label >HRA (15%) </label>
												<input class="form-control" type="text" >
											</div>
											<div class="input-block local-forms">
												<label >Conveyance </label>
												<input class="form-control" type="text" >
											</div>
											<div class="input-block local-forms">
												<label >Medical Allowance </label>
												<input class="form-control" type="text" >
											</div>
											<div class="input-block local-forms">
												<label >Others</label>
												<input class="form-control" type="text" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="pay-head-roll">
												<h5>Deductions</h5>
											</div>
											<div class="input-block local-forms">
												<label >TDS </label>
												<input class="form-control" type="text" >
											</div>
											<div class="input-block local-forms">
												<label >ESI </label>
												<input class="form-control" type="text" >
											</div>
											<div class="input-block local-forms">
												<label >PF </label>
												<input class="form-control" type="text" >
											</div>
											<div class="input-block local-forms">
												<label >Prof.Tax </label>
												<input class="form-control" type="text" >
											</div>
											<div class="input-block local-forms">
												<label >Labour Welfare </label>
												<input class="form-control" type="text" >
											</div>
											<div class="input-block local-forms">
												<label >Others</label>
												<input class="form-control" type="text" >
											</div>
										</div>
										<div class="col-12">
											<div class="doctor-submit text-end">
												<button type="submit" class="btn btn-primary submit-form me-2">Submit</button>
												<button type="submit" class="btn btn-primary cancel-form">Cancel</button>
											</div>
										</div>
									</div>
								</form>
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