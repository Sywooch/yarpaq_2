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


    $('.shipping_method_block input').change(function () {
        var amount = $(this).data('amount') || 0;
        var raw_amount = $(this).data('raw-amount') || 0;
        var cartSubTotal = $('.cart-sub-total').data('amount');

        $('#shipping-price').html(amount);

        $('.cart-total .val').html(cartSubTotal + raw_amount);
    });

    $('.zones_select').change(function () {
        var zone_id = $(this).val();


        $.getJSON('/shipping/calculate', {zone_id: zone_id}, function (response) {
            console.log(response);

            $('.shipping_method_block').hide();
            $('.shipping_method_block input').removeAttr('checked');

            $.each(response, function (type, obj) {
                $('#'+type+'_shipping_method_block').show();
                $('#'+type+'_shipping_method_block input')
                    .attr('data-amount', obj.amount)
                    .attr('data-raw-amount', obj.raw_amount);
            });

            $('.shipping_method_block:visible').eq(0).find('input').click();
        });



        // показ методов оплаты
        if (zone_id == 216 || zone_id == 4225) {
            $('#payment_method_cod').show();
            $('#payment_method_cheque').hide();
        } else {
            $('#payment_method_cod').hide();
            $('#payment_method_cheque').show();
        }
    });

    function validate () {
        $('.error_text').hide();
        $('.error')
            .removeClass('error')
            .find('.error_text').remove();

        var valid = $('#checkout-form')[0].checkValidity();


        var info_inputs = $('#checkout-form .address_form :input');
        info_inputs.each(function () {
            if ($(this).attr('required') !== undefined && $(this).val() == '') {

                var field_block = $(this).closest('.field_block');

                field_block.addClass('error');

                var error = $('<p class="error_text">'+required_error_text+'</p>');
                $(this).after(error);
                error.show();
            }
        });


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
        } else {
            var body = $("html, body");
            var error_block = $('.error');

            var scrollTop = error_block.offset().top - 90;

            body.stop().animate({scrollTop: scrollTop}, 500, 'swing', function() {

            });
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