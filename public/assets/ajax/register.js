$(document).ready(function () {
    
    $("#registration_form").submit(function (e) { 
        e.preventDefault();
        $(".error").text(" ");

        let rules = {
            name: "required|name|min:3",
            email: "required|email",
            phone: "required|mobile",
            password: "required|password_strong",
            confirm_password: "required|match:password",

        };

        let errors = validateForm("#registration_form", rules);

        if(Object.keys(errors).length > 0) {
            $.each(errors, function (indexInArray, valueOfElement) {
                $("#" + indexInArray + "_error").text(valueOfElement);              
                 
            });
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
                if(res.status == "error") {
                    if(res.message) {
                        alert(res.message);
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
                    alert(res.message);
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