window.state = window.state || {
    page: 1,
    perPage: 10,
    search: "",
    sortColumn: "doctor_id",
    sortOrder: "ASC"
};
(function () {

    var state = window.state;

    $(document).ready(function () {
        loadpagedata();

        $(".doctor-table-blk #searchInput").on("keyup", function () {
            state.search = $(this).val();
            state.page = 1;
            loadpagedata();
        });

        $(document).on("click", ".doctor-refresh", function () {
            state.page = 1;
            state.perPage = 10;
            state.search = "";
            state.sortColumn = "department_id";
            state.sortOrder = "ASC";

            $("#RecordsPerPage").val("10").trigger("change");
            $("#searchInput").val("");
            $(".row-check, #checkAll").prop("checked", false);
            $(".doctor-delete").addClass("disabled")
            loadpagedata();
        });
        
        $(document).on("click", "#doctor_Pagination .page-link", function () {
            const page = parseInt($(this).data("page"));
            state.page = page;
            loadpagedata();
        });

        $(".doctor-table-blk #RecordsPerPage").on("change", function () {
            state.perPage = parseInt($(this).val());
            state.page = 1;
            loadpagedata();
        });

        $(document).on("click", "#doctor_table th[data-column]", function () {
            let col = $(this).data("column");

            if (state.sortColumn === col) {
                state.sortOrder = (state.sortOrder === "ASC") ? "DESC" : "ASC";
            } else {
                state.sortColumn = col;
                state.sortOrder = "ASC";
            }

            state.page = 1;
            loadpagedata();
        });

        $(document).on("change", "#checkAll", function () {
            $(".row-check").prop("checked", $(this).prop("checked"));
            updateDeleteButtonState();
        });

        $(document).on("change", ".row-check", function () {

            if ($(".row-check").length === $(".row-check:checked").length) {
                $("#checkAll").prop("checked", true);
            } else {
                $("#checkAll").prop("checked", false);
            }

            updateDeleteButtonState();
        });

        $("#bio").on("input", function() {
            let count = $(this).val().length;
            $("#bio_count").text(count);    
            let desc = $(this).val();

            $.ajax({
                type: "POST",
                url: "doctors/save_doctor.php",
                data: {
                    action: 'count',
                    bio: desc
                },
                dataType: "json",
                success: function (data) {
                    $("#bio_count").text(data.data);   
                },
                error: function(xhr, status, error) {
                    console.log("Ajax Error:", error);
                    console.log("Status: ", status);
                    console.log("Response: ", xhr.responseText);
                }
            });
        });

        $("#addDoctorModal").on("show.bs.modal", function () {
            get_department();

            $(".error").text("");
            $("#email_verified").val(""); 
            $('#email_verified_icon').hide();
            $('#send_verification_btn').show();
        });

        $("#addDoctorModal").on("hide.bs.modal", function () {
            $("#add_doctor_form")[0].reset();
            $("button[name='save_doctor']").prop("disabled", false).text("Create Doctor");  
            $(".error").text("");
            $("input[name='email']").prop("readonly", false);
            $("button[name = 'send_verification']").prop("disabled", false).text(' Send');
            $('#email_verified_icon').hide();
            $('#email_verified').val("");  
            $("button[name = 'resend_otp']").prop("disabled", true).text('Resend otp');
            $('.otp_block').hide();
            $('#send_verification_btn').show();
            $("#duplicate_message").text();
            $("input[name = 'duplicate_id']").val("");
            $("#duplicate_name").text();
        });

        $(document).on('click', '.send_verification_btn', function() {
            $(".error").text("");
            
            let rules = {
                email: "required|email",
            };

            let errors = validateForm('#' + $(this).closest("form").attr("id"), rules);
            let formId = $(this).closest("form").attr("id");

            // if(Object.keys(errors).length > 0) {
            //     $.each(errors, function(index, value) {
            //         $("#" + (formId === "edit_doctor_form" ? "edit_" : "") + index + "_error").text(value);
            //     });
            //     return false;
            // }

            var email = $(this).closest("form").find("input[name='email']").val();
            var csrf_token = $(this).closest("form").find("input[name='csrf_token']").val();
            var edit_id = $(this).closest("form").find("#edit_doctor_id").val();

            $.ajax({
                type: "POST",
                url: "doctors/send_and_verifyotp.php",
                data: {
                    user_id: edit_id,
                    email: email,
                    action: "check_user",
                    csrf_token: csrf_token,
                },
                beforeSend: function() {
                    $("button[name = 'send_verification']").prop("disabled", true).html('<span class="spinner-border spinner-border-sm me-1"></span> Sending...');
                },
                dataType: "json",
                success: function (res) {
                    
                    if(res.status == "error") {
                        $("button[name = 'send_verification']").prop("disabled", false).text(' Send');
                        if(res.message) {
                            showAlert(res.status, res.message);
                        }else{
                            $.each(res.errors, function(field, message) {
                                let prefix = (formId === "edit_doctor_form") ? "edit_" : "";
                                $("#" + prefix + field + "_error").text(Array.isArray(message) ? message.join(", ") : message);
                            });
                        }
                    }else if(res.status == "success") {
                        if (res.data == "duplicate") {
                            if(res.errors){
                                let prefix = (formId === "edit_doctor_form") ? "edit_" : "";
                                $("#" + prefix + "duplicate_message").text(res.errors.email);
                                $("#" + prefix + "duplicate_name").text(res.errors.user_name);
                                
                            }

                            showConfirmModal(function (confirmed) {
                                if (!confirmed) {
                                    console.log("confirm block");
                                    $("input[name='email']").prop("readonly", false);
                                    $("button[name='send_verification']").prop("disabled", false).text(' Send');
                                    return;
                                }
                                $("input[name = 'duplicate_id']").val(res.errors.user_id); 

                                sendOtpRequest(formId, edit_id, email, csrf_token);
                            });
                        }else{
                            $("input[name = 'duplicate_id']").val(""); 
                            sendOtpRequest(formId, edit_id, email, csrf_token);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Status: ", status);
                    console.log("Ajax Error: ", error);
                    console.log("Response: ", xhr.responseText);
                }
            });
            
        });

        $(document).on('click', '.verify_otp_btn', function() {
            $(".error").text("");

            let rules = {
                otp: "required|digits:6"
            };

            let form = $(this).closest("form");
            let errors = validateForm('#' + $(this).closest("form").attr("id"), rules);
            let formId = $(this).closest("form").attr("id");

            if(Object.keys(errors).length > 0) {
                console.log("errors ", errors);
                console.log("formid ", formId);

                $.each(errors, function(index, value) {
                    $("#" + (formId === "edituser_form" ? "edit_" : "") + index + "_error").text(value);
                });
                return false;
            }

            var duplicate_id = $("input[name = 'duplicate_id']").val();
            var csrf_token = $(this).closest("form").find("input[name='csrf_token']").val();
            var otp = $(this).closest("form").find("input[name='otp']").val();

            $.ajax({
                type: "POST",
                url: "doctors/send_and_verifyotp.php",
                data: {
                    otp: otp,
                    duplicate_id: duplicate_id,
                    csrf_token: csrf_token,
                    action: 'verify_otp'
                },
                beforeSend: function() {
                    $("button[name = 'verify_otp']").prop("disabled", true).text('Verifying...');
                },
                dataType: "json",
                success: function (res) {
                    $("button[name = 'verify_otp']").prop("disabled", false).text('Verify OTP');
                    if(res.status == "error") {
                        
                        if(res.message) {
                            showAlert(res.status, res.message);
                        }else{
                            $.each(res.errors, function(field, message) {
                                let prefix = (formId === "edituser_form") ? "edit_" : "";
                                $("#" + prefix + field + "_error").text(Array.isArray(message) ? message.join(", ") : message);
                            });
                        }
                    }else if(res.status == "success") {
                        showAlert(res.status, res.message);
                        if(res.data.user_id) {
                            console.log("data");
                            $("input[name = 'duplicate_id']").val(res.data.user_id);
                            form.find("input[name = 'first_name']").val(res.data.first_name);
                            form.find("input[name = 'middle_name']").val(res.data.middle_name);
                            form.find("input[name = 'last_name']").val(res.data.last_name);
                            form.find("input[name = 'dob']").val(res.data.dob);
                            let gender = (res.data.gender) ? res.data.gender.toLowerCase() : "";
                            form.find("input[name = 'gender'][value='" + gender + "']").prop("checked", true);
                            form.find("select[name = 'status']").val(res.data.status).trigger("change");
                            form.find("input[name = 'phone']").val(res.data.phone);
                        }
                        $("button[name = 'verify_otp']").prop("disabled", false).text('Verify OTP');
                        $('.otp_block').hide();
                        $('.email_verified_icon').show();
                        form.find("input[name='email_verified']").val(res.data.email);
                    } 
                },
                error: function(xhr, status, error){
                    console.log("Status: ", status);
                    console.log("Ajax Error: ", error);
                    console.log("Response: ", xhr.responseText);
                }
            });
        });

        $("#add_doctor_form").submit(function(e) {
            e.preventDefault();
            $(".error").text("");

            let rules = {
                first_name: "required|name|min:2|max:10",
                middle_name: "required|name|min:1|max:10",
                last_name: "required|name|min:2|max:10",
                email: "required|email|max:30",
                phone: "required|mobile",
                specialty: "required|min:2|max:20",
                sub_specialty: "required|min:2|max:20",
                qualification: "required|min:2|max:20",
                department_id: "required",
                years_experience: "required|numeric|min_value:0|max_value:99",
                medical_license_no: "required|min:5|max:20|regex:/^[A-Za-z0-9\/\-]+$/",
                license_issue_date: "required|date",
                license_expiry_date: "required|date",
                consultation_fee     : "required|numeric|min_value:0",
                available_days       : "required|min:3|max:50",
                available_time_from : "required",
                available_time_to   : "required",
                gender  : "required",
                dob: "required|date",
                languages_spoken: "required|min:2|max:25",
                bio: "required|min:10|max:300",
                street  : "required|min:5|max:50",
                city    : "required|name|min:2|max:20",
                state   : "required|name|min:2|max:20",
                pincode : "required|regex:/^[0-9]{5,6}$/",
                password : "required|password_strong|min:6|max:20",
                confirm_password : "required|match:password|min:6|max:20",
                status: "required",
                doctor_status: "required",
                is_consultation_online: "required|numeric",
                two_fa_enabled: "required|numeric",
                profile_image: "required|file:type:jpg,jpeg,png|max_size:2MB"
            };

            let errors = validateForm("#add_doctor_form", rules);

            if(Object.keys(errors).length > 0) {
                $.each(errors, function(key, message) {
                    $("#" + key + "_error").text(message);
                });
                return false;
            }

            let otpVisible = $(this).closest("form").find(".otp_block").is(":visible");

            if(otpVisible) {
                let checkotp = {
                    otp : "required|digits:6|numeric"
                }

                let checkotperror = validateForm("#add_doctor_form", checkotp);
                // console.log(checkotperror);
                if(Object.keys(checkotperror).length > 0) {
                    $.each(checkotperror, function(field, value) {
                        $("#" + field + "_error").text(value);
                    });
                    return false;
                }
            }

            let verified_email = $("input[name = 'email_verified']").val().trim();
            let current_email = $("#email").val().trim();

            if(!verified_email || verified_email !== current_email) {
                $("#email_error").text("Please verify your email.");
                $("input[name='email']").prop("readonly", false);
                $("button[name = 'send_verification']").prop("disabled", false).text(' Send');
                $('#send_verification_btn').show();
                $("#otp").val('');
                $('#email_verified_icon').hide("");

                return false; 
            }

            let form = $("#add_doctor_form")[0];
            let formdata = new FormData(form);
            let duplicate_id = $("input[name = 'duplicate_id']").val();

            if(duplicate_id) {
                formdata.append("duplicate_id", duplicate_id);
            }
            
            $.ajax({
                type: "POST",
                url: "doctors/save_doctor.php",
                data: formdata,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $(".error").text("");
                    $("button[name='save_doctor']").prop("disabled", true).text("Creating...");
                }, 
                dataType: "json",
                success: function(res) {
                    $("button[name='save_doctor']").prop("disabled", false).text("Create Doctor");
                    if(res.status == "error") {
                        if(res.message) {
                            showAlert(res.status, res.message);
                        }else{
                            $.each(res.errors, function(field, message) {
                                if(Array.isArray(message)) {
                                        $("#" + field + "_error").text(message.join(", "));
                                }else{
                                    $("#" + field + "_error").text(message);
                                    if(res.data == "unveryfied") {
                                        $("input[name='email']").prop("readonly", false);
                                        $("button[name = 'send_verification']").prop("disabled", false).text(' Send');
                                        $('#send_verification_btn').show();
                                        $("#otp").val('');
                                        $('#email_verified_icon').hide("");
                                    }
                                }
                            });
                        }
                    }else if(res.status == "success") {
                        showAlert(res.status, res.message);
                        $("button[name='save_doctor']").prop("disabled", false).text("Create Doctor");  
                        $("#add_doctor_form")[0].reset();
                        $(".error").text("");
                        $("#addDoctorModal").modal("hide");
                        loadpagedata();
                    }
                }, 
                error: function(xhr, status, error) {
                    console.log("Status: ", status);
                    console.log("Ajax Error: ", error);
                    console.log("Response: ", xhr.responseText);
                }
            });
        });

    });

    function showConfirmModal(callback) {
        $('#confirmModal').modal('show');

        $('#confirmYes').off('click').on('click', function () {
            $('#confirmModal').modal('hide');
            callback(true);
        });

        $('#confirmNo').off('click').on('click', function () {
            $('#confirmModal').modal('hide');
            callback(false);
        });
    }

    function sendOtpRequest(formId, edit_id, email, csrf_token) {
        $.ajax({
            type: "POST",
            url: "doctors/send_and_verifyotp.php",
            data: {
                user_id: edit_id,
                email: email,
                action: "send_otp",
                csrf_token: csrf_token,
            },
            dataType: "json",
            success: function (res) {
                if(res.status == "error") {
                    $("button[name = 'send_verification']").prop("disabled", false).text('Send');
                    if(res.message) {
                        showAlert(res.status, res.message);
                    }else{
                        $.each(res.errors, function(field, message) {
                            let prefix = (formId === "edituser_form") ? "edit_" : "";
                            $("#" + prefix + field + "_error").text(Array.isArray(message) ? message.join(", ") : message);
                        });
                    }
                }else if(res.status == "success") {
                    showAlert(res.status, res.message);
                    $('.otp_block').show();
                    $("input[name='email']").prop("readonly", true);
                    $("button[name = 'send_verification']").prop("disabled", true).text(' Send');
                    $('.send_verification_btn').hide();

                    console.log("id: ", $("input[name='duplicate_id']").val()); 


                    startOtpTimer(300); 
                }
            },
            error: function(xhr, status, error) {
                console.log("Status: ", status);
                console.log("Ajax Error: ", error);
                console.log("Response: ", xhr.responseText);
            }
        });
    }

    function loadpagedata() {
        const { page, perPage, search, sortColumn, sortOrder} =  state;
        const csrf_token = $("#docor_csrf_token").val();
        const table = $("#doctor_table");
        if (!table.length) return;

        $.ajax({
            type: "POSt",
            url: "doctors/get_doctordata.php",
            data: {
                csrf_token: csrf_token,
                page: page,
                perPage: perPage,
                search: search,
                sortColumn: sortColumn,
                sortOrder: sortOrder
            },
            dataType: "json",
            success: function (res) {
                if(res.status == "error") {
                    showAlert(res.status, res.message);
                }else if(res.status == "success") {

                    const tbody = "#doctor_table tbody";
                    const infoText = "#doctor_InfoText";
                    const pagination = "#doctor_Pagination";

                    $(tbody).html(res.data.html);

                    const totalRecords = res.data.total;
                    const totalPages = Math.ceil(totalRecords / perPage);

                    let start = totalRecords === 0 ? 0 : (page - 1) * perPage + 1;
                    let end = Math.min(page * perPage, totalRecords);
                    
                    $(infoText).text(`Showing ${start} to ${end} of ${totalRecords} entries`);

                    $(pagination).html(generatePagination(page, totalPages));
                }
                
            }, 
            error: function(xhr, status, error) {
                console.log("Satus: ", status);
                console.log("Ajax Error: ", error);
                console.log("Response: ", xhr.responseText);
            }
        });

    }

    function updateDeleteButtonState() {
        if ($(".row-check:checked").length > 0) {
            $(".doctor-delete").removeClass("disabled");
        } else {
            $(".doctor-delete").addClass("disabled");
        }
    }
     let otpInterval = null;

    function startOtpTimer(duration = 300) {
        if (otpInterval) {
            clearInterval(otpInterval);
        }

        otpTime = duration;
        $('.resend_otp_btn').prop('disabled', true);
        updateOtpTimerUI();

        otpInterval = setInterval(() => {
            otpTime--;
            updateOtpTimerUI();

            if (otpTime <= 0) {
                clearInterval(otpInterval);
                otpInterval = null;
                $('.otp_timer').text('Expired');
                $('.resend_otp_btn').prop('disabled', false);
            }
        }, 1000);
    }

    function updateOtpTimerUI() {
        let min = Math.floor(otpTime / 60);
        let sec = otpTime % 60;

        $('.otp_timer').text(
            `${String(min).padStart(2,'0')}:${String(sec).padStart(2,'0')}`
        );
    }

    function get_department(callback) {
        let csrf_token = $("input[name = 'csrf_token']").val();
        $.ajax({
            type: "POST",
            url: "doctors/loadoptions.php",
            data: {
                csrf_token: csrf_token
            }, 
            dataType: "json",
            success: function(res) {
                if(res.status == "error") {
                    showAlert(res.message);
                }else if(res.status == "success") {
                    $("#department_id").html(res.data);
                    $("#edit_depatrment_id").html(res.data);
                    if(callback) callback();
                }
            }, 
            error: function(xhr, status, error){
                console.log("Status: ", status);
                console.log("Ajax Error: ", error);
                console.log("Response: ", xhr.responseText);
            }
        });

    }

})();
