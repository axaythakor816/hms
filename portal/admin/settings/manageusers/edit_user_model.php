<?php
require_once '../../../../core/init.php';

require_login();

if(!has_permission('manage users', 'can_edit')) {
    showalert("error", "Access Denied");
    exit;
}

require_role([1,6]);
?>

<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <form id="edituser_form" novalidate>

                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="user_id" id="edit_user_id">

                    <div class="row">

                        <!-- First Name -->
                        <div class="col-md-6">
                            <div class="input-block local-forms">
                                <label>First Name <span class="login-danger">*</span></label>
                                <input type="text" name="first_name" id="edit_first_name" class="form-control" placeholder="Enter First Name">
                                <span class="error" id="edit_first_name_error"></span>
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6">
                            <div class="input-block local-forms">
                                <label>Last Name <span class="login-danger">*</span></label>
                                <input type="text" name="last_name" id="edit_last_name" class="form-control" placeholder="Enter Last Name">
                                <span class="error" id="edit_last_name_error"></span>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mt-3">
                            <div class="input-block local-forms">
                                <label>Email <span class="login-danger">*</span></label>

                                <div class="d-flex align-items-center gap-2">
                                    <!-- Email Input -->
                                    <input type="email" name="email" id="edit_email" placeholder="Enter Email Address" class="form-control">

                                    <!-- Verification Icon -->
                                    <span id="edit_email_verified_icon" class="email_verified_icon" style="font-size:20px; color:green;">✔️</span>

                                    <!-- Send Verification Button -->
                                    <button type="button" id="edit_send_verification_btn" name="send_verification" class="btn btn-sm btn-success send_verification_btn">
                                        Send
                                    </button>
                                </div>
                            
                                <span class="error" id="edit_email_error"></span>
                            </div>
                        </div>

                        <!-- OTP Field -->
                        <div class="col-md-6 mt-3 otp_block" id="otp_block" style="display:none;">
                            <div class="input-block local-forms">
                                <label>Enter OTP <span class="login-danger">*</span></label>

                                <div class="row g-2 align-items-center">
                                    <div class="col-auto">
                                        <input type="text" name="otp" id="edit_otp"
                                            placeholder="Enter OTP"
                                            class="form-control form-control-sm">
                                    </div>

                                    <div class="col-auto">
                                        <button type="button" id="edit_verify_otp_btn" name="verify_otp"
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
                                            id="edit_resend_otp_btn" name="resend_otp"
                                            class="btn p-1 btn-info text-light resend_otp_btn"
                                            disabled>
                                        Resend OTP
                                    </button>
                                </div>
                                <span class="error" id="edit_otp_error"></span>
                            </div>
                        </div>

                        <!-- Hidden Email Verified Field -->
                        <input type="hidden" name="email_verified" id="edit_email_verified" value="">

                        <!-- Phone -->
                        <div class="col-md-6 mt-3">
                            <div class="input-block local-forms">
                                <label>Phone <span class="login-danger">*</span></label>
                                <input type="text" name="phone" id="edit_phone" class="form-control" placeholder="Enter Phone Number">
                                <span class="error" id="edit_phone_error"></span>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 mt-3">
                            <div class="input-block local-forms">
                                <label>Password</label>
                                <input type="password" name="password" id="edit_password" class="form-control" placeholder="Enter New Password">
                                <span class="error" id="edit_password_error"></span>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6 mt-3">
                            <div class="input-block local-forms">
                                <label>Confirm Password</label>
                                <input type="password" name="confirm_password" id="edit_confirm_password" class="form-control" placeholder="Confirm New Password">
                                <span class="error" id="edit_confirm_password_error"></span>
                            </div>
                        </div>

                        <!-- Role -->
                        <div class="col-md-6 mt-3">
                            <div class="input-block local-forms">
                                <label>Role <span class="login-danger">*</span></label>
                                <select name="role_id" id="edit_role_id" class="form-select form-control">
                                    <!-- Options dynamically load -->
                                </select>
                                <span class="error" id="edit_role_id_error"></span>
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6 mt-3">
                            <label class="mb-2 d-block">Gender <span class="login-danger">*</span></label>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="edit_gender_male" value="Male">
                                <label class="form-check-label" for="edit_gender_male">Male</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="edit_gender_female" value="Female">
                                <label class="form-check-label" for="edit_gender_female">Female</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="edit_gender_other" value="Other">
                                <label class="form-check-label" for="edit_gender_other">Other</label>
                            </div>
                            <br>
                            <span class="error" id="edit_gender_error"></span>
                        </div>

                        <!-- Date of Birth -->
                        <div class="col-md-6 mt-3">
                            <div class="input-block local-forms">
                                <label>Date of Birth <span class="login-danger">*</span></label>
                                <input type="date" name="dob" id="edit_dob" class="form-control">
                                <span class="error" id="edit_dob_error"></span>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mt-3">
                            <div class="input-block local-forms">
                                <label>Status <span class="login-danger">*</span></label>
                                <select name="status" id="edit_status" class="form-select form-control">
                                    <option value="">Select Options</option>
                                    <option value="active">Active</option>
                                    <option value="pending" disabled>pending</option>
                                    <option value="blocked">Blocked</option>
                                    <option value="inactive">inactive</option>

                                </select>
                                <span class="error" id="edit_status_error"></span>
                            </div>
                        </div>

                    </div>

                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_user" class="btn btn-primary">Update User</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
