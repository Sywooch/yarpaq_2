$(function () {

    var star = $('.review_stars i');

    star.mouseover(function () {
        var container = $(this).closest('.review_stars');
        var index = $(this).index();

        switchOffAllStars(container);

        container.find('i').each(function (key, value) {

            if (key > index) {
                return 0;
            }

            $(this).addClass('on');
        });

    });

    star.mouseout(function () {
        var container = $(this).closest('.review_stars');
        switchOffAllStars(container);
        switchOnCurrentRank(container);
    });

    star.click(function () {
        var container = $(this).closest('.review_stars');
        var index = $(this).index();
        var rank = (index + 1);

        container.data('rank', rank);
        $('#stars_input').val(rank);
    });

    function switchOffAllStars(container) {
        container.find('i').removeClass('on');
    }

    function switchOnCurrentRank(container) {
        var current_rank = container.data('rank');

        container.find('i').slice(0, current_rank).addClass('on');
    }

    $('.review_confirm_button').click(function () {
        $('#review_form').submit();
    });

});