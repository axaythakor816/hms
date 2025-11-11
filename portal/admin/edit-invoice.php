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
								<li class="breadcrumb-item"><a href="invoices.php">Accounts </a></li>
								<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
								<li class="breadcrumb-item active">Edit Invoice</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				
				<div class="row">
					<div class="col-sm-12">
					
						<div class="card ">
							<div class="card-body">
								<form>
									<div class="row">
										<div class="col-12">
											<div class="form-heading">
												<h4>Edit Invoice</h4>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">  
											<div class="input-block local-forms">
												<label >Patient Name <span class="login-danger">*</span></label>
												<input class="form-control" type="text" value="Bernardo James" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Email <span class="login-danger">*</span></label>
												<input class="form-control" type="email"  value="example@gmail.com" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Department <span class="login-danger">*</span></label>
												<select class="form-control select">
													<option>Select  Department</option>
													<option>Orthopedics</option>
													<option>Radiology</option>
													<option>Dentist</option>
												  </select>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Tax <span class="login-danger">*</span></label>
												<select class="form-control select">
													<option>Select  Tax</option>
													<option>VAT</option>
													<option>GST</option>
													<option>No GST</option>
												  </select>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms cal-icon">
												<label >Invoice Date  <span class="login-danger">*</span></label>
												<input class="form-control datetimepicker" type="text" value="01.05.2020" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms cal-icon">
												<label >Due Date <span class="login-danger">*</span></label>
												<input class="form-control datetimepicker" type="text" value="04.05.2020" >
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label>Patient Address  <span class="login-danger">*</span></label>
												<textarea class="form-control" rows="3" cols="30">5754 Airport Rd, Coosada, AL, 36020</textarea>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label>Billing  Address  <span class="login-danger">*</span></label>
												<textarea class="form-control" rows="3" cols="30">5754 Airport Rd, Coosada, AL, 36020</textarea>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Payment Method <span class="login-danger">*</span></label>
												<select class="form-control select">
													<option>Select Payment Method</option>
													<option>Debit Card</option>
													<option>Gpay</option>
												  </select>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">
											<div class="input-block local-forms">
												<label >Select Payment Status <span class="login-danger">*</span></label>
												<select class="form-control select">
													<option>Select  Tax</option>
													<option>Paid</option>
													<option>Un Paid</option>
													<option>Patially Paid</option>
												  </select>
											</div>
										</div>
										<div class="col-12 col-sm-12">
											<div class="table-responsive">
												<table class="table border-0 custom-table invoices-table">
													<thead>
														<tr>
															<th style="width: 20px">#</th>
															<th class="col-sm-2">Item</th>
															<th class="col-md-6">Description</th>
															<th style="width:100px;">Unit Cost</th>
															<th style="width:80px;">Qty</th>
															<th>Amount</th>
															<th> </th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>1</td>
															<td>
																<input class="form-control" type="text" style="min-width:150px" value="Full body checkup">
															</td>
															<td>
																<input class="form-control" type="text" style="min-width:150px" value="Lorem ipsum dolor sit amet, consectetur adipiscing elit">
															</td>
															<td>
																<input class="form-control" style="width:100px" type="text" value="150">
															</td>
															<td>
																<input class="form-control" style="width:80px" type="text" value="1">
															</td>
															<td>
																<input class="form-control "  style="width:120px" type="text" value="150">
															</td>
															<td><a href="javascript:void(0)" class="text-success font-18 add-table-invoice" title="Add"><i class="fa fa-plus"></i></a></td>
														</tr>
														<tr>
															<td>2</td>
															<td>
																<input class="form-control" type="text" style="min-width:150px" value="Blood Test">
															</td>
															<td>
																<input class="form-control" type="text" style="min-width:150px" value="Lorem ipsum dolor sit amet, consectetur adipiscing elit">
															</td>
															<td>
																<input class="form-control" style="width:100px" type="text" value="12">
															</td>
															<td>
																<input class="form-control" style="width:80px" type="text" value="1">
															</td>
															<td>
																<input class="form-control "  style="width:120px" type="text" value="120">
															</td>
															<td><a href="javascript:void(0)" class="text-success font-18 add-table-invoice" title="Add"><i class="fa fa-plus"></i></a></td>
														</tr>
													</tbody>
												</table>
											</div>
											<div class="table-responsive custom-table invoices-table">
												<table class="table border-0 grand-totals">
													<tbody>
														<tr>
															<td  class="text-end">Total</td>
															<td >
																<input class="form-control text-end" type="text" value="220">
															</td>
														</tr>
														<tr>
															<td  class="text-end ">Tax</td>
															<td >
																<input class="form-control text-end" type="text" value="0">
															</td>
														</tr>
														<tr class="bold-total">
															<td  class="text-end">
																Grand Total
															</td>
															<td >
																<input class="form-control text-end" type="text" value="$320">
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										<div class="col-12">
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