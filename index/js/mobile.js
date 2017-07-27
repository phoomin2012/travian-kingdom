$(document).ready(function () {
    // SHOW/HIDE MENU
    $('.header-btn.burger').on('click', function () {
        if($(".nav-button.language").hasClass("active")){
            $(".nav-button.language").removeClass("active");
            $('.mobile-menu').toggle();
            return;
        }
        if ($('.mobile-header').hasClass('active')) {
            setTimeout(function () {
                $('.branding-area').toggle();
            }, 500);
        }
        else {
            $('.branding-area').toggle();
        }

        $('.mobile-header').toggleClass('active');
        $('.mobile-nav-wrapper').toggleClass('swiped');
        $('.control-block').toggleClass('swiped');
        $('.overlay').toggle();

    });

    $('.overlay').on('click', function () {
        $('.header-btn.burger').click();
    });

    $('.mobile-nav-wrapper .menu-item').on("click", function () {
        $('.header-btn.burger').click();
    });




    $(window).on('resize', function(){
        if( $(window).width()<800){
            $('.window-wrapper,.content-pop-up,.main-wrapper').css("min-height", $(window).height() + "px");
        }else{
            $('.window-wrapper,.content-pop-up,.main-wrapper').css("min-height",  "0");
        }

    });

    $('ul.mobile-menu a.scrollLink').click(function(e) {
    	var link = $(this);
    	$('footer .menu-item a[data-m-index="' + link.attr('data-m-index') + '"]').click();
    });
});