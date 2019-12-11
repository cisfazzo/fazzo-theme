$(function () {
    'use strict'


    $('[data-toggle="offcanvas"]').on('click', function () {
        $('.offcanvas-collapse').toggleClass('open')
    })

    const { easing, tween, styler } = window.popmotion;
    const divStyler = styler(document.querySelector('#head-title'));
    tween({
        from: { x: -100, rotate: 0 },
        to: { x: 100, rotate: 0 },
        duration: 3000,
        ease: easing.easeInOut,
        flip: Infinity,
        // elapsed: 500,
        // loop: 5,
        // yoyo: 5
    }).start(divStyler.set);

    $('#head-top-right-wrapper #search-collapse').click(function() {

        $('#head-top-right-wrapper .search-field').css("display", "inline-block").animate({opacity:1},800);
        $('#head-top-right-wrapper .search-submit').css("display", "inline-block").animate({opacity:1},800);
        $('#head-top-right-wrapper #search-collapse').css("display", "none");
        $('#head-top-right-wrapper .search-field').focus();

    });

})