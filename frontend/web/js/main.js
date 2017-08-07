var isMobile = false; //initiate as false
// device detection
if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
	|| /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;

var _window = $(window),
	window_height = _window.height();


/* Index slider begin */


if ($("#index_slider").length > 0) {
    // Slider Arrays
    var arr_src = [],
    arr_link = [],
    slider_length = $("#index_slider .bullets a").length;
    for (var i = 0; i < slider_length; i++) {
        arr_src.push($("#index_slider .bullets a").eq(i).attr("href"));
        arr_link.push($("#index_slider .bullets a").eq(i).data("link"));
    }
}


run_slider = function(slider_index, _this, direction) {
    if ($(this).hasClass("active")) {} else {
        $("#index_slider").addClass("preload");
        $("#index_slider").addClass("animated");
        $("#index_slider .bullets a").removeClass("active");
        _this.addClass("active");
        if (direction == true) {
            $("#index_slider .image").prepend("<div style='left:100%'><a href="+arr_link[slider_index]+"><img src='"+arr_src[slider_index]+"' alt='' /></a></div>");
        } else {
            $("#index_slider .image").prepend("<div style='left:-100%'><a href="+arr_link[slider_index]+"><img src='"+arr_src[slider_index]+"' alt='' /></a></div>");
        }


        $("#index_slider .image img").eq(0).load(function(){
            $("#index_slider").removeClass("preload");

            if (direction == true) { 
                $("#index_slider .image > div").eq(1).animate({"left": "-100%"}, 600);

                //$("#index_slider .image > div").eq(1).find("img").eq(0).animate({"left": "150%"}, 600);
                //$("#index_slider .image > div").eq(1).find("img").eq(1).animate({"left": "150%", "opacity": "show"}, 600);
            } else {
                $("#index_slider .image > div").eq(1).animate({"left": "100%"}, 600);

                //$("#index_slider .image > div").eq(1).find("img").eq(0).animate({"left": "-50%"}, 600);
                //$("#index_slider .image > div").eq(1).find("img").eq(1).animate({"left": "-50%", "opacity": "show"}, 600);
            }

            $("#index_slider .image > div").eq(0).animate({"left": "0"}, 600);

            setTimeout(function(){
                $("#index_slider .image > div").eq(1).remove();
                $("#index_slider .image > div").css('left','');
                $("#index_slider").removeClass("animated");


            }, 600);
        });
    }
}

    $(document).on( "click", "#index_slider .bullets a", function() {
	    if ($("#index_slider").hasClass("animated")) {} else {
	        var slider_index = $(this).index(),
	        _this = $(this),
            _this_index = $("#index_slider .bullets a.active").index();
            console.log(slider_index)
            if (_this_index > slider_index) {
                direction = true;
            } else {
                direction = false;
            }


	    }
	    return false;
	});


    $(document).on( "click", "#index_slider .arrows a", function() {
		var slider_index = $("#index_slider .bullets a.active").index();


		bullet_active = slider_index;


		if ($(this).hasClass("next")) {
			bullet_active--;
			if (bullet_active == -1) {
				bullet_active = slider_length-1;
			}
			direction = false;
		} else {
			bullet_active++;
			if (bullet_active == slider_length) {
				bullet_active = 0;
			}
			direction = true;
		}

		var _this = $("#index_slider .bullets a").eq(bullet_active);
	    run_slider(slider_index, _this, direction);        
		//$("#index_slider .bullets a").eq(bullet_active).click();
		return false;
	});





$("#index_slider").mouseover(function(){
    window.C_MOUSE_OVER = true;
}).mouseleave(function(){
    window.C_MOUSE_OVER = false;
    window.C_MOUSE_LEAVE = true;
	if(_window.width() < 769) {
		window.C_MOUSE_OVER = true;
	}
});

$("#index_slider").mousemove(function(){
    window.C_MOUSE_OVER = true;
});

_window.resize(function(){
	if(_window.width() < 769) {
   		window.C_MOUSE_OVER = true;
	}
});

if(_window.width() < 769) {
	window.C_MOUSE_OVER = true;
}


function main_carousel_interval() {
    main_intervalus = setInterval( function() {
        if (window.C_MOUSE_OVER) {
            return;
        }
    	$("#index_slider .arrows a.next").click();

    }, 15000);
}

setTimeout( function() {
    if ($(window).width() > 768) {
        main_carousel_interval();
    }
}, 300);

/* Index slider end */



/* Team carousel begin */

	$(".product_carusel .arrows a").click(function(){
		var _this = $(this),
		_this_carusel = _this.parents(".product_carusel"),
		direction = _this.attr("class"),
		item_lenght = _this_carusel.find(".swipe li").length,
		item_width = _this_carusel.find(".swipe li").width();
		if (_this_carusel.find(".swipe ul").hasClass("animation_go")) {} else {
			team_slide(direction, item_width, item_lenght, _this_carusel);
		}

		
		return false;
	});

	$(".product_carusel").on("swipeleft",function(){
		$(this).find(".arrows a.next").click();
	}).on("swiperight",function(){
		$(this).find(".arrows a.prev").click();
	});

	function team_slide(direction, item_width, item_lenght, _this_carusel) {
		_this_carusel.find(".swipe ul").addClass("animation_go");
		_this_carusel.find(".swipe").addClass("overflow");
		if (direction=="next") {
			_this_carusel.find(".swipe ul").css("left", -(item_width*2)+"px");
			setTimeout(function(){
				_this_carusel.find(".swipe ul").removeClass("animation_go");
				_this_carusel.find(".swipe li").eq(0).clone().appendTo(_this_carusel.find(".swipe ul"));
				_this_carusel.find(".swipe li").eq(0).remove();
				_this_carusel.find(".swipe ul").removeAttr("style");
				_this_carusel.find(".swipe").removeClass("overflow");
			}, 450);
		} else {
			_this_carusel.find(".swipe ul").css("left", -(item_width*0)+"px");
			setTimeout(function(){
				_this_carusel.find(".swipe ul").removeClass("animation_go");
				_this_carusel.find(".swipe li").eq(item_lenght-1).clone().prependTo(_this_carusel.find(".swipe ul"));
				_this_carusel.find(".swipe li").eq(item_lenght).remove();
				_this_carusel.find(".swipe ul").removeAttr("style");
				_this_carusel.find(".swipe").removeClass("overflow");
			}, 450);
		}
	}

/* Team carousel end */


/* Full nav begin */

	$(".nav_trigger").mouseover(function(){
		if (_window.width() > 921) {
			$(this).addClass("active");
			$(".full_nav, .darkness_nav").addClass("show_me");			
		}
	}).mouseleave(function(){
		if (_window.width() > 921) {
			$(".nav_trigger").removeClass("active");
			$(".full_nav, .darkness_nav").removeClass("show_me");
		}
	});

	$(".full_nav .left_side .categories_list ul li a, .full_nav .left_side .top_categories > ul > li > a").mouseover(function(){
		if (_window.width() > 992) {
			var _this = $(this),
			_this_nav = _this.next().find(">*").html();

			$(".full_nav .right_side").addClass("show_me");
			$(".full_nav .right_side nav").html(_this_nav);
		}
	});

	$(".full_nav").mouseleave(function(){
		$(".full_nav .right_side").removeClass("show_me");
		$(".full_nav .right_side nav").html("");
	});

	$(document).on('mouseout', '.full_nav, .nav_trigger', function(){
        $("body").on("click",navHide);
    });
    $(document).on('mouseover', '.full_nav, .nav_trigger', function(){
        $("body").off("click",navHide);
    })
    function navHide(){
    	if ($(".nav_trigger").hasClass("active")) {
        	$(".nav_trigger a").click();
    	}
    }		


	$(".full_nav").on("swipeleft",function(){
		if (isMobile) {
			$("a.toggler").click();
		}
	}).on("swiperight",function(){

	});



/* Full nav end */



/* Adaptive JS begin */
	
	var _logo_width = $("header#header .second > div h1.logo").width(),
	_nav_trigger_width = $(".nav_trigger").width(),
	_sign_link_width = $(".sign_link").width(),
	_basket_link_width = $(".basket_link").width(),


	_search_width = $("header#header .second > div").width() - _logo_width - _nav_trigger_width - _sign_link_width - _basket_link_width - 20;
	
	if (_window.width() < 922) {
		_search_width = _search_width - 50;
	}

	$(".head_search").css("width", _search_width+"px");

	_window.resize(function(){
		var _logo_width = $("header#header .second > div h1.logo").width(),
		_nav_trigger_width = $(".nav_trigger").width(),
		_sign_link_width = $(".sign_link").width(),
		_basket_link_width = $(".basket_link").width(),
		_search_width = $("header#header .second > div").width() - _logo_width - _nav_trigger_width - _sign_link_width - _basket_link_width - 20;
		
		if (_window.width() < 922) {
			_search_width = _search_width - 50;
		}

		$(".head_search").css("width", _search_width+"px");
	});

/* Adaptive JS end */


/* Nav begin */
	
	$("a.toggler").click(function(){
		var _this = $(this);
		if (_this.hasClass("active")) {
			_this.removeClass("active_last");
			setTimeout(function(){
				_this.removeClass("active_second");
			}, 300);
			setTimeout(function(){
				_this.removeClass("active");
			}, 600);
			$("body").removeClass("overflow");
			$("body").removeClass("mobile_nav");
			$(".full_nav").removeClass("show_me").removeAttr("style");
			$(".full_nav *").removeClass("active");
		} else {
			_this.addClass("active");
			setTimeout(function(){
				_this.addClass("active_second");
			}, 300);
			setTimeout(function(){
				_this.addClass("active_last");
			}, 600);

			$(".full_nav").addClass("show_me");
			$(".full_nav").css("height", _window.height()+"px");

			$("body").addClass("overflow");
			$("body").addClass("mobile_nav");
		}
		return false;
	});

	$(".full_nav .left_side .categories_list > ul > li > a").click(function(){
		if (_window.width() < 992) {
			var _this = $(this);
			if (_this.hasClass("active")) {
				$(".full_nav .left_side .categories_list > ul > li > a").removeClass("active");
				$(".full_nav .left_side .categories_list > ul > li > div").removeClass("active");
				$(".full_nav .left_side .categories_list > ul > li > div article h3 a").removeClass("active");
				$(".full_nav .left_side .categories_list > ul > li > div article ul").removeClass("active");
			} else {
				$(".full_nav .left_side .categories_list > ul > li > a").removeClass("active");
				$(".full_nav .left_side .categories_list > ul > li > div").removeClass("active");
				_this.addClass("active");
				_this.next().addClass("active");
			}
			return false;
		}
	});

	$(".full_nav .left_side .categories_list > ul > li > div article h3 a").click(function(){
		if (_window.width() < 992) {
			var _this = $(this);
			if (_this.hasClass("active")) {
				$(".full_nav .left_side .categories_list > ul > li > div article h3 a").removeClass("active");
				$(".full_nav .left_side .categories_list > ul > li > div article ul").removeClass("active");
			} else {
				$(".full_nav .left_side .categories_list > ul > li > div article h3 a").removeClass("active");
				$(".full_nav .left_side .categories_list > ul > li > div article ul").removeClass("active");
				_this.addClass("active");
				_this.parent().next().addClass("active");
			}
			return false;
		}
	});

/* Nav end */


/* Search mobile begin */

	$(".search_toggler").click(function(){
		$("body").addClass("overflow");
		$(".head_search").addClass("show_me");
		$("a.toggler").hide();
		return false;
	});

	$(".head_search a.close").click(function(){
		$("body").removeClass("overflow");
		$(".head_search").removeClass("show_me");
		$("a.toggler").show();
		return false;
	});


/* Search mobile end */


/* Go up begin */
$(".second_footer a.up").click(function(){
	$('html, body').animate({
            scrollTop: 0
    }, 900); 
	return false;
});
/* Go up end */


/* Mobile categories begin */
if ($(".mobile_categories").length) {
	$(".mobile_categories ul").imagesLoaded(function(){
		$(".mobile_categories ul").css("width", ((($(".mobile_categories ul li").width()+8)*$(".mobile_categories ul li").length)+8)+"px");
	});
}

_window.resize(function(){
	if ($(".mobile_categories").length) {
		$(".mobile_categories ul").imagesLoaded(function(){
			$(".mobile_categories ul").css("width", ((($(".mobile_categories ul li").width()+8)*$(".mobile_categories ul li").length)+8)+"px");
		});
	}
});
/* Mobile categories end */




/* Sign in modal begin */

	$(".sign_in_dropdown > div .login a").click(function(){
		$("body").addClass("overflow");
		$(".darkness").addClass("show_me");
		setTimeout(function(){
			$(".signin_modal").addClass("show_me");
			$(".sign_link > a").removeClass("active");
		}, 300);
		return false;
	});

	$(".signin_modal a.close").click(function(){
		$("body").removeClass("overflow");
		$(".signin_modal").removeClass("show_me");
		setTimeout(function(){
			$(".darkness").removeClass("show_me");
		}, 300);
		return false;
	});

	$(".sign_link > a").click(function(){
		
		var _this = $(this);
		if (_this.hasClass("active")) {
			_this.removeClass("active");
			
		} else {
			_this.addClass("active");
		}
		
		return false;
	});

	$(document).on('mouseout', '.sign_link', function(){
        $("body").on("click",signHide);
    });
    $(document).on('mouseover', '.sign_link', function(){
        $("body").off("click",signHide);
    })
    function signHide(){
    	if ($(".sign_link > a").hasClass("active")) {
        	$(".sign_link > a").click();
    	}
    }

    $(".darkness").click(function(){
    	if ($(".signin_modal").hasClass("show_me")) {
    		$(".signin_modal a.close").click();
    	}
    });

/* Sign in modal end */

/* Comment modal begin */

	$(".open_comment_modal").click(function(){
		$("body").addClass("overflow");
		$(".darkness").addClass("show_me");
		setTimeout(function(){
			$(".comment_modal").addClass("show_me");
		}, 300);
		return false;
	});

	$(".comment_modal a.close").click(function(){
		$("body").removeClass("overflow");
		$(".comment_modal").removeClass("show_me");
		setTimeout(function(){
			$(".darkness").removeClass("show_me");
		}, 300);
		return false;
	});

/* Comment modal end */


/* Scroll up begin */
    $("a.back_to_top").click(function(){
        $('html, body').animate({
            scrollTop: 0
        }, 900); 
        return false;
    });
    _window.scroll(function(){
        var top_pos = document.documentElement.scrollTop||document.body.scrollTop;
        if (top_pos > _window.height()) {
            $("a.back_to_top").addClass("show_me");
        } else {
            $("a.back_to_top").removeClass("show_me");
        }
    });
/* Scroll up end */


/* Sort by begin */

    $(".sort_by ul a").click(function(){
        var _this = $(this),
        _this_index = _this.parent().index(),
        _this_text = _this.text();
        $(".sort_by > a span").text(_this_text);
        $(".sort_by ul a").removeClass("active");
        _this.addClass("active");
        //reload_emulation();

        return false;
    });

/* Sort by end */


/* Price slider begin */
	$("#price_slider").ionRangeSlider({
	    hide_min_max: true,
	    keyboard: true,
	    min: 0,
	    max: 5000,
	    from: 1000,
	    to: 4000,
	    type: 'double',
	    step: 1,
	    grid: true
	});
/* Price slider end */


/* Filtre mobile begin */
	
	$(".product_header_mobile a.filtre").click(function(){
		$("aside.aside_filter, .darkness").addClass("show_me");
		$("body").addClass("overflow");
		$(".filters_block").css("height", (_window.height()-105)+"px");
		return false;
	});
	
	$("aside.aside_filter footer a").click(function(){
		$("aside.aside_filter, .darkness").removeClass("show_me");
		$("body").removeClass("overflow");
		$(".filters_block").css("height", (_window.height()-105)+"px");
		return false;
	});

/* Filtre mobile end */


/* Product gallery begin */

$(".priduct_gallery .thumbnails li a").click(function(){
        var  _this = $(this),
        src = _this.attr("href"),
        _this_index = _this.parent().index(),
        previous = $(".priduct_gallery .thumbnails li a.active").parent().index();
        if (_this.hasClass("active")) {} else {
            $(".priduct_gallery .thumbnails li a").removeClass("active");
            _this.addClass("active");
            if (_this_index > previous) {
                $(".priduct_gallery .image").append("<div style='left: "+$(".priduct_gallery").width()+"px'><img src='"+src+"' alt='' /></div>");
            } else {
                $(".priduct_gallery .image").append("<div style='left: -"+$(".priduct_gallery").width()+"px'><img src='"+src+"' alt='' /></div>");
            }

            $(".priduct_gallery .image > div + div img").load(function(){
                $(".priduct_gallery .image > div + div").css("left", "0");
                if (_this_index > previous) {
                    $(".priduct_gallery .image > div:first-child").css("left", "-100%");
                } else {
                    $(".priduct_gallery .image > div:first-child").css("left", "100%");
                }
                setTimeout(function(){
                    $(".priduct_gallery .image > div:first-child").remove();
                }, 300);
            });            
        }
        return false;
    });

/* Product gallery end */


/* Product tabs begin */

	$(".product_infos .tabs ul li a").click(function(){
		var _this = $(this),
		_this_index = _this.parent().index();
		$(".product_infos .tabs ul li a").removeClass("active");
		_this.addClass("active");
		$(".product_infos .inner > div").removeClass("active").eq(_this_index).addClass("active");
		return false;
	});

/* Product tabs end */


/* Payment select begin */

	$(".methods_list ul li label input").change(function(){
		$(".methods_list ul li").removeClass("active").eq($(".methods_list ul li label input:checked").parent().parent().index()).addClass("active");
	});

	$(".methods_list ul li > div a").click(function(){
		$(this).parent().find("a").removeClass("active");
		$(this).addClass("active");
		return false;
	});

/* Payment select end */

/* Size select begin */
	$(".size_select ul li a").click(function(){
		var _this_name = $(this).text();
		$(this).parent().parent().find("a").removeClass("active");
		$(this).addClass("active");
		$(this).parent().parent().prev().find("em").html(_this_name);
		return false;
	});
/* Size select end */

/* Color select begin */
	$(".color_select ul li a").click(function(){
		var _this_style = $(this).find("em").attr("style");
		$(this).parent().parent().find("a").removeClass("active");
		$(this).addClass("active");
		$(this).parent().parent().prev().find("em").attr("style", _this_style);
		return false;
	});
/* Color select end */