$(document).ready(function() {

    var owl = $(".owl-carousel:not(.owl-three,.owl-one)");
    owl.owlCarousel({
        items: 5, //10 items above 1000px browser width

        itemsDesktop: [1199, 5], //5 items between 1400px and 1025px
        itemsDesktopSmall: [979, 4], // 2 items betweem 900px and 601px
        itemsTablet: [768, 2.5], //2 items between 600 and 480;
        itemsMobile: [479,2],
        rewindNav: false,
        navigation: true // itemsMobile disabled - inherit from itemsTablet option
    });
    $(".owl-three").owlCarousel({
        items:3, //10 items above 1000px browser width

        itemsDesktop: [1199, 3], //5 items between 1400px and 1025px
        itemsDesktopSmall: [980, 4], // 2 items betweem 900px and 601px
        itemsTablet: [768,2.5], //2 items between 600 and 0;
        itemsMobile: [479,2],
        rewindNav: false,
        navigation: true // itemsMobile disabled - inherit from itemsTablet option
    });
    $(".owl-one").owlCarousel({
        items:1, //10 items above 1000px browser width

        itemsDesktop: [1199, 1], //5 items between 1400px and 1025px
        itemsDesktopSmall: [980, 1], // 2 items betweem 900px and 601px
        itemsTablet: [768, 1], //2 items between 600 and 0;
        itemsMobile: [479, 1],
        rewindNav: false,
        navigation: true // itemsMobile disabled - inherit from itemsTablet option
    });
  //  $('#best_seller').tab('show');

    $(".product-icons i").mouseover(function(){
      var getText=$(this).data("text");
        var getParent=$(this).parents(".product-icons")[0];
        console.log(getParent);
        $( getParent).next(".hover_text").text(getText);
    });
    $(".product-icons i").mouseout(function(){

        $(".hover_text").text(' ');
    });
    displayReSize();
    setWidthProduct();
    if($('.quantity-input').val()==1){
        $('.sp-minus').addClass("disabled-sp");

    }
$('.cart-remove-btn').on('click', function(){
    $(this).parents('tr').remove();
});


$(document).mouseup(function (e)
{
    var container = $(".desktop-nav.vertical-left-megamenu");
    var container1 = $(".widgets-content");

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.parents('.nav-vertical-left-megamenu').removeClass('active');
        container1.removeClass('widgets-content-active');
    }
});
$(document).mouseup(function (e)
{
    var container = $(".desktop-nav.vertical-left-megamenu");
    var container1 = $(".widgets-content");
    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.removeClass('actived');
        container1.removeClass('widgets-content-active');
    }
});
})
function displayReSize(){
    if ( $(window).width() <= 600) {
        $(".search_query").attr('placeholder','Axtarış sözü ...');

    }
      else {
        $(".search_query").attr('placeholder','Axtarış sözünü burada yazın....');
    }

}


function setWidthProduct(){
    displayReSize();
    var widthProduct=$(".special-new-years .owl-item").width();
    $(".special-new-years .product_image").css({'height':widthProduct}) ;
    $(".special-new-years .product_image img").css({'height':widthProduct}) ;
}
$(window).resize(function() {
   // setWidthProduct();
    setInterval(setWidthProduct,10);
    displayReSize();
});
$('.product_tabs  a[href="#best_seller"]').tab('show');
$('.product-tab a[href="#comment_product"]').tab('show');

$(".cart-login .dropdown-cart").click(function(){
    if($(this).hasClass('open')){
        $(".widgets-content").removeClass('widgets-content-active');

    } else{
        $(".widgets-content").addClass('widgets-content-active');

    }
})
$(".border-list>li .toggle-down").click(function(){
    $(this).parent().toggleClass("active");
    $(this).children("i").toggleClass("fa-angle-down");
    $(this).children("i").toggleClass("fa-angle-up");
    $(this).parent().children(".angle-down-more").toggle(200);
});
$(".list-infoMenu>li").click(function(){
    $(this).toggleClass("active");
    $(this).children(".sub-infoMenu").toggle(200);
});

var sap = jQuery.noConflict();
sap('.sp-plus').on('click', function(){
    $('.sp-minus').removeClass("disabled-sp");
    var oldVal = sap('.quantity-input').val();
    var newVal = (parseInt(sap('.quantity-input').val(),10) +1);
    sap('.quantity-input').val(newVal);
});

sap('.sp-minus').on('click', function(){
    var oldVal = sap('.quantity-input').val();
    var newVal = (parseInt(sap('.quantity-input').val(),10) -1);
    if (oldVal > 1) {
        var newVal = parseFloat(oldVal) - 1;
        $(this).removeClass("disabled-sp");
    } else {
        var newVal = 1;
        $(this).addClass("disabled-sp");
    }
    sap('.quantity-input').val(newVal);
});

var $ = jQuery.noConflict();
function getName (str){
    if (str.lastIndexOf('\\')){
        var i = str.lastIndexOf('\\')+1;
    }
    else{
        var i = str.lastIndexOf('/')+1;
    }
    var filename = str.slice(i);
    var uploaded = document.getElementsByClassName("fileformlabel")[0];
    uploaded.innerHTML = filename;
}
$(".product-filter_elem .button-view>button").click(function(){
    $(".product-filter_elem .button-view>button").removeClass("active");
    $(this).addClass("active");
    if(this.id=='list-view'){

        $(".categoryProductsAll>div").attr("class",'col-lg-12 col-md-12 list');
        $(".categoryProductsAll .product_image").attr("class",'col-lg-3 col-md-3 col-sm-5 col-xs-4 no-padding-left product_image2');
        $(".categoryProductsAll .product_info").attr('class','col-lg-5 col-md-6  col-sm-7  col-xs-8 description-product');
        $(".categoryProductsAll .operations-order").attr('class','col-lg-3 col-md-3 operations-order');

    }else{

        $('.categoryProductsAll .product_image2').attr("class",'product_image');
        $(".categoryProductsAll>div").attr("class",'col-lg-3 col-md-3 col-sm-4 col-xs-4');
        $(".categoryProductsAll .description-product").attr('class','product_info');

        $(".categoryProductsAll .operations-order").attr('class','operations-order');

    }
})
$("#range_02").ionRangeSlider({

    min: 0,
    max: 450,
    from: 330
});
$(".photo_container>a").click( function(){
    $(".photo_container a").removeClass("activeThumb");
    $(this).addClass("activeThumb");
});
$(".filter-btn").click(function(){
    $(".widgets-content").toggleClass("widgets-content-active");
    $("aside").toggleClass("filter-panel")
})

$(".hide-footer").click(function(){
    $(".must-hide").slideToggle();
    $(".hide-footer").toggleClass("show-footer");

    $(".hide-footer .fa").attr("class","fa fa-angle-down");
    $(".show-footer .fa").attr("class","fa fa-angle-up");
})




  $(window).load(function(){
         $(".desktop-nav").swipe({
              swipeStatus:function(event, phase, direction, distance, duration, fingers)
                  {
                      if (phase=="move" && direction =="right") {
                           $(".containers").addClass("open-sidebar");
                           return false;
                      }
                      if (phase=="move" && direction =="left") {
                           $(".containers").removeClass("open-sidebar");
                           return false;
                      }
                  }
          }); 
      });



  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

