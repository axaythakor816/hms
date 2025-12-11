<!-- Add Doctor Modal -->
<div class="modal fade" id="addDoctorModal" tabindex="-1" aria-labelledby="addDoctorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- modal-xl for large form -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDoctorLabel">Add New Doctor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>	
            </div>

            <div class="modal-body">
                <form action="#" method="POST">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-heading">
                                <h4>Doctor Details</h4>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-4">  
                            <div class="input-block local-forms">
                                <label >First Name <span class="login-danger">*</span></label>
                                <input name="dfname" class="form-control" type="text" placeholder="" >
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-4">
                            <div class="input-block local-forms">
                                <label >Last Name <span class="login-danger">*</span></label>
                                <input name="dlname" class="form-control" type="text" placeholder="" >
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-4">
                            <div class="input-block local-forms">
                                <label >User Name <span class="login-danger">*</span></label>
                                <input name="duname" class="form-control" type="text" placeholder="" >
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6">
                            <div class="input-block local-forms">
                                <label >Mobile <span class="login-danger">*</span></label>
                                <input name="dnumber" class="form-control" type="text" placeholder="" >
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6">
                            <div class="input-block local-forms">
                                <label >Email <span class="login-danger">*</span></label>
                                <input name="demail" class="form-control" type="email" autocomplete="username" placeholder="">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6">
                            <div class="input-block local-forms">
                                <label >Password <span class="login-danger">*</span></label>
                                <input name="dpassword" class="form-control" type="password" autocomplete="current-password" placeholder="">
                            </div>
                        </div>
                        <!--
                        <div class="col-12 col-md-6 col-xl-6">
                            <div class="input-block local-forms">
                                <label >Confirm Password <span class="login-danger">*</span></label>
                                <input class="form-control" type="password" placeholder="" >
                            </div>
                        </div>-->
                        <div class="col-12 col-md-6 col-xl-6">
                            <div class="input-block local-forms cal-icon">
                                <label >Date Of Birth  <span class="login-danger">*</span></label>
                                <input name="ddob" class="form-control datetimepicker" type="text"  placeholder="" >
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6">
                            <div class="input-block select-gender">
                                <label class="gen-label">Gender<span class="login-danger">*</span></label>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" value="Male" name="dgender" class="form-check-input mt-0">Male
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" value="Female" name="dgender" class="form-check-input mt-0">Female
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" value="other" name="dgender" class="form-check-input mt-0">other
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-4">
                            <div class="input-block local-forms">
                                <label >Education <span class="login-danger">*</span></label>
                                <input name="dedu" class="form-control" type="text" placeholder="" >
                            </div>
                        </div>
                        <!--
                        <div class="col-12 col-md-6 col-xl-4">
                            <div class="input-block local-forms">
                                <label >Designation <span class="login-danger">*</span></label>
                                <input class="form-control" type="text" placeholder="" >
                            </div>
                        </div>-->
                        <div class="col-12 col-md-6 col-xl-4">
                            <div class="input-block local-forms">
                                <label >Department <span class="login-danger">*</span></label>
                                <select name="ddepart" class="form-control select">
                                    <option value="">Select Department</option>
                                    <option value="Orthopedist">Orthopedist</option>
                                    <option value="Skin Specialist">Skin Specialist</option>
                                    <option value="Psychology">Psychology</option>
                                    <option value="Neurologist">Neurologist</option>
                                    <option value="Dentist">Dentist</option>
                                    <option value="Cardiologist">Cardiologist</option>
                                    <option value="Gynecologist">Gynecologist</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-12 col-sm-12">
                            <div class="input-block local-forms">
                                <label>Address  <span class="login-danger">*</span></label>
                                <textarea name="daddress" class="form-control" rows="3" cols="30"></textarea>
                            </div>
                        </div>
                        <!--
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="input-block local-forms">
                                <label >City <span class="login-danger">*</span></label>
                                <select class="form-control select">
                                    <option>Select City</option>
                                    <option>Alaska</option>
                                    <option>Los Angeles</option>
                                    </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="input-block local-forms">
                                <label >Country  <span class="login-danger">*</span></label>
                                <select class="form-control select">
                                    <option>Select Country </option>
                                    <option>Usa</option>
                                    <option>Uk</option>
                                    <option>Italy</option>
                                    </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="input-block local-forms">
                                <label >State/Province <span class="login-danger">*</span></label>
                                <select class="form-control select">
                                    <option>Select State</option>
                                    <option>Alaska</option>
                                    <option>California</option>
                                    </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="input-block local-forms">
                                <label >Postal Code <span class="login-danger">*</span></label>
                                <input class="form-control" type="text" placeholder="" >
                            </div>
                        </div>
                        <div class="col-12 col-sm-12">
                            <div class="input-block local-forms">
                                <label>Start Biography  <span class="login-danger">*</span></label>
                                <textarea class="form-control" rows="3" cols="30"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6">
                            <div class="input-block local-top-form">
                                <label class="local-top">Avatar <span class="login-danger">*</span></label>
                                <div class="settings-btn upload-files-avator">
                                    <input type="file" accept="image/*" name="image" id="file" onchange="if (!window.__cfRLUnblockHandlers) return false; loadFile(event)" class="hide-input" data-cf-modified-3361286fab073aa18b96d427-="">
                                    <label for="file" class="upload">Choose File</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-6">
                            <div class="input-block select-gender">
                                <label class="gen-label">Status <span class="login-danger">*</span></label>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="gender" class="form-check-input mt-0">Active
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="gender" class="form-check-input mt-0">In Active
                                    </label>
                                </div>
                            </div>
                        </div>-->
                        <div class="col-12">
                            <div class="doctor-submit text-end">
                                <button type="submit" name="sub" class="btn btn-primary submit-form me-2">Submit</button>
                                
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
