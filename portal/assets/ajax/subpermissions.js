window.state = window.state || {
    page: 1,
    perPage: 10,
    search: "",
    sortColumn: "sub_permission_id",
    sortOrder: "ASC"
};

(function() {
    var state = window.state;

    $(document).ready(function () {
        loadpagedata();

        
        $(".subpermission-table-blk #searchInput").on("keyup", function () {
            state.search = $(this).val();
            state.page = 1;
            loadpagedata();
        });

        $(document).on("click", ".subpermission-refresh", function () {
            state.page = 1;
            state.perPage = 10;
            state.search = "";
            state.sortColumn = "subpermission_id";
            state.sortOrder = "ASC";

            $("#RecordsPerPage").val("10").trigger("change");
            $("#searchInput").val("");
            $(".row-check, #checkAll").prop("checked", false);
            $(".subpermission-delete").addClass("disabled")
            loadpagedata();
        });

        $(document).on("click", "#subpermission_Pagination .page-link", function () {
            const page = parseInt($(this).data("page"));
            state.page = page;
            loadpagedata();
        });

        $(".subpermission-search-blk #RecordsPerPage").on("change", function () {
            state.perPage = parseInt($(this).val());
            state.page = 1;
            loadpagedata();
        });

        $(document).on("click", "#subpermission_table th[data-column]", function () {
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
    
        $("#addSubPermissionModal").on("show.bs.modal", function() {
            $(".error").text("");
            get_roles();
            get_modules();
        });

        $(document).on("change", "select[name = 'module_id']", function() {
            var module_id = $(this).val();            
            get_fields(module_id);
        });

        $("#addSubPermissionModal").on("hide.bs.modal", function () {
            $("#addSubPermission_form")[0].reset();
            $("button[name='save_sub_permission']").prop("disabled", false).html("Save Sub Permission");  
            $(".error").text("");
        });
        
        $("#addSubPermission_form").submit(function(e) {
            e.preventDefault();
            $(".error").text("");

            let rules = {};

            $("#module_id").length && (rules.module_id = "required");
            $("#role_id").length && (rules.role_id = "required");
            $("#field_id").length && (rules.field_id = "required");

            let errors = validateForm("#addSubPermission_form", rules);

            if(Object.keys(errors).length > 0) {
                $.each(errors, function(keys, value) {
                    $("#" + keys + "_error").text(value);
                });
                return false;
            }

            var form = $("#addSubPermission_form")[0];
            var formdata = new FormData(form);
            $.ajax({
                type: "POST",
                url: "settings/sub_permissions/save_subpermission.php",
                data: formdata,
                beforeSend: function() {
                    $("button[name = 'save_sub_permission']").prop("disabled", true).html('<span class="spinner-border spinner-border-sm me-1"></span> Saving...');
                },
                processData: false, 
                contentType: false,
                dataType: "json",
                success: function (res) {
                    $("button[name = 'save_sub_permission']").prop("disabled", false).html('Save Sub Permission');
                    if(res.status == "error") {
                        if(res.message) {
                            showAlert(res.status, res.error);
                        }else{
                            $.each(res.errors, function(index, message) {
                                $("#" + index + "_error").text(message);
                            });
                        }
                    }else if(res.status == "success") {
                        showAlert(res.status, res.message);
                        $("#addSubPermission_form")[0].reset();
                        $(".error").text("");
                        $("#addSubPermissionModal").modal("hide");
                        loadpagedata();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Status: ", status, error);
                    console.log("Response: ", xhr.responseText);
                }
            });
        });

         $("#editSubPermissionModal").on("hide.bs.modal", function () {
            $("#editSubPermission_form")[0].reset();
            $(".error").text("");
            $("button[name='update_sub_permission']").prop("disabled", false).html("Update Sub Permission");  
        });

        $(document).on("click", ".edit-btn", function() {
            $(".error").text("");

            var sub_permission_id = $(this).data("id");
            var field_id = $(this).data("field");
            var module_id = $(this).data("module");
            var role_id = $(this).data("role");
            var can_add = $(this).data("can_add");
            var can_view = $(this).data("can_view");
            var can_edit = $(this).data("can_edit");
            var can_delete = $(this).data("can_delete");

            $("#edit_sub_permission_id").val(sub_permission_id);

            get_roles(function() {
                $("#edit_role_id").val(role_id).trigger("change");
            });
            get_modules(function() {
                $("#edit_module_id").val(module_id).trigger("change");
                get_fields(module_id, function(){
                    $("#edit_field_id").val(field_id).trigger("change");
                });
            })

            $("#edit_can_view").prop("checked", can_view == 1);
            $("#edit_can_add").prop("checked", can_add == 1);
            $("#edit_can_edit").prop("checked", can_edit == 1);
            $("#edit_can_delete").prop("checked", can_delete == 1);
            $("#editSubPermissionModal").modal("show");

        });

        $("#editSubPermission_form").submit(function(e) {
            e.preventDefault();
            $(".error").text("");

            let rules = {};

            $("#edit_module_id").length && (rules.module_id = "required");
            $("#edit_role_id").length && (rules.role_id = "required");
            $("#edit_field_id").length && (rules.field_id = "required");

            let errors = validateForm("#editSubPermission_form", rules);

            if(Object.keys(errors).length > 0) {
                $.each(errors, function(keys, value) {
                    $("#edit_" + keys + "_error").text(value);
                });
                return false;
            }

            var form = $("#editSubPermission_form")[0];
            var formdata = new FormData(form);

            $.ajax({
                type: "POST",
                url: "settings/sub_permissions/edit_subpermission.php",
                data: formdata,
                processData: false,
                contentType: false,
                beforeSend: function(){
                    $("button[name = 'update_sub_permission']").prop("disabled", true).html('<span class="spinner-border spinner-border-sm me-1"></span> Updating...');
                },
                dataType: "json",
                success: function (res) {
                    $("button[name = 'update_sub_permission']").prop("disabled", true).html('Update Sub Permission');
                    if(res.status == "error") {
                        if(res.message) {
                            showAlert(res.status, res.message);
                        }else{
                            $.each(res.errors, function(keys, value) {
                                $("#edit_" + keys + "_error").text(value);
                            });
                        }
                    }else if(res.status == "success") {
                        showAlert(res.status, res.message);
                        $("#editSubPermissionModal").modal("hide");
                        $("#editSubPermission_form")[0].reset();
                        loadpagedata();
                    }
                    
                },
                error: function(xhr, status, error) {
                    console.log("Status: ", status, error);
                    console.log("Response: ", xhr.responseText);
                }
            });
        });

        $("#deleteSubPermissionModal").on("hide.bs.modal", function () {
            $("#delete_sub_permission_form")[0].reset();
            $("button[name='delete_sub_permission']").prop("disabled", false).text("Delete");
        });

        $(document).on("click", ".delete-btn", function () {
            let id = $(this).data("id");
            let name = $(this).data("name");
            // console.log("id: ",id);
            $("#delete_sub_permission_id").val(id);
            $("#delete_sub_permission_name_text").text("Sub Permission Name : " + name.toUpperCase());
            $("#deleteSubPermissionModal").modal("show");
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
            $("#delete_sub_permission_id").val(ids);  
            $("#delete_sub_permission_name_text").text("Delete " + ids.length + " Selected Sub Permission?");
            
            $("#deleteSubPermissionModal").modal("show");
        });

        $("#delete_sub_permission_form").submit(function(e) {
            e.preventDefault();
            
            var form = $("#delete_sub_permission_form")[0];
            var formdata = new FormData(form);
            
            $.ajax({
                type: "POST",
                url: "settings/sub_permissions/delete_subpermission.php",
                data: formdata,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    $("button[name='delete_sub_permission']").prop("disabled", true).text("Deleting...");
                },
                success: function(res) {
                    $("button[name='delete_sub_permission']").prop("disabled", false).text("Delete");
                    if(res.status == "error") {
                        $("#deleteSubPermissionModal").modal("hide");
                        showAlert(res.status, res.message);
                    }else if(res.status, res.message) {
                        showAlert(res.status, res.message);
                        $("#delete_sub_permission_form")[0].reset();
                        $("#deleteSubPermissionModal").modal("hide");
                        $("#delete_sub_permission_name_text").text("");
                        loadpagedata();

                        $("#checkAll").prop("checked", false);
                        $(".row-check").prop("checked", false);
                        $(".subpermission-delete").addClass("disabled");

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
                action: "settings/sub_permissions/export_subpermissiondata.php",
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

    function get_fields(module_id, callback) {
        var csrf_token = $("#csrf_token").val();

        $.ajax({
            type: "POST",
            url: "settings/sub_permissions/loadoptions.php",
            data: {
                csrf_token, 
                module_id,
                action: "get_fields"
            },
            dataType: "json",
            success: function (res) {
                $("#field_id").html(res.data);
                $("#edit_field_id").html(res.data);
                if(callback) callback();
            },
            error: function(xhr, status, error) {
                console.log("Status: ", status);
                console.log("Ajax Error: ", error);
                console.log("Response: ", xhr.responseText);
            }
        });

    }

    function get_modules(callback) {
        var csrf_token = $("#csrf_token").val();

        $.ajax({
            type: "POST",
            url: "settings/sub_permissions/loadoptions.php",
            data: {
                csrf_token,
                action: "get_modules"
            },
            dataType: "json",
            success: function (res) {
                $("#module_id").html(res.data);
                $("#edit_module_id").html(res.data);
                if(callback) callback();
            },
            error: function(xhr, status, error) {
                console.log("Status: ", status);
                console.log("Ajax Error: ", error);
                console.log("Response: ", xhr.responseText);
            }
        });
    }

    function get_roles(callback) {
        var csrf_token = $("#csrf_token").val();

        $.ajax({
            type: "POST",
            url: "settings/sub_permissions/loadoptions.php",
            data: {
                csrf_token,
                action: "get_roles"
            },
            dataType: "json",
            success: function (res) {
                $("#role_id").html(res.data);   
                $("#edit_role_id").html(res.data);  
                if(callback) callback();    
            },
            error: function(xhr, status, error) {
                console.log("Status: ", status);
                console.log("Ajax Error: ", error);
                console.log("Response: ", xhr.responseText);
            }
        });
    }

    function loadpagedata() {
        const { page, perPage, search, sortColumn, sortOrder } = state;
        const token = $("#subpermission_csrf_token").val();
        const table = $("#subpermission_table");
        if (!table.length) return;

        $.ajax({
            type: "POST",
            url: "settings/sub_permissions/get_subpermissiondata.php",
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
                    
                    const tbody = "#subpermission_table tbody";
                    const pagination = "#subpermission_Pagination";
                    const infotext = "#subpermission_InfoText";

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
            $(".subpermission-delete").removeClass("disabled");
        } else {
            $(".subpermission-delete").addClass("disabled");
        }
    }

})();