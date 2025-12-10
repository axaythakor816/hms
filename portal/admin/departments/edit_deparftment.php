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
								<li class="breadcrumb-item"><a href="departments.php">Department </a></li>
								<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
								<li class="breadcrumb-item active">Edit Department</li>
							</ul>
						</div>
					</div>
				</div>
                <?php 
    			
				$id=$_GET['id'];
				$select="SELECT * FROM department WHERE id='$id'";
				$data=mysqli_query($conn,$select);
				$row=mysqli_fetch_array($data);

				?>
				<!-- /Page Header -->
				<div class="row">
					<div class="col-sm-12">
					
						<div class="card">
							<div class="card-body">
                            <form action="#" method="POST">
									<div class="row">
										<div class="col-12">
											<div class="form-heading">
												<h4>Add Department</h4>
											</div>
										</div>
										<div class="col-12 col-md-6 col-xl-6">  
											<div class="input-block local-forms">
												<label >Department Name <span class="login-danger">*</span></label>
												<input value="<?php echo $row['depart']?>" name="depart" class="form-control" type="text" >
											</div>
										</div>
                                        <div class="col-12 col-md-6 col-xl-6">  
											<div class="input-block local-forms">
												<label >Department Head <span class="login-danger">*</span></label>
												<input value="<?php echo $row['head']?>" name="head" class="form-control" type="text" >
											</div>
										</div>
										
										<div class="col-12">
											<div class="doctor-submit text-end">
												<button name="update" type="submit" class="btn btn-primary submit-form me-2">Create Department</button>
												
											</div>
										</div>
									</div>
								</form>

                                <?php
                                if (isset($_POST['update']))
                                {
                                    $depart=$_POST['depart'];
									$head=$_POST['head'];
									


                                $update="UPDATE department SET depart='$depart',head='$head' WHERE id='$id'";

								
                                $data=mysqli_query($conn,$update);
                                if($data){
                                    ?>
                                    <script type="text/javascript">
                                        alert("data update successfully");
                                        window.open("departments.php","_self");
                                    </script>
                                    <?php
                                }else{
                                    ?>
                                    <script type="text/javascript">
                                        alert("please try again");
                                    </script>
                                    <?php
                                }
                            }
							?>
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