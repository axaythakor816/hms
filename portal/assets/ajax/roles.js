window.state = window.state || {
    page: 1,
    perPage: 10,
    search: "",
    sortColumn: "id",
    sortOrder: "ASC"
};
(function () {

    var state = window.state;
    $(document).ready(function () {
        loadpagedata();


        $("#searchInput").on("keyup", function () {
            state.search = $(this).val();
            state.page = 1;
            loadpagedata();
        });

        $(document).on("click", ".role-refresh", function () {
            state.page = 1;
            state.perPage = 10;
            state.search = "";
            state.sortColumn = "id";
            state.sortOrder = "ASC";

            $("#RecordsPerPage").val("10").trigger("change");
            $("#searchInput").val("");
            $(".row-check, #checkAll").prop("checked", false);
            $(".role-delete").addClass("disabled")
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

        $("#addRoleModal").on("hide.bs.modal", function () {
            $("#addrole_form")[0].reset();
            $("button[name='save_role']").prop("disabled", false).text("Create Role");  
            $(".error").text("");
        });

        $("#addrole_form").submit(function(e) {
            e.preventDefault();
            $(".error").text("");

            let rules = {
                role_name: "required",
            };

            let errors = validateForm("#addrole_form", rules);

            if(Object.keys(errors).length > 0) {
                $.each(errors, function (index, value) {
                    $("#" + index + "_error").text(value);                 
                });
                return false;
            }

            var form = $("#addrole_form")[0];
            var formdata = new FormData(form);

            $.ajax({
                type: "POST",
                url: "settings/roles/save_role.php",
                data: formdata,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $(".error").text("");
                    $("button[name='save_role']").prop("disabled", true).text("Creating...");
                },
                success: function (res) {
                    $("button[name='save_role']").prop("disabled", false).text("Create Role");  
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
                        $("button[name='save_role']").prop("disabled", false).text("Create Role");  
                        $("#addrole_form")[0].reset();
                        $(".error").text("");                
                        $("#addRoleModal").modal("hide");
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

        $("#editRoleModal").on("hide.bs.modal", function () {
            $("#editrole_form")[0].reset();
            $(".error").text("");
            $("button[name='update_role']").prop("disabled", false).text("Update Role");  

        });

        $(document).on("click", ".edit-btn", function () {

            let id = $(this).data("id");
            let role = $(this).data("role");

            $("#edit_role_id").val(id);

            $("#edit_role_name").val(role);
        
            $("#editRoleModal").modal("show");
        });

        $("#editrole_form").submit(function(e) {
        e.preventDefault();
            $(".error").text("");
        
            let rules = {
                role_name: "required",
            };

            let errors = validateForm("#editrole_form", rules);

            if(Object.keys(errors).length > 0) {
                $.each(errors, function (index, value) {
                    $("#edit_" + index + "_error").text(value);                 
                });
                return false;
            }

            var form = $("#editrole_form")[0];
            var formdata = new FormData(form);

            $.ajax({
                type: "POST",
                url: "settings/roles/edit_role.php",
                data: formdata,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $(".error").text("");
                    $("button[name='update_role]").prop("disabled", true).text("Updating...");
                }, 
                success: function(res) {
                    $("button[name='update_role']").prop("disabled", false).text("Update Role"); 
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
                        $("#editRoleModal").modal("hide");
                        $("#editrole_form")[0].reset();
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

        $("#deleteRoleModal").on("hide.bs.modal", function () {
            $("#delete_role_form")[0].reset();
            $("button[name='delete_role']").prop("disabled", false).text("Delete");
        });

        $(document).on("click", ".delete-btn", function () {
            let id = $(this).data("id");
            let name = $(this).data("name");
            // console.log("id: ",id);
            $("#delete_role_id").val(id);
            $("#delete_role_name_text").text("Role Name : " + name.toUpperCase());
            $("#deleteRoleModal").modal("show");
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
            $("#delete_role_id").val(ids);  
            $("#delete_role_name_text").text("Delete " + ids.length + " Selected Roles?");
            
            $("#deleteRoleModal").modal("show");
        });

        $("#delete_role_form").submit(function(e) {
            e.preventDefault();
            
            var form = $("#delete_role_form")[0];
            var formdata = new FormData(form);
            
            $.ajax({
                type: "POST",
                url: "settings/roles/delete_role.php",
                data: formdata,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    $("button[name='delete_role']").prop("disabled", true).text("Deleting...");
                },
                success: function(res) {
                    $("button[name='delete_role']").prop("disabled", false).text("Delete");
                    if(res.status == "error") {
                        $("#deleteRoleModal").modal("hide");
                        showAlert(res.status, res.message);
                    }else if(res.status, res.message) {
                        showAlert(res.status, res.message);
                        $("#delete_role_form")[0].reset();
                        $("#deleteRoleModal").modal("hide");
                        $("#delete_role_name_text").text("");
                        loadpagedata();

                        $("#checkAll").prop("checked", false);
                        $(".row-check").prop("checked", false);
                        $(".role-delete").addClass("disabled");

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
                action: "settings/roles/export_roledata.php",
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

    function loadpagedata() {
        const { page, perPage, search, sortColumn, sortOrder} = state;
        const token = $("#role_csrf_token").val();

        $.ajax({
            type: "POST",
            url: "settings/roles/get_roledata.php",
            data: {
                page: page,
                perPage: perPage,
                search: search,
                sortColumn: sortColumn,
                sortOrder: sortOrder,
                csrf_token: token
            },
            dataType: 'json',
            success: function (res) {
                if(res.status == "error") {
                    showAlert(res.status, res.message);
                }else if(res.status == "success") {
                    
                    const tbody = "#role_table tbody";
                    const pagination = "#role_Pagination";
                    const infotext = "#role_InfoText";

                    $(tbody).html(res.data.html);

                    const totalRecords = res.data.total;
                    const totalPages = Math.ceil(totalRecords / perPage);

                    let start = totalRecords === 0 ? 0 : (page - 1) * perPage + 1;
                    let end = Math.min(page  * perPage, totalRecords);

                    $(infotext).text(`Showing ${start} to ${end} of ${totalRecords} entries`);
                    $(pagination).html(generatePagination(page, totalPages));

                }
                
            },
            error: function(xhr, status, error) {
                console.log("Ajax Error: ", error);
                console.log("Status: ", status);
                console.log("Response: ", xhr.responseText);
            }
        });
    }

    function updateDeleteButtonState() {
        if ($(".row-check:checked").length > 0) {
            $(".role-delete").removeClass("disabled");
        } else {
            $(".role-delete").addClass("disabled");
        }
    }


})();
