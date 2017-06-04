var is_mobile = false,
    headerClone = false,
    windowWidth = $(window).width();
jQuery(function($) {
    is_mobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? !0 : !1; /*if(is_mobile==true){$(".desktop-nav .menu-parent > a").attr("href","#");}*/
    $("ul.menu li").hoverIntent({

        over: function() {
            $(this).addClass("active")
        },
        out: function() {
            $(this).removeClass("active")
        },
        selector: "li",
        timeout: 145,
        interval: 55
    });
    $(".widget").hoverIntent({
        over: function() {
            $(this).addClass("active")
        },
        out: function() {
            $(this).removeClass("active")
        },
        timeout: 145,
        interval: 55
    });
    //responsiveHorizontalMenu();
    /*responsiveVerticalMenu();*/
    /*megamenusSetup();*/
    var url = window.location.href;
    $('.megamenus a[href="' + url + '"]').parent().addClass('actived');
    stickyMenu();
    $(document).on('click', '.vertical-toggle-menu', function() {
        $(this).closest('.megamenus').find('.menu').slideToggle("slow");
        return false;
    });


    $('.menu-button').on('click', function(){
        $('body').addClass('opened-menu');
        $('.opened-menu .close-header-layer').fadeIn(300);
        closePopups();
        return false;
    });

    $('.close-header-layer, .close-menu').on('click', function(){
        $('.navigation.disable-animation').removeClass('disable-animation');
        $('body').removeClass('opened-menu');
        $('header.opened').removeClass('opened');
        $('.close-header-layer:visible').fadeOut(300);
    });

    $(document).on('click', '.link-open-submenu', function(){
       var megacontent = $(this).next('.menu-megacontent');
        if(megacontent.hasClass('actived')){
            $(this).parent().removeClass('active');
            megacontent.removeClass('actived').slideUp(300);
            
        }else{
            $(this).parent().addClass('active');
            megacontent.addClass('actived').slideDown(300);
        }
    });

    $(document).on('click', '.vertical-responsive', function () {
        var vertical = $('.vertical-left-megamenu');
        if(vertical.hasClass('actived'))
            vertical.removeClass('actived');
        else{
            vertical.addClass('actived');
        }
    });
    $(document).on('click', '.horizontal-responsive', function () {
        var vertical = $(this).next('.horizontal-top-megamenu');
        if(vertical.hasClass('actived'))
            vertical.removeClass('actived').slideUp(300);
        else{
            vertical.addClass('actived').slideDown(300);
        }
    });

    $(document).on('click', '.nav-vertical-left-megamenu  .link-open-dropdown', function () {
        var parent = $(this).closest('.nav-vertical-left-megamenu');
        if(parent.hasClass('active')){
            $(".widgets-content").removeClass('widgets-content-active');
            parent.removeClass('active');
        } else{
          $(".widgets-content").addClass('widgets-content-active');
            parent.addClass('active');
        }
    });
});
function closePopups(){
    $('.popup.active').animate({'opacity':'0', 'visibility':'hidden'}, 300, function(){$(this).removeClass('active');});
}
function setMenuActived() {
    var path = window.location.pathname;
    path = path.replace(/\/$/, "");
    path = decodeURIComponent(path);
    $(".megamenus a").each(function() {
        var href = $(this).attr('href');
        if (path.substring(0, href.length) === href) {
            $(this).closest('li').addClass('actived');
        }
    });
}
$.event.special.debouncedresize ? $(window).on("debouncedresize", function() {
    if ($(window).width() != windowWidth) {
        /*$(".megamenu").removeAttr('style');*/
        windowWidth = $(window).width();
        /*megamenusSetup();*/
    }
    if (windowWidth > 991) {
        $(".vertical-left-megamenu").removeClass('actived').attr("style", '');
        $(".cat-link-orther").removeClass('showed').attr("style", '');
    } else {
        $(".cat-link-orther").addClass('showed');
    }


}) : $(window).on("resize", function() {
    if ($(window).width() != windowWidth) {
        /*$(".megamenu").removeAttr('style');*/
        windowWidth = $(window).width();
        /*megamenusSetup();*/
    }
    if (windowWidth > 991) {
        $(".vertical-left-megamenu").removeClass('actived').attr("style", '');
        $(".cat-link-orther").removeClass('showed').attr("style", '');

    } else {
        $(".cat-link-orther").addClass('showed');

    }

});

function containerWidth() {
    var $ = jQuery;
    var b = $(".container").width(),
        a = $(window).width();
    $('.container_width').each(function() {
        $(this).css({
            'left': -(a - b) / 2,
            'width': b,
            'visibility': 'visible'
        });
    });
}

function fullWidth() {
    var $ = jQuery;
    var b = $(window).width();
    $('.full_width').each(function() {
        $(this).css({
            'width': b,
            'visibility': 'visible'
        });
    });
}

function megamenusSetup() {
    if ($(".option5 .nav-vertical-left-megamenu").length > 0) {
        $(".nav-vertical-left-megamenu").each(function() {
            var a = $(".container").actual('width'),
                b = $(this).find('.vertical-left-megamenu').actual('width'),
                c = a - b;
            if (windowWidth >= 992) {
                var c = a - b;
                $(this).find('.megamenu').each(function() {
                    var t=$(this);
                    setTimeout(function () {
                        t.css('width',c+'px');
                    },1)
                });
            }
        });
    } else if ($(".option6 .nav-vertical-left-megamenu").length > 0) {
        $(".nav-vertical-left-megamenu").each(function() {
            var a = $(".container").actual('width'),
                b = $(this).find('.vertical-left-megamenu').actual('width'),
                c = a - b;
            if (windowWidth >= 992) {
                var c = a - b;
                $(this).find('.megamenu').each(function() {
                    var t=$(this);
                    setTimeout(function () {
                        t.css('width',c+'px');
                    },1)
                });
            }
        });
    } else {
        if ($(".nav-vertical-left-megamenu").length > 0) {
            $(".nav-vertical-left-megamenu").each(function() {
                var a = $(".container").actual('width'),
                    b = $(this).actual('width'),
                    c = a - b;
                if (windowWidth >= 992) {
                    var c = a - b;
                    $(this).find('.megamenu').each(function() {
                        var t=$(this);
                        setTimeout(function () {
                            t.css('width',c+'px');
                         },1)
                    });
                }
            });
        }
    }
}

function stickyMenu() {
    /*if (windowWidth > 991) {*/
        var b = this,
            c = $("#sticky-header");
        if (!headerClone) {}
        $.fn.waypoint && $('[data-fixed="fixed"]').waypoint("sticky", {
            stuckClass: "fixed",
            handler: function(direction) {
                if (direction == 'up') {
                    $(".sticky-item").each(function(index) {
                        var b = $(this).data('sticky');
                        var id = $(this).attr('id')
                        $('#' + id + ' > div, #' + id + ' > ul, #' + id + ' > nav').appendTo($("." + b));
                    });
                } else {
                    $(".sticky-item").each(function(index) {
                        var b = $(this).data('sticky');
                        $('.' + b + ' > div, .' + b + ' > ul, .' + b + ' > nav').appendTo($(this));
                    });
                }
            },
            offset: -400
        });
    /*}*/
}

function destroyStickyHeader() {
    if ($.fn.waypoint && windowWidth < 992) {
        $('[data-fixed="fixed"]').waypoint("unsticky");
    } else {
        stickyMenu();
    }
}