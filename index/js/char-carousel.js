$(document).ready(function () {
    var leftBtn = $('#char-carousel').find('.left-arrow-wrapper');
    var rightBtn = $('#char-carousel').find('.right-arrow-wrapper');

    var gauls = $('.info-text .gauls');
    var romans = $('.info-text .romans');
    var teutons = $('.info-text .teutons');

    var showDescription = function(){
        if($('#char-foreground .char').hasClass("gaul")){
            $('.info-text .info-wrap').hide();
            $('.info-text .info-more').hide();
            gauls.first().show();
        } else if($('#char-foreground .char').hasClass("roman")){
            $('.info-text .info-wrap').hide();
            $('.info-text .info-more').hide();
            romans.first().show()
        } else {
            $('.info-text .info-wrap').hide();
            $('.info-text .info-more').hide();
            teutons.first().show();
        }
    };
    showDescription();

    $('#arrows').on('click', function () {
        $('.info-text').toggleClass("active");

        if($('#char-foreground .char').hasClass("gaul")){
            if($('.info-text').hasClass("active")){
                gauls.first().hide();
                gauls.last().show();
            } else {
                gauls.first().show();
                gauls.last().hide();
            }
        } else if($('#char-foreground .char').hasClass("roman")){
            if($('.info-text').hasClass("active")){
                romans.first().hide();
                romans.last().show();
            } else {
                romans.first().show();
                romans.last().hide();
            }
        } else {
            if($('.info-text').hasClass("active")){
                teutons.first().hide();
                teutons.last().show();
            } else {
                teutons.first().show();
                teutons.last().hide();
            }
        }
    });

    rightBtn.on('click', function(){
        var foreChar = $('#char-foreground .char').remove();
        var backChar = $('#char-background .char').last().remove();

        if($('.info-text').hasClass("active")){
            $('.info-text').toggleClass("active")
        }

        $('#char-background').prepend(foreChar);
        $('#char-foreground').append(backChar);
        showDescription();
    });

    leftBtn.on('click', function(){
        var foreChar = $('#char-foreground .char').remove();
        var backChar = $('#char-background .char').first().remove();

        if($('.info-text').hasClass("active")){
            $('.info-text').toggleClass("active")
        }

        $('#char-background').append(foreChar);
        $('#char-foreground').append(backChar);
        showDescription();
    });
});