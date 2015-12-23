// Avoid `console` errors in browsers that lack a console.
"use strict";

jQuery(window).load(function() {
	jQuery(".loader").delay(500).fadeOut();
	jQuery("#mask").delay(1000).fadeOut("slow");
});

jQuery(document).ready(function(){
	
	
	//dragable mobile
	var drag;
	if(jQuery(window).width()<796){drag=false;}else{drag=true;}	
	
	/* Color Picker */
	
	  //demo
	 jQuery('.picker-btn').click(function(){
	  if(jQuery('.color-picker').css('right')=='0px'){
	   jQuery('.color-picker').animate({ "right": "-223px" }, "slow" );
	  }else{
	   jQuery('.color-picker').animate({ "right": "0px" }, "slow" );
	  }
	 });
    setTimeout(function(){
    jQuery('.color-picker').animate({ "right": "-223px" }, "slow" );}, 4000);

 
    
	
	//var currentColor = 'red';
	//jQuery('body').addClass(currentColor);

	jQuery('.picker-bluegray').click(function(){
		jQuery('body').removeClass(currentColor);
		jQuery('body').addClass('bluegray');
		currentColor='bluegray';
		wpgmappity_maps_loaded();
	});
	jQuery('.picker-black').click(function(){
		jQuery('body').removeClass(currentColor);
		jQuery('body').addClass('black');
		currentColor='black';
		wpgmappity_maps_loaded();
	});
	jQuery('.picker-green').click(function(){
		jQuery('body').removeClass(currentColor);
		jQuery('body').addClass('green');
		currentColor='green';
		wpgmappity_maps_loaded();
	});
	jQuery('.picker-wine').click(function(){
		jQuery('body').removeClass(currentColor);
		jQuery('body').addClass('wine');
		currentColor='wine';
		wpgmappity_maps_loaded();
	});
	jQuery('.picker-yellow').click(function(){
		jQuery('body').removeClass(currentColor);
		jQuery('body').addClass('yellow');
		currentColor='yellow';
		wpgmappity_maps_loaded();
	});
	jQuery('.picker-gold').click(function(){
		jQuery('body').removeClass(currentColor);
		jQuery('body').addClass('gold');
		currentColor='gold';
		wpgmappity_maps_loaded();
	});
	jQuery('.picker-red').click(function(){
		jQuery('body').removeClass(currentColor);
		jQuery('body').addClass('red');
		currentColor='red';
		wpgmappity_maps_loaded();
	});
	jQuery('.picker-orange').click(function(){
		jQuery('body').removeClass(currentColor);
		jQuery('body').addClass('orange');
		currentColor='orange';
		wpgmappity_maps_loaded();
	});
	jQuery('.dark-version').click(function(){
		jQuery('body').addClass('darker');
	});
	jQuery('.light-version').click(function(){
		jQuery('body').removeClass('darker');
	});
	
	/* googleMaps Footer Map */
		var bluegray = "#768FAC"
		var wine = "#B95D82"
		var black = "#030303"
		var green = "#77be32"
		var yellow = "#CBB774"
		var gold = "#C5BB7B"
		var orange = "#fda527"
		var red = "#CA0021"

		var color = red // set your map color here! (blue, black, green, yellow, purple, orange...)
		var saturation = 100
		function wpgmappity_maps_loaded() {
			var pointerUrl = jellythemes.theme_path + '/images/map/pointer-'+currentColor+'.png' // set your color pointer here! (pointer-blue/green/yellow/fucsia/purple/turquoise/red/orange.png)
			switch(currentColor) {
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
            case ('gold'):
                var color = gold;
				var saturation = 100;
                break;
            case ('red'):
                var color = red;
				var saturation = 100;
                break;
            case ('orange'):
                var color = orange;
				var saturation = 100;
                break;
            case ('wine'):
                var color = wine;
				var saturation = 100;
                break;
        }	
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
		var marker0= new google.maps.Marker({
		 position : point0,
		 map : wpgmappitymap,
		 icon: pointerUrl //Custom Pointer URL
		 });
		google.maps.event.addListener(marker0,'click',
		 function() {
		 var infowindow = new google.maps.InfoWindow(
		 {content: 'undefined'});
		 infowindow.open(wpgmappitymap,marker0);
		 });
		}
		window.onload = function() {
		 wpgmappity_maps_loaded();
		};
	
	
	

		
	/* End */
});