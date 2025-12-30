window.state = window.state || {
    page: 1,
    perPage: 10,
    search: "",
    sortColumn: "doctor_id",
    sortOrder: "ASC"
};
(function () {

    var state = window.state;

    $(document).ready(function () {
        loadpagedata();

        $(".doctor-table-blk #searchInput").on("keyup", function () {
            state.search = $(this).val();
            state.page = 1;
            loadpagedata();
        });

        $(document).on("click", ".doctor-refresh", function () {
            state.page = 1;
            state.perPage = 10;
            state.search = "";
            state.sortColumn = "department_id";
            state.sortOrder = "ASC";

            $("#RecordsPerPage").val("10").trigger("change");
            $("#searchInput").val("");
            $(".row-check, #checkAll").prop("checked", false);
            $(".doctor-delete").addClass("disabled")
            loadpagedata();
        });
        
        $(document).on("click", "#doctor_Pagination .page-link", function () {
            const page = parseInt($(this).data("page"));
            state.page = page;
            loadpagedata();
        });

        $(".doctor-table-blk #RecordsPerPage").on("change", function () {
            state.perPage = parseInt($(this).val());
            state.page = 1;
            loadpagedata();
        });

        $(document).on("click", "#doctor_table th[data-column]", function () {
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
        
        
    });

    function loadpagedata() {
        const { page, perPage, search, sortColumn, sortOrder} =  state;
        const csrf_token = $("#docor_csrf_token").val();
        const table = $("#doctor_table");
        if (!table.length) return;

        $.ajax({
            type: "POSt",
            url: "doctors/get_doctordata.php",
            data: {
                csrf_token: csrf_token,
                page: page,
                perPage: perPage,
                search: search,
                sortColumn: sortColumn,
                sortOrder: sortOrder
            },
            dataType: "json",
            success: function (res) {
                if(res.status == "error") {
                    showAlert(res.status, res.message);
                }else if(res.status == "success") {

                    const tbody = "#doctor_table tbody";
                    const infoText = "#doctor_InfoText";
                    const pagination = "#doctor_Pagination";

                    $(tbody).html(res.data.html);

                    const totalRecords = res.data.total;
                    const totalPages = Math.ceil(totalRecords / perPage);

                    let start = totalRecords === 0 ? 0 : (page - 1) * perPage + 1;
                    let end = Math.min(page * perPage, totalRecords);
                    
                    $(infoText).text(`Showing ${start} to ${end} of ${totalRecords} entries`);

                    $(pagination).html(generatePagination(page, totalPages));
                }
                
            }, 
            error: function(xhr, status, error) {
                console.log("Satus: ", status);
                console.log("Ajax Error: ", error);
                console.log("Response: ", xhr.responseText);
            }
        });

    }

})();
