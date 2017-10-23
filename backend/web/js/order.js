var modal               = $('#orderDeleteModal');
var confirm_delete_btn  = modal.find('[confirm-btn]');
var new_product_el      = $('#orderproductaddform-product_id');
var quantity_el         = $('#orderproductaddform-quantity');
var table               = $('#productsTable');

$(function () {


    /**
     * При изменении страны для Shipping-a подгружать доступные регионы
     */
    $('#order-shipping_country_id').change(function () {

        var region_element = $('#'+$(this).data('region-element-id'));
        var url = $(this).data('url');
        var default_zone_id = region_element.data('default-id');

        getJSON(url, {country_id: $(this).val()}, function (response) {

            region_element.html('');

            $.each(response.data, function (id, name) {
                var option;
                if (default_zone_id == id) {
                    option = $('<option value="'+id+'" selected>'+name+'</option>');
                } else {
                    option = $('<option value="'+id+'">'+name+'</option>');
                }

                region_element.append(option);
            });

        });

    });

    $('#order-shipping_country_id').change();


    /**
     * При изменении страны для Payment-a подгружать доступные регионы
     */
    $('#order-payment_country_id').change(function () {

        var region_element = $('#'+$(this).data('region-element-id'));
        var url = $(this).data('url');
        var default_zone_id = region_element.data('default-id');

        getJSON(url, {country_id: $(this).val()}, function (response) {

            region_element.html('');

            $.each(response.data, function (id, name) {
                var option;
                if (default_zone_id == id) {
                    option = $('<option value="'+id+'" selected>'+name+'</option>');
                } else {
                    option = $('<option value="'+id+'">'+name+'</option>');
                }
                region_element.append(option);
            });

        });

    });

    $('#order-payment_country_id').change();


    /**
     * Обработка нажатия на кнопку удаления товара из заказа
     */
    table.delegate('[order-product-delete-btn]', 'click', function () {
        var order_product_id    = $(this).data('id');
        var product_name        = $(this).data('name');

        // если товар уже прикреплен к товару
        if (order_product_id !== undefined) {
            // прописываем данные конкретного товара в модальное окно
            modal.find('[order-product-name]').html(product_name);
            confirm_delete_btn.attr('data-id', order_product_id);

            modal.modal();
        }
        // если товар только что добавили и не сохранили
        else {
            $(this).closest('tr').fadeOut(300, function() { $(this).remove(); });
        }
    });


    /**
     * Обработка нажатия на кнопку подтверждения удаления
     */
    confirm_delete_btn.click(function () {
        var order_product_id = $(this).data('id');
        var self = $(this);

        self.button('loading');

        // непосредственное удаление
        $.post('/order/delete-product-from-order?order_product_id='+order_product_id, function (response) {
            self.button('reset');
            modal.modal('hide');

            if (response.status) {
                removeProductRow(order_product_id);
            }

        }, 'json');
    });

    /**
     * удаление строки из верстки
     *
     * @param order_product_id
     */
    function removeProductRow(order_product_id) {
        var row = $('[order-product-delete-btn][data-id="'+order_product_id+'"]').closest('tr');
        row.fadeOut(300, function() { $(this).remove(); });
    }


    /**
     * Действие после выбора товара
     */
    new_product_el.change(function () {
        clearOptions();

        var product_id = $(this).val();

        if (product_id != null) {
            checkForOptions(product_id);
        }


    });

    function clearOptions() {
        $('#options').html('');
    }


    /**
     * Нажатие на кнопку "Добавить продукт"
     */
    $('.order-product-add-btn').click(function () {
        var self = $(this);
        var product_id = new_product_el.val();
        var options_data = {};
        $.each($('.option_el'), function () {
            options_data[ $(this).data('id') ] = $(this).val();
        });

        var data = {
            'product_id': product_id,
            'options': options_data
        };

        // добавление order option
        postJSON('/product/info?'+ $.param(data), function (response) {

            if (response.status) {
                var nextNum = table.find('tr').size();

                var quantity        = quantity_el.val();
                var name            = response.data.title;
                var model           = response.data.model;
                var price           = response.data.price;
                var total_price     = quantity * price;

                // добавить строку товара в общий список
                var html = '';
                html += '<tr>';
                html +=     '<td>'+nextNum+'.</td>';
                html +=     '<td>'+name;
                html +=     '<input type="hidden" name="OrderProduct['+nextNum+'][product_id]" value="'+product_id+'">';
                html +=     '<input type="hidden" name="OrderProduct['+nextNum+'][quantity]" value="'+quantity+'">';

                $.each(options_data, function (product_option_id, product_option_value_id) {
                    html +=     '<input type="hidden" name="OrderProduct['+nextNum+'][options]['+product_option_id+']" value="'+product_option_value_id+'">';
                });

                html +=     '</td>';
                html +=     '<td>'+model+'</td>';
                html +=     '<td>'+quantity+'</td>';
                html +=     '<td>'+price+'</td>';
                html +=     '<td>'+total_price+'</td>';
                html +=     '<td><button type="button" class="btn btn-danger btn-xs" order-product-delete-btn="" data-name="'+name+'">Delete from order</button></td>';
                html += '</tr>';

                table.find('tbody').append(html);

                resetAddProductForm();
            }

        });
    });

    function resetAddProductForm() {
        new_product_el.val('').change();
        quantity_el.val('');
    }


    /**
     * Проверка есть ли опции (варианты)
     * @param product_id
     */
    function checkForOptions(product_id) {
        getJSON('/product-option/check-for-options', {product_id: product_id}, function (response) {
            if (response.status) {
                if (response.data.product_options != undefined) {
                    $.each(response.data.product_options, function (index, product_option) {

                        var option = product_option.option;

                        // добавить select с данными опции
                        var block = generateSelectBlock(product_option.id, option.name);
                        var select = block.find('select');
                        $.each(product_option.values, function (key, product_option_value) {
                            select.append('<option value="'+product_option_value.id+'">'+product_option_value.name+'</option>');
                        });

                        $('#options').append(block);

                    });
                }
            }
        });
    }

    function generateSelectBlock(id, label) {
        var html = '';
        html += '<div class="form-group required">\n';
        html += '<label class="control-label" for="option-size">'+label+'</label>\n';
        html += '<select id="options_el_'+id+'" class="form-control option_el" data-id="'+id+'" name="options['+id+']" aria-required="true" aria-invalid="false">\n';
        html += '</select>';
        html += '</div>';

        return $(html);
    }
});
