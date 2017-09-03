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
});