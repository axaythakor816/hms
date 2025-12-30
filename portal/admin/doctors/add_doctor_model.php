<!-- Add Doctor Modal -->
<div class="modal fade" id="addDoctorModal" tabindex="-1" aria-labelledby="addDoctorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDoctorLabel">Add New Doctor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">

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
                                                <label for="display_name">Display Name <span class="login-danger">*</span></label>
                                                <input id="display_name" name="display_name" class="form-control" type="text" placeholder="Enter full name">
                                                <span class="error" id="display_name_error"></span>
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
                                                <select id="department_id" name="department_id" class="form-control select">
                                                    <option value="">Select Department</option>
                                                    <option value="1">Orthopedist</option>
                                                    <option value="2">Skin Specialist</option>
                                                    <option value="3">Psychology</option>
                                                    <option value="4">Neurologist</option>
                                                    <option value="5">Dentist</option>
                                                    <option value="6">Cardiologist</option>
                                                    <option value="7">Gynecologist</option>
                                                </select>
                                                <span class="error" id="department_id_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="years_experience">Years of Experience <span class="login-danger">*</span></label>
                                                <input id="years_experience" name="years_experience" class="form-control" type="number" placeholder="Enter number of years">
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
                                                <label for="languages_spoken">Languages Spoken <span class="login-danger">*</span></label>
                                                <input id="languages_spoken" name="languages_spoken" class="form-control" type="text" placeholder="English, Hindi">
                                                <span class="error" id="languages_spoken_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-block local-forms">
                                                <label for="bio">Bio <span class="login-danger">*</span></label>
                                                <textarea id="bio" name="bio" class="form-control" rows="3" placeholder="Short bio about the doctor"></textarea>
                                                <span class="error" id="bio_error"></span>
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
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="email">Email <span class="login-danger">*</span></label>
                                                <input id="email" name="email" class="form-control" type="email" placeholder="Enter email address">
                                                <span class="error" id="email_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="phone">Phone <span class="login-danger">*</span></label>
                                                <input id="phone" name="phone" class="form-control" type="text" placeholder="Enter phone number">
                                                <span class="error" id="phone_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-forms">
                                                <label for="password">Password <span class="login-danger">*</span></label>
                                                <input id="password" name="password" class="form-control" type="password" placeholder="Enter password">
                                                <span class="error" id="password_error"></span>
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
                                            <div class="input-block select-gender">
                                                <label for="is_consultation_online">Consultation Online? <span class="login-danger">*</span></label>
                                                <select id="is_consultation_online" name="is_consultation_online" class="form-control">
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                                <span class="error" id="is_consultation_online_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block">
                                                <label for="is_enabled">Status <span class="login-danger">*</span></label>
                                                <select id="is_enabled" name="is_enabled" class="form-control">
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                                <span class="error" id="is_enabled_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-block local-top-form">
                                                <label for="photo_url">Profile Photo <span class="login-danger">*</span></label>
                                                <input id="photo_url" type="file" name="photo_url" class="form-control">
                                                <span class="error" id="photo_url_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- accordion end -->

                    <div class="col-12 text-end mt-3">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>