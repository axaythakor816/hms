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
    });

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

})();