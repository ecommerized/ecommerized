(function($){
    "use strict";

    // get client order
    $(document).ready(function () {
        $('.clientSelectOption').on('change', function () {
            commonAjax('GET', $('#client-order-route').val(), orderResponse, orderResponse, { id: $(this).val() });
        });
    });

    $(".orderPayableAmountContainer").hide();
    $(".payableAmount").hide();

    function orderResponse(response) {
        $(".selectOrderList").html(response.responseText);

        if (response.responseText.length !== 0) {
            $(".orderPayableAmountContainer").show();
        }else{
            $(".orderPayableAmountContainer").hide();
            $(".payableAmount").hide();
            $(".invoiceCreateForm").show();
        }
    }

    $(document).ready(function () {
        $('.selectOrderList').on('change', function () {
            if ($(this).find(':selected').val() != '') {
                $(".payableAmount").show();
                $(".invoiceCreateForm").hide();
            }else{
                $(".payableAmount").hide();
                 $(".invoiceCreateForm").show();
            }
        });
    });

    function invoiceResponse(response) {
        if (response['status'] === true) {
            toastr.success(response['message']);
            window.location = $('#client-invoice-list-route').val()
        } else {
            commonHandler(response)
        }
    }
    window.invoiceResponse=invoiceResponse;

    // Invoice List Datatable
    $(document).ready(function () {
        dataTable('all');
    });

    $(document).on('click', '.invoiceStatusTab', function (e) {
        var status = $(this).data('status');
        dataTable(status);
    });

    var allInvoiceTable
    $(document).on('input', '#datatableSearch', function () {
        allInvoiceTable.search($(this).val()).draw();
    });

    function dataTable(status) {

        allInvoiceTable = $("#invoiceTable-" + status).DataTable({
            pageLength: 10,
            ordering: false,
            serverSide: false,
            processing: true,
            responsive: true,
            searching: true,
            language: {
                paginate: {
                    previous: "<i class='fa-solid fa-angles-left'></i>",
                    next: "<i class='fa-solid fa-angles-right'></i>",
                },
                searchPlaceholder: "Search event",
                search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
            },
            ajax: {
                url: $('#client-invoice-list-route').val(),
                data: function (data) {
                    data.status = status;
                }
            },
            dom: '<>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
            columns: [
                { data: 'DT_RowIndex', "name": 'DT_RowIndex', searchable: true },
                { data: 'client_name', name: 'client_name', searchable: true, },
                { data: 'plan_name', name: 'plan_name', searchable: true, },
                { data: 'invoice_id', name: 'invoice_id'},
                { data: "total_price", name: "total_price" },
                { data: "status", name: "status" },
                { data: "action", name: "action" }
            ],
            stateSave: true,
            "bDestroy": true
        });
    }

    function updateCurrencyOptions() {
        var gatewayId = $('#change-status-gateway').val();
        var payAmount = parseFloat($('#pay-amount').val()) || 0;

        if (gatewayId) {
            // Find the selected gateway
            var selectedGateway = gateways.find(gateway => gateway.id == gatewayId);

            if (selectedGateway) {
                var currencySelect = $('#change-status-gateway-currency');
                currencySelect.empty(); // Clear existing options

                // Populate the currency dropdown
                selectedGateway.currencies.forEach(function (currency) {
                    // Calculate the converted value based on conversion rate
                    var convertedValue = (payAmount * currency.conversion_rate).toFixed(2);
                    currencySelect.append(
                        `<option value="${currency.currency}">${convertedValue} ${currency.currency}</option>`
                    );
                });
            }
        }
    }

    $(document).on('change', '#change-status-gateway', function () {
        updateCurrencyOptions(); // Update the currencies when the gateway changes
    });

    $(document).on('change', '#payment_status', function () {
        if($(this).val() == 1){
            $(document).find('#change-status-gateway-block').removeClass('d-none');
            $(document).find('#change-status-gateway-currency-block').removeClass('d-none');
        }else{
            $(document).find('#change-status-gateway-block').addClass('d-none');
            $(document).find('#change-status-gateway-currency-block').addClass('d-none');
        }
    });

})(jQuery);
