var sliderInstance;

var screenshotsSlider, artworksSlider;

var popUp = {
    coords: [4.7, 14.7, 34.5, 54.6, 74.5, 94.4],
    tabClicked: function (tabObj, activate) {
        var $parent = $("#media .content-pop-up");
        var tabs = $parent.find('.tabs').find(".tab");
        var tabName = $(tabObj).data('tab-name');
        tabs.removeClass('active');
        $(tabObj).addClass('active');
        $parent.find('.media-content').hide();
        var contentTab = $parent.find('[data-tab-content=' + tabName + ']').show();

        if (tabName == 'screenshots' && activate) {
            artworksSlider.pauseAnimation();
            screenshotsSlider.resumeAnimation();
        }
        if (tabName == 'artworks' && activate) {
            artworksSlider.resumeAnimation();
            screenshotsSlider.pauseAnimation();
        }

    },
    tabs: function () {
        var $parent = $("#media .content-pop-up");
        var tabs = $parent.find('.tabs').find(".tab");

        screenshotsSlider = new sliderConstructor({sliderId: 'screenshots', el: $('.media-content[data-tab-content="screenshots"]'), startOnPage: "#media"});
        artworksSlider = new sliderConstructor({sliderId: 'artworks', el: $('.media-content[data-tab-content="artworks"]'), startOnPage: "#media"});

        tabs.off("click").on('click', function () {
            popUp.tabClicked($(this), true);

        });
        if (!tabs.hasClass("active")) {
            popUp.tabClicked(tabs.eq(0), false);
        }
    }
};

function onNavigate(page) {
    $(".characters .character").removeClass("visible");
    $(".characters .character." + page.slice(1)).addClass("visible");
    $(document).trigger("pageScrolled", [page])
}

function onScrollEvent(e) {
    if ($(window).width() < 500) {
        return;
    }
    if (window.current)
        return;

    var delta = e.detail || e.deltaY || -e.wheelDelta;
    var index = 0;
    if (Math.abs(delta) > 0) {
        e.preventDefault();
        var current = $('footer .menu-item a.active').length ? $('footer .menu-item a.active') : $('footer .menu-item a').eq(0);
        index = +current.data("m-index");
    }
    if (delta > 0 && canscroll) {
        $('footer .menu-item a[data-m-index="' + (index + 1) + '"]').click()
    }
    if (delta < 0 && canscroll) {
        $('footer .menu-item a[data-m-index="' + (index - 1) + '"]').click()
    }
}
var scrollValue = 0;
$(document).ready(function (e) {

    //$(".fancybox").fancybox({padding:0, nextEffect: 'fade', prevEffect: 'fade'});	

    $('.aboutLink, .communityLink').hover(function () {
        $(this).find('img').css('display', 'none');
        $(this).find('img.hover').css('display', '');
    }, function () {
        $(this).find('img').css('display', 'none');
        $(this).find('img.normal').css('display', '');
    });

    var touchY = null;





    $("body").on("tap", function (e) {
        e.preventDefault();
    });

    $("body").on("touchstart", function (e) {
        touchY = e.originalEvent.changedTouches[0].pageY
    });
    $("body").on("touchmove", function (e) {
        e.preventDefault();
    });
    $("body").on("touchend", function (e) {

        if (e.originalEvent.changedTouches && e.originalEvent.changedTouches[0]) {

            var delta = touchY - e.originalEvent.changedTouches[0].pageY;
            //$('#game-tour .pop-up-header').html(delta);
            if (Math.abs(delta) > 40) {
                var current = $('footer .menu-item a.active').length ? $('footer .menu-item a.active') : $('footer .menu-item a').eq(0);
                var index = +current.data("m-index");
                if (delta > 0 && canscroll) {
                    $('footer .menu-item a[data-m-index="' + (index + 1) + '"]').click()
                }
                if (delta < 0 && canscroll) {
                    $('footer .menu-item a[data-m-index="' + (index - 1) + '"]').click()
                }

                // touchY = e.originalEvent.changedTouches[0].screenY;
            }
        }

    });

    if ($(window).width() < 800)
        $('.window-wrapper,.content-pop-up,.main-wrapper').css("min-height", $(window).height() + "px");

    popUp.tabs();

    /*    var texts = $("#game-tour .text-block .description-wrap");
     new sliderConstructor({
     sliderId:'tour',
     el: $('#slider-tour-wrap'),
     lightsOff: false,
     coords: popUp.coords, // todo COORDS!!!!!
     onHideCB: function (num, speed) {
     texts.eq(num).fadeOut(speed);
     },
     onShowCb: function (num, speed) {
     texts.eq(num).fadeIn(speed);
     },
     startOnPage: "#game-tour"
     });
     */

    $(".discover-button").on("click", function () {
        $("footer .menu-item.home").next().find("a").click();
    });


    canscroll = true;

    $('footer .menu-item').find("a").on('click', function (e) {
        if (!canscroll)
            return;
        canscroll = false;
        disable_scroll()
        var link = $(this)
        $('.menu-item a').removeClass("active");
        link.toggleClass("active");
        var id = link.attr('href');
        $('html,body').animate({
            scrollTop: $(id).offset().top
        }, 500, function () {
            scrollValue = $(window).scrollTop();

            canscroll = true;
            enable_scroll()
            onNavigate(id);
        });
        e.preventDefault();
    });

    $('#btn-text').on('click', function () {
        $('#reg-key-submit').click();
    });
    $(".news").on("click", ".close", function () {
        $(this).parents(".news").fadeOut(function () {
            $(this).remove();
        });
    });

    //navigateDownButton
    $('.navigateDownButton').on('click', function () {
        var current = $('footer .menu-item a.active').length ? $('footer .menu-item a.active') : $('footer .menu-item a').eq(0);
        var index = +current.data("m-index");
        $('footer .menu-item a[data-m-index="' + (index + 1) + '"]').click()
    });

    //resizeSlatesFontSize();

    var scrollTop = $(window).scrollTop();
    if ($(window).width() > 1024) {

        var windowWrappers = $('.window-wrapper');
        for (var i = 0; i < windowWrappers.length; ++i) {

            var ww = $(windowWrappers[i]);
            var pos = ww.position();
            if (scrollTop >= pos.top - 50 && scrollTop <= pos.top + 50) {
                $('footer .menu-item a').removeClass('active');
                $('footer .menu-item a[data-m-index="' + i + '"]').addClass('active');
                break;
            }

        }
    }


});

/*
 function resizeSlatesFontSize() {
 var foSize = 20;
 if ($(window).width() > 768) {
 $(".slate.large .description").each(function (i) {
 while ($(this).height() > 126) {
 
 foSize--;
 $(this).parent().css("font-size", foSize + "px");
 }
 })
 foSize = 20;
 $(".slate.small .description").each(function (i) {
 while ($(this).height() > 60) {
 
 foSize--;
 $(this).parent().css("font-size", foSize + "px");
 }
 })
 }
 }
 */


function selectCountry(newCountry)
{
    var newLocation = 'http://' + window.location.host + '/' + newCountry;
    $.cookie('_tery', newCountry, {domain: document.domain});
    top.location.href = newLocation;


}

function preventDefault(e) {
    e = e || window.event;
    if (e.preventDefault)
        e.preventDefault();
    e.returnValue = false;
}

function wheel(e) {
    if (!current)
        preventDefault(e)
}
function disable_scroll() {

    if ($(window).width() < 500) {
        return;
    }

    if (window.addEventListener) {
        window.addEventListener('DOMMouseScroll', wheel, false);
    }
    window.onmousewheel = document.onmousewheel = wheel;

}

function enable_scroll() {

    if ($(window).width() < 500) {
        return;
    }

    if (window.removeEventListener) {
        window.removeEventListener('DOMMouseScroll', wheel, false);
    }
    window.onmousewheel = document.onmousewheel = null;
    window.onmousewheel = onScrollEvent
}
if (window.addEventListener) {
    window.addEventListener('DOMMouseScroll', onScrollEvent, false);
}
window.onmousewheel = onScrollEvent