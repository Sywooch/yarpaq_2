var DEBUG = true;

function Logger() {

    this.log = function (str) {

        if (DEBUG) {
            console.log(str);
        }
    }
}
var Logger = new Logger();

$(function () {

    // Javascript to enable link to tab
    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
    } // add a suffix



    $('.values_group').delegate('.deleteOptionValueBtn', 'click', function () {

        if ($(this).hasClass('immediate')) {
            $(this).closest('.value_row').remove();
        } else {
            $(this).closest('.value_row').toggleClass('disabled');
        }
    });

    $('.addOptionValueBtn').click(function () {
        var group = $(this).closest('.tab-pane').find('.values_group');
        var tpl = group.find('.optionValueTpl').clone();

        tpl.removeClass('optionValueTpl');
        group.append(tpl);
        tpl.fadeIn();
        tpl.removeClass('hide');

    });

});


function onChangeOrderUser(e) {

    var target = $(e.target);
    var user_id = target.val();
    var url     = target.data('info-url');

    $.getJSON(url, {user_id: user_id}, function (response) {

        // if success
        if (response.status !== undefined) {

            // populate fields
            var data = response.data;
            $.each(data, function (property, value) {
                $('#order-'+property).val(value);
            });
        } else {
            Logger.log('Load order user info: "status" property not found');
        }
    });
}

// override getJSON fn
var getJSONfn = $.getJSON;

function getJSON(url, data, callback) {
    if (loading) return false;

    var loading = true;
    $.getJSON(url, data, function (response) {
        loading = false;

        callback(response);
    });
}

function postJSON(url, data, callback) {
    if (loading) return false;

    var loading = true;
    $.post(url, data, function (response) {
        loading = false;

        callback(response);
    }, 'json');
}
