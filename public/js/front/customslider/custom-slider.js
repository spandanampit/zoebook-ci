
var mycarousal = '';
// Slider
jQuery(document).ready(function () {
	// window.slider= jQuery("#carousel").parent().html();
     mycarousal = jQuery("#carousel").waterwheelCarousel({
        flankingItems: 2,
		 // number tweeks to change apperance
        startingItem: 1, // item to place in the center of the carousel. Set to 0 for auto
        separation: 390, // distance between items in carousel
        separationMultiplier: 0.82, // multipled by separation distance to increase/decrease distance for each additional item
        horizonOffset: 0, // offset each item from the "horizon" by this amount (causes arching)
        horizonOffsetMultiplier: 1, // multipled by horizon offset to increase/decrease offset for each additional item
        sizeMultiplier: 0.75, // determines how drastically the size of each item changes
        opacityMultiplier: 1, // determines how drastically the opacity of each item changes
        horizon: 0, // how "far in" the horizontal/vertical horizon should be set from the container wall. 0 for auto
        movingToCenter: function ($item) {
            jQuery('#callback-output').prepend('movingToCenter: ' + $item.attr('id') + '<br/>');
        },
        movedToCenter: function ($item) {
            jQuery('#callback-output').prepend('movedToCenter: ' + $item.attr('id') + '<br/>');
        },
        movingFromCenter: function ($item) {
            jQuery('#callback-output').prepend('movingFromCenter: ' + $item.attr('id') + '<br/>');
        },
        movedFromCenter: function ($item) {
            jQuery('#callback-output').prepend('movedFromCenter: ' + $item.attr('id') + '<br/>');
        },
        clickedCenter: function ($item) {
            jQuery('#callback-output').prepend('clickedCenter: ' + $item.attr('id') + '<br/>');
        }
    });

// debugger
    jQuery('.toggle-prev').bind('click', function () {
        mycarousal.prev();
        return false
    });

    jQuery('.toggle-next').bind('click', function () {
        mycarousal.next();
        return false;
    });


});

