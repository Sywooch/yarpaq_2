$(function () {

    var discount_period = $('#discount-period');

    discount_period.change(function () {

        if ($(this).val() == 1) {
            $('.field-discount-start_date') .show();
            $('.field-discount-end_date')   .show();
        } else {
            $('.field-discount-start_date') .hide();
            $('.field-discount-end_date')   .hide();
        }
    });

    discount_period.change();

});