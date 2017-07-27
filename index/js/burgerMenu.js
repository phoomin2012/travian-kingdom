$(document).ready(function () {

    var menu = $("footer .foot-menu");
    $(".burger >span", menu).on("click", function (e) {

        $(this).parent().toggleClass("active");
        $(this).toggleClass("active");
        e.preventDefault();
    })
    var newMenu = $(".menu-list", menu)

    function moveMenuItem() {
        if (menu.width() >= 960 || menu.height() > 42) {
            $(".burger", menu).css({display: "inline-block"});
            newMenu.prepend($(" > .menu-item", menu).eq($("> .menu-item", menu).length - 1))
            setTimeout(function () {
                if (menu.width() >= 960 || menu.height() > 42) {
                    moveMenuItem()
                }
            }, 50)
        }
    }

    if (menu.width() >= 960 || menu.height() > 42) {

        $(".burger", menu).css({display: "inline-block"});
        moveMenuItem();
    }
    $(window).resize(moveMenuItem);
})