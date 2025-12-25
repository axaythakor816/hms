window.state = window.state || {
    page: 1,
    perPage: 10,
    search: "",
    sortColumn: "module_id",
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

        $(document).on("click", ".module-refresh", function () {
            state.page = 1;
            state.perPage = 10;
            state.search = "";
            state.sortColumn = "module_id";
            state.sortOrder = "ASC";

            $("#RecordsPerPage").val("10").trigger("change");
            $("#searchInput").val("");
            $(".row-check, #checkAll").prop("checked", false);
            $(".mudule-delete").addClass("disabled")
            loadpagedata();
        });

        $(document).on("click", ".page-link", function() {
            const page = parseInt($(this).data("page"));
            state.page = page;
            loadpagedata();
        });

        $("#RecordsPerPage").on("change", function() {
            state.perPage = parseInt($(this).val());
            state.page = 1;
            loadpagedata();
        });

        $(document).on("click", "th[data-column]", function() {
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

        $("#addModuleModal").on("hide.bs.modal", function () {
            $("#addmodule_form")[0].reset();
            $("button[name='save_module']").prop("disabled", false).text("Create Module");  
            $(".error").text("");
        });

        $("#addmodule_form").submit(function(e) {
            e.preventDefault();
            $(".error").text("");

            let rules = {
                module_name: "required|max:20",
            };

            let errors = validateForm("#addmodule_form", rules);

            if(Object.keys(errors).length > 0) {
                $.each(errors, function (index, value) {
                    $("#" + index + "_error").text(value);                 
                });
                return false;
            }

            var form = $("#addmodule_form")[0];
            var formdata = new FormData(form);

            $.ajax({
                type: "POST",
                url: "settings/modules/save_modules.php",
                data: formdata,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $(".error").text("");
                    $("button[name='save_module']").prop("disabled", true).text("Creating...");
                },
                success: function (res) {
                    $("button[name='save_module']").prop("disabled", false).text("Create Module");  
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
                        $("button[name='save_module']").prop("disabled", false).text("Create Module");  
                        $("#addmodule_form")[0].reset();
                        $(".error").text("");
                        $("#addModuleModal").modal("hide");
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

        $("#editModuleModal").on("hide.bs.modal", function () {
            $("#editmodule_form")[0].reset();
            $(".error").text("");
            $("button[name='update_module']").prop("disabled", false).text("Update Module");  

        });

        $(document).on("click", ".edit-btn", function () {

            let id = $(this).data("id");
            let module = $(this).data("module");

            $("#edit_module_id").val(id);
            $("#edit_module_name").val(module); 
            $("#editModuleModal").modal("show");
        });

        $("#editmodule_form").submit(function(e) {
        e.preventDefault();
            $(".error").text("");
        
            let rules = {
                module_name: "required|max:20",
            };

            let errors = validateForm("#editmodule_form", rules);

            if(Object.keys(errors).length > 0) {
                $.each(errors, function (index, value) {
                    $("#edit_" + index + "_error").text(value);                 
                });
                return false;
            }

            var form = $("#editmodule_form")[0];
            var formdata = new FormData(form);

            $.ajax({
                type: "POST",
                url: "settings/modules/edit_module.php",
                data: formdata,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $(".error").text("");
                    $("button[name='update_module']").prop("disabled", true).text("Updating...");
                }, 
                success: function(res) {
                    $("button[name='update_module']").prop("disabled", false).text("Update Module"); 
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
                        $("#editModuleModal").modal("hide");
                        $("#editmodule_form")[0].reset();
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

        $("#deleteModuleModal").on("hide.bs.modal", function () {
            $("#delete_module_form")[0].reset();
            $("button[name='delete_module']").prop("disabled", false).text("Delete");
        });

        $(document).on("click", ".delete-btn", function () {
            let id = $(this).data("id");
            let name = $(this).data("name");
            $("#delete_module_id").val(id);
            $("#delete_module_name_text").text("Module Name : " + name.toUpperCase());
            $("#deleteModuleModal").modal("show");
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
            $("#delete_module_id").val(ids);  
            $("#delete_module_name_text").text("Delete " + ids.length + " Selected Module?");
            
            $("#deleteModuleModal").modal("show");
        });

        $("#delete_module_form").submit(function(e) {
            e.preventDefault();
            
            var form = $("#delete_module_form")[0];
            var formdata = new FormData(form);
            
            $.ajax({
                type: "POST",
                url: "settings/modules/delete_module.php",
                data: formdata,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    $("button[name='delete_module']").prop("disabled", true).text("Deleting...");
                },
                success: function(res) {
                    $("button[name='delete_module']").prop("disabled", false).text("Delete");
                    if(res.status == "error") {
                        $("#deleteModuleModal").modal("hide");
                        showAlert(res.status, res.message);
                    }else if(res.status, res.message) {
                        showAlert(res.status, res.message);
                        $("#delete_module_form")[0].reset();
                        $("#deleteModuleModal").modal("hide");
                        $("#delete_module_name_text").text("");
                        loadpagedata();

                        $("#checkAll").prop("checked", false);
                        $(".row-check").prop("checked", false);
                        $(".module-delete").addClass("disabled");

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
                action: "settings/modules/export_moduledata.php",
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
        const token = $("#module_csrf_token").val();

        $.ajax({
            type: "POST",
            url: "settings/modules/get_moduledata.php",
            data: {
                csrf_token: token,
                page: page,
                perPage: perPage,
                search: search,
                sortColumn: sortColumn,
                sortOrder: sortOrder
            },
            dataType: "json",
            success: function (res) {
                
                const tbody = "#module_table tbody";
                const infotext = "#module_InfoText";
                const pagination = "#module_Pagination";

                $(tbody).html(res.data.html);

                const totalRecords = res.data.total;
                const totalPages = Math.ceil(totalRecords / perPage);

                let start = totalRecords === 0 ? 0 : (page - 1) * perPage + 1;
                let end = Math.min(page * perPage, totalRecords);

                $(infotext).text(`Showing ${start} to ${end} of ${totalRecords} entries`);
                $(pagination).html(generatePagination(page, totalPages));            
            },
            error: function(xhr, status, error) {
                console.log("Status:", status);
                console.log("Ajax Error: ", error);
                console.log("Response: ", xhr.responseText);
            }
        });
    }

    function updateDeleteButtonState() {
        if ($(".row-check:checked").length > 0) {
            $(".module-delete").removeClass("disabled");
        } else {
            $(".module-delete").addClass("disabled");
        }
    }
})();