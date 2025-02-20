(function ($) {
    "use strict";

    var packageDatatable;

    packageDatatable =  $("#packageDatatable").DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: true,
        processing: true,
        searching: true,
        responsive: true,
        language: {
            paginate: {
                previous: "<i class='fa-solid fa-angles-left'></i>",
                next: "<i class='fa-solid fa-angles-right'></i>",
            }
        },
        ajax: {
            url: $('#service-route').val(),
            data: function (d) {
                d.search_key = $('#search-key').val();
            }
        },
        dom: '<>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
        columns: [
            {"data": "icon", "name": "icon", searchable: false, responsivePriority: 1},
            {"data": "name", "name": "name"},
            {"data": "monthly_price", "name": "monthly_price"},
            {"data": "yearly_price", "name": "yearly_price"},
            {"data": "status", "name": "status", searchable: false},
            {"data": "action", searchable: false, responsivePriority: 2},
        ]
    });
    $('#search-key').on('keyup', function () {
        packageDatatable.ajax.reload();
    });


    updateAllServiceOptions();

    // Add Service Row
    $(document).on('click', '#addMorePackageBtn', function () {
        let tr = $('#clone-custom-service').find('tr').clone();
        tr.find('input[type="number"]').val(''); // Reset quantity input
        tr.find('select[name="service_id[]"]').val(''); // Reset service selection
        tr.find('select[name="quantity_type[]"]').val('1'); // Default to "Limited"
        tr.find('input[name="quantity[]"]').prop('readonly', false).val(''); // Reset quantity field
        $('#packageItems').append(tr); // Append the new service row
        updateAllServiceOptions(); // Update dropdown options dynamically
    });

    // Remove Service Row
    $(document).on('click', '.removePackage', function () {
        $(this).closest('tr').remove(); // Remove the service row
        updateAllServiceOptions(); // Update dropdown options dynamically
    });

    // Handle Service Selection Change
    $(document).on('change', 'select[name="service_id[]"]', function () {
        updateAllServiceOptions(); // Update dropdown options dynamically
    });

    // Handle Quantity Type Change
    $(document).on('change', '.customer_limit_type', function () {
        const $input = $(this).closest('.input-group').find('input[name="quantity[]"]');
        if ($(this).val() === '1') { // Limited
            $input.prop('readonly', false).val(''); // Enable input
        } else { // Unlimited
            $input.prop('readonly', true).val(-1); // Disable input and set to -1
        }
    });

    // Add Feature Row
    $(document).on('click', '#addMoreFeatureBtn', function () {
        let tr = $('#clone-custom-features').find('tr').clone();
        tr.find('input[type="text"]').val(''); // Clear text input for feature name
        tr.find('select[name="other_value[]"]').val('1'); // Default to "Yes"
        $('#featureItems').append(tr); // Append the new feature row
    });

    // Remove Feature Row
    $(document).on('click', '.removeFeature', function () {
        $(this).closest('tr').remove(); // Remove the feature row
    });

    // Update All Service Options
    function updateAllServiceOptions() {
        const selectedServices = getSelectedServices(); // Get all selected services

        $('#inputTable').find('select[name="service_id[]"]').each(function () {
            const currentValue = $(this).val(); // Get the current value of this dropdown
            $(this).find('option').each(function () {
                const optionValue = $(this).val();
                // Show the option if it's not selected or if it's the current value
                if (selectedServices.includes(optionValue) && optionValue !== currentValue) {
                    $(this).hide(); // Hide already selected options
                } else {
                    $(this).show(); // Show available options
                }
            });
        });
    }

    // Get All Selected Services
    function getSelectedServices() {
        const selectedServices = [];
        $('#inputTable').find('select[name="service_id[]"]').each(function () {
            const value = $(this).val();
            if (value) {
                selectedServices.push(value); // Add selected service ID to the array
            }
        });
        return selectedServices;
    }

})(jQuery);
