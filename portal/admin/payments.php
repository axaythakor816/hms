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
								<li class="breadcrumb-item active">Payments </li>
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
												<h3>Payment List</h3>
												<div class="doctor-search-blk">
													<div class="top-nav-search table-search-blk">
														<form>
															<input type="text" class="form-control" placeholder="Search here">
															<a class="btn"><img src="assets/img/icons/search-normal.svg" alt=""></a>
														</form>
													</div>
													<div class="add-group">
														<a href="add-payment.php" class="btn btn-primary add-pluss ms-2"><img src="assets/img/icons/plus.svg" alt=""></a>
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
											<div class="col-12 col-md-6 col-xl-4 ">
												<div class="input-block local-forms">
													<label >Payment Status </label>
													<select class="form-control select">
														<option>Select Payment Status</option>
														<option>Paid</option>
														<option>Un Paid</option>
														<option>Patially Paid</option>
													  </select>
												</div>
											</div>
											<div class="col-12 col-md-6 col-xl-4 ms-auto">
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
												<th>Invoice Number</th>
												<th>Patient</th>
												<th>Payment Type</th>
												<th>Paid Date</th>
												<th>Paid Amount</th>
												<th>Status</th>
												<th ></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<div class="form-check check-tables">
														<input class="form-check-input" type="checkbox" value="something">
													</div>
												</td>
												<td><a href="invoice-view.html">#INV-0004</a></td>
												<td class="profile-image"><a href="profile.html"><img width="28" height="28" src="assets/img/profiles/avatar-01.jpg" class="rounded-circle m-r-5" alt=""> Andrea Lalema</a></td>
												<td>Credit Card</td>
												<td>01.10.2022</td>
												<td>$2450</td>
												<td><button class="custom-badge status-green ">Paid</button></td>
												<td class="text-end">
													<div class="dropdown dropdown-action">
														<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
														<div class="dropdown-menu dropdown-menu-end">
															<a class="dropdown-item" href="edit-payment.html"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
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
												<td><a href="invoice-view.html">#INV-0001</a></td>
												<td class="profile-image"><a href="profile.html"><img width="28" height="28" src="assets/img/profiles/avatar-02.jpg" class="rounded-circle m-r-5" alt=""> Smith Bruklin</a></td>
												<td>Debit Card</td>
												<td>02.10.2022</td>
												<td>$1505</td>
												<td><button class="custom-badge status-pink ">Un Paid</button></td>
												<td class="text-end">
													<div class="dropdown dropdown-action">
														<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
														<div class="dropdown-menu dropdown-menu-end">
															<a class="dropdown-item" href="edit-payment.html"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
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
												<td><a href="invoice-view.html">#INV-0002</a></td>
												<td class="profile-image"><a href="profile.html"><img width="28" height="28" src="assets/img/profiles/avatar-03.jpg" class="rounded-circle m-r-5" alt=""> Bernardo James</a></td>
												<td>Pay Pal</td>
												<td>01.10.2022</td>
												<td>$2000</td>
												<td><button class="custom-badge status-green ">Paid</button></td>
												<td class="text-end">
													<div class="dropdown dropdown-action">
														<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
														<div class="dropdown-menu dropdown-menu-end">
															<a class="dropdown-item" href="edit-payment.html"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
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
												<td><a href="invoice-view.html">#INV-0003</a></td>
												<td class="profile-image"><a href="profile.html"><img width="28" height="28" src="assets/img/profiles/avatar-04.jpg" class="rounded-circle m-r-5" alt=""> Mark Hay Smith</a></td>
												<td>Credit Card</td>
												<td>05.10.2022</td>
												<td>$1000</td>
												<td><button class="custom-badge status-orange ">Patially Paid</button></td>
												<td class="text-end">
													<div class="dropdown dropdown-action">
														<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
														<div class="dropdown-menu dropdown-menu-end">
															<a class="dropdown-item" href="edit-payment.html"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
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
												<td><a href="invoice-view.html">#INV-0004</a></td>
												<td class="profile-image"><a href="profile.html"><img width="28" height="28" src="assets/img/profiles/avatar-05.jpg" class="rounded-circle m-r-5" alt=""> Galaviz Lalema</a></td>
												<td>Debit Card</td>
												<td>01.10.2022</td>
												<td>$2300</td>
												<td><button class="custom-badge status-green ">Paid</button></td>
												<td class="text-end">
													<div class="dropdown dropdown-action">
														<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
														<div class="dropdown-menu dropdown-menu-end">
															<a class="dropdown-item" href="edit-payment.html"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
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
												<td><a href="invoice-view.html">#INV-0003</a></td>
												<td class="profile-image"><a href="profile.html"><img width="28" height="28" src="assets/img/profiles/avatar-06.jpg" class="rounded-circle m-r-5" alt=""> Andrea Lalema</a></td>
												<td>Pay Pal</td>
												<td>05.10.2022</td>
												<td>$4000</td>
												<td><button class="custom-badge status-orange ">Patially Paid</button></td>
												<td class="text-end">
													<div class="dropdown dropdown-action">
														<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
														<div class="dropdown-menu dropdown-menu-end">
															<a class="dropdown-item" href="edit-payment.html"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
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
												<td><a href="invoice-view.html">#INV-0005</a></td>
												<td class="profile-image"><a href="profile.html"><img width="28" height="28" src="assets/img/profiles/avatar-07.jpg" class="rounded-circle m-r-5" alt=""> William Stephin</a></td>
												<td>Pay Pal</td>
												<td>10.10.2022</td>
												<td>$3000</td>
												<td><button class="custom-badge status-pink ">Un Paid</button></td>
												<td class="text-end">
													<div class="dropdown dropdown-action">
														<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
														<div class="dropdown-menu dropdown-menu-end">
															<a class="dropdown-item" href="edit-payment.html"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
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