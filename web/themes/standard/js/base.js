(function ($) {
    $('#scrollToTop').affix({
        // how far to scroll down before link "slides" into view
        offset: {top: 50}
    });

    $(document).on("click", ".vocab-entry-popover-audio", function () {
        var audioalias = $(this).data('audioalias');
        stopAudio();
        initAudio(audioalias);
        playAudio();
    });

    /* ----------------------------------------------- */
    /* ----------------------------------------------- */
    /* OnLoad Page */
    $(document).ready(
        function ($) {
            if ($(window).width() > 992 || window.isIOS) {
                $('.menu-item').hover(
                    function (e) {
                        $(this).siblings().removeClass('active').children('ul').removeClass('in');
                        $(this).addClass('active');
                        $(this).children('ul').addClass('in');
                    }, function (e) {

                    });
            }
        }
    );
    /* OnLoad Window */
    var init = function () {

        $('[data-toggle="tooltip"]').tooltip()

    };

    window.onload = init;

})(jQuery);
