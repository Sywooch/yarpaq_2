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
    });

    $('#checkout-submit').click(function (e) {
        e.preventDefault();

        $('#checkout-form').submit();
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