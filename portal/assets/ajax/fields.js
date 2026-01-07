window.state = window.state || {
    page: 1,
    perPage: 10,
    search: "",
    sortColumn: "field_id",
    sortOrder: "ASC"
};
(function() {
    var state = window.state;
    $(document).ready(function() {
        loadpagedata();

        $(".field-table-blk #searchInput").on("keyup", function () {
            state.search = $(this).val();
            state.page = 1;
            loadpagedata();
        });

        $(document).on("click", ".field-refresh", function () {
            state.page = 1;
            state.perPage = 10;
            state.search = "";
            state.sortColumn = "field_id";
            state.sortOrder = "ASC";

            $("#RecordsPerPage").val("10").trigger("change");
            $("#searchInput").val("");
            $(".row-check, #checkAll").prop("checked", false);
            $(".field-delete").addClass("disabled")
            loadpagedata();
        });

        $(document).on("click", "#field_Pagination .page-link", function() {
            const page = parseInt($(this).data("page"));
            state.page = page;
            loadpagedata();
        });

        $(".field-table-blk #RecordsPerPage").on("change", function() {
            state.perPage = parseInt($(this).val());
            state.page = 1;
            loadpagedata();
        });

        $(document).on("click", "#field_table th[data-column]", function() {
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

        $("#addFieldModal").on("hide.bs.modal", function() {
            $("#addfield_form")[0].reset();
            $(".error").text("");
            $("button[name = 'save_field']").prop("disabled", false).html("Create Field");
        });

        $("#addFieldModal").on("show.bs.modal", function() {
            get_module();
        });

        $("#addfield_form").submit(function(e) {
            e.preventDefault();
            $(".error").text("");

            let rules = {};

            $("#module_id").length && (rules.module_id = "required");
            $("#field_name").length && (rules.field_name = "required|min:2|max:30");

            let errors = validateForm("#addfield_form", rules);

            if(Object.keys(errors).length > 0) {
                $.each(errors, function(index, message) {
                    $("#" + index + "_error").text(message);
                });
                return false;
            }

            var form = $("#addfield_form")[0];
            var formdata = new FormData(form);
            
            $.ajax({
                type: "POST",
                url: "settings/fields/save_field.php",
                data: formdata,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $("button[name = 'save_field").prop("disabled", true).html('<span class="spinner-border spinner-border-sm me-1"></span> Creating...');
                },
                success: function(res) {
                    $("button[name='save_field']").prop("disabled", false).html("Create Field");  
                    if(res.status == "error") {
                        if(res.message) {
                            showAlert(res.status, res.message);
                        }else{
                            $.each(res.errors, function(index, message) {
                                $("#" + index + "_error").text(message);
                            });
                        }
                    }else if(res.status == "success") {
                        showAlert(res.status, res.message);
                        $("#addfield_form")[0].reset();
                        $(".error").text("");
                        $("#addFieldModal").modal("hide");
                        loadpagedata();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Status: ", status);
                    console.log("Ajax Error: ", error);
                    console.log("Response: ", xhr.responseText);
                }

            });
        });

        $("#editFieldModal").on("hide.bs.modal", function () {
            $("#editfield_form")[0].reset();
            $(".error").text("");
            $("button[name='update_field']").prop("disabled", false).html("Update Field");  
        });

        $(document).on("click", ".edit-btn", function () {

            let id = $(this).data("id");
            let module_id = $(this).data("module");
            let field = $(this).data("field");

            get_module(function() {
                $("#edit_module_id").val(module_id).trigger("change");
            });
            $("#edit_field_name").val(field);
            $("#field_id").val(id);
            $("#editFieldModal").modal("show");
        });

        $("#editfield_form").submit(function(e) {
            e.preventDefault();
            $(".error").text("");

            let rules = {};
            $("#edit_module_id").length && (rules.module_id = "required");
            $("#edit_field_name").length && (rules.field_name = "required|min:2|max:30");

            let errors = validateForm("#editfield_form", rules);

            if(Object.keys(errors).length > 0) {
                $.each(errors, function(index, message) {
                    $("#edit_" + index + "_error").text(message);
                });
                return false;
            }

            var form = $("#editfield_form")[0];
            var formdata = new FormData(form);

            $.ajax({
                type: "POST",
                url: "settings/fields/edit_field.php",
                data: formdata,
                beforeSend: function() {
                    $("button[name = 'update_field']").prop("disabled", true).html('<span class="spinner-border spinner-border-sm me-1"></span> Updating...');
                },
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (res) {
                    if(res.status == "error") {
                        if(res.message) {
                            showAlert(res.status, res.message);
                        }else{
                            $.each(res.errors, function(index, message) {
                                $("#edit_" + index + "_error").text(message);
                            });
                        }
                    }else if(res.status == "success") {
                        showAlert(res.status, res.message);
                        $("#editFieldModal").modal("hide");
                        $("#editfield_form")[0].reset();
                        loadpagedata();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Status: ", status);
                    console.log("Ajax Error: ", error);
                    console.log("Response: ", xhr.responseText);
                },
                complete: function() {
                    $("button[name = 'update_field']").prop("disabled", false).html('Update Field');
                }
            });

        });

        $("#deleteFieldModal").on("hide.bs.modal", function() {
            $("#delete_field_form")[0].reset();
            $("#delete_field_id").val("");
            $("#delete_field_name_text").text("");
            $("button[name='delete_field']").prop("disabled", false).html("Delete");           
        });

        $(document).on("click", ".delete-btn", function() {
            let id = $(this).data("id");
            let name = $(this).data("name");

            $("#delete_field_id").val(id);
            $("#delete_field_name_text").text("Field Name : " + name.toUpperCase());
            $("#deleteFieldModal").modal("show");
        });

        $(document).on("click", "#deleteSelected", function() {
            let ids = [];

            $(".row-check:checked").each(function(){
                ids.push($(this).val());
            });

            if(ids.length === 0) {
                showAlert("error", "Please select at least one record.");
            }
            $("#delete_field_id").val(ids);  
            $("#delete_field_name_text").text("Delete " + ids.length + " Selected Fields?");
            
            $("#deleteFieldModal").modal("show");
        })

        $("#delete_field_form").submit(function(e) {
            e.preventDefault();

            var form = $("#delete_field_form")[0];
            var formdata = new FormData(form);

            $.ajax({
                type: "POST",
                url: "settings/fields/delete_field.php",
                data: formdata,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $("button[name = '']").prop("disabled", true).html('<span class="spinner-border spinner-border-sm me-1"></span> Deleting...');
                },
                dataType: "json",
                success: function (res) {
                    if(res.status == "error") {
                        showAlert(res.status, res.message);
                    }else if(res.status == "success") {
                        showAlert(res.status, res.message);
                        $("#delete_field_form")[0].reset();
                        $("#deleteFieldModal").modal("hide");
                        $("#delete_field_name_text").text("");
                        loadpagedata();

                        $("#checkAll").prop("checked", false);
                        $(".row-check").prop("checked", false);
                        $(".field-delete").addClass("disabled");
                    }
                    
                },
                error: function(xhr, status, error) {
                    console.log("Status: ", status);
                    console.log("Ajax Errot: ", error);
                    console.log("Response: ", xhr.responseText);
                }
            });
        })

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
                action: "settings/fields/export_fielddata.php",
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
            $(".field-delete").removeClass("disabled");
        } else {
            $(".field-delete").addClass("disabled");
        }
    }

    function get_module(callback) {
        let csrf_token = $("#csrf_token").val();
         
        $.ajax({
            type: "POST",
            url: "settings/fields/loadoptions.php",
            data: {
                csrf_token,
            }, 
            dataType: "json",
            success: function(res) {
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

    function loadpagedata() {
        const { page, perPage, search, sortColumn, sortOrder } = state;
        const csrf_token = $("#field_csrf_token").val();
        const table = $("#field_table");
        if(!table.length) return;

        $.ajax({
            type: "POST",
            url: "settings/fields/get_fielddata.php",
            data: {
                csrf_token,
                page,
                perPage,
                search,
                sortColumn,
                sortOrder
            },
            dataType: "json",
            success: function(res) {
                const tbody = "#field_table tbody";
                const infotext = "#field_InfoText";
                const pagination = "#field_Pagination";

                $(tbody).html(res.data.html);

                const totalRecords = res.data.total;
                const totalPages = Math.ceil(totalRecords  / perPage);

                let start = totalRecords === 0 ? 0 : (page - 1) * perPage + 1;
                let end = Math.min(page * perPage, totalRecords);

                $(infotext).text(`Showing ${start} to ${end} of ${totalRecords} entries`);
                $(pagination).html(generatePagination(page, totalPages, ));

            },
            error: function(xhr, status, error) {
                console.log("Status: ", status);
                console.log("Ajax Error: ", error);
                console.log("Response: ", xhr.responseText);
            }
        });

    }
})();