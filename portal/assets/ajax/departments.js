$(document).ready(function () {
    // showAlert();
    $("#addDepatmentModal").on("hide.bs.modal", function () {
        $("#adddepartment_form")[0].reset();
        $(".error").text("");
    });

    $("#adddepartment_form").submit(function(e) {
        e.preventDefault();
        $(".error").text("");


        let rules = {
            department_name: "required|max:30",
            department_description: "required|max:100",
        };

        let errors = validateForm("#adddepartment_form", rules);

        if(Object.keys(errors).length > 0) {
            $.each(errors, function (index, value) {
                $("#" + index + "_error").text(value);                 
            });
            return false;
        }

        var form = $("#adddepartment_form")[0];
        var formdata = new FormData(form);

        $.ajax({
            type: "POST",
            url: "departments/save_department.php",
            data: formdata,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function() {
                $(".error").text("");
                $("button[name='save_department']").prop("disabled", true).text("Creating...");
            },
            success: function (res) {
                // alert(res.message);
                // showAlert(res.message);
                $("button[name='save_department']").prop("disabled", false).text("Create Department");  
                if(res.status == "error") {
                    if(res.message) {
                        showAlert(res.status, res.message);
                    }else {
                        $.each(res.errors, function(field, message) {
                            if(Array.isArray(message)) {
                                $("#" + field + "_error").text(message.join(", "));
                            } else{
                                $("#" + field + "_error").text(message);
                            }
                        });
                    }
                } else if (res.status == "success") {
                    // alert(res.message);
                    showAlert(res.status, res.message);
                    $("#addDepatmentModal").modal("hide");
                    $("#adddepartment_form")[0].reset();
                    loadPage("departments/department_list.php");  
                }              
            },
            error: function(xhr, status, error) {
                console.log("Ajax Error:", error);
                console.log("Status: ", status);
                console.log("Response: ", xhr.responseText);
            }
        });
    });
});