$(document).ready(function () {
    $(".error").text("");

    $("#change_password_form").submit(function(e) {
        e.preventDefault();
        $(".error").text("");

        let rules = {
            'old_password': 'required',
            'new_password': 'required|password_strong',
            'confirm_password': 'required|match:new_password'
        };

        let errors = validateForm("#change_password_form", rules);
        
        if(Object.keys(errors).length > 0) {
            $.each(errors, function(keys, value) {
                $("#" + keys + "_error").text(value);
            });
            return false;
        };

        var form = $("#change_password_form")[0];
        var formdata = new FormData(form);

        $.ajax({
            type: "POST",
            url: "settings/passwords/change_password.php",
            data: formdata,
            processData: false,
            contentType: false,
            beforeSend: function(data) {
                // $("button[name = 'change_password']").prop("disabled", true).text("changing...");
                $("button[name='change_password']").prop("disabled", true).html('<span class="spinner-border spinner-border-sm me-1"></span> Changing...');
            },
            dataType: "json",
            success: function (res) {
                $("button[name = 'change_password']").prop("disabled", false).text("Change Password");
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
                    $("#change_password_form")[0].reset();
                    $(".error").text("");
                    showAlert(res.status, res.message);
                }                
            },
            error: function(xhr, status, error) {
                console.log("Status: ", status);
                console.log("Ajax Error: ", error);
                console.log("Response: ", xhr.responseText);
            }
        });

    })
});