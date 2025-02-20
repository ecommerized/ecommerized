(function ($) {
    ("use strict");
    var portfolioDatatable

    portfolioDatatable = $("#portfolioDatatable").DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: false,
        processing: true,
        responsive: true,
        searching: false,
        language: {
            paginate: {
                previous: "<i class='fa-solid fa-angles-left'></i>",
                next: "<i class='fa-solid fa-angles-right'></i>",
            },
            searchPlaceholder: "Search here...",
            search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
        },
        ajax: {
            url: $('#portfolio-route').val(),
            data: function (d) {
                d.search_key = $('#search-key').val();
            },
        },
        dom: '<>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
        columns: [
            {"data": 'banner_image', "name": 'banner_image', searchable: false},
            { "data": "title" ,"name":"title" },
            { "data": "portfolioCategory" ,"name":"portfolioCategory" },
            { "data": "tag" ,"name":"tag" },
            { "data": "status" ,"name":"status" ,searchable: false },
            { "data": "action" ,"name":"action" ,searchable: false },
        ]
    });

    $('#search-key').on('keyup', function () {
        portfolioDatatable.ajax.reload();
    });

    $(".sf-select-modal-label").select2({
        tags: true,
        dropdownCssClass: "sf-select-dropdown",
        selectionCssClass: "sf-select-section",
        dropdownParent: $("#add-modal"),
    });


    window.editResponse = function (response) {
        $(document).find('#portfolio-edit-modal').find('.sf-select-modal-label').select2({
            tags: true,
            dropdownCssClass: "sf-select-dropdown",
            selectionCssClass: "sf-select-section",
            dropdownParent: $("#portfolio-edit-modal"),
        });
    }

    window.openEditModal = function (url) {
        getEditModal(url, '#portfolio-edit-modal', 'editResponse');
    }

})(jQuery);
