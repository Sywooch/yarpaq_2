$(document).ready(function() {
	var animated = new Array('animated fadeInDown' , 'animated zoomIn', 'animated slideInLeft', 'animated fadeInUp', 'animated fadeInDown');
	if (!!$.prototype.bxSlider){
		if($("#homeslider").length >0){
			var config = $("#homeslider").data();
			$('#homeslider').bxSlider({
				mode			: config.mode,
	            useCSS			: (config.usecss == '1' ? true : false),
	            minSlides		: config.minslide,
	            maxSlides		: config.maxslide,
	            infiniteLoop	: (config.infiniteloop == '1' ? true : false),
	            hideControlOnEnd: (config.hidecontrolonend == '1' ? true : false),
	            pager			: (config.pager == '1' ? true : false),
	            autoHover		: (config.autohover == '1' ? true : false),
	            auto			: (config.auto == '1' ? true : false),
	            speed			: parseInt(config.speed),
	            pause			: parseInt(config.pause),
	            controls		: (config.controls == '1' ? true : false),
	            slideWidth		: config.slidewidth,
	            slideMargin		: parseInt(config.slidemargin),
	            nextText: '',
            	prevText: '',
				onSliderLoad: function(currentIndex) {
	                $('.homeslider-container').eq(currentIndex).find(".custom-animated").each(function(index) {
	                	$(this).show().addClass(animated[index]).attr('data-animated', animated[index]);
	                });
	            },
				onSlideAfter: function(slideElement, oldIndex, newIndex) {
	                slideElement.find(".custom-animated").each(function(index) {
	                	$(this).show().addClass(animated[index]).attr('data-animated', animated[index]);
	                });
	                /*
	                $('.bxslider-container').eq(oldIndex).find(".custom-animated").each(function(index) {
	                	$(this).hide().removeClass($(this).attr("data-animated"));
	                });
	                */
	            },
	            onSlideBefore: function(slideElement, oldIndex, newIndex) {
	                slideElement.find('.custom-animated').each(function() {
	                    $(this).hide().removeClass($(this).attr("data-animated"));
	                });
	            }
			});
		}


	}

/*


    if (typeof(homeslider_speed) == 'undefined')
        homeslider_speed = 500;
    if (typeof(homeslider_pause) == 'undefined')
        homeslider_pause = 3000;
    if (typeof(homeslider_loop) == 'undefined')
        homeslider_loop = true;
    if (typeof(homeslider_width) == 'undefined')
        homeslider_width = 779;
    $('.homeslider-description').click(function() {
        window.location.href = $(this).prev('a').prop('href');
    });
    var animated = new Array('animated fadeInDown', 'animated slideInLeft', 'animated zoomIn', 'animated fadeInUp', 'animated fadeInDown');
    if (!!$.prototype.bxSlider)
        $('#homeslider').bxSlider({
            useCSS: false,
            maxSlides: 1,
            infiniteLoop: homeslider_loop,
            hideControlOnEnd: true,
            pager: true,
            autoHover: true,
            auto: homeslider_loop,
            speed: parseInt(homeslider_speed),
            pause: homeslider_pause,
            controls: true,
            nextText: '<i class="fa fa-angle-right"></i>',
            prevText: '<i class="fa fa-angle-left"></i>',
            onSliderLoad: function(currentIndex) {
                var current = $('.homeslider-container').eq(currentIndex);
                current.find(".custom-animated").each(function(index) {
                    //var el = this;
                    $(this).show().addClass(animated[index]).attr('data-animated', animated[index])
                    // setTimeout(function() {
                        // $(el).show().addClass(animated[index]).attr('data-animated', animated[index]);
                    // }, (index * 500));
                });
            },
            onSlideBefore: function(slideElement, oldIndex, newIndex) {
                slideElement.find('.custom-animated').each(function() {
                    $(this).hide().removeClass($(this).attr("data-animated"));
                });
            },
            onSlideAfter: function(slideElement, oldIndex, newIndex) {
                slideElement.find(".custom-animated").each(function(index) {
                	$(this).show().addClass(animated[index]).attr('data-animated', animated[index]);

                    // var el = this;
                    // setTimeout(function() {
                        // $(el).show().addClass(animated[index]).attr('data-animated', animated[index]);
                    // }, (index * 500));
                });
            }
        });
        */

});
