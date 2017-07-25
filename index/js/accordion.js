$(document).ready(function () {
    $(".language-box").on("click", function (e) {
        e.stopImmediatePropagation();
        e.stopPropagation();
    });
    $(".language-box .accordion .accordion-header").on("click", function () {
        if($(this).parent().hasClass('active')) return;
        $(".language-box .accordion.active").removeClass('active').find(".accordion-content").slideUp()

        $(this).parent().children(".accordion-content").slideToggle();
        $(this).parent().toggleClass("active");
    });

    $(".nav-button.language").on("click", function (e) {
        $(this).toggleClass("active");
        $('.mobile-menu').toggle();
    });
    $(".language-box .accordion .country").on('click', function (e) {
        e.stopPropagation();
        $(".language-box .accordion .country").removeClass("active");
        $(this).addClass("active");
        $(".nav-button.language").toggleClass("active");
        $('.mobile-menu').toggle();
    });

    function closeBlocks() {
        $('.column .arrow-wrap').removeClass('active');
        $('.column .column-description').slideUp();
    }

    function showBlock(el) {
        $(el).parent().find('.column-description').slideDown();
        $(el).parent().find('.arrow-wrap').addClass('active');
    }


    $('#travian-classic .clicker').on('click', function () {
        if ($(window).width() <= 400) {
            if ($(this).find('.arrow-wrap').hasClass('active')) {
                closeBlocks();
                return;
            }
            closeBlocks();
            showBlock(this);
        }
    });
});