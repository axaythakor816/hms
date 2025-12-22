$(document).ready(function () {
    $("#forgot_form").submit(function(e) {
        e.preventDefault();
        $(".error").text("");

        var rules = {
            user_name: 'required|username'
        };

        var errors = validateForm("#forgot_form", rules);

        if(Object.keys(errors).length > 0) {
            $.each(errors, function(keys, message) {
                $("#" + keys + "_error").text(message);
            });
            return false;
        }

        var formdata = new FormData($("#forgot_form")[0]);

        $.ajax({
            type: "POST",
            url: "../forgotpassword/send_forgot_password_link.php",
            data: formdata,
            beforeSend: function() {
                $("button[name = 'forgot_password']").prop("disabled", true).html('<span class="spinner-border spinner-border-sm me-1"></span> Sending...');
            },
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (res) {
                $("button[name = 'forgot_password']").prop("disabled", false).html('Send Reset Link <i class="fa fa-paper-plane"></i>');
                $("#forgot_form")[0].reset();
                if(res.status == "error") {
                    if(res.message) {
                        showAlert(res.status, res.message);
                    }else{
                         $.each(res.errors, function(field, message) {
                            if(Array.isArray(message)) {
                                $("#" + field + "_error").text(message.join(", "));
                            }else{
                                $("#" + field + "_error").text(message);
                            }
                        });
                    }
                }else if(res.status == "success") {
                    showAlert(res.status, res.message);
                    Redirect("http://localhost/hms/public/page-login.php", 2000);
                }
            },
            error: function(xhr, status, error) {
                console.log("Status: ", status);
                console.log("Ajax Error: ", error);
                console.log("Response: ", xhr.responseText);
            }
        });
    })

    $("#reset_form").submit(function(e) {
        e.preventDefault();
        $(".error").text("");

        let rules = {
            new_password: "required|password_strong",
            confirm_password: "required|match:new_password"
        };

        let errors = validateForm("#reset_form", rules);

        if(Object.keys(errors).length > 0) {
            $.each(errors, function(field, message) {
                $("#" + field + "_error").text(message);
            });
            return false;
        }

        var formdata = new FormData($("#reset_form")[0]);
        formdata.append("action", "changepassword");

        $.ajax({
            type: "POST",
            url: "../forgotpassword/reset_password.php",
            data: formdata,
            beforeSend: function() {
                $("button[name = 'reset_password']").prop("disabled", true).html('<span class="spinner-border spinner-border-sm me-1"></span> Changing Password...');
            },
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (res) {
                $("button[name = 'reset_password']").prop("disabled", false).html('Reset Password <i class="fa fa-check"></i>');
                if(res.status == "error") {
                    if(res.message) {
                        $("#reset_form")[0].reset();
                        showAlert(res.status, res.message)
                    }else{
                        $.each(res.errors, function(keys, message) {
                             if(Array.isArray(message)) {
                                $("#" + keys + "_error").text(message.join(", "));
                            }else{
                                $("#" + keys + "_error").text(message);
                            }
                        });
                    }
                }else if(res.status == "success") {
                    $("#reset_form")[0].reset();
                    showAlert(res.status, res.message);
                    Redirect("http://localhost/hms/public/page-login.php", 2000);
                } 
            }
        });
    });
});

function verify_token(token) {

    $.ajax({
        type: "POST",
        url: "../forgotpassword/reset_password.php",
        data: {
            action: "verify_token",
            token: token
        },
        dataType: "json",
        success: function (res) {
            if(res.status == "error") {
                showAlert(res.status, res.message);
                Redirect("http://localhost/hms/public/page-login.php", 2000);
            }else if(res.status == "success") {
                $("#user_id").val(res.data);
                console.log("id: ", res.data);
            }
        },
        error: function(xhr, status, error) {
            console.log("status: ", status);
            console.log("Ajax Error: ", error);
            console.log("Response: ", xhr.responseText);
        }
    });
}