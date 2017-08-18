$(function () {

    $('#country_select').change(function () {
        $.getJSON('/checkout/zones', {country_id: $(this).val()}, function (response) {
            var zone_select = $('#zone_select');
            zone_select.html('');

            $.each(response, function (id, name) {
                zone_select.append( $('<option value="'+id+'">'+name+'</option>') );
            });
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
                $('#'+type+'_shipping_method_block').fadeIn();
                $('#'+type+'_method').val(obj.code);


                $('.shipping_method_block:visible input').attr('checked', 'checked');
            });
        });
    });

    $('#checkout-submit').click(function () {
        $('#checkout-form').submit();
    });
});