<?php
require_once '../../../core/init.php';

require_login();
if(!has_permission("doctors", "can_edit")) {
    showalert("error", "Access Denied You Are Not Authorize Persion");	
	exit;
}
?>

<!-- Edit Doctor Modal -->
<div class="modal fade" id="editDoctorModal" tabindex="-1" aria-labelledby="editDoctorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDoctorLabel">Edit Doctor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="edit_doctor_form" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

                    
                    <!-- Hidden doctor ID -->
                    <input type="hidden" name="doctor_id" id="edit_doctor_id">

                    <div class="accordion" id="editDoctorFormAccordion">

                        <!-- Doctor Basic Details -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="editHeadingBasic">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#editCollapseBasic" aria-expanded="true" aria-controls="editCollapseBasic">
                                    Doctor Basic Details
                                </button>
                            </h2>
                            <div id="editCollapseBasic" class="accordion-collapse collapse show" aria-labelledby="editHeadingBasic" data-bs-parent="#editDoctorFormAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="edit_first_name">First Name <span class="login-danger">*</span></label>
                                                <input id="edit_first_name" name="first_name" class="form-control" type="text" placeholder="Enter First name">
                                                <span class="error" id="edit_first_name_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="edit_middle_name">Middle Name <span class="login-danger">*</span></label>
                                                <input id="edit_middle_name" name="middle_name" class="form-control" type="text" placeholder="Enter Middle name">
                                                <span class="error" id="edit_middle_name_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="edit_last_name">Last Name <span class="login-danger">*</span></label>
                                                <input id="edit_last_name" name="last_name" class="form-control" type="text" placeholder="Enter Last name">
                                                <span class="error" id="edit_last_name_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="edit_qualification">Qualification <span class="login-danger">*</span></label>
                                                <input id="edit_qualification" name="qualification" class="form-control" type="text" placeholder="e.g. MBBS, MD">
                                                <span class="error" id="edit_qualification_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="edit_specialty">Speciality <span class="login-danger">*</span></label>
                                                <input id="edit_specialty" name="specialty" class="form-control" type="text" placeholder="e.g. Cardiology, Dermatology">
                                                <span class="error" id="edit_specialty_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="edit_sub_specialty">Sub Speciality</label>
                                                <input id="edit_sub_specialty" name="sub_specialty" class="form-control" type="text" placeholder="Optional: e.g. Pediatric Cardiology">
                                                <span class="error" id="edit_sub_specialty_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="edit_department_id">Department <span class="login-danger">*</span></label>
                                                <select id="edit_department_id" name="department_id" class="form-control form-select">
                                                    <!-- option inserted dynamically -->
                                                </select>
                                                <span class="error" id="edit_department_id_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="edit_years_experience">Years of Experience <span class="login-danger">*</span></label>
                                                <input id="edit_years_experience" min="0" max="99" name="years_experience" class="form-control" type="number" placeholder="Enter number of years">
                                                <span class="error" id="edit_years_experience_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- License Details -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="editHeadingLicense">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#editCollapseLicense" aria-expanded="false" aria-controls="editCollapseLicense">
                                    License Details
                                </button>
                            </h2>
                            <div id="editCollapseLicense" class="accordion-collapse collapse" aria-labelledby="editHeadingLicense" data-bs-parent="#editDoctorFormAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="edit_medical_license_no">Medical License No <span class="login-danger">*</span></label>
                                                <input id="edit_medical_license_no" name="medical_license_no" class="form-control" type="text" placeholder="Enter license number">
                                                <span class="error" id="edit_medical_license_no_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="edit_license_issue_date">License Issue Date <span class="login-danger">*</span></label>
                                                <input id="edit_license_issue_date" name="license_issue_date" class="form-control datetimepicker" type="date">
                                                <span class="error" id="edit_license_issue_date_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="edit_license_expiry_date">License Expiry Date <span class="login-danger">*</span></label>
                                                <input id="edit_license_expiry_date" name="license_expiry_date" class="form-control datetimepicker" type="date">
                                                <span class="error" id="edit_license_expiry_date_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Availability & Fee -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="editHeadingAvailability">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#editCollapseAvailability" aria-expanded="false" aria-controls="editCollapseAvailability">
                                    Availability & Fee
                                </button>
                            </h2>
                            <div id="editCollapseAvailability" class="accordion-collapse collapse" aria-labelledby="editHeadingAvailability" data-bs-parent="#editDoctorFormAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="edit_consultation_fee">Consultation Fee <span class="login-danger">*</span></label>
                                                <input id="edit_consultation_fee" name="consultation_fee" class="form-control" type="number" step="0.01" placeholder="Enter fee in USD">
                                                <span class="error" id="edit_consultation_fee_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="edit_available_days">Available Days <span class="login-danger">*</span></label>
                                                <input id="edit_available_days" name="available_days" class="form-control" type="text" placeholder="Mon, Tue, Wed">
                                                <span class="error" id="edit_available_days_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-block local-forms">
                                                <label for="edit_available_time_from">Time From <span class="login-danger">*</span></label>
                                                <input id="edit_available_time_from" name="available_time_from" class="form-control" type="time">
                                                <span class="error" id="edit_available_time_from_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-block local-forms">
                                                <label for="edit_available_time_to">Time To <span class="login-danger">*</span></label>
                                                <input id="edit_available_time_to" name="available_time_to" class="form-control" type="time">
                                                <span class="error" id="edit_available_time_to_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Personal Info -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="editHeadingPersonal">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#editCollapsePersonal" aria-expanded="false" aria-controls="editCollapsePersonal">
                                    Personal Info
                                </button>
                            </h2>
                            <div id="editCollapsePersonal" class="accordion-collapse collapse" aria-labelledby="editHeadingPersonal" data-bs-parent="#editDoctorFormAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="edit_dob">Date of Birth <span class="login-danger">*</span></label>
                                                <input id="edit_dob" name="dob" class="form-control" type="date">
                                                <span class="error" id="edit_dob_error"></span>
                                            </div>
                                        </div>    
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="edit_profile_image">Profile Image <span class="login-danger"></span></label>
                                                <input id="edit_profile_image" type="file" name="profile_image" class="form-control">
                                                <span class="error" id="edit_profile_image_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="edit_languages_spoken">Languages Spoken <span class="login-danger">*</span></label>
                                                <input id="edit_languages_spoken" name="languages_spoken" class="form-control" type="text" placeholder="English, Hindi">
                                                <span class="error" id="edit_languages_spoken_error"></span>
                                            </div>
                                        </div>           
                                        <div class="col-md-5">
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
                                            </div><br>
                                            <span class="error" id="edit_gender_error"></span>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-block local-forms">
                                                <label for="edit_bio">Bio <span class="login-danger">*</span></label>
                                                <textarea id="edit_bio" name="bio" class="form-control" rows="3" placeholder="Short bio about the doctor"></textarea>
                                                <small class="text-muted">
                                                    <span id="edit_bio_count">0</span>/300 characters used
                                                </small>
                                                <span class="error" id="edit_bio_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Doctor Address Details -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="editHeadingAddress">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#editCollapseAddress" aria-expanded="false" aria-controls="editCollapseAddress">
                                    Doctor Address Details
                                </button>
                            </h2>
                            <div id="editCollapseAddress" class="accordion-collapse collapse" aria-labelledby="editHeadingAddress" data-bs-parent="#editDoctorFormAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-block local-forms">
                                                <label for="edit_street">Street Address <span class="login-danger">*</span></label>
                                                <input id="edit_street" name="street" class="form-control" type="text" placeholder="Enter street / area">
                                                <span class="error" id="edit_street_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-block local-forms">
                                                <label for="edit_city">City <span class="login-danger">*</span></label>
                                                <input id="edit_city" name="city" class="form-control" type="text" placeholder="Enter city">
                                                <span class="error" id="edit_city_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-block local-forms">
                                                <label for="edit_state">State <span class="login-danger">*</span></label>
                                                <input id="edit_state" name="state" class="form-control" type="text" placeholder="Enter state">
                                                <span class="error" id="edit_state_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-block local-forms">
                                                <label for="edit_pincode">Pincode <span class="login-danger">*</span></label>
                                                <input id="edit_pincode" name="pincode" class="form-control" type="text" placeholder="Enter pincode">
                                                <span class="error" id="edit_pincode_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Login Details -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="editHeadingLogin">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#editCollapseLogin" aria-expanded="false" aria-controls="editCollapseLogin">
                                    User Login Details
                                </button>
                            </h2>
                            <div id="editCollapseLogin" class="accordion-collapse collapse" aria-labelledby="editHeadingLogin" data-bs-parent="#editDoctorFormAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-block local-forms">
                                                <label for="edit_email">Email <span class="login-danger">*</span></label>
                                                <div class="d-flex align-items-center gap-2">
                                                    <input id="edit_email" name="email" class="form-control" type="email" placeholder="Enter email address">
                                                    <span id="edit_email_verified_icon" class="email_verified_icon" style="display: none; font-size:20px; color:green;">✔️</span>
                                                    <button type="button" id="edit_send_verification_btn" name="send_verification" class="btn btn-sm btn-success send_verification_btn">
                                                        Send
                                                    </button>
                                                </div>
                                                <span class="error" id="edit_email_error"></span>
                                            </div>
                                        </div>
										<input type="hidden" name="email_verified" id="edit_email_verified" value="">

                                        <!-- OTP Field -->
                                        <div class="col-md-6 otp_block" id="edit_otp_block" style="display:none;">
                                            <div class="input-block local-forms">
                                                <label>Enter OTP <span class="login-danger">*</span></label>
                                                <div class="d-flex align-items-center gap-2">
                                                    <input type="text" name="otp" id="edit_otp" placeholder="Enter OTP" class="form-control form-control-sm" style="max-width: 240px;">
                                                    <button type="button" id="edit_verify_otp_btn" class="btn btn-primary btn-md verify_otp_btn">Verify OTP</button>
                                                </div>
                                                <div class="mt-1 d-flex align-items-center gap-3">
                                                    <small class="text-muted">OTP expires in <span id="edit_otp_timer" class="otp_timer">05:00</span></small>
                                                    <button type="button" name="resend_otp" id="edit_resend_otp_btn" class="btn p-1 btn-info btn-sm">Resend OTP</button>
                                                </div>
                                                <span class="error" id="edit_otp_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="input-block local-forms">
                                                <label for="edit_phone">Phone <span class="login-danger">*</span></label>
                                                <input id="edit_phone" name="phone" class="form-control" type="text" placeholder="Enter mobile number">
                                                <span class="error" id="edit_phone_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="input-block local-forms">
                                                <label for="edit_password">Password <span class="login-danger"></span></label>
                                                <input id="edit_password" name="password" class="form-control" type="password" placeholder="Enter password">
                                                <span class="error" id="edit_password_error"></span>
                                            </div>
                                        </div>
										<div class="col-md-6">
                                            <div class="input-block local-forms">
                                                <label for="edit_confirm_pssword">Confirm Password <span class="login-danger"></span></label>
                                                <input id="edit_confirm_pssword" name="confirm_password" class="form-control" type="password" placeholder="Enter confirm password">
                                                <span class="error" id="edit_confirm_pssword_error"></span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

						<!-- Other Settings -->
						<div class="accordion-item">
							<h2 class="accordion-header" id="editHeadingOther">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#editCollapseOther" aria-expanded="false" aria-controls="editCollapseOther">
									Other Settings
								</button>
							</h2>
							<div id="editCollapseOther" class="accordion-collapse collapse" aria-labelledby="editHeadingOther" data-bs-parent="#editDoctorFormAccordion">
								<div class="accordion-body">
									<div class="row">

										<!-- Account Status -->
										<div class="col-md-4">
											<div class="input-block local-forms">
												<label for="edit_status">Account Status <span class="login-danger">*</span></label>
												<select id="edit_status" name="status" class="form-control form-select">
													<option value="" disabled selected>Select account status</option>
													<option value="active">Active</option>
													<option value="inactive">Inactive</option>
													<option value="blocked">Blocked</option>
												</select>
												<span class="error" id="edit_status_error"></span>
											</div>
										</div>

										<!-- Doctor Status -->
										<div class="col-md-4">
											<div class="input-block local-forms">
												<label for="edit_doctor_status">Doctor Status <span class="login-danger">*</span></label>
												<select id="edit_doctor_status" name="doctor_status" class="form-control form-select">
													<option value="" disabled selected>Select doctor status</option>
													<option value="active">Active</option>
													<option value="inactive">Inactive</option>
													<option value="suspended">Suspended</option>
													<option value="retired">Retired</option>
												</select>
												<span class="error" id="edit_doctor_status_error"></span>
											</div>
										</div>

										<!-- Online Consultation -->
										<div class="col-md-4">
											<div class="input-block local-forms">
												<label for="edit_is_consultation_online">Online Consultation <span class="login-danger">*</span></label>
												<select id="edit_is_consultation_online" name="is_consultation_online" class="form-select form-control">
													<option value="" disabled selected>Select option</option>
													<option value="1">Yes</option>
													<option value="0">No</option>
												</select>
												<span class="error" id="edit_is_consultation_online_error"></span>
											</div>
										</div>

										<!-- Two Factor Authentication -->
										<div class="col-md-4 mt-2">
											<div class="input-block local-forms">
												<label for="edit_two_fa_enabled">Two Factor Authentication <span class="login-danger">*</span> </label>
												<select id="edit_two_fa_enabled" name="two_fa_enabled" class="form-select form-control">
													<option value="" disabled selected>Select option</option>
													<option value="0">Disabled</option>
													<option value="1">Enabled</option>
												</select>
												<span class="error" id="edit_two_fa_enabled_error"></span>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>

                    </div>

                    <div class="mt-3 text-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="edit_save_btn">Update Doctor</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
