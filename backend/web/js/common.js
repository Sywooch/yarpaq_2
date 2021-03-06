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


    $('.order-status-change-select').change(function () {

        var order_id = $(this).data('order-id');
        var status_id = $(this).val();

        $.post('/order/change-status-ajax', { order_id: order_id, status_id: status_id }, function (response) {

        }, 'json');

    });

    $('.product-status-change-select').change(function () {

        var product_id = $(this).data('product-id');
        var status_id = $(this).val();

        $.post('/product/change-status-ajax', { product_id: product_id, status_id: status_id }, function (response) {

        }, 'json');

    });


    var commonNotificationsBlock = $('#commonNotificationsBlock');

    function loadCommonNotifications() {

        var url = commonNotificationsBlock.data('url') + '?r=' + Math.random();

        $.getJSON(url, function (response) {

            // moderation products
            if (response.moderation_products !== undefined) {
                $('#noti_moderation_products').html(response.moderation_products);
            } else {
                $('#noti_moderation_products').html('-');
            }

            // new orders
            if (response.new_orders !== undefined) {
                $('#noti_new_orders').html(response.new_orders);
            } else {
                $('#noti_new_orders').html('-');
            }


            // new reviews
            if (response.new_reviews !== undefined) {
                $('#noti_reviews').html(response.new_reviews);
            } else {
                $('#noti_reviews').html('-');
            }


            // out of stock products
            if (response.out_of_stock_products !== undefined) {
                $('#noti_out_of_stock').html(response.out_of_stock_products);
            } else {
                $('#noti_out_of_stock').html('-');
            }

            // out of stock products
            if (response.no_result_queries_count !== undefined) {
                $('#noti_no_result_queries_count').html(response.no_result_queries_count);
            } else {
                $('#noti_no_result_queries_count').html('-');
            }


            // total notifications
            if (response.total !== undefined) {
                $('#noti_total').html(response.total);
            } else {
                $('#noti_total').html('-');
            }
        });
    }

    if (commonNotificationsBlock.length) {
        // load common notifications
        setInterval(loadCommonNotifications, 5000);
        loadCommonNotifications();
    }
});

$(window).scroll(function(){

    var top_pos = document.documentElement.scrollTop||document.body.scrollTop;

    if (top_pos > $("header#header_new").height()) {
        top_pos = $("header#header_new").height();
    }

    $("#aside_basket").css("margin-top", -top_pos+"px")

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
