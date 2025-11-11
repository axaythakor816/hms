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
								<li class="breadcrumb-item"><a href="payments.php">Accounts </a></li>
								<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
								<li class="breadcrumb-item active">Add Payments </li>
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
												<h4>Add Payments</h4>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">  
											<div class="input-block local-forms">
												<label >Payment Number <span class="login-danger">*</span></label>
												<input class="form-control" type="text" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms cal-icon">
												<label >Payment Date  <span class="login-danger">*</span></label>
												<input class="form-control datetimepicker" type="text"  placeholder="" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Patient Name <span class="login-danger">*</span></label>
												<input class="form-control" type="text" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Doctor Name <span class="login-danger">*</span></label>
												<select class="form-control select">
													<option>Enter Doctor Name</option>
													<option>Dr.Galaviz Lalema</option>
													<option>Dr.Bernardo James</option>
													<option>Dr.Mark Hay Smith</option>
												  </select>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Total Amount <span class="login-danger">*</span></label>
												<input class="form-control" type="text" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Discount <span class="login-danger">*</span></label>
												<input class="form-control" type="text" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Payment Method <span class="login-danger">*</span></label>
												<select class="form-control select">
													<option>Select Payment Method</option>
													<option>Credit Card</option>
													<option>Debit Card</option>
													<option>Pay Pal</option>
												  </select>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Payment Status <span class="login-danger">*</span></label>
												<select class="form-control select">
													<option>Select Payment Status</option>
													<option>Paid</option>
													<option>Patially Paid</option>
													<option>Un Paid</option>
												  </select>
											</div>
										</div>
										<div class="col-12 col-sm-12">
											<div class="input-block local-forms">
												<label>Other Information  <span class="login-danger">*</span></label>
												<textarea class="form-control" rows="3" cols="30"></textarea>
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