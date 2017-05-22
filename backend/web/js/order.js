$(function () {
    $('#order-shipping_country_id').change(function () {

        var region_element = $('#'+$(this).data('region-element-id'));
        var url = $(this).data('url');

        getJSON(url, {country_id: $(this).val()}, function (response) {

            region_element.html('');

            $.each(response.data, function (id, name) {
                var option = $('<option value="'+id+'">'+name+'</option>');
                region_element.append(option);
            });

        });

    });

    $('#order-payment_country_id').change(function () {

        var region_element = $('#'+$(this).data('region-element-id'));
        var url = $(this).data('url');

        getJSON(url, {country_id: $(this).val()}, function (response) {

            region_element.html('');

            $.each(response.data, function (id, name) {
                var option = $('<option value="'+id+'">'+name+'</option>');
                region_element.append(option);
            });

        });

    });
});