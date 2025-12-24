var state = {
    page: 1,
    perPage: 10,
    search: "",
    sortColumn: "user_id",
    sortOrder: "ASC"
};

$(document).ready(function () {

    $("#searchInput").on("keyup", function () {
        state.search = $(this).val();
        state.page = 1;
        loadpagedata();
    });

    $(document).on("click", ".user-refresh", function () {
        state.page = 1;
        state.perPage = 10;
        state.search = "";
        state.sortColumn = "user_id";
        state.sortOrder = "ASC";

        $("#RecordsPerPage").val("10").trigger("change");
        $("#searchInput").val("");
        $(".row-check, #checkAll").prop("checked", false);
        $(".user-delete").addClass("disabled")
        loadpagedata();
    });

    $(document).on("click", ".page-link", function () {
        const page = parseInt($(this).data("page"));
        state.page = page;
        loadpagedata();
    });

    $("#RecordsPerPage").on("change", function () {
        state.perPage = parseInt($(this).val());
        state.page = 1;
        loadpagedata();
    });

    $(document).on("click", "th[data-column]", function () {
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
    
    $("#addUserModal").on("show.bs.modal", function() {
        get_roles();
        $("#email_verified").val(""); 
        $('#email_verified_icon').hide();
        $('#send_verification_btn').show();
    });

    $("#addUserModal").on("hide.bs.modal", function () {
        $("#adduser_form")[0].reset();
        $("button[name='save_user']").prop("disabled", false).text("Create User");  
        $(".error").text("");
        $("input[name='email']").prop("readonly", false);
        $("button[name = 'send_verification']").prop("disabled", false).text(' Send');
        $('#email_verified_icon').hide();
        $('#email_verified').val("");  
        $("button[name = 'resend_otp']").prop("disabled", true).text('Resend otp');
        $('.otp_block').hide();
        $('#send_verification_btn').show();
    });

    $("#adduser_form").submit(function(e) {
        e.preventDefault();
        $(".error").text("");

        let rules = {
            first_name: "required|name|max:10",
            last_name: "required|name|max:10",
            email: "required|email",
            phone: "required|mobile",
            password: "required|password_strong",
            confirm_password: "required|match:password",
            role_id: "required",
            gender: "required",
            dob: "required|date",
            status: "required",
        };

        let errors = validateForm("#adduser_form", rules);

        if(Object.keys(errors).length > 0) {
            $.each(errors, function (index, value) {
                $("#" + index + "_error").text(value);                 
            });
            return false;
        }

        let otpVisible = $(this).closest("form").find(".otp_block").is(":visible");

        if(otpVisible) {
            var checkotp = $("#otp").val().trim();
            if(!checkotp) {
                $("#otp_error").text("Otp Is Required.");
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

        var form = $("#adduser_form")[0];
        var formdata = new FormData(form);

        $.ajax({
            type: "POST",
            url: "settings/manageusers/save_user.php",
            data: formdata,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function() {
                $(".error").text("");
                $("button[name='save_user']").prop("disabled", true).text("Creating...");
            },
            success: function (res) {
                $("button[name='save_user']").prop("disabled", false).text("Create User");  
                if(res.status == "error") {
                    if(res.message) {
                        showAlert(res.status, res.message);
                    }else {
                        $.each(res.errors, function(field, message) {
                            if(Array.isArray(message)) {
                                $("#" + field + "_error").text(message.join(", "));
                            } else{
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
                } else if (res.status == "success") {
                    showAlert(res.status, res.message);
                    $("button[name='save_user']").prop("disabled", false).text("Create user");  
                    $("#adduser_form")[0].reset();
                    $(".error").text("");
                    $("#addUserModal").modal("hide");
                    loadpagedata();
                }              
            },
            error: function(xhr, status, error) {
                console.log("Ajax Error:", error);
                console.log("Status: ", status);
                console.log("Response: ", xhr.responseText);
            }
        });
    });

    $("#editUserModal").on("hide.bs.modal", function () {
        $("#edituser_form")[0].reset();
        $(".error").text("");
        $("button[name='update_user']").prop("disabled", false).text("Update User");  
        $("input[name='email']").prop("readonly", false);
        $("button[name = 'send_verification']").prop("disabled", false).text(' Send');
        $('#edit_email_verified_icon').hide();
        $('#edit_email_verified').val("");  
        $("button[name = 'resend_otp']").prop("disabled", true).text('Resend otp');
        $('.otp_block').hide();
        $('#edit_send_verification_btn').show();

    });

    $(document).on("click", ".edit-btn", function () {

        let id = $(this).data("id");
        let first_name = $(this).data("first_name");
        let last_name = $(this).data("last_name");
        let email = $(this).data("email");
        let phone = $(this).data("phone");
        let role = $(this).data("role");
        let dob = $(this).data("dob");
        let status = $(this).data("status");
        let gender = $(this).data("gender");

        $("#edit_user_id").val(id);

        get_roles(function() {
            $("#edit_role_id").val(role).trigger("change");
        });

        $("input[name='gender'][value='" + gender + "']").prop("checked", true);

        $("#edit_first_name").val(first_name);
        $("#edit_last_name").val(last_name);
        $("#edit_email").val(email);
        $("#edit_phone").val(phone);
        $("#edit_dob").val(dob);
        $("#edit_status").val(status);
        $("#editUserModal").modal("show");

        $('#edit_send_verification_btn').hide();

        $("#edit_email_verified").val(email); 
        $('#edit_email_verified_icon').show();
        // console.log($("#edit_email_verified").val());

    });

    $("#edituser_form").submit(function(e) {
       e.preventDefault();
        $(".error").text("");
       
        let rules = {
            first_name: "required|name|max:10",
            last_name: "required|name|max:10",
            email: "required|email",
            phone: "required|mobile",
            password: "required|password_strong",
            confirm_password: "required|match:password",
            role_id: "required",
            gender: "required",
            dob: "required|date",
            status: "required",
        };

        let errors = validateForm("#edituser_form", rules);

        if(Object.keys(errors).length > 0) {
            $.each(errors, function (index, value) {
                $("#edit_" + index + "_error").text(value);                 
            });
            return false;
        }

        let otpVisible = $(this).closest("form").find(".otp_block").is(":visible");

        if(otpVisible) {
            var checkotp = $("#edit_otp").val().trim();
            if(!checkotp) {
                $("#edit_otp_error").text("Otp Is Required.");
                return false;
            }
        }

        let verified_email = $(this).closest("form").find("input[name='email_verified']").val().trim();
        let current_email  = $(this).closest("form").find("input[name='email']").val().trim();

        if(!verified_email || verified_email !== current_email) {
            $("#edit_email_error").text("Please verify your email.");
            $("input[name='email']").prop("readonly", false);
            $("button[name = 'send_verification']").prop("disabled", false).text(' Send');
            $('#edit_send_verification_btn').show();
            $("#edit_otp").val('');
            $('#edit_email_verified_icon').hide();

            return false; 
        }
        let near = $(this).closest("form");

        var form = $("#edituser_form")[0];
        var formdata = new FormData(form);

        $.ajax({
            type: "POST",
            url: "settings/manageusers/edit_user.php",
            data: formdata,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $(".error").text("");
                $("button[name='update_user']").prop("disabled", true).text("Updating...");
            }, 
            success: function(res) {
                $("button[name='update_user']").prop("disabled", false).text("Update User"); 
                if(res.status == "error") {
                    if(res.message) {
                        showAlert(res.status, res.message);
                    }else{
                        $.each(res.errors, function(field, message) {
                            if(Array.isArray(message)) {
                                $("#edit_" + field + "_error").text(message.join(", "));
                            }else{
                                $("#edit_" + field + "_error").text(message);
                                if(res.data == "unveryfied") {
                                    near.find("input[name='email']").prop("readonly", false);
                                    near.find("button[name = 'send_verification']").prop("disabled", false).text(' Send');
                                    near.find('#edit_send_verification_btn').show();
                                    near.find("#edit_otp").val('');
                                    near.find('#edit_email_verified_icon').hide("");
                                }
                            }
                        });
                    }
                }else if(res.status == "success") {
                    showAlert(res.status, res.message);
                    $("#editUserModal").modal("hide");
                    $("#edituser_form")[0].reset();
                    loadpagedata();
                }
            },
            error: function(xhr, status, error) {
                console.log("Ajax Error: ", error);
                console.log("Status: ", status),
                console.log("Response: ", xhr.responseText);
            }
        });
    });

    $("#deleteUserModal").on("hide.bs.modal", function () {
        $("#delete_user_form")[0].reset();
        $("button[name='delete_user']").prop("disabled", false).text("Delete");
    });

    $(document).on("click", ".delete-btn", function () {
        let id = $(this).data("id");
        let name = $(this).data("name");
        // console.log("id: ",id);
        $("#delete_user_id").val(id);
        $("#delete_user_name_text").text("User Name : " + name.toUpperCase());
        $("#deleteUserModal").modal("show");
    }); 

    $(document).on("click", "#deleteSelected", function () {

        let ids = [];

        $(".row-check:checked").each(function () {
            ids.push($(this).val());
        });

        if (ids.length === 0) {
            showAlert("error", "Please select at least one record.");
            return;
        }
        // console.log(ids);
        $("#delete_user_id").val(ids);  
        $("#delete_user_name_text").text("Delete " + ids.length + " Selected Users?");
        
        $("#deleteUserModal").modal("show");
    });

    $("#delete_user_form").submit(function(e) {
        e.preventDefault();
        
        var form = $("#delete_user_form")[0];
        var formdata = new FormData(form);
        
        $.ajax({
            type: "POST",
            url: "settings/manageusers/delete_user.php",
            data: formdata,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $("button[name='delete_user']").prop("disabled", true).text("Deleting...");
            },
            success: function(res) {
                $("button[name='delete_user']").prop("disabled", false).text("Delete");
                if(res.status == "error") {
                    $("#deleteUserModal").modal("hide");
                    showAlert(res.status, res.message);
                }else if(res.status, res.message) {
                    showAlert(res.status, res.message);
                    $("#delete_user_form")[0].reset();
                    $("#deleteUserModal").modal("hide");
                    $("#delete_user_name_text").text("");
                    loadpagedata();

                    $("#checkAll").prop("checked", false);
                    $(".row-check").prop("checked", false);
                    $(".user-delete").addClass("disabled");

                }
            },
            error: function(xhr, status, error) {
                console.log("Ajax Error: ", error);
                console.log("Status: ", status);
                console.log("Response: ", xhr.responseText);
            }
        });
    });

    $(".exportdata").click(function (e) {
        e.preventDefault();

        const { page, perPage, search, sortColumn, sortOrder } = state;
        const type = $(this).data("type");
        const csrf = $(this).data("csrf");

        let iframe = $('<iframe>', {
            name: 'exportFrame',
            style: 'display:none;'
        });

        $("body").append(iframe);

        let form = $('<form>', {
            method: "POST",
            action: "settings/manageusers/export_userdata.php",
            target: 'exportFrame'
        });

        form.append(
            $('<input>', {type:'hidden', name:'page', value:page}),
            $('<input>', {type:'hidden', name:'perPage', value:perPage}),
            $('<input>', {type:'hidden', name:'search', value:search}),
            $('<input>', {type:'hidden', name:'sortColumn', value:sortColumn}),
            $('<input>', {type:'hidden', name:'sortOrder', value:sortOrder}),
            $('<input>', {type:'hidden', name:'type', value:type}),
            $('<input>', {type:'hidden', name:'csrf_token', value:csrf})
        );

        $("body").append(form);

        form.submit(); 

        setTimeout(() => {
            form.remove();
            iframe.remove();
        }, 2000);
    });

    $(document).on('click', '.send_verification_btn', function() {
        $(".error").text("");
        
        let rules = {
            email: "required|email",
        };

        // let errors = validateForm("#adduser_form", rules);
        let errors = validateForm('#' + $(this).closest("form").attr("id"), rules);
        let formId = $(this).closest("form").attr("id");

        if(Object.keys(errors).length > 0) {
            $.each(errors, function(index, value) {
                $("#" + (formId === "edituser_form" ? "edit_" : "") + index + "_error").text(value);
            });
            return false;
        }

        // var email = $("input[name = 'email']").val();
        // var csrf_token = $("input[name='csrf_token']").val();

        var email = $(this).closest("form").find("input[name='email']").val();
        var csrf_token = $(this).closest("form").find("input[name='csrf_token']").val();
        var edit_id = $(this).closest("form").find("#edit_user_id").val();

        $.ajax({
            type: "POST",
            url: "settings/manageusers/send_and_verifyotp.php",
            data: {
                user_id: edit_id,
                email: email,
                action: "send_otp",
                csrf_token: csrf_token,
            },
            beforeSend: function() {
                $("button[name = 'send_verification']").prop("disabled", true).html('<span class="spinner-border spinner-border-sm me-1"></span> Sending...');
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
                    startOtpTimer(300); 
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
        // let errors = validateForm("#adduser_form", rules);
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

        // var otp = $("input[name = 'otp']").val();
        // var csrf_token = $("input[name='csrf_token']").val();
        var csrf_token = $(this).closest("form").find("input[name='csrf_token']").val();
        var otp = $(this).closest("form").find("input[name='otp']").val();

        $.ajax({
            type: "POST",
            url: "settings/manageusers/send_and_verifyotp.php",
            data: {
                otp: otp,
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
                    $('.otp_block').hide();
                    $('.email_verified_icon').show();
                    // $("input[name = 'email_verified']").val(res.data);
                    form.find("input[name='email_verified']").val(res.data);

                } 
            },
            error: function(xhr, status, error){
                console.log("Status: ", status);
                console.log("Ajax Error: ", error);
                console.log("Response: ", xhr.responseText);
            }
        });
    });

    $(document).on('click', '.resend_otp_btn', function () {
        $(".error").text("");
        
        let rules = {
            email: "required|email",
        };

        // let errors = validateForm("#adduser_form", rules);
        let errors = validateForm('#' + $(this).closest("form").attr("id"), rules);
        let formId = $(this).closest("form").attr("id");

        if(Object.keys(errors).length > 0) {
            let formId = $(this).closest("form").attr("id");
            $.each(errors, function(index, value) {
                $("#" + (formId === "edituser_form" ? "edit_" : "") + index + "_error").text(value);
            });
            return false;
        }

        var email = $(this).closest("form").find("input[name='email']").val();
        var csrf_token = $(this).closest("form").find("input[name='csrf_token']").val();

        // var email = $("input[name = 'email']").val();
        // var csrf_token = $("input[name='csrf_token']").val();

        $.ajax({
            type: "POST",
            url: "settings/manageusers/send_and_verifyotp.php",
            data: {
                email: email,
                action: "send_otp",
                csrf_token: csrf_token,
            },
            beforeSend: function() {
                $("button[name = 'resend_otp']").prop("disabled", true).text('Resending...');
            },
            dataType: "json",
            success: function (res) {
                if(res.status == "error") {
                    $("button[name = 'resend_otp']").prop("disabled", false).text('Resend otp');
                    if(res.message) {
                        showAlert(res.status, res.message);
                    }else{
                        $.each(res.errors, function(field, message) {
                            let prefix = (formId === "edituser_form") ? "edit_" : "";
                            $("#" + prefix + field + "_error").text(Array.isArray(message) ? message.join(", ") : message);
                        });
                    }
                }else if(res.status == "success") {
                    showAlert(res.status, "OTP has been resent to your email. Please check your inbox.");
                    $("button[name = 'resend_otp']").prop("disabled", true).text('Resend otp');
                    startOtpTimer(300); 
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


function get_roles(callback) {
    let csrf_token = $("#csrf_token").val();
    
    $.ajax({
        type: "POST",
        url: "settings/manageusers/loadoptions.php",
        data: {
            csrf_token: csrf_token
        },
        dataType: "json",
        success: function (res) {
            $("#role_id").html(res.data);  
            $("#edit_role_id").html(res.data);
          

            if(callback) callback();
        },
        error: function(xhr, status, error) {
            console.log("Ajax Error: ", error);
            console.log("Status: ", status);
            console.log("Response: ", xhr.responseText);
        }
    });
}

function loadpagedata() {
    const { page, perPage, search, sortColumn, sortOrder} = state;
    const csrf_token = $("#user_csrf_token").val();
    
    $.ajax({
        type: "POST",
        url: "settings/manageusers/get_userdata.php",
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

                const tbody = "#user_table tbody";
                const pagination = "#user_Pagination";
                const infotext = "#user_InfoText";

                $(tbody).html(res.data.html);

                const totalRecords = res.data.total;
                const totalPages = Math.ceil(totalRecords / perPage);

                let start = totalRecords === 0 ? 0 : (page - 1) * perPage + 1;
                let end = Math.min(page  * perPage, totalRecords);

                $(infotext).text(`Showing ${start} to ${end} of ${totalRecords} entries`);
                $(pagination).html(generatePagination(page, totalPages));
            }
            
        }
    });

}

function updateDeleteButtonState() {
    if ($(".row-check:checked").length > 0) {
        $(".user-delete").removeClass("disabled");
    } else {
        $(".user-delete").addClass("disabled");
    }
}

