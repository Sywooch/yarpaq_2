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

    initProductGallery();


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



    // quick view
    $('.quick_view_btn').click(function (e) {
        e.preventDefault();

        var quick_view_url = $(this).data('url');
        if (!quick_view_url) { return; }

        showOverlay();
        loadQuickViewData(quick_view_url);
    });

    $('.dark').click(function () {
        hideOverlay();
    });

    $('.popup_close_btn').click(function (e) {
        hideOverlay();
    });

    function loadQuickViewData(quick_view_url) {
        $('.popup_quick_view .popup_content').load(quick_view_url, function () {
            initProductGallery();
        });
    }

    function showOverlay() {
        $('.overlay').fadeIn();
    }

    function hideOverlay() {
        $('.overlay').fadeOut(function () {
            $(this).find('.popup .popup_content').html('');
        });
    }





    // product gallery

    var _slider_step = 0,
        _slider_step_height,
        _slider_visible_steps = 5,
        _slider_length;

    if (_window.width() < 481) {
        _slider_visible_steps = 3;
    }

    $(document).on('click', ".thumbnails .arrows a", function() {
        var _this = $(this);
        var container = _this.closest('.thumbnails');
        var arrowNext = container.find(".arrows a.next");
        var arrowPrev = container.find(".arrows a.prev");

        container.find(".arrows a").removeClass("unactive");

        if (_this.hasClass("prev")) {
            _slider_step++;
            if (_slider_step > 0) {
                _slider_step = 0;
            }
            if (_slider_step == 0) {
                arrowPrev.addClass("unactive");
            }
        } else {
            _slider_step--;
            if (_slider_step < -(_slider_length-_slider_visible_steps)) {
                _slider_step = -(_slider_length-_slider_visible_steps);
            }
            if (_slider_step < -(_slider_length-_slider_visible_steps)+1) {
                arrowNext.addClass("unactive");
            }
        }

        container.find(".xzoom-thumbs").css("top", (_slider_step*_slider_step_height)+"px");

        return false;
    });

    $(document).on('click', ".thumbnails .thumb", function(e) {
        e.preventDefault();

        var currentIndex = $(this).index();
        var container = $(this).closest('.thumbnails');
        var arrowNext = container.find(".arrows a.next");
        var arrowPrev = container.find(".arrows a.prev");

        if (currentIndex + _slider_step == _slider_visible_steps - 1) {
            arrowNext.click();
        }

        if (currentIndex + _slider_step == 0) {
            arrowPrev.click();
        }
    });

    function initProductGallery() {
        _slider_step_height = $(".priduct_gallery .thumbnails img").eq(0).height() + 15;
        _slider_length = $(".priduct_gallery .thumbnails img").length;
        initZoom();
    }

    function initZoom() {
        if (!isMobile) {
            $("._xzoom, .xzoom-gallery").xzoom();
        } else {
            $('#desktop-gallery').hide();
            $('#mobile-gallery').show().slick({
                dots: true
            });
        }
    }

});