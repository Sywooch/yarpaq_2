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

        });

        countryField.val(15);
        countryField.change();
    }


    $('.priduct_gallery .image img').elevateZoom();


    $('#footer-currency').change(function () {
        var currency_id = $(this).val();

        location.href = '/currency/switch?id='+currency_id;
    });

    $('#footer-lang').change(function () {
        var lang_url = $(this).val();

        location.href = lang_url;
    });
});