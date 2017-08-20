$(function () {
    $(':input[name="AddToCartForm[quantity]"]').change(function () {

        var self = $(this);

        var data = {
            product_id: self.data('product-id'),
            qty: self.val()
        };

        var token = $('.form-token');

        data[token.attr('name')] = token.attr('value');

        $.post('/cart/update', data, function (response) {
            console.log(response);
            if (response.status) {
                $('#cart-total').html( response.total );
            }

        }, 'json');

    });


    $('article .close').click(function () {

        var self = $(this);

        var data = {
            product_id: self.data('product-id')
        };

        var token = $('.form-token');

        data[token.attr('name')] = token.attr('value');

        $.post('/cart/remove', data, function (response) {
            console.log(response);

            if (response.status) {
                self.closest('article').fadeOut(function () {
                    $(this).remove();
                });

                if (response.status) {
                    $('#cart-total').html( response.total );
                }
            }


            if (!$('.basket_list article').size()) {
                location.reload()
            }
        }, 'json');

    });
});