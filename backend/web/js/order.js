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

        getJSON(url, {country_id: $(this).val()}, function (response) {

            region_element.html('');

            $.each(response.data, function (id, name) {
                var option = $('<option value="'+id+'">'+name+'</option>');
                region_element.append(option);
            });

        });

    });


    /**
     * При изменении страны для Payment-a подгружать доступные регионы
     */
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
        checkForOptions($(this).val());
    });


    /**
     * Нажатие на кнопку "Добавить продукт"
     */
    $('.order-product-add-btn').click(function () {

        getJSON('/product/info?product_id=' + new_product_el.val(), function (response) {

            if (response.status) {
                var nextNum = table.find('tr').size();

                var product_id      = response.data.id;
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
                html +=     '<input type="hidden" name="OrderProduct['+nextNum+'][order_id]" value="'+$('.order-product-add-btn').data('id')+'">';
                html +=     '<input type="hidden" name="OrderProduct['+nextNum+'][product_id]" value="'+product_id+'">';
                html +=     '<input type="hidden" name="OrderProduct['+nextNum+'][name]" value="'+name+'">';
                html +=     '<input type="hidden" name="OrderProduct['+nextNum+'][model]" value="'+model+'">';
                html +=     '<input type="hidden" name="OrderProduct['+nextNum+'][quantity]" value="'+quantity+'">';
                html +=     '<input type="hidden" name="OrderProduct['+nextNum+'][price]" value="'+price+'">';
                html +=     '<input type="hidden" name="OrderProduct['+nextNum+'][total]" value="'+total_price+'">';
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
        new_product_el.val(null).change();
        quantity_el.val('');
    }


    /**
     * Проверка есть ли опции (варианты)
     * @param product_id
     */
    function checkForOptions(product_id) {
        getJSON('/product/check-for-options', {product_id: product_id}, function (response) {
            if (response.status) {
                if (response.data.options != undefined) {
                    $.each(response.data.options, function (option_id, option) {

                        // добавить select с данными опции
                        var block = generateSelectBlock('option-'+option_id, option.name);
                        var select = block.find('select');
                        $.each(option.values, function (key, value) {
                            select.append('<option value="'+value.id+'">'+value.name+'</option>');
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
        html += '<select id="'+id+'" class="form-control" name="'+id+'" aria-required="true" aria-invalid="false">\n';
        html += '</select>';
        html += '</div>';

        return $(html);
    }
});