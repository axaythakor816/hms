<?php
require_once('includes/header.php');
?>

	<!-- Home Design Inner Pages -->
	<div class="ulockd-inner-home">
		<div class="container text-center">
			<div class="row">
				<div class="inner-conraimer-details">
					<div class="col-md-12">
						<h1 class="text-uppercase">DOCTOR'S TIMETABLE</h1>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Home Design Inner Pages -->
	<div class="ulockd-inner-page">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="ulockd-icd-layer">
						<ul class="list-inline ulockd-icd-sub-menu">
							<li><a href="#"> HOME </a></li>
							<li><a href="#"> > </a></li>
							<li> <a href="#"> DOCTOR'S TIMETABLE </a> </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Our About -->
	<section class="ulockd-about-one bgc-snowshade">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
				<div class="table-responsive">
									<table class="table border-0 custom-table comman-table datatable mb-0">
										<thead>
											<tr>
												
												<th>Id</th>
												<th>Doctor Name</th>
												<th>Department</th>
												<th>Available Days</th>
												<th>Available Time</th>
										
												<th ></th>
											</tr>
										</thead>
										<tbody>
										<?php
											$query="SELECT * FROM schedule";
											$data=mysqli_query($conn,$query);
											$result=mysqli_num_rows($data);
											if($result){

												while($row=mysqli_fetch_array($data)){
													?>
                                            <tr>
												

												<td><?php echo $row['id']; ?></td>
												<td><?php echo $row['sname']; ?></td>
												<td><?php echo $row['sdepart']; ?></td>
												<td><?php echo $row['sdays']; ?></td>
												<td><?php echo $row['sfrom']; echo" - "; echo $row['sto']; ?></td>
												
												
												
											</tr>
											<?php
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
	</section>

	
<?php 
require_once('includes/footer.php')
?>