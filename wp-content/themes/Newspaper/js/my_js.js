
jQuery(document).ready(function(jQuery) {

	// fix sidebar
	var windowz = jQuery(window);
	var hasWidget = jQuery('.td-main-sidebar').length;
	var isStick = !(jQuery(".td-main-sidebar").hasClass('nonStick'));
	var isMobile = windowz.outerWidth() < 768;
	if(windowz.outerWidth() > 768 && isStick){
	  if(hasWidget){
		jQuery(".td-pb-span3.td-main-sidebar .td-ss-main-sidebar").stick_in_parent({parent: ".td-main-content-wrap > .td-container > .td-pb-row"});	  	
	  }
	  jQuery(".td-pb-span3.td-main-sidebar").addClass('position');
	}
	if(!isMobile){
		console.log(jQuery('.td-pb-span3.td-main-sidebar .td-ss-main-sidebar').outerHeight());
		console.log(jQuery('.td-pb-span9.td-main-content').outerHeight());
		var isTaller = jQuery('.td-pb-span3.td-main-sidebar .td-ss-main-sidebar').outerHeight() > jQuery('.td-pb-span9.td-main-content').outerHeight();
		console.log(isTaller);
		if(isTaller){
			console.log("inner");
			jQuery('.td-main-sidebar').css("position","static");
		}
	}
	// end fix sidebar
	// owl carousel
    jQuery('.oul-product ul.products').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            500:{
                items:2
            },
            600:{
                items:3
            },
            1000:{
                items:4
            },
            1600:{
                items:5
            },
            2000:{
                items:5
            }
        }
    });

if(windowz.outerWidth() > 768 && isStick){   
    jQuery('section.related.products ul.products').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            500:{
                items:2
            },
            600:{
                items:3
            },
            1000:{
                items:4
            },
            1600:{
                items:4
            },
            2000:{
                items:4
            }
        }
    });
};
    // owl carousel end

    //slide thumbnail product
windowz.on('load', function(){
jQuery('#carousel').flexslider({
animation: "slide",
controlNav: false,
animationLoop: true,
slideshow: true,
itemWidth: 150,
itemMargin: 5,
asNavFor: '#slider'
});  
jQuery('#slider').flexslider({
animation: "slide",
controlNav: false,
animationLoop: true,
slideshow: true,
slideshowSpeed: 3000,
animationSpeed:600,
sync: "#carousel"
});
})
    //slide thumbnail product end

});


