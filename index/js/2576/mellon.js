// mellonConfig and mellonUrl are required

window.mellonBridgeInit = function (urn) {
    'use strict';

    var channelInstance, bridge = new MellonBridge(mellonConfig);
    var channel = bridge.getNewChannel(urn);


    channel
            .on('event', function (id) {
                $(document).trigger('mellon.' + id);
            })
            .on('close', function () {
                var modal = $('div.jqFensterModal:visible');
                if (modal.length) {
                    $.fensterFinder(modal).close().destroy();
                }
            })
            .on('redirect', function (params) {
                // see redirect in events.js
                $(document).trigger('mellon.redirect', params.url);
                //window.location.href = params.url;
            })
            .on('resize', function (w, h) {
                var windowWidth = $(window).width();

                if (w > windowWidth) {
                    w = windowWidth - 10;
                    $('div.jqFensterHolder:visible').addClass('mobile');
                }

                // keep the minimum width on 300
                w = w < 300 ? 300 : w;
                h = h < 200 ? 200 : h;

                channelInstance.resize(w, h);

                $('div.jqFensterModalContent iframe')
                        .animate({width: w, height: h + 20}, 'fast');
            });

    channelInstance = channel.createInstance();

    return channelInstance;
};


var GameworldHandler = {
    ageText: '',
    applicationCountryId: '',
    applicationInstanceId: '',
    select: function (title, applicationCountryId, applicationInstanceId) {

        this.applicationCountryId = applicationCountryId;
        this.applicationInstanceId = applicationInstanceId;

        $btnPlayNow = $('#btnPlayNow');
        $btnPlayNow.text($btnPlayNow.data('template').replace('%s', title));
        current.hide();
        current = $('#tribe-pop-up').show();

    },
    createEntry: function (gw) {

        var onclick = "GameworldHandler.select('" + gw.title + "','" + gw.applicationCountryId + "','" + gw.applicationInstanceId + "')";

        if (gw.isInMaintenance) {
            onclick = "";
        }

        var html = '<div class="world-block" onclick="' + onclick + '">';
        html += '    <div style="float:left;width:75px;">';
        html += '      <img src="img/serverIcon.png" />';
        html += '    </div>';
        html += '    <div style="float:left;width:220px">';
        html += '    	<div class="world-name">' + gw.title + '</div>';
        html += '     	  <div class="server-data">';
        html += '         	 <div class="users-online">';
        if (gw.population) {
            html += '         	    <img class="online-icon" src="img/icons/player.png" alt=""/>';
            html += '             	   <p class="online">' + gw.population + '</p>';
        }
        html += '  	       </div>';
        if (gw.serverAge) {
            html += ' 	        <div class="server-age">' + this.ageText.replace('%s', gw.serverAge) + '</div>';
        }
        html += '      	</div>';
        html += '    </div>';
        html += '    <div style="clear:both"></div>';
        html += '</div>';
        return html;


    },
    init: function (list, recommendedGameworld) {

        this.ageText = $('#gwList').data('server-age');

        var html = '';
        var recommendedGwCount = 0;
        for (var i = 0; i < list.length; ++i) {
            var gw = list[i];

            if (gw.status == 'active' && gw.recommended) {
                html += this.createEntry(gw);
                recommendedGwCount++;
            }
        }

        if (recommendedGwCount > 0) {
            $('#gwList .recommended .entries').html(html);
            $('#gwList .recommended').css('display', '');
        }

        html = '';
        for (var i = 0; i < list.length; ++i) {
            var gw = list[i];

            if (gw.status != 'active' || gw.recommended) {
                continue;
            }

            html += this.createEntry(gw);
        }

        if (html.length > 0) {
            $('#gwList .others').css('display', '');
            $('#gwList .others .entries').html(html);
        }


    }

};



$(function () {
    var bridge = new MellonBridge(mellonConfig);

    $('#tribe-pop-up').on('mellonGwSelection', function (e) {
        var url = bridge.prepareUrnForGame(mellonUrl.getAjaxGameWorldList('registration')),
                $btnPlayNow = $('#btnPlayNow').addClass('disabled')
                .on('click', function () {
                    return false;
                });


        url = url.replace('https:', 'http:');
        $.getJSON(url).success(function (data) {

            if (!data || !data.success || !$.isArray(data.list)) {
                return false;
            }

            // select the recommended gameworld
            var recommendedGameworld = null;
            var firstActiveGW = null;
            var activeGameworlds = 0;

            for (var i = 0; i < data.list.length; ++i) {
                var gw = data.list[i];

                if (gw.status != 'active') {
                    continue;
                }

                activeGameworlds++;
                firstActiveGW = gw;
                if (gw.recommended) {
                    recommendedGameworld = gw;

                }
            }

            if (!recommendedGameworld) {
                recommendedGameworld = firstActiveGW;
                recommendedGameworld.recommended = true;
            }



            GameworldHandler.applicationCountryId = recommendedGameworld.applicationCountryId;
            GameworldHandler.applicationInstanceId = recommendedGameworld.applicationInstanceId;

            if (activeGameworlds > 1) {
                $('#server-select-container').css('display', '');

                GameworldHandler.init(data.list, recommendedGameworld);
                $('#gw-select').on('click', function () {

                    $('#game-world').css('display', 'block');

                });

            }


            $btnPlayNow.text($btnPlayNow.data('template').replace('%s', recommendedGameworld.title))
                    .removeClass('disabled')
                    .on('click', function () {
                        mellonConfig.application.countryId = GameworldHandler.applicationCountryId;
                        mellonConfig.application.instanceId = GameworldHandler.applicationInstanceId;

                        var userParam = 'teuton',
                                $char = $('#char-foreground .char');

                        switch (true) {
                            case ($char.hasClass('gaul')):
                                userParam = 'gaul';
                                break;
                            case ($char.hasClass('roman')):
                                userParam = 'roman';
                                break;
                        }

                        var $link = $('<a>').addClass('jqFenster')
                                .data({
                                    mellonIframeUrl: mellonUrl.getInstantLogin(userParam),
                                    selector: '#mellonModal'
                                });

                        $('body').append($link);
                        $link.trigger('click');
                    });
        });
    });
});
