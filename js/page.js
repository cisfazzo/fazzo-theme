$.fn.onPositionChanged = function (trigger, millis) {
    if (millis == null) millis = 100;
    var o = $(this[0]); // our jquery object
    if (o.length < 1) return o;

    var lastPos = null;
    var lastOff = null;
    setInterval(function () {
        if (o == null || o.length < 1) return o; // abort if element is non existend eny more
        if (lastPos == null) lastPos = o.position();
        if (lastOff == null) lastOff = o.offset();
        var newPos = o.position();
        var newOff = o.offset();
        if (lastPos.top != newPos.top || lastPos.left != newPos.left) {
            $(this).trigger('onPositionChanged', {lastPos: lastPos, newPos: newPos});
            if (typeof (trigger) == "function") trigger(lastPos, newPos);
            lastPos = o.position();
        }
        if (lastOff.top != newOff.top || lastOff.left != newOff.left) {
            $(this).trigger('onOffsetChanged', {lastOff: lastOff, newOff: newOff});
            if (typeof (trigger) == "function") trigger(lastOff, newOff);
            lastOff = o.offset();
        }
    }, millis);

    return o;
};


$(function () {
    'use strict'

    $('[data-toggle="offcanvas"]').on('click', function () {
        $('.offcanvas-collapse').toggleClass('open')
    })

    /*
        const {easing, tween, styler, value, posed, physics} = window.popmotion;
        const divStyler = styler(document.querySelector('#head-title'));
        tween({
            from: {x: -200, rotate: 0},
            to: {x: 200, rotate: 0},
            duration: 3000,
            ease: easing.easeInOut,
            flip: Infinity,
            // elapsed: 500,
            // loop: 5,
            // yoyo: 5
        }).start(divStyler.set);
    */
    $('#head-top-right-wrapper #search-collapse').click(function () {

        $('#head-top-right-wrapper .search-field').css("display", "inline-block").animate({opacity: 1}, 800);
        $('#head-top-right-wrapper .search-submit').css("display", "inline-block").animate({opacity: 1}, 800);
        $('#head-top-right-wrapper #search-collapse').css("display", "none");
        $('#head-top-right-wrapper .search-field').focus();

    });

    /*
        function fazzo_bar(inner, id, duration, seek, style, jsonstyle1, jsonstyle2) {
            var adjust = 2;
            $(inner).prepend($("<div id='" + id + "' style='" + style + "'></div>"));
            var inner_height = $(inner).css('height');
            inner_height = parseInt(inner_height.replace('px', ''));
            var id_height = $("#" + id).css('height');
            id_height = parseInt(id_height.replace('px', ''));
            var bottom = inner_height - (2 * id_height) - adjust;
            $("#" + id).onPositionChanged(function () {
                var pos = $("#" + id).position();
                if (pos.top <= adjust) {
                    $("#" + id).css(jsonstyle1);
                }
                if (pos.top >= (bottom - adjust)) {

                    $("#" + id).css(jsonstyle2);
                }
            });
            tween({
                from: {y: 0, rotate: 0},
                to: {y: bottom, rotate: 0},
                duration: duration,
                ease: easing.easeInOut,
                flip: Infinity,
            }).start(styler(document.querySelector("#" + id)).set).seek(seek);
        }

        $("#head-title").css('z-index', '2');
        $("#head-top-left-wrapper").css('z-index', '4');
        $("#head-bottom-full-wrapper").css('z-index', '4');

        var style = 'box-shadow: 0px 4px 15px 1px rgba(0,0,0,0.75);background-image: linear-gradient(to bottom, #969696, #6e6e6e, #494949, #272727, #000000);position:absolute; width:100%; height: 12px;';
        var jsonstyle1 = {'box-shadow': '0px 4px 15px 1px rgba(0,0,0,0.75)', 'z-index': '-1'};
        var jsonstyle2 = {'box-shadow': '0px 10px 15px 1px rgba(0,0,0,0.75)', 'z-index': '3'};

        for (var i = 0, j = 1; i < 0.6; i = i + 0.1, j++) {
            fazzo_bar("#head-middle-full-wrapper", "bar" + j, 3000, i, style, jsonstyle1, jsonstyle2);
        }

        const polarToCartesian = ({angle, radius}) => ({
            x: radius * Math.cos(angle),
            y: radius * Math.sin(angle)
        });


        var roundabout_child_count = $("#menu-roundabout-meta-frontpage-nav > .menu-roundabout-child").length;
        var roundabout_angle_step = 6.3 / roundabout_child_count;
        var roundabout_angle = 0;
        $('#menu-roundabout-meta-frontpage-nav').children('.menu-roundabout-child').each(function () {
            physics({
                from: {angle: roundabout_angle, radius: 250},
                velocity: {angle: 0.1, radius: 0}
            }).pipe(polarToCartesian).start(styler(this).set);
            roundabout_angle = roundabout_angle + roundabout_angle_step;
        });

        var time = 120;
        var time_add = time;
        var disco_time = 5000;
        var time_restore = 60;

        function fazzo_disco() {
            $('li').each(function () {
                var element = $(this);
                setTimeout(function () {
                    fazzo_trigger_mouseenter(element);
                }, time);
                time = time + time_add;
            });

            $('a').each(function () {
                var element = $(this);
                setTimeout(function () {
                    fazzo_trigger_mouseenter(element);
                }, time);
                time = time + time_add;
            });

            setTimeout(function () {
                fazzo_disco();
            }, disco_time);
        }
        setTimeout(function () {
            fazzo_disco();
        }, disco_time);
        */

    function fazzo_trigger_mouseenter(element) {
        element.addClass('hover');
        setTimeout(function () {
            fazzo_end_mouseenter(element);
        }, time_restore);
    }

    function fazzo_end_mouseenter(element) {
        element.removeClass('hover');
    }

});

