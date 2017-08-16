$(function () {
    $('#country_select').change(function () {
        $('.zones_select').hide();
        $('#zones_'+$(this).val()).show();
    });

    $('#country_select').change();
});