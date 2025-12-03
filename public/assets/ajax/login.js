$(document).ready(function () {
    // showAlert("error", "Error alert working!");

    $("#login_form").submit(function (e) { 
        e.preventDefault();
        $(".error").text(" ");

        let rules = {
            username: "required|username",
            password: "required",
        };
        
        let errors = validateForm("#login_form", rules);

        if(Object.keys(errors).length > 0) {
            $.each(errors, function (keys, values) { 
                 $("#" + keys + "_error").text(values);
            });
            return false;
        }

        var form = $("#login_form")[0];
        var formdata = new FormData(form);

        $.ajax({
            type: "post",
            url: "../public/login.php",
            data: formdata,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function () {
                $(".error").text("");
                $("button[name='login']").prop("disabled", true).text("Loggedin...");  
            },
            success: function (res) {
                $("button[name='login']").prop("disabled", false).text("Login");  
                $("button[name='login']").html('Login <i class="fa fa-sign-in"></i>');  

                if(res.status == "error") {
                    if(res.message) {
                        showAlert(res.status, res.message);
                        $("#login_form")[0].reset();
                    } else if(res.errors) {
                        $.each(res.errors, function(field, messages) {
                            if (Array.isArray(messages)) {
                                $("#" + field + "_error").text(messages.join(", "));
                            } else {
                                $("#" + field + "_error").text(messages);
                            }
                        });
                    }
                } else if(res.status == "success") {
                    showAlert(res.status, res.message);
                    $("#login_form")[0].reset();
                    Redirect(res.data, 1000);                    
                }
            },
            error: function(xhr, status, error) {
                console.log("Ajax Error:", error);
                console.log("Satus:", status);
                console.log("Response:", xhr.responseText);
            }

        });
        
    });

});