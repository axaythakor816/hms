// const state = {
//     page: 1, perPage: 10, search: "", sortColumn: "department_id", sortOrder: "DESC" 
// };

var state = window.state || {
    page: 1,
    perPage: 10,
    search: "",
    sortColumn: "department_id",
    sortOrder: "DESC"
};


$(document).ready(function () {
 
    loaddata();

    $("#searchInput").on("keyup", function () {
        state.search = $(this).val();
        state.page = 1;
        loaddata();
    });

    $(document).on("click", ".doctor-refresh", function () {
        state.page = 1;
        state.perPage = 10;
        state.search = "";
        state.sortColumn = "department_id";
        state.sortOrder = "DESC";

        $("#RecordsPerPage").val("10").trigger("change");
        $("#searchInput").val("");
        loaddata();
    });

    $(document).on("click", ".edit-btn", function () {

        let id = $(this).data("id");
        let name = $(this).data("name");
        let head = $(this).data("head_id");
        let desc = $(this).data("desc");

        $("#edit_department_id").val(id);
        $("#edit_department_name").val(name);
        $("#edit_department_description").val(desc);

        $("#edit_desc_count").text(desc.length);

        $("#editDepartmentModal").modal("show");
    });


    $("#addDepatmentModal").on("hide.bs.modal", function () {
        $("#adddepartment_form")[0].reset();
        $("#desc_count").text(0);   

        $(".error").text("");
    });

    $("#department_description").on("input", function() {
        let count = $(this).val().length;
        $("#desc_count").text(count);
        let desc = $(this).val();

        $.ajax({
            type: "POST",
            url: "departments/save_department.php",
            data: {
                action: 'count',
                department_description: desc
            },
            dataType: "json",
            success: function (data) {
                $("#desc_count").text(data.data);   
            },
            error: function(xhr, status, error) {
                console.log("Ajax Error:", error);
                console.log("Status: ", status);
                console.log("Response: ", xhr.responseText);
            }
        });
    });

    $("#adddepartment_form").submit(function(e) {
        e.preventDefault();
        $(".error").text("");


        let rules = {
            department_name: "required|max:30",
            department_description: "required|max:300",
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
                    showAlert(res.status, res.message);
                    $("#addDepatmentModal").modal("hide");
                    $("#adddepartment_form")[0].reset();
                    loaddata();
                }              
            },
            error: function(xhr, status, error) {
                console.log("Ajax Error:", error);
                console.log("Status: ", status);
                console.log("Response: ", xhr.responseText);
            }
        });
    });

    $(document).on("click", ".page-link", function () {
        const page = parseInt($(this).data("page"));
        state.page = page;
        loaddata();
    });

    $("#RecordsPerPage").on("change", function () {
        state.perPage = parseInt($(this).val());
        state.page = 1;
        loaddata();
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
        loaddata();
    });

});

function loaddata() {
    const { page, perPage, search, sortColumn, sortOrder } = state;
    const token = $('#department_csrf_token').val();

    $.ajax({
        type: "POST",
        url: "departments/get_departmentdata.php",
        data: {
            csrf_token: token,
            action: "POST",
            page: page,
            perPage: perPage,
            search: search,
            sortColumn: sortColumn,
            sortOrder: sortOrder
        },
        dataType: "json",
        success: function(res) {

            if (res.status === 'error') {
                return showAlert(res.message);
            }

            const tbody = "#department_table tbody";
            const pagination = "#department_Pagination";
            const infoText = "#Department_InfoText";

            $(tbody).html(res.data.html);

            const totalRecords = res.data.total;
            const totalPages = Math.ceil(totalRecords / perPage);

            let start = totalRecords === 0 ? 0 : (page - 1) * perPage + 1;
            let end = Math.min(page * perPage, totalRecords);

            $(infoText).text(`Showing ${start} to ${end} of ${totalRecords} entries`);

            $(pagination).html(generatePagination(page, totalPages));

        },

        error: function(xhr, status, error) {
            console.log("AJAX error:", error);
            console.log("Status: ", status);
            console.log("Response: ", xhr.responseText);
        }
    });
}


