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
								<li class="breadcrumb-item"><a href="staff-list.php">Staffs </a></li>
								<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
								<li class="breadcrumb-item active">Staff List</li>
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
												<h3>Staffs List</h3>
												<div class="doctor-search-blk">
													<div class="top-nav-search table-search-blk">
														<form>
															<input type="text" class="form-control" placeholder="Search here">
															<a class="btn"><img src="assets/img/icons/search-normal.svg" alt=""></a>
														</form>
													</div>
													<div class="add-group">
														<a href="add-staff.php" class="btn btn-primary add-pluss ms-2"><img src="assets/img/icons/plus.svg" alt=""></a>
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
												<th>Number</th>
												<th>Email</th>
												<th>Date Of Birth</th>
												<th>Gender</th>
												<th>Education</th>
												<th >Job Role</th>
												<th >Address</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
										<?php
										 
											$query="SELECT * FROM staff";
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
												<td><?php echo $row['fname'], $row['lname'];?></td>
												<td><?php echo $row['number']; ?></td>
												<td><?php echo $row['email']; ?></td>
												<td><?php echo $row['dob']; ?></td>
												<td><?php echo $row['gender']; ?></td>
												<td><?php echo $row['edu']; ?></td>
												<td><?php echo $row['job']; ?></td>
											
												<td><?php echo $row['address']; ?></td>
												
												
											
												<td class="text-end">
													
														
														
															<a class="dropdown-item" href="edit-staff.php?id=<?php echo $row['id']; ?>"><i class="fa-solid fa-pen-to-square m-r-5"></i> Edit</a>
                                                            
													
												</td>
                                                <td class="text-end">
                                                <a class="dropdown-item" onclick="return confirm('Are You sure, you want to delete?')" href="delete-staff.php?id=<?php echo $row['id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
															
                                                </td>
											</tr>
											<?php
                                            $sr++;
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