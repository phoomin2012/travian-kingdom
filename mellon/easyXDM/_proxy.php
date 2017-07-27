<!doctype html>
<html>
    <head>
        <title>Mellon</title>

        <style type="text/css">
            html, body{ overflow: hidden; margin: 0; padding: 0; width: 100%; height: 100%; background: none transparent; }
            iframe{ overflow: hidden; width: 100%; height: 100%; border: 0; outline: none; background: none transparent; }
        </style>

        <script type="text/javascript" src="<?php echo $mellon_url;?>easyXDM/easyXDM.min.js"></script>
        <script type="text/javascript">
            var iframe, docOf = function (ifr) {
                return ifr.contentDocument || ifr.contentWindow.document;
            };

            easyXDM.DomHelper.requiresJSON("<?php echo $mellon_url;?>easyXDM/json2.js");

            window.bridge = new easyXDM.Rpc(
                    {
                        local: '<?php echo $mellon_url;?>easyXDM/name.html',
                        swf: "<?php echo $mellon_url;?>easyXDM/easyxdm.swf",
                        onReady: function () {
                            var elem = document.getElementById('loader');
                            elem.parentElement.removeChild(elem);

                            iframe = document.createElement('iframe');
                            iframe.scrolling = 'no';
                            iframe.frameSpacing = 0;
                            iframe.frameBorder = 0;
                            iframe.src = easyXDM.query.urn;

                            document.body.appendChild(iframe);
                            iframe.setAttribute('allowTransparency', 1);
                        }
                    },
                    {
                        local: {
                            resize: function (w, h) {
                                iframe.style.width = +w + 'px';
                                iframe.style.height = +h + 'px';
                                docOf(iframe).body.style.width = 'auto';
                                return {result: true};
                            },
                            ping: function () {
                                return {result: (docOf(iframe).readyState || 'complete') === 'complete'};
                            }
                        },
                        remote: {
                            close: {},
                            event: {},
                            resize: {},
                            redirect: {},
                            setCookie: {},
                            getCookie: {},
                            marketingTracking: {}
                        }
                    }
            );
        </script>
    </head>
    <body>
        <div id="loader" style="left: 0; right: 0;">
            <img src="<?php echo $mellon_url;?>images/loading.gif" width="220" height="20" alt="Loading..." />
        </div>
    </body>
</html>
