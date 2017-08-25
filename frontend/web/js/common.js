$(function () {
    $('#signin-popup-form').submit(function (e) {
        e.preventDefault();

        var form = $(this);

        $.getJSON('/login', form.serialize(), function (response) {
            if (response.status) {
                location.reload();
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
});