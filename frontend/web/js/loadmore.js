$(function () {
    $('.show_more_btn').click(function (e) {
        e.preventDefault();

        var self = $(this),
            url = self.attr('href'),                        // URL следующей страницы
            product_list = $('.product_result_list');       // блок в который надо будет поместить полученные повары

        self.addClass('loading');                           // активируем вид загрузки

        $.getJSON(url, function (response) {
            self.removeClass('loading');                    // отключаем вид загрузки

            if (response.next_page_url != '') {
                self.attr('href', response.next_page_url);      // обновляем URL следующей страницы, для следующего нажатия
            } else {
                self.hide();
            }

            product_list.append(response.markup);           // помещаем полученный товары в блок
        });
    });
});