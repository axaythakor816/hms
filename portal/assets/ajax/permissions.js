window.state = window.state || {
    page: 1,
    perPage: 10,
    search: "",
    sortColumn: "permission_id",
    sortOrder: "ASC"
};
(function () {

    var state = window.state;
    $(document).ready(function () {
        loadpagedata();


        $(".permission-table-blk #searchInput").on("keyup", function () {
            state.search = $(this).val();
            state.page = 1;
            loadpagedata();
        });

        $(document).on("click", ".permission-refresh", function () {
            state.page = 1;
            state.perPage = 10;
            state.search = "";
            state.sortColumn = "permission_id";
            state.sortOrder = "ASC";

            $("#RecordsPerPage").val("10").trigger("change");
            $("#searchInput").val("");
            $(".row-check, #checkAll").prop("checked", false);
            $(".permission-delete").addClass("disabled")
            loadpagedata();
        });

        $(document).on("click", "#permission_Pagination .page-link", function () {
            const page = parseInt($(this).data("page"));
            state.page = page;
            loadpagedata();
        });

        $(".permission-search-blk #RecordsPerPage").on("change", function () {
            state.perPage = parseInt($(this).val());
            state.page = 1;
            loadpagedata();
        });

        $(document).on("click", "#permission_table th[data-column]", function () {
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
        
        $("#addpermissionModal").on("show.bs.modal", function() {
            get_roles();
            get_modules();
        });

        $("#addpermissionModal").on("hide.bs.modal", function () {
            $("#addpermission_form")[0].reset();
            $("button[name='save_permission']").prop("disabled", false).text("Create Permission");  
            $(".error").text("");
        });

        $("#addpermission_form").submit(function(e) {
            e.preventDefault();
            $(".error").text("");

            let rules = {};

            $("#module_id").length && (rules.module_id = "required");
            $("#role_id").length && (rules.role_id = "required");

            let errors = validateForm("#addpermission_form", rules);

            if(Object.keys(errors).length > 0) {
                $.each(errors, function (index, value) {
                    $("#" + index + "_error").text(value);                 
                });
                return false;
            }

            var form = $("#addpermission_form")[0];
            var formdata = new FormData(form);

            $.ajax({
                type: "POST",
                url: "settings/permissions/save_permission.php",
                data: formdata,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $(".error").text("");
                    $("button[name='save_permission']").prop("disabled", true).text("Creating...");
                },
                success: function (res) {
                    $("button[name='save_permission']").prop("disabled", false).text("Create Permission");  
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
                        $("button[name='save_permission']").prop("disabled", false).text("Create Permission");  
                        $("#addpermission_form")[0].reset();
                        $(".error").text("");
                        $("#addpermissionModal").modal("hide");
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

        $("#editpermissionModal").on("hide.bs.modal", function () {
            $("#editpermission_form")[0].reset();
            $(".error").text("");
            $("button[name='update_permission']").prop("disabled", false).text("Update Permission");  

        });

        $(document).on("click", ".edit-btn", function () {

            let id = $(this).data("id");
            let role = $(this).data("role");
            let module = $(this).data("module");
            let can_view = $(this).data("can_view");
            let can_add = $(this).data("can_add");
            let can_edit = $(this).data("can_edit");
            let can_delete = $(this).data("can_delete");

            $("#edit_permission_id").val(id);
            get_roles(function() {
                $("#edit_role_id").val(role).trigger("change");
            });
            get_modules(function() {
                $("#edit_module_id").val(module).trigger("change");
            })

            $("#edit_module").val(module);
            $("#edit_can_view").prop("checked", can_view == 1);
            $("#edit_can_add").prop("checked", can_add == 1);
            $("#edit_can_edit").prop("checked", can_edit == 1);
            $("#edit_can_delete").prop("checked", can_delete == 1);

            $("#editpermissionModal").modal("show");
        });

        $("#editpermission_form").submit(function(e) {
        e.preventDefault();
            $(".error").text("");
        
            let rules = {};

            $("#edit_module_id").length && (rules.module_id = "required");
            $("#edit_role_id").length && (rules.role_id = "required");

            let errors = validateForm("#editpermission_form", rules);

            if(Object.keys(errors).length > 0) {
                $.each(errors, function (index, value) {
                    $("#edit_" + index + "_error").text(value);                 
                });
                return false;
            }

            var form = $("#editpermission_form")[0];
            var formdata = new FormData(form);

            $.ajax({
                type: "POST",
                url: "settings/permissions/edit_permission.php",
                data: formdata,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $(".error").text("");
                    $("button[name='update_permission']").prop("disabled", true).text("Updating...");
                }, 
                success: function(res) {
                    $("button[name='update_permission']").prop("disabled", false).text("Update permissions"); 
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
                        $("#editpermissionModal").modal("hide");
                        $("#editpermission_form")[0].reset();
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

        $("#deletePermissionModal").on("hide.bs.modal", function () {
            $("#delete_permission_form")[0].reset();
            $("button[name='delete_permission']").prop("disabled", false).text("Delete");
        });

        $(document).on("click", ".delete-btn", function () {
            let id = $(this).data("id");
            let name = $(this).data("name");
            // console.log("id: ",id);
            $("#delete_permission_id").val(id);
            $("#delete_permission_name_text").text("Permission Name : " + name.toUpperCase());
            $("#deletePermissionModal").modal("show");
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
            $("#delete_permission_id").val(ids);  
            $("#delete_permission_name_text").text("Delete " + ids.length + " Selected Permission?");
            
            $("#deletePermissionModal").modal("show");
        });

        $("#delete_permission_form").submit(function(e) {
            e.preventDefault();
            
            var form = $("#delete_permission_form")[0];
            var formdata = new FormData(form);
            
            $.ajax({
                type: "POST",
                url: "settings/permissions/delete_permission.php",
                data: formdata,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    $("button[name='delete_permission']").prop("disabled", true).text("Deleting...");
                },
                success: function(res) {
                    $("button[name='delete_permission']").prop("disabled", false).text("Delete");
                    if(res.status == "error") {
                        $("#deletePermissionModal").modal("hide");
                        showAlert(res.status, res.message);
                    }else if(res.status, res.message) {
                        showAlert(res.status, res.message);
                        $("#delete_permission_form")[0].reset();
                        $("#deletePermissionModal").modal("hide");
                        $("#delete_permission_name_text").text("");
                        loadpagedata();

                        $("#checkAll").prop("checked", false);
                        $(".row-check").prop("checked", false);
                        $(".permission-delete").addClass("disabled");

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
                action: "settings/permissions/export_permissiondata.php",
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

    function get_roles(callback) {
        let csrf_token = $("#csrf_token").val();
        
        $.ajax({
            type: "POST",
            url: "settings/permissions/loadoptions.php",
            data: {
                action: "roles",
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

    function get_modules(callback) {
        let csrf_token = $("#csrf_token").val();
        
        $.ajax({
            type: "POST",
            url: "settings/permissions/loadoptions.php",
            data: {
                action: "modules",
                csrf_token: csrf_token
            },
            dataType: "json",
            success: function (res) {
                $("#module_id").html(res.data);  
                $("#edit_module_id").html(res.data);
            
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
        const token = $("#permission_csrf_token").val();
        const table = $("#permission_table");
        if (!table.length) return;

        $.ajax({
            type: "POST",
            url: "settings/permissions/get_permissiondata.php",
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
                    
                    const tbody = "#permission_table tbody";
                    const pagination = "#permission_Pagination";
                    const infotext = "#permission_InfoText";

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
            $(".permission-delete").removeClass("disabled");
        } else {
            $(".permission-delete").addClass("disabled");
        }
    }
})();