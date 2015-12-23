"use strict";
(function($) {

    jQuery(window).load(function() {
        jQuery(".loader").delay(500).fadeOut();
        jQuery("#mask").delay(1000).fadeOut("slow");
    });
	$(document).ready(function () {
        $('input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="month"], input[type="time"], input[type="week"]').each(function() {
            var el = this, type = $(el).attr('type');
            if ($(el).val() == '') $(el).attr('type', 'text');
            $(el).focus(function() {
                $(el).attr('type', type);
                el.click();
            });
            $(el).blur(function() {
                if ($(el).val() == '') $(el).attr('type', 'text');
            });
        });
        $( '.swipebox' ).swipebox();
        $('.megabutton').click(function(e) {
            $('.md-overlay').addClass('show');
            $('.modal-form').addClass('show');
            $('.md-overlay').on('click',function() {
                $(this).removeClass('show');
                $('.modal-form').removeClass('show');
            });
            e.preventDefault();
        });
        /*Validation*/  
        $("#contactform").validate({
            submitHandler: function(form) {
                $(form).ajaxSubmit();
                $(form).find('.formSent').show();
                $(form).find('input[type=text]').val('');
                $(form).find('input[type=email]').val('');
                $(form).find('textarea').val('');
            }
        });
        /*Validation*/  
        $("#reservationform").validate({
            submitHandler: function(form) {
                $(form).ajaxSubmit();
                $(form).find('.formSent').show();
                $(form).find('input[type=text]').val('');
                $(form).find('input[type=email]').val('');
                $(form).find('input[type=date]').val('');
                $(form).find('input[type=time]').val('');
                $(form).find('textarea').val('');
            }
        });

        
        if (!$('#ip-container').hasClass('single')) {
            $(window).bind("scroll", function(){ //when the user is scrolling...
                if ($(window).scrollTop() >= 100) { //header hide by scroll
                    $('#header').addClass('overflow');
                } else {
                    $('#header').removeClass('overflow');
                }
                if ($(window).scrollTop() >= ($('#owl-main').height()/2)) { //If user scroll entire home slider
                    $('#header').addClass('fixed');
                } else {
                    $('#header').removeClass('fixed');
                }
            });
        }

        if ($(".player").length>0) { //If there are video backgrounds
            $(".player").mb_YTPlayer();
        }

        /*Sections appears in scroll*/
        $('.jt_row').bind('inview', function(event, visible) {
            if (visible === true) {
                $(this).addClass('visible');
            }
        });

        $(window).scrollTop(1); //move scroll to fires inview events

        $(document).on('click', '.collapse.in .menu-item a', function() {
            $('.collapse').collapse('hide');
        });

    }); // End document ready
    
    $(document).ajaxComplete(function() {
        "use strict";
        $("#owl-project-single").owlCarousel({
            navigation: true,
            slideSpeed: 300,
            paginationSpeed: 400,
            singleItem: true
        });
        $(".close").click(function(e) {
            $('#ajax').html('').css('height','0px');
            e.preventDefault();
        });
    }); // End ajax complete

	$(window).load(function() {
        //Set Google maps 
        if ($('#maps').length>0) {wpgmappity_maps_loaded();}

        // Set video player buttons behaviour
        $(".player").each(function () { 
            var btn = $(this).find('.playstop');
            var player = $(this);
            if ($(this).getPlayer()==='undefined') {
                var state = $(this).getPlayer().getPlayerState();
            } else {state=1;}
            if (state==1) {
                btn.text('Pause');
                btn.addClass('stop')
            } else {
                btn.text('Play');
                btn.removeClass('stop');
            }
            if (btn.length>0) {
                btn.click(function(e) {
                    if ($(this).hasClass('stop')) {
                        player.pauseYTP();
                        btn.text('Play');
                    } else {
                        player.playYTP();
                        btn.text('Pause');
                    }   
                    $(this).toggleClass('stop');
                    e.preventDefault();
                });
            }
        });

    	$("#owl-main-text").owlCarousel({
    		autoPlay: 8000,
    		goToFirst: true,
    		goToFirstSpeed: 2000,
    		navigation: false,
    		slideSpeed: 700,
    		pagination: false,
    		transitionStyle: "fadeUp",
    		singleItem: true
    	});
        $('#home-slider').height($(window).height());
        $('.slider-parallax').css('padding-top', $(window).height() + 'px');
    	/* Home background slider */
		$("#owl-main").owlCarousel({
			autoPlay: 8000,
			navigation: true,
            goToFirst: true,
            goToFirstSpeed: 2000,
			slideSpeed: 100,
			pagination: true,
			transitionStyle: "fade",
			singleItem: true,
			afterInit: function() {
                $('#home-slider').height($(window).height());
                if (!$('#home-slider').hasClass('fixed-height')) {
                    $('#home-slider #owl-main .item').height($(window).height());
                    $('#home-slider #owl-main img').height($(window).height());
                } else {
                    $('#home-slider #owl-main .item').height(600);
                }
                
                $('#home-slider #owl-main img').width('auto');
                
                var left = ((($('#home-slider').width() - $('#home-slider #owl-main img').width())/2));
                if (left<0) {
                    $('#home-slider #owl-main img').css('top', '0px' );

                    $('#home-slider #owl-main img').css('left', left + 'px' );
                } else {
                    $('#home-slider #owl-main img').css('left', '0px' );
                    $('#home-slider #owl-main img').height('auto');
                    $('#home-slider #owl-main img').width($(window).width());
                    $('#home-slider #owl-main img').css('top', ((($('#home-slider').height() - $('#home-slider #owl-main img').height())/2)) + 'px' );
                }

            },
            afterUpdate: function() {
                $('#home-slider').height($(window).height());
                if (!$('#home-slider').hasClass('fixed-height')) {
                    $('#home-slider #owl-main .item').height($(window).height());
                    $('#home-slider #owl-main img').height($(window).height());
                } else {
                    $('#home-slider #owl-main .item').height(600);
                }
                $('#home-slider #owl-main img').width('auto');
                var left = ((($('#home-slider').width() - $('#home-slider #owl-main img').width())/2));
                if (left<0) {
                    $('#home-slider #owl-main img').css('top', '0px' );
                    $('#home-slider #owl-main img').css('left', left + 'px' );
                } else {
                    $('#home-slider #owl-main img').css('left', '0px' );
                    $('#home-slider #owl-main img').height('auto');
                    $('#home-slider #owl-main img').width($(window).width());
                    $('#home-slider #owl-main img').css('top', ((($('#home-slider').height() - $('#home-slider #owl-main img').height())/2)) + 'px' );
                }
            }
		});

        //Generic carousel
        $(".generic-carousel .jelly-carousel").owlCarousel({
            navigation : false,
            pagination: false,
            autoPlay: true,
            slideSpeed : 300,
            paginationSpeed : 400,
            singleItem : true,
            transitionStyle: "fade",
        });
        $(".with_pagination.with_buttons .jelly-carousel").owlCarousel({
            navigation : true,
            navigationText: [
            "<",
            ">"
            ],
            pagination: true,
            autoPlay: false,
            slideSpeed : 300,
            paginationSpeed : 400,
            singleItem : true,
        });
        $(".with_pagination.testimonials .generic-carousel").owlCarousel({
            navigation : false,
            pagination: true,
            autoPlay: false,
            slideSpeed : 300,
            paginationSpeed : 400,
            singleItem : true,
        });


        var $container = $('#folio');
        $container.isotope({
            itemSelector: '.folio-item'
        });
        var $optionSets = $('.folio-filter'),
            $optionLinks = $optionSets.find('a');
        $optionLinks.click(function() {
            var $this = $(this);
            if ($this.hasClass('selected')) {
                return false;
            }
            var $optionSet = $this.parents('.folio-filter');
            $optionSet.find('.selected').removeClass('selected');
            $this.addClass('selected');
            // make option object dynamically, i.e. { filter: '.my-filter-class' }
            var options = {},
                key = $optionSet.attr('data-option-key'),
                value = $this.attr('data-option-value');
            value = value === 'false' ? false : value;
            options[key] = value;
            if (key === 'layoutMode' && typeof changeLayoutMode === 'function') {
                changeLayoutMode($this, options);
            } else {
                $container.isotope(options);
            }
            return false;
        });
$(document).ready(function() {
    $("#owl-about2").owlCarousel({
      navigation : true,
      navigationText: [
      "<",
      ">"
      ],
      pagination: true,
      autoPlay: false,
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem : true,
    });
});



/**** GALLERY ****/


$(document).ready(function(){
    jQuery('a[data-gal]').each(function() {
    jQuery(this).attr('rel', jQuery(this).data('gal'));
});     
$("a[data-rel^='prettyPhoto']").prettyPhoto({animationSpeed:'slow',theme:'light_square',slideshow:false,overlay_gallery: false,social_tools:false,deeplinking:false});
}); 

var $container = $('.portfolio');
$container.isotope({
    filter: '*',
    animationOptions: {
        duration: 750,
        easing: 'linear',
        queue: false,
    }
});
 
$('nav.primary ul a').click(function(){
    var selector = $(this).attr('data-filter');
    $container.isotope({
        filter: selector,
        animationOptions: {
            duration: 750,
            easing: 'linear',
            queue: false,
        }
    });
  return false;
});
 
var $optionSets = $('nav.primary ul'),
       $optionLinks = $optionSets.find('a');
  
       $optionLinks.click(function(){
          var $this = $(this);
      // don't proceed if already selected
      if ( $this.hasClass('selected') ) {
          return false;
      }
   var $optionSet = $this.parents('nav.primary ul');
   $optionSet.find('.selected').removeClass('selected');
   $this.addClass('selected'); 
});
        if (!$('body').hasClass('single')) {
            $('#nav li').removeClass('current');
            $('#nav li:first-child').addClass('current');
        }
        /*Scroll to sections*/
        $('.blog li.current').removeClass('current');
        $('.page-template-multipage li.current').removeClass('current');
        $('.page-template-blog li.current').removeClass('current');
        $('.current-menu-item').addClass('current');
        if (!$('body').hasClass('single') && $('.current-menu-item').length==0) {
            $('#nav').onePageNav();
        }
    }); // End Window Load
    
    //Set home slider height on resize
    $(window).resize(function () { 
        $('#home-slider').height($(window).height());
        $('.slider-parallax').css('padding-top', $(window).height() + 'px');
    });

    function wpgmappity_maps_loaded() {
        /* googleMaps Footer Map */
        var bluegray = "#768FAC"
        var wine = "#B95D82"
        var black = "#999996"
        var green = "#77be32"
        var yellow = "#CBB774"
        var gold = "#BDA86B"
        var orange = "#fda527"
        var red = "#EE2C46"

        var color = (jellythemes.style=='elegant' && jellythemes.color.length==0) ? gold : red; // set your map color here! (blue, black, green, yellow, purple, orange...)
        var saturation = 100;

        var point = jellythemes.color.length>0 ? 'pointer-' + jellythemes.color : 'pointer-' + jellythemes.style;
        var pointerUrl = jellythemes.theme_path + '/images/map/'+point+'.png'; // set your color pointer here! (pointer-blue/green/yellow/fucsia/purple/turquoise/red/orange.png)
        color = jellythemes.color.length>0 ? jellythemes.color : color;
        switch(color) {
            case ('bluegray'):
            var color = bluegray;
            var saturation = 100;
            break;
        case ('black'):
            var color = black;
            var saturation = -100;
            break;
        case ('green'):
            var color = green;
            var saturation = 100;
            break;
        case ('yellow'):
            var color = yellow;
            var saturation = 100;
            break;
        case ('red'):
            var color = red;
            var saturation = 100;
            break;
        case ('turquoise'):
            var color = turquoise;
            var saturation = 100;
            break;
        case ('orange'):
            var color = orange;
            var saturation = 100;
            break;
        case ('purple'):
            var color = purple;
            var saturation = 100;
            break;
        } //end switch
        var latlng = new google.maps.LatLng($('#maps').data('lat'), $('#maps').data('lon')); <!-- (Fist Value Longitude, Second Value Latitude), can obtain YOUR coordenates here!: http://universimmedia.pagesperso-orange.fr/geo/loc.htm -->
        var styles = [
            {
                "featureType": "landscape",
                "stylers": [
                    {"hue": "#000"},
                    {"saturation": -100},
                    {"lightness": 40},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "road.highway",
                "stylers": [
                    {"hue": color},
                    {"saturation": saturation},
                    {"lightness": 20},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "road.arterial",
                "stylers": [
                    {"hue": color},
                    {"saturation": saturation},
                    {"lightness": 20},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "road.local",
                "stylers": [
                    {"hue": color},
                    {"saturation": saturation},
                    {"lightness": 50},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "water",
                "stylers": [
                    {"hue": "#000"},
                    {"saturation": -100},
                    {"lightness": 15},
                    {"gamma": 1}
                ]
            },
            {
                "featureType": "poi",
                "stylers": [
                    {"hue": "#000"},
                    {"saturation": -100},
                    {"lightness": 25},
                    {"gamma": 1}
                ]
            }
        ];
        var drag;
        if($(window).width()<796){drag=false;}else{drag=true;}
        var options = {
            center : latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoomControl : false,
            mapTypeControl : false,
            scaleControl : false,
            streetViewControl : false,
            draggable:drag,
            scrollwheel:false,
            panControl : false, zoom : 17,
            styles: styles
        };
        var wpgmappitymap = new google.maps.Map(document.getElementById('wpgmappitymap'), options);
        var point0 = new google.maps.LatLng($('#maps').data('lat'),$('#maps').data('lon')); 
        var marker0 = new google.maps.Marker({
            position : point0,
            map : wpgmappitymap,
            icon: pointerUrl //Custom Pointer URL
        });
        google.maps.event.addListener( marker0, 'click',
            function() {
                var infowindow = new google.maps.InfoWindow({content: $('#maps').data('marker')});
                infowindow.open(wpgmappitymap,marker0);
        });
    } // end wpgmappity_maps_loaded();


    /* Parallax */
    jQuery(document).ready(function($) {
        "use strict";
        if ($(window).width()>1024) {
            jQuery(window).bind("scroll", function(){//when the user is scrolling...
                /* Parallax */
                Move('.paraOn'); //move the background images in relation to the movement of the scrollbar
            });
        }
    });
    function Move(seccio){
        jQuery(seccio).each(function(){
            //var posY = jQuery(window).scrollTop()+jQuery(window).height()-jQuery(this).attr('yPos')/10+jQuery(this).height()+'px';
            //jQuery(this).css('background-position', '0 ' + posY);
            $(this).css('background-position', '0 '+(($(window).scrollTop()+$(window).height()-$(this).attr('yPos'))/3+$(this).height())+'px');


        });
    }
    jQuery('.parallax').bind('inview', function(event, visible) {
            if (visible === true) {
                // element is now visible in the viewport
                var offset = jQuery(this).offset();
                jQuery(this).addClass('paraOn').attr('yPos',offset.top);
            } else {
                // element has gone out of viewport
                jQuery(this).removeClass('paraOn');
            }
    });


    jQuery(document).ready(function(){
        jQuery(".corner").click(function(){
            jQuery('#customizer').toggleClass('s-open');
        });
    });

    function swapStyleSheet(sheet){
        document.getElementById('general-css').setAttribute('href', sheet);
    }
}(jQuery));



jQuery(document).ready(function($){
    // browser window scroll (in pixels) after which the "back to top" link is shown
    var offset = 7000,
        //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
        offset_opacity = 1200,
        //duration of the top scrolling animation (in ms)
        scroll_top_duration = 700,
        //grab the "back to top" link
        $back_to_top = $('.cd-top');

    //hide or show the "back to top" link
    $(window).scroll(function(){
        ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
        if( $(this).scrollTop() > offset_opacity ) { 
            $back_to_top.addClass('cd-fade-out');
        }
    });

    //smooth scroll to top
    $back_to_top.on('click', function(event){
        event.preventDefault();
        $('body,html').animate({
            scrollTop: 0 ,
            }, scroll_top_duration
        );
    });

});


    