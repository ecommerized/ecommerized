(function ($) {
    ("use strict");
    var portfolioCategoryDatatable

    portfolioCategoryDatatable = $("#portfolioCategoryDatatable").DataTable({
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
            url: $('#theme-portfolio-category-route').val(),
            data: function (d) {
                d.search_key = $('#search-key').val();
            },
        },
        dom: '<>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
        columns: [
            {"data": 'DT_RowIndex', "name": 'DT_RowIndex', searchable: false},
            { "data": "name" ,"name":"name" },
            { "data": "status" ,"name":"status" ,searchable: false },
            { "data": "action" ,"name":"action" ,searchable: false },
        ]
    });

    $('#search-key').on('keyup', function () {
        portfolioCategoryDatatable.ajax.reload();
    });
})(jQuery);
