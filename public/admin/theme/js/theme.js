(function ($) {
    ("use strict");
    $(document).on('change', '#app_theme_style', function () {
        const selectedTheme = $(this).val();
        $('.theme-img').addClass('d-none');
        $('#theme-' + selectedTheme).removeClass('d-none');
    });
})(jQuery);
