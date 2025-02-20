(function ($) {
    "use strict";

    var Medi = {
        init: function () {
            this.Basic.init();
        },

        Basic: {
            init: function () {
                this.Preloader();
                this.Tools();
                this.PopupGallery();
                this.BackgroundImage();
                this.MobileMenu();
                this.TabTable();
                this.Select();
                this.MultiSelect();
                this.Editor();
                this.DateRangePicker();
                this.Message();
                this.FilUpLoad();
                this.PassShowHide();
                this.PriceToggle();
                this.AllSliders();
                this.FileUploadName();
                this.UpCount();
            },
            UpCount: function () {
                $(document).ready(function () {
                    $(".counter").countUp({
                        time: 2000,
                        delay: 10,
                    });
                });
            },
            FileUploadName: function () {
                $(document).ready(function () {
                    $(document).on(
                        "change input",
                        ".fileUploadInput",
                        function () {
                            var fileName =
                                $(this).prop("files").length > 1
                                    ? $(this)[0].files.length +
                                      " files selected"
                                    : $(this).val().split("\\").pop();
                            $(this)
                                .closest(".file-upload-one")
                                .find(".fileName")
                                .text(fileName || "Choose Image to upload");
                        }
                    );
                });
            },
            Preloader: function () {
                $("#preloader-status").fadeOut();
                $("#preloader").delay(350).fadeOut("slow");
                $("body").delay(350);
            },
            Tools: function () {
                // Calendar icon
                $("input.date-time-picker").each(function () {
                    $(this)
                        .closest(".primary-form-group-wrap")
                        .addClass("calendarIcon"); // Add your custom class here
                });

                // Checkout page payment
                $(document).ready(function () {
                    $(".checkoutPaymentItem li button").on('click', function () {
                        $(".checkoutPaymentItem li button").removeClass(
                            "active"
                        );
                        $(this).addClass("active");
                    });
                });

                // Landing page Header
                jQuery(window).on("scroll", function () {
                    if (jQuery(window).scrollTop() > 250) {
                        jQuery(".ld-header-section").addClass("sticky-on");
                    } else {
                        jQuery(".ld-header-section").removeClass("sticky-on");
                    }
                });
            },
            PopupGallery: function () {
                $(".sf-popup-gallery").each(function () {
                    $(this).magnificPopup({
                        delegate: "a",
                        type: "image",
                        showCloseBtn: false,
                        preloader: false,
                        gallery: {
                            enabled: true,
                        },
                        callbacks: {
                            elementParse: function (item) {
                                if (item.el[0].className == "video") {
                                    item.type = "iframe";
                                } else {
                                    item.type = "image";
                                }
                            },
                        },
                    });
                });
            },
            BackgroundImage: function () {
                $("[data-background]").each(function () {
                    $(this).css(
                        "background-image",
                        "url(" + $(this).attr("data-background") + ")"
                    );
                });
            },
            MobileMenu: function () {
                $(".mobileMenu").on("click", function () {
                    $(".zSidebar").addClass("menuClose");
                });
                $(".zSidebar-overlay").on("click", function () {
                    $(".zSidebar").removeClass("menuClose");
                });
                // Menu arrow
                $(".zSidebar-menu li a").each(function () {
                    if (
                        $(this).next("div").find("ul.zSidebar-submenu li")
                            .length > 0
                    ) {
                        $(this).addClass("has-subMenu-arrow");
                    }
                });
            },
            TabTable: function () {
                $(document).on(
                    "shown.bs.tab",
                    'button[data-bs-toggle="tab"]',
                    function (event) {
                        $($.fn.dataTable.tables(true))
                            .DataTable()
                            .responsive.recalc();
                        $($.fn.dataTable.tables(true)).css("width", "100%");
                        $($.fn.dataTable.tables(true))
                            .DataTable()
                            .columns.adjust()
                            .draw();
                    }
                );
            },
            EventPayMent: function () {
                $(".paymentItem").on("click", function () {
                    $(".paymentItem-input").prop("checked", false);
                    $(this).find(".paymentItem-input").prop("checked", true);
                });
            },
            Select: function () {
                // when need select with search field
                $(".sf-select").select2({
                    dropdownCssClass: "sf-select-dropdown",
                    selectionCssClass: "sf-select-section",
                });
                // when don't need search field but can't use in modal
                $(".sf-select-two").select2({
                    dropdownCssClass: "sf-select-dropdown",
                    selectionCssClass: "sf-select-section",
                    minimumResultsForSearch: -1,
                    placeholder: {
                        text: "Select an option",
                    },
                });
                // when don't need search field and can use in modal
                $(".sf-select-without-search").niceSelect();
                // when need search in modal
                $(".sf-select-modal").select2({
                    dropdownCssClass: "sf-select-dropdown",
                    selectionCssClass: "sf-select-section",
                    dropdownParent: $(".modal"),
                });
            },
            MultiSelect: function () {
                $(document).ready(function () {
                    $(".sf-select-checkbox-search").multiselect({
                        buttonClass: "form-select sf-select-checkbox-btn",
                        maxHeight: 322,
                        enableCaseInsensitiveFiltering: true,
                        templates: {
                            button: '<button type="button" class="multiselect dropdown-toggle" data-bs-toggle="dropdown"><span class="multiselect-selected-text"></span></button>',
                        },
                    });
                    $(".sf-select-checkbox").multiselect({
                        buttonClass: "form-select sf-select-checkbox-btn",
                        enableFiltering: false,
                        maxHeight: 322,
                        templates: {
                            button: '<button type="button" class="multiselect dropdown-toggle" data-bs-toggle="dropdown"><span class="multiselect-selected-text"></span></button>',
                        },
                    });
                });
            },
            Editor: function () {
                $(".summernoteOne").summernote({
                    placeholder: "Write description...",
                    tabsize: 2,
                    minHeight: 183,
                    toolbar: [
                        ["font", ["bold", "italic", "underline"]],
                        ["para", ["ul", "ol", "paragraph"]],
                    ],
                });
            },
            Z_Chart: function () {
                var options = {
                    chart: {
                        height: 350,
                        type: "area",
                        toolbar: {
                            show: false,
                        },
                    },
                    stroke: {
                        width: 2.5,
                        curve: "straight",
                    },
                    tooltip: {
                        enabled: false,
                    },
                    colors: ["#007AFF"],
                    dataLabels: {
                        enabled: false,
                    },
                    series: [
                        {
                            name: "Series 1",
                            data: [0.4, 0.55, 0.1, 0.35, 0.2, 0.9, 0.2],
                        },
                    ],
                    fill: {
                        type: "gradient",
                        gradient: {
                            gradientToColors: ["#007AFF"],
                            shadeIntensity: 1,
                            type: "vertical",
                            opacityFrom: 1,
                            opacityTo: 0.5,
                            stops: [0, 100],
                        },
                    },
                    xaxis: {
                        categories: [
                            " ",
                            "2019",
                            "2020",
                            "2021",
                            "2022",
                            "2023",
                            " ",
                        ],
                        tickPlacement: "on",
                        min: undefined,
                        max: undefined,
                        axisTicks: {
                            show: true,
                            borderType: "solid",
                            color: "#F0F0F0",
                            height: 13,
                        },
                        labels: {
                            style: {
                                cssClass: "revenueOverviewChart-xaxis-label",
                            },
                        },
                    },
                    yaxis: {
                        tickAmount: 5,
                        decimalsInFloat: 1,
                        min: 0,
                        max: 1.0,
                        labels: {
                            style: {
                                cssClass: "revenueOverviewChart-yaxis-label",
                            },
                        },
                    },
                };

                var z_revenueOverviewChart = new ApexCharts(
                    document.querySelector("#revenueOverviewChart"),
                    options
                );
                z_revenueOverviewChart.render();
            },
            DateRangePicker: function () {
                $(".date-time-picker").daterangepicker({
                    singleDatePicker: true,
                    autoApply: true,
                    autoUpdateInput: false,
                    locale: {
                        format: "D-M-Y",
                    },
                });
                $(".date-time-picker").on(
                    "apply.daterangepicker",
                    function (ev, picker) {
                        $(this).val(picker.startDate.format("DD/MM/YYYY"));
                    }
                );
            },
            Message: function () {
                // For Message
                const userChats = document.querySelectorAll(".user-chat");
                const chatMessages = document.querySelectorAll(
                    ".content-chat-message-user"
                );

                userChats.forEach((userChat) => {
                    userChat.addEventListener("click", () => {
                        const selectedUsername =
                            userChat.getAttribute("data-username");

                        chatMessages.forEach((chatMessage) => {
                            const messageUsername =
                                chatMessage.getAttribute("data-username");

                            if (messageUsername === selectedUsername) {
                                chatMessage.classList.add("active");
                            } else {
                                chatMessage.classList.remove("active");
                            }
                        });

                        userChats.forEach((chat) => {
                            chat.classList.remove("active");
                        });
                        userChat.classList.add("active");
                    });

                    // Activate the first user-chat element initially
                    userChats[0].classList.add("active");
                    chatMessages[0].classList.add("active");
                });
            },
            FilUpLoad: function () {
                // File attachment
                const dt = new DataTransfer();

                $("#mAttachment,#mAttachment1").on("change", function (e) {
                    for (var i = 0; i < this.files.length; i++) {
                        let fileBloc = $("<span/>", { class: "file-block" }),
                            fileName = $("<p/>", {
                                class: "name",
                                text: this.files.item(i).name,
                            });
                        fileBloc
                            .append(
                                '<span class="file-icon"><i class="fa-solid fa-file"></i></span>'
                            )
                            .append(fileName)
                            .append(
                                '<span class="file-delete"><i class="fa-solid fa-xmark"></i></span>'
                            );
                        $("#filesList > #files-names").append(fileBloc);
                    }

                    for (let file of this.files) {
                        dt.items.add(file);
                    }

                    this.files = dt.files;

                    $("span.file-delete").on('click', function () {
                        let name = $(this).next("span.name").text();

                        $(this).parent().remove();
                        for (let i = 0; i < dt.items.length; i++) {
                            if (name === dt.items[i].getAsFile().name) {
                                dt.items.remove(i);
                                continue;
                            }
                        }
                    });
                });
            },
            PassShowHide: function () {
                $(".toggle-password").on('click', function () {
                    $(this).toggleClass("fa-eye fa-eye-slash");
                    var input = $($(this).attr("toggle"));
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                });
            },
            PriceToggle: function () {
                $(document).ready(function () {
                    $("#billingMonthly-tab").on('click', function () {
                        $(".zPrice-plan-monthly")
                            .removeClass("d-none")
                            .addClass("d-block");
                        $(".zPrice-plan-annually")
                            .removeClass("d-block")
                            .addClass("d-none");
                    });

                    $("#billingAnnually-tab").on('click', function () {
                        $(".zPrice-plan-monthly")
                            .removeClass("d-block")
                            .addClass("d-none");
                        $(".zPrice-plan-annually")
                            .removeClass("d-none")
                            .addClass("d-block");
                    });
                });
            },
            AllSliders: function () {
                var swiperPricingSliderOne = new Swiper(".pricingSliderOne", {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    breakpoints: {
                        992: {
                            slidesPerView: 3,
                            spaceBetween: 20,
                        },
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 20,
                        },
                    },
                });
                var swiperTestimonialSliderOne = new Swiper(
                    ".testimonialSliderOne",
                    {
                        slidesPerView: 1,
                        spaceBetween: 32,
                        loop: true,
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        breakpoints: {
                            992: {
                                slidesPerView: 2,
                                spaceBetween: 32,
                            },
                        },
                    }
                );
                var swiperTestimonialSliderTwo = new Swiper(
                    ".testimonialSliderTwo",
                    {
                        slidesPerView: 1,
                        spaceBetween: 24,
                        loop: false,
                        autoplay: true,
                        pagination: {
                            el: ".swiper-pagination",
                        },
                        breakpoints: {
                            1024: {
                                slidesPerView: 3,
                                spaceBetween: 24,
                            },
                            576: {
                                slidesPerView: 2,
                                spaceBetween: 24,
                            },
                        },
                    }
                );
                var swiperTestimonialSliderThree = new Swiper(
                    ".testimonialSliderThree",
                    {
                        slidesPerView: 1,
                        spaceBetween: 24,
                        loop: false,
                        autoplay: true,
                        pagination: {
                            el: ".swiper-pagination",
                        },
                        breakpoints: {
                            1024: {
                                slidesPerView: 2,
                                spaceBetween: 24,
                            },
                            768: {
                                slidesPerView: 1.5,
                                spaceBetween: 24,
                            },
                        },
                    }
                );
                var swiperOurApproachSliderOne = new Swiper(
                    ".ourApproachSliderOne",
                    {
                        slidesPerView: 1,
                        spaceBetween: 24,
                        loop: false,
                        autoplay: true,
                        breakpoints: {
                            1024: {
                                slidesPerView: 2.5,
                                spaceBetween: 40,
                            },
                            768: {
                                slidesPerView: 1.5,
                                spaceBetween: 24,
                            },
                        },
                    }
                );
                var swiperHroBannerSliderOne = new Swiper(
                    ".swiperHroBannerSliderOne",
                    {
                        slidesPerView: 1,
                        spaceBetween: 24,
                        loop: false,
                        autoplay: true,
                        breakpoints: {
                            1024: {
                                slidesPerView: 2,
                                spaceBetween: 40,
                            },
                            768: {
                                slidesPerView: 1.5,
                                spaceBetween: 24,
                            },
                        },
                    }
                );
                var swiperOurJourneySliderOne = new Swiper(
                    ".ourJourneySliderOne",
                    {
                        slidesPerView: 1.5,
                        spaceBetween: 24,
                        loop: true,
                        autoplay: true,
                        centeredSlides: true,
                        breakpoints: {
                            1024: {
                                slidesPerView: 2.5,
                                spaceBetween: 24,
                            },
                            768: {
                                slidesPerView: 1.5,
                                spaceBetween: 24,
                            },
                        },
                    }
                );
                var swiperAutoSlide = new Swiper(".autoImageslider", {
                    slidesPerView: 2,
                    spaceBetween: 24,
                    mousewheel: false,
                    grabCursor: false,
                    loop: true,
                    speed: 3000,
                    autoplay: {
                        delay: 0,
                    },
                    freeMode: true,
                    breakpoints: {
                        1024: {
                            slidesPerView: 6,
                            spaceBetween: 160,
                        },
                        576: {
                            slidesPerView: 3,
                            spaceBetween: 24,
                        },
                    },
                });
                var swiperAutoSlide2 = new Swiper(".autoImageslider2", {
                    slidesPerView: 1.5,
                    spaceBetween: 24,
                    mousewheel: false,
                    grabCursor: false,
                    loop: true,
                    speed: 8000,
                    autoplay: {
                        delay: 0,
                    },
                    freeMode: true,
                    breakpoints: {
                        1024: {
                            slidesPerView: 3,
                            spaceBetween: 24,
                        },
                        576: {
                            slidesPerView: 2,
                            spaceBetween: 24,
                        },
                    },
                });
                var swiperAutoSlide = new Swiper(".autoImagesliderReverse", {
                    slidesPerView: 1.5,
                    spaceBetween: 24,
                    mousewheel: false,
                    grabCursor: false,
                    loop: true,
                    speed: 8000,
                    autoplay: {
                        delay: 0,
                        reverseDirection: true,
                    },
                    freeMode: true,
                    breakpoints: {
                        1024: {
                            slidesPerView: 3,
                            spaceBetween: 24,
                        },
                        576: {
                            slidesPerView: 2,
                            spaceBetween: 24,
                        },
                    },
                });
            },
        },
    };
    jQuery(document).ready(function () {
        Medi.init();
    });
})(jQuery);
