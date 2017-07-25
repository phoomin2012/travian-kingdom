(function($){
    var EV_REGISTRATION = 'registration',
        EV_LOGIN = 'login';

    var event,
        unload = document.documentElement.style.hasOwnProperty('WebkitAppearance') ? 'beforeunload' : 'unload';

    var forwardAfterDomModified = function (target) {
        var domchanged = false, attempt = 20;

        triggerEvent ();

        // waiting for extra js injecting
        $('head').bind("DOMSubtreeModified propertychange", function(){
            return (domchanged = true);
        });

        (function() {
            if (! domchanged) {
                if (--attempt === 0) {
                    return window.location = target;
                }
            }

            domchanged = false;
            return setTimeout(arguments.callee, 50);
        })();
    };

    var triggerEvent = function () {
        if (! event) return;

        $.ajaxSetup({async: false});
        $(document).trigger(event);

        // prevent execution unload
        event = null;
    };

    // fallback, on redirect / close page
    $(window).on(unload, function() {
        return triggerEvent ();
    });

    if (typeof window.mellonBridgeInit !== "undefined") {
        $(document)
            .on('mellon.registration', function () {
                return (event = EV_REGISTRATION);
            })
            .on('mellon.login', function () {
                return (event = EV_LOGIN);
            })
            .on('mellon.redirect', function (e, target) {
                return forwardAfterDomModified(target);
            });

    } else {
        if (typeof window.Post !== "undefined") {
            var f = Post.OnResponse || 0;
            Post.OnResponse = function (xml) {
                if ('success' == xml.firstChild.nodeValue.split("#")[0]) {
                    event = EV_REGISTRATION;
                    triggerEvent();
                }

                return f && f(xml);
            }
        }

        $(document)
            .ajaxComplete(function(e, xhr){
                var o = $.parseJSON(xhr.responseText);
                if (o && o.success) {
                    event = EV_REGISTRATION;
                    triggerEvent ();
                }
            });

        // direct registration link
        $(function() {
            var element = $('a#cta');
            return 0 === element.length || element.click(function (e) {
                e.preventDefault(); event = EV_REGISTRATION;
                return forwardAfterDomModified(element.attr("href"));
            });
        });
    }

    // direct login link
    $(function() {
        var element = $($('#login a')[0]||$('a#login')[0]);
        return 0 === element.length || element.click(function (e) {
            e.preventDefault(); event = EV_LOGIN;
            return forwardAfterDomModified(element.attr("href"));
        });
    });

})(jQuery);
