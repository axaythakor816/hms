$(document).ready(function () {

    $(document).on("click", "#send_verification_btn", function(e) {
        e.preventDefault();
        $(".error").text("");
        let email = $("input[name = 'email']").val();

        let rules = {
            email: "required|email"
        };

        let errors = validateForm("#registration_form", rules);

        if (Object.keys(errors).length > 0) {
            $.each(errors, function(keys, message) {
                $("#" + keys + "_error").text(message);
            })
            return false;
        }

        $.ajax({
            type: "POST",
            url: "../public/send_and_verifyotp.php",
            data: {
                action: "send_otp",
                email: email
            },
            beforeSend: function() {
                $("button[name = 'send_verification']").prop("disabled", true).html('<span class="spinner-border spinner-border-sm me-1"></span> Sending...');
                $("input[name='email']").prop("readonly", true);

            },
            dataType: "json",
            success: function (res) {
                if(res.status == "error") {
                    $("button[name = 'send_verification']").prop("disabled", false).html(' Send');
                    $("input[name='email']").prop("readonly", false);
                    if(res.message) {
                        showAlert(res.status, res.message);
                    }else{
                        $.each(res.errors, function(keys, message) {
                            $("#" + keys + "_error").text(Array.isArray(message) ? message.join(", ") : message);
                        });
                    }
                }else if(res.status == "success") {
                    showAlert(res.status, res.message);
                    $('.otp_block').show();
                    $("input[name='email']").prop("readonly", true);
                    $("button[name = 'send_verification']").prop("disabled", true).text(' Send');
                    $('#send_verification_btn').hide();
                    startOtpTimer(300);
                }
            }, 
            error: function (xhr, status, error) {
                console.log("Status: ", status,);
                console.log("Ajax Error: ", error);
                console.log("Response: ", xhr.responseText);
            }
        });
    });

    $(document).on("click", "#verify_otp_btn", function(e) {
        e.preventDefault();
        $(".error").text("");

        let otp = $("input[name = 'otp']").val();

        let rules = {
            otp: "required|digits:6"
        }

        let errors = validateForm("#registration_form", rules);

        if (Object.keys(errors).length > 0) {
            $.each(errors, function(keys, message) {
                $("#" + keys + "_error").text(message);
            })
            return false;
        }

        $.ajax({
            type: "POST",
            url: "../public/send_and_verifyotp.php",
            data: {
                action: "verify_otp",
                otp: otp
            }, 
            beforeSend: function() {
                $("button[name = 'verify_otp']").prop("disabled", true).text('Verifying...');
                $("input[name='otp']").prop("readonly", true);
            },
            dataType: "json",
            success: function (res) {
                if(res.status == "error") {
                    $("button[name = 'verify_otp']").prop("disabled", false).text('Verify OTP');
                    $("input[name='otp']").prop("readonly", false);

                    if(res.message) {
                        showAlert(res.status, res.message);
                    }else{
                        $.each(res.errors, function(field, message) {
                            $("#" + field + "_error").text(Array.isArray(message) ? message.join(" ,") : message);
                        });
                    }
                }else if(res.status == "success") {
                    showAlert(res.status, res.message);
                    $("button[name = 'verify_otp']").prop("disabled", false).text('Verify OTP');

                    $('.otp_block').hide();
                    $('.email_verified_icon').show();
                    $("input[name = 'email_verified']").val(res.data);
                }
                
            }, 
            error: function(xhr, status, error) {
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
            $.each(errors, function(index, value) {
                $("#" + index + "_error").text(value);
            });
            return false;
        }

        var email = $(this).closest("form").find("input[name='email']").val();
        var csrf_token = $(this).closest("form").find("input[name='csrf_token']").val();

        // var email = $("input[name = 'email']").val();
        // var csrf_token = $("input[name='csrf_token']").val();

        $.ajax({
            type: "POST",
            url: "../public/send_and_verifyotp.php",
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
                            $("#" + field + "_error").text(Array.isArray(message) ? message.join(", ") : message);
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
   
    $("#registration_form").submit(function (e) { 
        e.preventDefault();
        $(".error").text(" ");

        let rules = {
            name: "required|name|min:3",
            email: "required|email",
            phone: "required|mobile",
            password: "required|min:6|password_strong",
            confirm_password: "required|match:password",
        };

        let errors = validateForm("#registration_form", rules);

        if(Object.keys(errors).length > 0) {
            $.each(errors, function (indexInArray, valueOfElement) {
                $("#" + indexInArray + "_error").text(valueOfElement);              
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
            $("input[name='otp']").prop("readonly", false);

            $("button[name = 'send_verification']").prop("disabled", false).text(' Send');
            $('#send_verification_btn').show();
            $("#otp").val('');
            $('#email_verified_icon').hide("");

            return false; 
        }

        var form = $("#registration_form")[0];
        var formdata = new FormData(form);

        $.ajax({
            type: "POST",
            url: "../public/save_register.php",
            data: formdata,
            dataType: "json",
            processData: false, 
            contentType: false, 
            beforeSend: function () {
                $(".error").text("");
                $("button[name='register']").prop("disabled", true).text("Registering...");  
            },
            success: function(res) {
                $("button[name='register']").prop("disabled", false).text("Register");  
                $("button[name='register']").html('Register <i class="fa fa-user-plus"></i>');  

                if(res.status == "error") {
                    if(res.message) {
                        showAlert(res.status, res.message);
                    } else if(res.errors) {
                        $.each(res.errors, function(field, messages) {
                            if (Array.isArray(messages)) {
                                $("#" + field + "_error").text(messages.join(", "));
                            } else {
                                $("#" + field + "_error").text(messages);
                                if(res.data == "unveryfied") {
                                    $("input[name='email']").prop("readonly", false);
                                    $("input[name='otp']").prop("readonly", false);
                                    $("button[name = 'send_verification']").prop("disabled", false).text(' Send');
                                    $('#send_verification_btn').show();
                                    // $('.otp_block').hide();

                                    $("#otp").val('');
                                    $('#email_verified_icon').hide("");
                                }
                            }

                        });
                    }
                } else if(res.status == "success") {
                    showAlert(res.status, res.message);
                    $("#registration_form")[0].reset();
                    $("input[name='email']").prop("readonly", false);
                    $("input[name='otp']").prop("readonly", false);
                    Redirect("http://localhost/hms/public/page-login.php", 3000);                    
                }
            },
            error: function(xhr, status, error) {
                console.log("AJAX Error:", error);
                console.log("Status:", status);
                console.log("Response:", xhr.responseText);
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
    $('#resend_otp_btn').prop('disabled', true);
    updateOtpTimerUI();

    otpInterval = setInterval(() => {
        otpTime--;
        updateOtpTimerUI();

        if (otpTime <= 0) {
            clearInterval(otpInterval);
            otpInterval = null;
            $('#otp_timer').text('Expired');
            $('#resend_otp_btn').prop('disabled', false);
        }
    }, 1000);
}

function updateOtpTimerUI() {
    let min = Math.floor(otpTime / 60);
    let sec = otpTime % 60;

    $('#otp_timer').text(
        `${String(min).padStart(2,'0')}:${String(sec).padStart(2,'0')}`
    );
}
