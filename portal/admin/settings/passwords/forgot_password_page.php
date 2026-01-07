<?php
require_once '../../../../core/init.php';

require_login();
if(!has_permission('passwords', 'can_edit')) {
	showalert("error", "Access Denied");
	exit;
}

?>        
<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                        <li class="breadcrumb-item active">Forgot Password</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="send_email_form" novalidate>
                            <div class="row">
                                <h4 class="page-title">Forgot Password</h4>
                                
                                <div class="col-12 col-md-6 col-xl-12">  
                                    <div class="input-block local-forms">
                                        <label>User Name <span class="login-danger">*</span></label>
                                        <input class="form-control" type="text" name="user_name" id="user_name" placeholder="Enter your Registered email Or Number" required>
                                        <span id="user_name_error" class="error"></span>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="doctor-submit text-end">
                                        <button type="submit" name="send_link" class="btn btn-primary submit-form me-2">Send Reset Link</button>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                        <div class="mt-3">
                            <a href="settings/passwords/change_password_page.php" class="text-primary nav-link" style="font-size: 14px;">Back to Settings</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Page Content -->
</div>
<script src="../assets/ajax/passwords.js"></script>
