<?php
require_once('includes/auth_check.php');
require_once('includes/header.php');
require_once('includes/sidebar.php');
?>
        <div class="page-wrapper">
            	<!-- Page Content -->
                <div class="content container-fluid">

                	<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.php">Dashboard </a></li>
									<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
									<li class="breadcrumb-item active">Settings</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->

					<div class="settings-menu-links">
						<ul class="nav nav-tabs menu-tabs">
							<li class="nav-item active">
								<a class="nav-link" href="settings.php">General Settings</a>
							</li>
                            <li class="nav-item">
								<a class="nav-link" href="profile.php">My Profile</a>
							</li>
							
							
					
							
							<li class="nav-item">
								<a class="nav-link" href="change-password.php">Change Password</a>
							</li>
                           
							
						</ul>
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="card">
								<div class="card-header">
									<h5 class="card-title">Website Basic Details</h5>
								</div>
								<div class="card-body pt-0">
									<form>
										<div class="settings-form">
											<div class="input-block">
												<label>Website Name <span class="star-red">*</span></label>
												<input type="text" class="form-control" placeholder="Enter Website Name">
											</div>
											<div class="input-block ">
												<p class="settings-label">Logo <span class="star-red">*</span></p>
												<div class="settings-btn">
													<input type="file" accept="image/*" name="image" id="file" onchange="if (!window.__cfRLUnblockHandlers) return false; loadFile(event)" class="hide-input" data-cf-modified-bbf41e852b3e85ab8ea97df7-="">
													<label for="file" class="upload">
														<i class="feather-upload"></i>
													</label>
												</div>
												<h6 class="settings-size">Recommended image size is <span>150px x 150px</span></h6>
												<div class="upload-images">
													<img src="assets/img/logo-dark.png" alt="Image">
													<a href="javascript:void(0);" class="btn-icon logo-hide-btn">
														<i class="feather-x-circle"></i>
													</a>
												</div>
											</div>
											<div class="input-block">
												<p class="settings-label">Favicon <span class="star-red">*</span></p>
												<div class="settings-btn">
													<input type="file" accept="image/*" name="image" id="files" onchange="if (!window.__cfRLUnblockHandlers) return false; loadFile(event)" class="hide-input" data-cf-modified-bbf41e852b3e85ab8ea97df7-="">
													<label for="file" class="upload">
														<i class="feather-upload"></i>
													</label>
												</div>
												<h6 class="settings-size">
													Recommended image size is <span>16px x 16px or 32px x 32px</span>
												</h6>
												<h6 class="settings-size mt-1">Accepted formats: only png and ico</h6>
												<div class="upload-images upload-size">
													<img src="assets/img/favicon.png" alt="Image">
													<a href="javascript:void(0);" class="btn-icon logo-hide-btn">
														<i class="feather-x-circle"></i>
													</a>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-5 col-md-6">
													<div class="input-block">
														<div class="status-toggle d-flex justify-content-between align-items-center">
															<p class="mb-0">RTL</p>
															<input type="checkbox" id="status_1" class="check">
															<label for="status_1" class="checktoggle">checkbox</label>
														</div>
													</div>
												</div>
											</div>
											<div class="input-block mb-0">
												<div class="settings-btns">
													<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">Update</button>&nbsp;&nbsp;
													<button type="submit" class="btn btn-secondary btn-rounded">Cancel</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="card">
								<div class="card-header">
									<h5 class="card-title">Address Details</h5>
								</div>
								<div class="card-body pt-0">
									<form>
										<div class="settings-form">
											<div class="input-block">
												<label>Address Line 1 <span class="star-red">*</span></label>
												<input type="text" class="form-control" placeholder="Enter Address Line 1">
											</div>
											<div class="input-block">
												<label>Address Line 2 <span class="star-red">*</span></label>
												<input type="text" class="form-control" placeholder="Enter Address Line 2">
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="input-block">
														<label>City <span class="star-red">*</span></label>
														<input type="text" class="form-control">
													</div>
												</div>
												<div class="col-md-6">
													<div class="input-block">
														<label>State/Province <span class="star-red">*</span></label>
														<select class="select form-control">
															<option selected="selected">Select</option>
															<option>California</option>
															<option>Tasmania</option>  
															<option>Auckland</option>
															<option>Marlborough</option>
														</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="input-block">
														<label>Zip/Postal Code <span class="star-red">*</span></label>
														<input type="text" class="form-control">
													</div>
												</div>
												<div class="col-md-6">
													<div class="input-block">
														<label>Country <span class="star-red">*</span></label>
														<select class="select form-control">
															<option selected="selected">Select</option>
															<option>India</option>
															<option>London</option>  
															<option>France</option>
															<option>USA</option>
														</select>
													</div>
												</div>
											</div>
											<div class="input-block mb-0">
												<div class="settings-btns">
													<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">Update</button>&nbsp;&nbsp;
													<button type="submit" class="btn btn-secondary btn-rounded">Cancel</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					
                </div>
				<!-- /Page Content -->
			
        </div>
<?php 
require_once('includes/footer.php');
?>