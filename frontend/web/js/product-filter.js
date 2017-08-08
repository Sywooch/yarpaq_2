function GetURLParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam)
        {
            return sParameterName[1];
        }
    }
}

function ProductFilter() {
    var form                = $('#productFilterForm'),
        brand_input         = '.brand_filter',
        condition_input     = '.condition_filter',
        price_input         = '.price_filter',
        self = this;

    this.title      = null;

    this.per_page   = null;
    this.sort       = null;

    this.setCondition = function (condition_id) {
        self.condition = condition_id;
        self.update();
    };


    this.setPerPage = function (perPage) {
        this.per_page = perPage;
        self.update();
    };

    this.setSort = function (sort) {
        this.sort = sort;
        self.update();
    };

    this.resetPrice = function () {
        form.find(price_input)
            .val('')
            .change();

    };

    this.resetBrands = function () {
        form.find(brand_input)
            .removeAttr('checked')
            .change();
    };

    this.resetCondition = function () {
        form.find(condition_input)
            .removeAttr('checked')
            .change();
    };

    this.resetAll = function () {
        this.resetCondition();
        this.resetBrands();
        this.resetPrice();
    };
}

var productFilter = new ProductFilter();

$(function () {
    $(".price-range").ionRangeSlider({
        type: "double",
        postfix: "<span class=\"currency_icon\">M</span>",
        onFinish: function (data) {
            $('input[name="ProductFilter[price_from]"]').val( data.from );
            $('input[name="ProductFilter[price_to]"]').val( data.to );
        }
    });

    var form = $('#productFilterForm');

    $('.brand-reset-btn').click(function (e) {
        e.preventDefault();

        productFilter.resetBrands();
    });
    $('.condition-reset-btn').click(function (e) {
        e.preventDefault();

        productFilter.resetCondition();
    });


    $('.brand_filter').change(function () {
        form.submit();
    });
    $('.condition_filter').change(function () {
        form.submit();
    });

    $(".sort_by > a").click(function (e) {
        e.preventDefault();
    });

    $(".sort_by ul a").click(function () {
        var value = $(this).data('value');
        $('.sort_filter').val(value);

        form.submit();
    });

    $('.clear_filtre').click(function () {
        productFilter.resetAll();
    });


    $('.selected-filter').click(function () {
        var id = $(this).data('id');


        if ($(this).hasClass('selected-filter-checkbox')) {
            $('#'+id).removeAttr('checked')
                .change();
        }

        if ($(this).hasClass('selected-filter-price')) {
            $('.price_filter').val('');
            form.submit();
        }

        return false;
    });
});