window.state = window.state || {
    page: 1,
    perPage: 10,
    search: "",
    sortColumn: "department_id",
    sortOrder: "ASC"
};
(function () {

    var state = window.state;

    $(document).ready(function () {
        loadpagedata();

        $(".department-table-blk #searchInput").on("keyup", function () {
            state.search = $(this).val();
            state.page = 1;
            loadpagedata();
        });

        $(document).on("click", ".department-refresh", function () {
            state.page = 1;
            state.perPage = 10;
            state.search = "";
            state.sortColumn = "department_id";
            state.sortOrder = "ASC";

            $("#RecordsPerPage").val("10").trigger("change");
            $("#searchInput").val("");
            $(".row-check, #checkAll").prop("checked", false);
            $(".department-delete").addClass("disabled")
            loadpagedata();
        });

        $(document).on("click", "#department_Pagination .page-link", function () {
            const page = parseInt($(this).data("page"));
            state.page = page;
            loadpagedata();
        });

        $(".department-table-blk #RecordsPerPage").on("change", function () {
            state.perPage = parseInt($(this).val());
            state.page = 1;
            loadpagedata();
        });

        $(document).on("click", "#department_table th[data-column]", function () {
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

        $("#addDepatmentModal").on("hide.bs.modal", function () {
            $("#adddepartment_form")[0].reset();
            $("#desc_count").text(0);  
            $("button[name='save_department']").prop("disabled", false).text("Create Department");  

            $(".error").text("");
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

            let isModal = $(this).closest(".modal.show").length > 0;
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
                        $("button[name='save_department']").prop("disabled", false).text("Create Department");  
                        $("#adddepartment_form")[0].reset();
                        $("#desc_count").text(0);  
                        $(".error").text("");

                        if(isModal) {
                            $("#addDepatmentModal").modal("hide");
                            loadpagedata();
                        }else{
                            loadPage("departments/department_list.php")
                        }
                    }              
                },
                error: function(xhr, status, error) {
                    console.log("Ajax Error:", error);
                    console.log("Status: ", status);
                    console.log("Response: ", xhr.responseText);
                }
            });
        });

        $("#editDepartmentModal").on("hide.bs.modal", function () {
            $("#editdepartment_form")[0].reset();
            $("#edit_desc_count").text(0);   
            $(".error").text("");
            $("button[name='update_department']").prop("disabled", false).text("Update Department");  

        });

        $("#edit_department_description").on("input", function() {
            var count = $(this).val().length;
            $("#edit_desc_count").text(count);
            var desc = $(this).val();

            $.ajax({
                type: "POST",
                url: "departments/save_department.php",
                data: {
                    action: "count",
                    department_description: desc
                },
                dataType: "json",
                success: function(res) {
                    $("#edit_desc_count").text(res.data);
                },
                error: function(xhr, status, error) {
                    console.log("Ajax Error: ", error);
                    console.log("Status: ", status);
                    console.log("Response: ", xhr.responseText);
                }
            });
        });

        $(document).on("click", ".edit-btn", function () {

            let id = $(this).data("id");
            let name = $(this).data("name");
            let head = $(this).data("head_id");
            // let desc = $(this).data("desc");
            let desc = String($(this).data("desc") ?? "");
            
            $("#edit_department_id").val(id);
            $("#edit_department_name").val(name);
            $("#edit_department_description").val(desc);

            $("#edit_desc_count").text(desc.length);

            $("#editDepartmentModal").modal("show");
        });

        $("#editdepartment_form").submit(function(e) {
        e.preventDefault();
            $(".error").text("");
        
            let rules = {
                department_name: "required|max:30",
                department_head_id: "required",
                department_description: "required|max:300",
            };

            let errors = validateForm("#editdepartment_form", rules);

            if(Object.keys(errors).length > 0) {
                $.each(errors, function (index, value) {
                    $("#edit_" + index + "_error").text(value);                 
                });
                return false;
            }

            var form = $("#editdepartment_form")[0];
            var formdata = new FormData(form);

            $.ajax({
                type: "POST",
                url: "departments/edit_department.php",
                data: formdata,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $(".error").text("");
                    $("button[name='update_department']").prop("disabled", true).text("Updating...");
                }, 
                success: function(res) {
                    $("button[name='update_department']").prop("disabled", false).text("Update Department"); 
                    if(res.status == "error") {
                        if(res.message) {
                            showAlert(res.status, res.message);
                        }else{
                            $.each(res.errors, function(field, message) {
                                if(Array.isArray(message)) {
                                    $("#edit_" + field + "_error").text(message.join(", "));
                                }else{
                                    $("#edit_" + field + "_error").text(message);
                                }
                            });
                        }
                    }else if(res.status == "success") {
                        showAlert(res.status, res.message);
                        $("#editDepartmentModal").modal("hide");
                        $("#editdepartment_form")[0].reset();
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

        $("#deleteDepartmentModal").on("hide.bs.modal", function () {
            $("#deletedepartment_form")[0].reset();
            $("button[name='delete_department']").prop("disabled", false).text("Delete");
        });

        $(document).on("click", ".delete-btn", function () {
            let id = $(this).data("id");
            let name = $(this).data("name");
            // console.log(id);
            $("#delete_department_id").val(id);
            $("#delete_department_name_text").text("Department Name : " + name);
            $("#deleteDepartmentModal").modal("show");
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
            $("#delete_department_id").val(ids);  
            $("#delete_department_name_text").text("Delete " + ids.length + " Selected Departments?");
            
            $("#deleteDepartmentModal").modal("show");
        });

        $("#deletedepartment_form").submit(function(e) {
            e.preventDefault();
            
            var form = $("#deletedepartment_form")[0];
            var formdata = new FormData(form);
            
            $.ajax({
                type: "POST",
                url: "departments/delete_department.php",
                data: formdata,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    $("button[name='delete_department']").prop("disabled", true).text("Deleting...");
                },
                success: function(res) {
                    $("button[name='delete_department']").prop("disabled", false).text("Delete");
                    if(res.status == "error") {
                        $("#deleteDepartmentModal").modal("hide");
                        showAlert(res.status, res.message);
                    }else if(res.status, res.message) {
                        showAlert(res.status, res.message);
                        $("#deletedepartment_form")[0].reset();
                        $("#deleteDepartmentModal").modal("hide");
                        $("#delete_department_name_text").text("");
                        loadpagedata();

                        $("#checkAll").prop("checked", false);
                        $(".row-check").prop("checked", false);
                        $(".department-delete").addClass("disabled");

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
                action: "departments/export_data.php",
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

    });

    function updateDeleteButtonState() {
        if ($(".row-check:checked").length > 0) {
            $(".department-delete").removeClass("disabled");
        } else {
            $(".department-delete").addClass("disabled");
        }
    }

    function loadpagedata() {
        const { page, perPage, search, sortColumn, sortOrder } = state;
        const token = $('#department_csrf_token').val();
        const table = $("#department_table");
        if (!table.length) return;
        
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
                    return showAlert(res.status, res.message);  
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

})();


