$(function () {

    $('#country_select').change(function () {
        $.getJSON('/checkout/zones', {country_id: $(this).val()}, function (response) {
            var zone_select = $('#zone_select');
            zone_select.html('');

            var default_zone_id = zone_select.data('default');

            $.each(response, function (id, name) {
                if (default_zone_id != id) {
                    zone_select.append( $('<option value="'+id+'">'+name+'</option>') );
                } else {
                    zone_select.append( $('<option selected value="'+id+'">'+name+'</option>') );
                }
            });

            zone_select.change();
        });
    });

    $('#country_select').change();

    $('.zones_select').change(function () {
        var zone_id = $(this).val();


        $.getJSON('/shipping/calculate', {zone_id: zone_id}, function (response) {
            console.log(response);

            $('.shipping_method_block').hide();
            $('.shipping_method_block input').removeAttr('checked');

            $.each(response, function (type, obj) {
                $('#'+type+'_shipping_method_block').show();
            });

            $('.shipping_method_block:visible').eq(0).find('input').click();
        });



        // показ методов оплаты
        if (zone_id == 216 || zone_id == 4225) {
            $('#payment_method_cod').show();
        } else {
            $('#payment_method_cod').hide();
        }
    });

    function validate () {
        var valid = true;

        $('.error_text').hide();

        var payment_method = $('input[name="payment_method"]');
        var payment_methods = $('.payment_methods');

        if (!$('.payment_method_row.active').length) {
            payment_methods.find('.error_text').show();
            valid = false;
        }

        return valid;
    }

    $('#checkout-submit').click(function (e) {
        e.preventDefault();

        if (validate()) {
            $('#checkout-form').submit();
        }

    });


    $('.albali_taksit').click(function (e) {
        e.preventDefault();

        $('#albali_method').val( '2.'+$(this).data('taksit') );
    });

    $('.bolkart_taksit').click(function (e) {
        e.preventDefault();

        $('#bolkart_method').val( '1.'+$(this).data('taksit') );
    });
});