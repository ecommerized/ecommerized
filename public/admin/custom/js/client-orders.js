(function ($) {
    "use strict";

    $(document).ready(function () {
        dataTable('all');
    });

    $(document).on('click', '.orderStatusTab', function (e) {
        var status = $(this).data('status');
        dataTable(status);
    });

    function dataTable(status) {
        $("#orderTable-" + status).DataTable({
            pageLength: 10,
            ordering: false,
            serverSide: false,
            processing: true,
            responsive: true,
            searching: false,
            ajax: {
                url: $('#client-order-list-route').val(),
                data: function (data) {
                    data.status = status;
                }
            },
            language: {
                paginate: {
                    previous: "<i class='fa-solid fa-angles-left'></i>",
                    next: "<i class='fa-solid fa-angles-right'></i>",
                },
                searchPlaceholder: "Search event",
                search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
            },
            dom: '<>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
            columns: [
                {data: 'client_name', name: 'client_name'},
                {data: 'plan_name', name: 'plan_name'},
                {data: 'order_id', name: 'order_id', responsivePriority:1},
                {data: "total_price", name: "total_price"},
                {data: "working_status", name: "working_status"},
                {data: "payment_status", name: "payment_status"},
                {data: "end_date", name: "end_date"},
                {data: "progress", name: "progress", responsivePriority:2},
                {data: "action", name: "action"}
            ],
            stateSave: true,
            "bDestroy": true
        });
    }

    $(document).on('click', '.assign-member', function (e) {
        var checkedStatus = 0;
        if ($(this).prop('checked') == true) {
            checkedStatus = 1;
        }
        commonAjax('GET', $('#assignMemberRoute').val(), assigneeResponse, assigneeResponse, {
            'member_id': $(this).val(),
            'checked_status': checkedStatus,
            'order_id': $(this).data('order'),
        });
    });

    function assigneeResponse(response) {
        if (response['status'] === true) {
            toastr.success(response['message']);
            location.reload();
        } else {
            commonHandler(response)
        }
    }

    $(document).on('click', '#noteAddModal', function (e) {
        $("#orderIdField").val($(this).data("order_id"));
    });
    $(document).on('click', '#noteEditModal', function (e) {
        $("#orderIdField").val($(this).data("order_id"));
        $("#noteDetails").val($(this).data("details"));
        $("#noteIdField").val($(this).data("id"));
    });

})(jQuery);
