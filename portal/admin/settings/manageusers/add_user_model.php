<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('manage users', 'can_add')) {
    showalert("error", "Access Denied");
    exit;
}

require_role([1, 6]);
?>

<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form id="adduser_form" novalidate>

                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

                    <div class="row">

                        <!-- First Name -->
                        <div class="col-md-6">
                            <div class="input-block local-forms">
                                <label>First Name <span class="login-danger">*</span></label>
                                <input type="text" name="first_name" id="first_name" placeholder="Enter First name" class="form-control">
                                <span class="error" id="first_name_error"></span>
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6">
                            <div class="input-block local-forms">
                                <label>Last Name <span class="login-danger">*</span></label>
                                <input type="text" name="last_name" id="last_name" placeholder="Enter Last Name" class="form-control">
                                <span class="error" id="last_name_error"></span>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mt-3">
                            <div class="input-block local-forms">
                                <label>Email <span class="login-danger">*</span></label>

                                <div class="d-flex align-items-center gap-2">
                                    <!-- Email Input -->
                                    <input type="email" name="email" id="email" placeholder="Enter Email Address" class="form-control">

                                    <!-- Verification Icon -->
                                    <span id="email_verified_icon" class="email_verified_icon" style="font-size:20px; color:green;">✔️</span>

                                    <!-- Send Verification Button -->
                                    <button type="button" id="send_verification_btn" name="send_verification" class="btn btn-sm btn-success send_verification_btn">
                                        Send
                                    </button>
                                </div>
                            
                                <span class="error" id="email_error"></span>
                            </div>
                        </div>

                        <!-- OTP Field -->
                        <div class="col-md-6 mt-3 otp_block" id="otp_block" style="display:none;">
                            <div class="input-block local-forms">
                                <label>Enter OTP <span class="login-danger">*</span></label>

                                <div class="row g-2 align-items-center">
                                    <div class="col-auto">
                                        <input type="text" name="otp" id="otp"
                                            placeholder="Enter OTP"
                                            class="form-control form-control-sm">
                                    </div>

                                    <div class="col-auto">
                                        <button type="button" id="verify_otp_btn" name="verify_otp"
                                                class="btn btn-primary btn-md verify_otp_btn">
                                            Verify OTP
                                        </button>
                                    </div>
                                </div>

                                <!-- OTP Timer -->
                               <div class="mt-1 d-flex align-items-center gap-3">
                                    <small class="text-muted">
                                        OTP expires in <span id="otp_timer" class="otp_timer">05:00</span>
                                    </small>

                                    <button type="button"
                                            id="resend_otp_btn" name="resend_otp"
                                            class="btn p-1 btn-info text-light resend_otp_btn"
                                            disabled>
                                        Resend OTP
                                    </button>
                                </div>
                                <span class="error" id="otp_error"></span>
                            </div>
                        </div>

                        <!-- Hidden Email Verified Field -->
                        <input type="hidden" name="email_verified" id="email_verified" value="">

                        <!-- Phone -->
                        <div class="col-md-6 mt-3">
                            <div class="input-block local-forms">
                                <label>Phone <span class="login-danger">*</span></label>
                                <input type="text" name="phone" id="phone" placeholder="Enter Phone Number" class="form-control">
                                <span class="error" id="phone_error"></span>

                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 mt-3">
                            <div class="input-block local-forms">
                                <label>Password <span class="login-danger">*</span></label>
                                <input type="password" name="password" id="password" placeholder="Enter Password" class="form-control">
                                <span class="error" id="password_error"></span>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6 mt-3">
                            <div class="input-block local-forms">
                                <label>Confirm Password <span class="login-danger">*</span></label>
                                <input type="password" name="confirm_password" id="confirm_password" placeholder="Enter Confirm Password" class="form-control">
                                <span class="error" id="confirm_password_error"></span>
                            </div>
                        </div>

                        <!-- Role -->
                        <div class="col-md-6 mt-3">
                            <div class="input-block local-forms">
                                <label>Role <span class="login-danger">*</span></label>
                                <select name="role_id" id="role_id" class="form-select form-control">
                                    <!-- roles dynamically load -->
                                </select>
                                <span class="error" id="role_id_error"></span>
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6 mt-3">
                            <label class="mb-2 d-block">Gender <span class="login-danger">*</span></label>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="gender_male" value="Male">
                                <label class="form-check-label" for="gender_male">Male</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="gender_female" value="Female">
                                <label class="form-check-label" for="gender_female">Female</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="gender_other" value="Other">
                                <label class="form-check-label" for="gender_other">Other</label>
                            </div><br>
                                <span class="error" id="gender_error"></span>
                        </div>

                        <!-- Date of Birth -->
                        <div class="col-md-6 mt-3">
                            <div class="input-block local-forms">
                                <label>Date of Birth <span class="login-danger">*</span></label>
                                <input type="date" name="dob" id="dob" class="form-control">
                                <span class="error" id="dob_error"></span>

                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mt-3">
                            <div class="input-block local-forms">
                                <label>Status <span class="login-danger">*</span></label>
                                <select name="status" id="status" class="form-select form-control">
                                    <option value="">Select Options</option>
                                    <option value="active">Active</option>
                                    <!-- <option value="pending">pending</option> -->
                                    <option value="blocked">Blocked</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <span class="error" id="status_error"></span>

                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="save_user" class="btn btn-primary">
                            Create User
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
