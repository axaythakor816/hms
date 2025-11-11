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
								<li class="breadcrumb-item"><a href="index.php">Dashboard </a></li>
								<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
								<li class="breadcrumb-item active">Admin Dashboard</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				
				<div class="good-morning-blk">
					<div class="row">
						<div class="col-md-6">
							<div class="morning-user">
								<h2>Good Morning, <span><?php
								require_once('includes/config.php');
								?>axay</span></h2>
								<p>Have a nice day at work</p>
							</div>
						</div>
						<div class="col-md-6 position-blk">
							<div class="morning-img">
								<img src="assets/img/morning-img-01.png" alt="">
							</div>
						</div>
					</div>
				</div>
				
				
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
							<div class="dash-boxs comman-flex-center">
								<img src="assets/img/icons/calendar.svg" alt="">
							</div>
							<?php
										 
										
											$query="SELECT * FROM appointment";
											$data=mysqli_query($conn,$query);
											if($result=mysqli_num_rows($data));
											{
											
                                             
													?>
							<div class="dash-content dash-count">
								<h4>Appointments</h4>
								<h2><span class="counter-up" ><?php echo $result; ?></span></h2>
								<?php
							}
						
							?>
							</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
							<div class="dash-boxs comman-flex-center">
								<img src="assets/img/icons/profile-add.svg" alt="">
							</div>
							<?php
										 
										
											$query="SELECT * FROM patient";
											$data=mysqli_query($conn,$query);
											if($result=mysqli_num_rows($data));
											{
											
                                             
													?>
							<div class="dash-content dash-count">
								<h4>New Patients</h4>
								<h2><span class="counter-up" ><?php echo $result; ?></span></h2>
								<?php
							}
							?>
								
							</div>
                        </div>
                    </div>
                    
                </div>
				<div class="row">
					<div class="col-12 col-md-12 col-lg-6 col-xl-9">
						<div class="card">
							<div class="card-body">
								<div class="chart-title patient-visit">
									<h4>Patient Visit by Gender</h4>
									<div >
										<ul class="nav chat-user-total">
											<li><i class="fa fa-circle current-users" aria-hidden="true"></i>Male 75%</li>
											<li><i class="fa fa-circle old-users" aria-hidden="true"></i> Female 25%</li>
										</ul>
									</div>
									
								</div>	
								<div id="patient-chart"></div>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-12 col-lg-6 col-xl-3 d-flex">
						<div class="card">
							<div class="card-body">
								<div class="chart-title">
									<h4>Patient by Department</h4>
								</div>	
								<div id="donut-chart-dash" class="chart-user-icon">
									<img src="assets/img/icons/user-icon.svg" alt="">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-md-12  col-xl-4">
                        <div class="card top-departments">
							<div class="card-header">
								<h4 class="card-title mb-0">Top Departments</h4>
							</div>
                            <div class="card-body">
                                <div class="activity-top">
									<div class="activity-boxs comman-flex-center">
										<img src="assets/img/icons/dep-icon-01.svg" alt="">
									</div>
									<div class="departments-list">
										<h4>General Physician</h4>
										<p>35%</p>
									</div>
								</div>
								<div class="activity-top">
									<div class="activity-boxs comman-flex-center">
										<img src="assets/img/icons/dep-icon-02.svg" alt="">
									</div>
									<div class="departments-list">
										<h4>Dentist</h4>
										<p>24%</p>
									</div>
								</div>
								<div class="activity-top">
									<div class="activity-boxs comman-flex-center">
										<img src="assets/img/icons/dep-icon-03.svg" alt="">
									</div>
									<div class="departments-list">
										<h4>ENT</h4>
										<p>10%</p>
									</div>
								</div>
								<div class="activity-top">
									<div class="activity-boxs comman-flex-center">
										<img src="assets/img/icons/dep-icon-04.svg" alt="">
									</div>
									<div class="departments-list">
										<h4>Cardiologist</h4>
										<p>15%</p>
									</div>
								</div>
								<div class="activity-top mb-0">
									<div class="activity-boxs comman-flex-center">
										<img src="assets/img/icons/dep-icon-05.svg" alt="">
									</div>
									<div class="departments-list">
										<h4>Opthomology</h4>
										<p>20%</p>
									</div>
								</div>
                            </div>
                        </div>
                    </div>
					<div class="col-12 col-md-12  col-xl-8">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title d-inline-block">Upcoming Appointments</h4> <a href="appointments.php" class="patient-views float-end">Show all</a>
							</div>
							<div class="card-body p-0 table-dash">
								<div class="table-responsive">
											<table class="table mb-0 border-0 datatable custom-table">
										<thead>
											<tr>
												<th>
													<div class="form-check check-tables">
														<input class="form-check-input" type="checkbox" value="something">
													</div>
												</th>
												<th>No</th>
												<th>Patient name</th>
												<th>Department And Doctor </th>
												<th>Date</th>
												
										</thead>
										<tbody>
										<?php
											$query="SELECT * FROM appointment";
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
												<td><?php echo $row['name']; ?></td>
												<td class="table-image appoint-doctor">
													
													<h2><?php echo $row['doctor']; ?></h2>
												</td>
												<td class="appoint-time"><?php echo $row['date']; ?></td>
												
												
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
				<div class="row">
					<div class="col-12 col-xl-12">
						<div class="card">
							<div class="card-header pb-0">
								<h4 class="card-title d-inline-block">Recent Patients </h4> <a href="patients.php" class="float-end patient-views">Show all</a>
							</div>
							<div class="card-block table-dash">
									<div class="table-responsive">
									<table class="table mb-0 border-0 datatable custom-table">
										<thead>
											<tr>
												<th>
													<div class="form-check check-tables">
														<input class="form-check-input" type="checkbox" value="something">
													</div>
												</th>
												<th>No</th>
												<th>Patient name</th>
												<th>Department and Doctor</th>
												<th>Date of Birth</th>
												<th>Gender</th>
												<th>Admit Date</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
										<?php
										 
										
										 $query="SELECT * FROM patient";
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
												<td class="table-image">
													<h2><?php echo $row['fname']; echo " "; echo $row['lname']; ?></h2>
												</td>
												<td><?php echo $row['doctor']; ?></td>
												<td><?php echo $row['dob']; ?></td>
												<td><?php echo $row['gender']; ?></td>
												<td><button class="custom-badge status-green "><?php echo $row['admit']; ?></button></td>
												<?php
                                             $sr=$sr+1;
												}	
											}else{
                                                echo"No Record Found" ;
                                            }
												?>
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
<?php 
require_once('includes/footer.php');
?>