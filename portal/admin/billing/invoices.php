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
								<li class="breadcrumb-item active">Invoices</li>
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
												<h3>Invoice List</h3>
												<div class="doctor-search-blk">
													<div class="top-nav-search table-search-blk">
														<form>
															<input type="text" class="form-control" placeholder="Search here">
															<a class="btn"><img src="assets/img/icons/search-normal.svg" alt=""></a>
														</form>
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
												<th>Invoice Number</th>
												<th>Patient Name</th>
												<th>Admit Date</th>
												<th>Patient Status</th>
												<th>Amount</th>
												<th>Bill Status</th>
												<th>Descharge Date</th>
												<th ></th>
											</tr>
										</thead>
										<tbody>

		 									<?php
										 	require('includes/config.php');
											$query = "SELECT * FROM patient";
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
												<td>00<?php echo $row['id']; ?></td>
												<td><?php echo $row['fname']; echo " "; echo $row['lname']; ?></td>
												
												
                                                <td><?php echo $row['admit']; ?></td>
												<td>
													<?php
														$a = "Admit";
														if($row['status'] == $a){
															?>
															<button class="custom-badge status-pink "><?php echo $row['status']; ?></button>
															<?php
														}else{
															?>
															<button class="custom-badge status-green "><?php echo $row['status']; ?></button>
															<?php
														}

													?>
												
												</td>
												<td>$<?php echo $row['amt']; ?></td>
												<td>
													<?php
													
														$b = "Paid";
														$c = "Un Paid";
														if($row['bstatus'] == $b){
															?>
															<button class="custom-badge status-green "><?php echo $row['bstatus']; ?></button>
															<?php
														}elseif($row['bstatus'] == $c){
															?>
															<button class="custom-badge status-pink "><?php echo $row['bstatus']; ?></button>
															<?php
														}else{
															?>
															<button class="custom-badge status-orange ">----</button>
															<?php
														}

													?>
												
												</td>
												<td><?php echo $row['ddate']; ?></td>
												
												<td class="text-end">
													
												<a class="dropdown-item" href="create-invoice.php?id=<?php echo $row['id']; ?>"><i class="fa fa-plus" aria-hidden="true"></i>Add</a>		

												<a class="dropdown-item" href="invoice-view.php?id=<?php echo $row['id']; ?>"><i class="feather-eye m-r-5"></i> View</a>
															
													
												</td>
                                                <td class="text-end">
												<a class="dropdown-item" href="edit-invoice.php?id=<?php echo $row['id']; ?>"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                                                            
                                                <a class="dropdown-item" onclick="return confirm('Are You sure, you want to delete?')" href="delete-invoice.php?id=<?php echo $row['id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
															
                                                </td>
											</tr>
                                           
											<?php
                                             $sr=$sr+1;
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
   <?php 
require_once('includes/footer.php');
?>