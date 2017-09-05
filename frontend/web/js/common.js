$(function () {
    $('#signin-popup-form').submit(function (e) {
        e.preventDefault();

        var form = $(this);

        form.find('.error').remove();

        $.getJSON(form.attr('action'), form.serialize(), function (response) {
            if (response.status) {
                location.reload();
            } else {
                form.append('<p style="color: red" class="error">'+response.message+'</p>');
            }
        });

    });

    $('#recovery-password-form').submit(function (e) {
        e.preventDefault();

        var form = $(this);

        form.find('.error').remove();

        $.post(form.attr('action'), form.serialize(), function (response) {
            if (response.status) {

            } else {
                form.append('<p style="color: red" class="error">'+response.message+'</p>');
            }
        }, 'json');

    });


    var regForm = $('#regForm');
    if (regForm.size()) {
        var countryField    = regForm.find('#countryField');
        var zoneField       = regForm.find('#zoneField');

        countryField.change(function () {
            var country_id = $(this).val();
            zoneField.children().slice(1).remove();

            $.each(zones[country_id], function (id, name) {
                zoneField.append('<option value="'+id+'">'+name+'</option>');
            });

            // если есть значение по-умолчанию, то прописать его
            if (zoneField.data('default-value') !== undefined) {
                zoneField.val(zoneField.data('default-value'));
            }

        });

        if (countryField.val() == '') {
            countryField.val(15);
        }


        countryField.change();
    }


    if (!isMobile) {
        $("._xzoom, .xzoom-gallery").xzoom();
    } else {
        $('#desktop-gallery').hide();
        $('#mobile-gallery').show().slick({
            dots: true
        });
    }


    $('#footer-currency').change(function () {
        var currency_id = $(this).val();

        location.href = '/currency/switch?id='+currency_id;
    });

    $('#footer-lang').change(function () {
        var lang_url = $(this).val();

        location.href = lang_url;
    });


    var auto_search_container = $('.autocomplete');
    var main_search = $('#main-search');
    main_search.blur(function () {
        auto_search_container.fadeOut();
    });
    main_search.focus(function () {
        $(this).keyup();
    });
    main_search.keyup(function () {
        var q = $(this).val();
        var action = $(this).data('action');


        if (q.length <= 2) {
            return;
        }

        $.getJSON(action, {q: q}, function (response) {

            if (!response.length) {
                auto_search_container.fadeOut();
                return false;
            }

            // clear list
            auto_search_container.html('');

            // build html
            for (var i=0; i<response.length; i++) {
                var product = response[i];

                html = '<li>';
                html +=     '<a href="'+product.url+'" class="clear">';
                html += '        <span class="autocomplete-image-block" style="background-image: url(\''+product.preview+'\')">';
                html += '            <img src="'+product.preview+'">';
                html += '        </span>';
                html += '        <span class="autocomplete-right-block">';
                html += '            <span class="product-title">'+product.title+'</span>';
                html += '            <div class="product-price">'+product.price+' <em style="display: none;">$40</em></div>';
                html += '        </span>';
                html += '    </a>';
                html += '</li>';

                auto_search_container.append($(html));
            }

            // show block
            auto_search_container.fadeIn();

        });

    });

    var mobile_search = $('#mobile-search');
});