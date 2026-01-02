<?php
require_once '../../../core/init.php';

require_login();
if(!has_permission("doctors", "can_add")) {
    showalert("error", "Access Denied You Are Not Authorize Persion");	
	exit;
}
?>
<!-- Add Doctor Modal -->
<div class="modal fade" id="addDoctorModal" tabindex="-1" aria-labelledby="addDoctorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDoctorLabel">Add New Doctor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="add_doctor_form" enctype="multipart/form-data" novalidate> 
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
    
                    <div class="accordion" id="doctorFormAccordion">

                        <!-- Doctor Basic Details -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingBasic">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBasic" aria-expanded="true" aria-controls="collapseBasic">
                                    Doctor Basic Details
                                </button>
                            </h2>
                            <div id="collapseBasic" class="accordion-collapse collapse show" aria-labelledby="headingBasic" data-bs-parent="#doctorFormAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="first_name">First Name <span class="login-danger">*</span></label>
                                                <input id="first_name" name="first_name" class="form-control" type="text" placeholder="Enter First name">
                                                <span class="error" id="first_name_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="middle_name">Middel Name <span class="login-danger">*</span></label>
                                                <input id="middle_name" name="middle_name" class="form-control" type="text" placeholder="Enter Middel name">
                                                <span class="error" id="middle_name_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="last_name">Last Name <span class="login-danger">*</span></label>
                                                <input id="last_name" name="last_name" class="form-control" type="text" placeholder="Enter Last name">
                                                <span class="error" id="last_name_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="qualification">Qualification <span class="login-danger">*</span></label>
                                                <input id="qualification" name="qualification" class="form-control" type="text" placeholder="e.g. MBBS, MD">
                                                <span class="error" id="qualification_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="specialty">Speciality <span class="login-danger">*</span></label>
                                                <input id="specialty" name="specialty" class="form-control" type="text" placeholder="e.g. Cardiology, Dermatology">
                                                <span class="error" id="specialty_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="sub_specialty">Sub Speciality</label>
                                                <input id="sub_specialty" name="sub_specialty" class="form-control" type="text" placeholder="Optional: e.g. Pediatric Cardiology">
                                                <span class="error" id="sub_specialty_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="department_id">Department <span class="login-danger">*</span></label>
                                                <select id="department_id" name="department_id" class="form-control form-select">
                                                    <!-- option inserted dynamically -->
                                                </select>
                                                <span class="error" id="department_id_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="years_experience">Years of Experience <span class="login-danger">*</span></label>
                                                <input id="years_experience" min="0" max="99" name="years_experience" class="form-control" type="number" placeholder="Enter number of years">
                                                <span class="error" id="years_experience_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- License Details -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingLicense">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLicense" aria-expanded="false" aria-controls="collapseLicense">
                                    License Details
                                </button>
                            </h2>
                            <div id="collapseLicense" class="accordion-collapse collapse" aria-labelledby="headingLicense" data-bs-parent="#doctorFormAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="medical_license_no">Medical License No <span class="login-danger">*</span></label>
                                                <input id="medical_license_no" name="medical_license_no" class="form-control" type="text" placeholder="Enter license number">
                                                <span class="error" id="medical_license_no_error"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="license_issue_date">License Issue Date <span class="login-danger">*</span></label>
                                                <input id="license_issue_date" name="license_issue_date" class="form-control datetimepicker" type="date">
                                                <span class="error" id="license_issue_date_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="license_expiry_date">License Expiry Date <span class="login-danger">*</span></label>
                                                <input id="license_expiry_date" name="license_expiry_date" class="form-control datetimepicker" type="date">
                                                <span class="error" id="license_expiry_date_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Availability & Fee -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingAvailability">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAvailability" aria-expanded="false" aria-controls="collapseAvailability">
                                    Availability & Fee
                                </button>
                            </h2>
                            <div id="collapseAvailability" class="accordion-collapse collapse" aria-labelledby="headingAvailability" data-bs-parent="#doctorFormAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="consultation_fee">Consultation Fee <span class="login-danger">*</span></label>
                                                <input id="consultation_fee" name="consultation_fee" class="form-control" type="number" step="0.01" placeholder="Enter fee in USD">
                                                <span class="error" id="consultation_fee_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="available_days">Available Days <span class="login-danger">*</span></label>
                                                <input id="available_days" name="available_days" class="form-control" type="text" placeholder="Mon, Tue, Wed">
                                                <span class="error" id="available_days_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-block local-forms">
                                                <label for="available_time_from">Time From <span class="login-danger">*</span></label>
                                                <input id="available_time_from" name="available_time_from" class="form-control" type="time">
                                                <span class="error" id="available_time_from_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-block local-forms">
                                                <label for="available_time_to">Time To <span class="login-danger">*</span></label>
                                                <input id="available_time_to" name="available_time_to" class="form-control" type="time">
                                                <span class="error" id="available_time_to_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Personal Info -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingPersonal">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePersonal" aria-expanded="false" aria-controls="collapsePersonal">
                                    Personal Info
                                </button>
                            </h2>
                            <div id="collapsePersonal" class="accordion-collapse collapse" aria-labelledby="headingPersonal" data-bs-parent="#doctorFormAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="dob">Date of Birth <span class="login-danger">*</span></label>
                                                <input id="dob" name="dob" class="form-control" type="date">
                                                <span class="error" id="dob_error"></span>
                                            </div>
                                        </div>    
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="profile_image">Profile Image <span class="login-danger">*</span></label>
                                                <input id="profile_image" type="file" name="profile_image" class="form-control">
                                                <span class="error" id="profile_image_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="languages_spoken">Languages Spoken <span class="login-danger">*</span></label>
                                                <input id="languages_spoken" name="languages_spoken" class="form-control" type="text" placeholder="English, Hindi">
                                                <span class="error" id="languages_spoken_error"></span>
                                            </div>
                                        </div>           
                                        <div class="col-md-5">
                                            <label class="mb-2 d-block">Gender <span class="login-danger">*</span></label>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" id="gender_male" value="male">
                                                <label class="form-check-label" for="gender_male">Male</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" id="gender_female" value="female">
                                                <label class="form-check-label" for="gender_female">Female</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" id="gender_other" value="other">
                                                <label class="form-check-label" for="gender_other">Other</label>
                                            </div><br>
                                                <span class="error" id="gender_error"></span>
                                        </div>
                                            
                                        <div class="col-md-7">
                                            <div class="input-block local-forms">
                                                <label for="bio">Bio <span class="login-danger">*</span></label>
                                                <textarea id="bio" name="bio" class="form-control" rows="3" placeholder="Short bio about the doctor"></textarea>
                                                <small class="text-muted">
                                                    <span id="bio_count">0</span>/300 characters used
                                                </small>
                                                <span class="error" id="bio_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Doctor Address Details -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingAddress">
                                <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseAddress"
                                        aria-expanded="false"
                                        aria-controls="collapseAddress">
                                    Doctor Address Details
                                </button>
                            </h2>

                            <div id="collapseAddress"
                                class="accordion-collapse collapse"
                                aria-labelledby="headingAddress"
                                data-bs-parent="#doctorFormAccordion">

                                <div class="accordion-body">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="input-block local-forms">
                                                <label for="street">Street Address <span class="login-danger">*</span></label>
                                                <input id="street" name="street" class="form-control" type="text"
                                                    placeholder="Enter street / area">
                                                <span class="error" id="street_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="input-block local-forms">
                                                <label for="city">City <span class="login-danger">*</span></label>
                                                <input id="city" name="city" class="form-control" type="text"
                                                    placeholder="Enter city">
                                                <span class="error" id="city_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="input-block local-forms">
                                                <label for="state">State <span class="login-danger">*</span></label>
                                                <input id="state" name="state" class="form-control" type="text"
                                                    placeholder="Enter state">
                                                <span class="error" id="state_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="input-block local-forms">
                                                <label for="pincode">Pincode <span class="login-danger">*</span></label>
                                                <input id="pincode" name="pincode" class="form-control" type="text"
                                                    placeholder="Enter pincode">
                                                <span class="error" id="pincode_error"></span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Login Details -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingLogin">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLogin" aria-expanded="false" aria-controls="collapseLogin">
                                    User Login Details
                                </button>
                            </h2>
                            <div id="collapseLogin" class="accordion-collapse collapse" aria-labelledby="headingLogin" data-bs-parent="#doctorFormAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-block local-forms">
                                                <label for="email">Email <span class="login-danger">*</span></label>
                                                <div class="d-flex align-items-center gap-2">
                                                    <input id="email" name="email" class="form-control" type="email" placeholder="Enter email address">
                                                    <!-- Verification Icon -->
                                                    <span id="email_verified_icon" class="email_verified_icon" style="display: none; font-size:20px; color:green;">✔️</span>

                                                    <!-- Send Verification Button -->
                                                    <button type="button" id="send_verification_btn" name="send_verification" class="btn btn-sm btn-success send_verification_btn">
                                                        Send
                                                    </button>
                                                </div>
                                                <span class="error" id="email_error"></span>
                                            </div>
                                        </div>
                                        <!-- OTP Field -->
                                        <div class="col-md-6 otp_block" id="otp_block" style="display:none;">
                                            <div class="input-block local-forms">
                                                <label>Enter OTP <span class="login-danger">*</span></label>

                                                <div class="d-flex align-items-center gap-2">

                                                    <input type="text" name="otp" id="otp"
                                                        placeholder="Enter OTP"
                                                        class="form-control form-control-sm" style="max-width: 240px;">
                    
                                                    <button type="button" id="verify_otp_btn" name="verify_otp"
                                                            class="btn btn-primary btn-md verify_otp_btn">
                                                        Verify OTP
                                                    </button>
                                                
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
                                        <div class="col-md-6">
                                            <div class="input-block local-forms">
                                                <label for="phone">Phone <span class="login-danger">*</span></label>
                                                <input id="phone" name="phone" class="form-control" type="text" placeholder="Enter phone number">
                                                <span class="error" id="phone_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-block local-forms">
                                                <label for="password">Password <span class="login-danger">*</span></label>
                                                <input id="password" name="password" class="form-control" type="password" placeholder="Enter password">
                                                <span class="error" id="password_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-block local-forms">
                                                <label for="confirm_pssword">Confirm Password <span class="login-danger">*</span></label>
                                                <input id="confirm_password" name="confirm_password" class="form-control" type="password" placeholder="Enter confirm password">
                                                <span class="error" id="confirm_password_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Other Settings -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOther">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOther" aria-expanded="false" aria-controls="collapseOther">
                                    Other Settings
                                </button>
                            </h2>
                            <div id="collapseOther" class="accordion-collapse collapse" aria-labelledby="headingOther" data-bs-parent="#doctorFormAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                       
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="status">Account Status <span class="login-danger">*</span></label>
                                                <select id="status" name="status" class="form-control form-select">
                                                    <option value="">Select</option>
                                                    <option value="active">Active</option>
                                                    <option value="inactive">Inactive</option>
                                                    <option value="blocked">Blocked</option>
                                                </select>
                                                <span class="error" id="status_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="doctor_status">Doctor Status <span class="login-danger">*</span></label>
                                                <select id="doctor_status" name="doctor_status" class="form-control form-select">
                                                    <option value="">Select</option>
                                                    <option value="active">Active</option>
                                                    <option value="inactive">Inactive</option>
                                                    <option value="suspended">Suspended</option>
                                                    <option value="retired">Retired</option>
                                                </select>
                                                <span class="error" id="doctor_status_error"></span>
                                            </div>
                                        </div>

                                        <!-- Online Consultation -->
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="is_consultation_online">
                                                    Online Consultation <span class="login-danger">*</span>
                                                </label>
                                                <select id="is_consultation_online" name="is_consultation_online" class="form-select form-control">
                                                    <option value="">Select</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <span class="error" id="is_consultation_online_error"></span>
                                            </div>
                                        </div>

                                        <!-- Two Factor Authentication -->
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="two_fa_enabled">
                                                    Two Factor Authentication
                                                </label>
                                                <select id="two_fa_enabled" name="two_fa_enabled" class="form-select form-control">
                                                    <option value="">Select</option>
                                                    <option value="0">Disabled</option>
                                                    <option value="1">Enabled</option>
                                                </select>
                                                <span class="error" id="two_fa_enabled_error"></span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- accordion end -->

                    <div class="col-12 text-end mt-3">
                        <button type="button" class="btn btn-secondary me-2 cancel-form" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="save_doctor" class="btn btn-primary">Create Doctor</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

