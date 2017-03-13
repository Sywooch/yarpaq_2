$(function () {

    var tree = $('.tree');
    var body = $('body');

    tree.delegate('.list-group-item .bind-a', 'click', function() {
        var self = $(this);

        $('.glyphicon', this)
            .toggleClass('glyphicon-chevron-right')
            .toggleClass('glyphicon-chevron-down');


        // проверяем, если требуется подгрузка потомков
        // то есть если нету группы потомков, ищем по ID
        if ($(self.attr('href')).size() == 0) {
            $.getJSON($(this).attr('data-children-url'), function (response) {

                // клонируем корневой элемент
                var group = $('.list-group.tpl').clone().removeClass('hide tpl');
                var item = $('.list-group-item.tpl').clone().removeClass('hide tpl');

                // если загружены элементы
                if (response.length) {

                    // конструируем новую группу
                    $.each(response, function () {
                        var item_data = $(this).get(0);

                        var c_item = item.clone();
                        c_item.find('.bind-header').html(item_data.header);
                        c_item.find('.bind-edit').attr('href', item_data.editUrl);
                        c_item.find('.bind-add').attr('href', item_data.addUrl);
                        c_item.find('.bind-move-up').attr('href', item_data.moveUpUrl);
                        c_item.find('.bind-move-down').attr('href', item_data.moveDownUrl);
                        c_item.find('.bind-delete').attr('href', item_data.deleteUrl);
                        c_item.find('.bind-view').attr('href', item_data.viewUrl);
                        c_item.find('.bind-a').attr('href', '#item-'+item_data.id);
                        c_item.find('.bind-a').attr('data-children-url', item_data.childrenUrl);

                        if (item_data.childrenCount == 0) {
                            c_item.find('.glyphicon').css('visibility', 'hidden');
                        }

                        group.append(c_item);
                    });

                    group.attr('id', self.attr('href').substr(1));
                    group.insertAfter(self.closest('.list-group-item'));
                    group.collapse('show');
                }
            });
        }
    });

    tree.find('.list-group-root .bind-a').click();


    // move up
    body.delegate('.bind-move-up', 'click', function (e) {
        e.preventDefault();

        var url = $(this).attr('href'),
            self = $(this),
            item = self.closest('.list-group-item');

        $.post(url, function (response) {
            if (response.result && response.result == true) {
                item.insertBefore(item.prev());
            }
        }, 'json');
    });


    // move down
    body.delegate('.bind-move-down', 'click', function (e) {
        e.preventDefault();

        var url = $(this).attr('href'),
            self = $(this),
            item = self.closest('.list-group-item');

        $.post(url, function (response) {
            if (response.result && response.result == true) {
                item.insertAfter(item.next());
            }
        }, 'json');
    });
});