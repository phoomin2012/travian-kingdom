var current;
$(document).ready(function () {
    var tribeSelection = false;
    var newUser = true;
    var curScroll = 0, scrollPOS = 0;

    var showContent = function () {
        content.css("visibility", "visible");

        $("body").scrollTop(scrollPOS);
        $("html,body").scrollTop(scrollPOS);

        overlay.hide();
        if (typeof current != "undefined") {
            if (current != null) {
                current.hide();
                current = null;
            }
        }
    };

    var hideContent = function () {
        scrollPOS = $("html,body").scrollTop() || $("body").scrollTop();
        overlay.show();
    };

    var content = $('#content-wrapper');
    var overlay = $('#pop-up-window-wrap');

    $(".mobile-header .btn-gradient.news").on('click', function () {
        hideContent();
        current = $('#news').show();
    })

    $('.close-btn').on('click', function () {
        if (!tribeSelection) {
            showContent();
            tribeSelection = false;
        } else {
            if (current.attr("id") == "game-world") {
                current.hide();
                current = $('#tribe-pop-up').show();
            } else {
                showContent();
                tribeSelection = false;
            }
        }
    });

    $('#login-pop-up').on('click', function (e) {
        if ($(window).width() > 768) {
            e.preventDefault();
            overlay.show();
            current = $('#login').show();
        }
    });

    $('#imprint-pop-up').on('click', function () {
        hideContent();
        current = $('#imprint').show();
    });

    $('#to-imprint').on('click', function (e) {
        e.preventDefault();
        hideContent();
        current = $('#imprint').show();
    });
    $('#to-rules').on('click', function (e) {
        e.preventDefault();
        hideContent();
        current = $('#rules').show();
    });

    /*
     $('#to-news').on('click', function (e) {
     e.preventDefault();
     hideContent();
     current = $('#news').show();
     });
     $('.news-entry .news-title , .news-entry .news-icon').on('click', function () {
     current.hide();
     current = $('#news-detail').show();
     });
     $('#news-detail .pop-up-window-header').on('click', function () {
     current.hide();
     current = $('#news').show();
     });*/

    $('footer .play-now').on('click', function (e) {
        e.preventDefault();
        hideContent();
        if (!newUser) {
            current = $('#game-world').show();
        } else {
            current = $('#register-key').show();
            $('#register-key').find("input[type=text], textarea").val('');
        }
    });

    $('#homeBtnPlayNow').on('click', function (e) {
        e.preventDefault();
        if ($(window).width() < 800) {
            $('#loginButton').click();
            return;
        }

        hideContent();
        current = $('#tribe-pop-up').show(0, function () {
            $(this).trigger('mellonGwSelection');
        });
        tribeSelection = true;
    });

    $('.world-block').on('click', function () {
        current.hide();
        if (!tribeSelection) {
            current = $('#register-key').show();
            $('#register-key').find("input[type=text], textarea").val('');
        } else {
            current = $('#tribe-pop-up').show();
        }
    });

    $(".linkRegister").on('click', function (e) {
        e.preventDefault();
        current.hide();
        current = $('#register').show();
    });

    $(".linkForgotPW").on('click', function (e) {
        e.preventDefault();
        current.hide();
        current = $('#forgot-pwd').show();
    });

    $('.show-login').on('click', function (e) {
        e.preventDefault();
        showContent();
        overlay.show();
        current = $('#login').show();
    });

    $('.news .message').on('click', function (e) {
        e.preventDefault();
        overlay.show();
        current = $('#news-detail').show();
    });

    $('#server-select,#gw-select').on('click', function (e) {
        e.preventDefault();
        current.hide();
        current = $('#game-world').show();
    });

    $('#homeBtnMobileApp,#companionAppLink').on('click', function (e) {
        e.preventDefault();
        hideContent();
        current = $('#companion-app').show();
    });

    $('#to-select').on('click', function (e) {
        e.preventDefault();
        current.hide();
        current = $('#game-world').show();
    });
    overlay.on("click", function (e) {
        if (e.target.id == "pop-up-window-wrap") {
            showContent()
        }
    });

    if (window.location.hash == "#to-rules") {
        $("#to-rules").click();
    }

    if (window.location.hash == '#to-imprint') {
        hideContent();
        current = $('#imprint').show();
    }

});