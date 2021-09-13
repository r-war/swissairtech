
 jQuery(document).ready(function () {
     "use strict"

     /*  - Carouserl Slider Interval Speed
     ------------------------------------------------*/
     $("#menuzord").menuzord({
        align: "right",
	    effect: "slide",
		animation: "zoom-in"
     });
    /*  - End Of Carouserl Slider Interval Speed
    ------------------------------------------------*/

    /* ======== Counter About Page ====== */

    if( $().counterUp ){
        $('.counter').counterUp({
            delay: 10,
            time: 1000
        });
    }

    /* ========== Revo home 1 ============= */
    if( $().revolution ){
        var revapi;
        revapi = jQuery('.tp-banner').revolution({
            delay:9000,
            startwidth:1170,
            startheight:800,
            hideThumbs:10
        });
    }
    /*----------- Scroll to Feature Section ----------*/
    $('#go-to-next').on('click',function() {
        $('html,body').animate({scrollTop:$('#slider').offset().top - 70}, 1000);
    });
    /*----------- Scroll to Feature Section end ----------*/

    /* =========== Gallery Page ============ */

    if( $().magnificPopup ){

        $('.limo-gallery').magnificPopup({
            delegate: 'a',
            type: 'image',
            gallery:{
                enabled:true
            }
        });

        $('.owl-carousel').magnificPopup({
            delegate: 'a', // child items selector, by clicking on it popup will open
            type: 'image'
            // other options
        });
    }

    $('select').each(function(){
    var $this = $(this), numberOfOptions = $(this).children('option').length;

    $this.addClass('select-hidden');
    $this.wrap('<div class="select"></div>');
    $this.after('<div class="select-styled"></div>');

    var $styledSelect = $this.next('div.select-styled');
    $styledSelect.text($this.children('option').eq(0).text());

    var $list = $('<ul />', {
        'class': 'select-options'
    }).insertAfter($styledSelect);

    for (var i = 0; i < numberOfOptions; i++) {
        $('<li />', {
            text: $this.children('option').eq(i).text(),
            rel: $this.children('option').eq(i).val()
        }).appendTo($list);
    }

    var $listItems = $list.children('li');

    $styledSelect.on('click', function(e) {
        e.stopPropagation();
        $('div.select-styled.active').each(function(){
            $(this).removeClass('active').next('ul.select-options').hide();
        });
        $(this).toggleClass('active').next('ul.select-options').toggle();
    });

    $listItems.on('click', function(e) {
        e.stopPropagation();
        $styledSelect.text($(this).text()).removeClass('active');
        $this.val($(this).attr('rel'));
        $list.hide();
    });

    $(document).on('click', function() {
        $styledSelect.removeClass('active');
        $list.hide();
    });

});


     /*  - for search bar toggle
     ---------------------------------------------------*/
     $(".toggle-pade").on('click', function () {
         $(".form-group").toggle("slow");
     });
     /*  - for search bar toggle end
     ---------------------------------------------------*/


    /*  - Quote Slider
    ------------------------------------------------------*/
        var quoteSlider = $("#quote-slider");

        quoteSlider.owlCarousel({
        autoPlay : 3000,
        stopOnHover : true,
        pagination : true,
        paginationNumbers: false,

        navigation: true,
        navigationText: [
            "<i class='fa fa-angle-right icon-white'></i>",
            "<i class='fa fa-angle-left icon-white'></i>"
        ],

        itemsCustom : [
            [0, 1],
            [450, 1],
            [600, 1],
            [700, 1],
            [1000, 1],
            [1200, 1],
        ],
            // Responsive
            responsive: true,
            responsiveRefreshRate : 200,
            responsiveBaseWidth: window
        });

    /*  - Quote Slider End
    ---------------------------------------------------*/

    /*  - Quote Slider
    ---------------------------------------------------*/
     $('.this-section .owl-carousel').owlCarousel({
         loop: true, // loop is true up to 1199px screen.
         nav: false, // is true across all sizes
         margin: 0, // margin 10px till 960 breakpoint
         autoplay: true,
         responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
         responsive: {
             0: {
                 items: 1 // In this configuration 1 is enabled from 0px up to 479px screen size
             },
             1200: {
                 items: 5,
                 loop: false,
                 margin: 0,
             }
         }
     });
     /*  - End Of Quote Slider
     ---------------------------------------------------*/


     /*  - Car Details Slider
     ---------------------------------------------------*/
     var quoteSlider = $("#car-details-slider");

        quoteSlider.owlCarousel({
        autoPlay : 3000,
        stopOnHover : true,
        pagination : true,
        paginationNumbers: false,

        navigation: true,
        navigationText: [
            "<i class='fa fa-angle-right icon-white'></i>",
            "<i class='fa fa-angle-left icon-white'></i>"
        ],

        itemsCustom : [
            [0, 1],
            [450, 1],
            [600, 1],
            [700, 1],
            [1000, 1],
            [1200, 1],
        ],
            // Responsive
            responsive: true,
            responsiveRefreshRate : 200,
            responsiveBaseWidth: window
        });
    /*  - Car Details Slider
    ---------------------------------------------------*/

    $(".account").on('click', function()
        {
        var X=$(this).attr('id');

        if(X==1)
        {
        $(".submenu").hide();
        $(this).attr('id', '0');
        }
        else
        {

        $(".submenu").show();
        $(this).attr('id', '1');
        }

        });

        //Mouseup textarea false
        $(".submenu").mouseup(function()
        {
        return false
        });
        $(".account").mouseup(function()
        {
        return false
    });


    //Textarea without editing.
    $(document).mouseup(function() {
        $(".submenu").hide();
        $(".account").attr('id', '');
    });


 }); // Document Resdy Function End

jQuery(document).ready(function(){
    var submitIcon = $('.searchbox-icon');
    var inputBox = $('.searchbox-input');
    var searchBox = $('.searchbox');
    var isOpen = false;
    submitIcon.on('click', function(){
        if(isOpen == false){
            searchBox.addClass('searchbox-open');
            inputBox.focus();
            isOpen = true;
        } else {
            searchBox.removeClass('searchbox-open');
            inputBox.focusout();
            isOpen = false;
        }
    });
     submitIcon.mouseup(function(){
            return false;
        });
    searchBox.mouseup(function(){
            return false;
        });
    $(document).mouseup(function(){
        if(isOpen == true){
            $('.searchbox-icon').css('display','block');
            submitIcon.click();
        }
    });

    function buttonUp(){
        var inputVal = $('.searchbox-input').val();
        inputVal = $.trim(inputVal).length;
        if( inputVal !== 0){
            $('.searchbox-icon').css('display','none');
        } else {
            $('.searchbox-input').val('');
            $('.searchbox-icon').css('display','block');
        }
    }


    /*  - wow animation wow.js
    ---------------------------------------------------*/
     var wow = new WOW ({
          boxClass:     'wow',      // animated element css class (default is wow)
          animateClass: 'animated', // animation css class (default is animated)
          offset:       0,          // distance to the element when triggering the animation (default is 0)
          mobile:       false       // trigger animations on mobile devices (true is default)
       });
      //wow.init();
    /*  - wow animation wow.js End
    ---------------------------------------------------*/

});
