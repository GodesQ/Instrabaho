(function ($) {
	"use strict";
	var owl_rtl = false;
	$(document).ready(function(){
		if ( $( ".project-sidebar .panel-body, .service-side .panel-body" ).length )
		{
			$(".project-sidebar .panel-body, .service-side .panel-body").niceScroll();
		}
	});
	$(document).ready(function(){
		if ( $( ".popup-video" ).length )
		{
			jQuery("a.popup-video").YouTubePopUp( { autoplay: 0 } );
		}
		
		if ( $( ".services-range-slider" ).length )
		{
			var $servicesRange = $(".services-range-slider"),
			$servicesInputFrom = $(".services-input-from"),
			$servicesInputTo = $(".services-input-to"),
			instance,
			min = 0,
			max = 20000,
			from = 0,
			to = 0;
			$servicesRange.ionRangeSlider({
				skin: "round",
				type: "double",
				min: min,
				max: max,
				from: 0,
				to: 20000,
				onStart: updateInputs,
				onChange: updateInputs
			});
			instance = $servicesRange.data("ionRangeSlider");
			function updateInputs (data) {
				from = data.from;
				to = data.to;
				
				$servicesInputFrom.prop("value", from);
				$servicesInputTo.prop("value", to);	
			}
			$servicesInputFrom.on("input", function () {
				var val = $(this).prop("value");
				
				if (val < min) {
					val = min;
				} else if (val > to) {
					val = to;
				}
				
				instance.update({
					from: val
				});
			});
			$servicesInputTo.on("input", function () {
				var val = $(this).prop("value");
				
				if (val < from) {
					val = from;
				} else if (val > max) {
					val = max;
				}
				
				instance.update({
					to: val
				});
			});
		}			
		$( ".show-skills" ).on( "click", function() {
				$( this ).parent().addClass('active');
			    $(this).hide();
			});
	});
	$.protip();
	$('select').select2();
	$('.btn').on('click', function() {
    var $this = $(this);
	  $this.button('loading');
		setTimeout(function() {
		   $this.button('reset');
	   }, 8000);
	});
	var $container = $('.grid');
	$container.imagesLoaded(function(){
	  $container.masonry({
		itemSelector : '.grid-item',
		percentPosition: true,
		layoutMode: 'masonry',
		transitionDuration: '0.7s',
	  });
	});
	
$(document).ready(function(){
  $("a.scroll").on('click', function(event) {
		if (this.hash !== "") {
		  event.preventDefault();
	
		  var hash = this.hash;
	
		  $('html, body').animate({
			scrollTop: $(hash).offset().top
		  }, 800, function(){
			window.location.hash = hash;
		  });
		} 
	  });
});
/*FRONT END JAVASCRIPT*/
if ( $( ".client-slider" ).length )
{
	$('.client-slider').owlCarousel({
		loop: true,
		margin: 10,
		autoplay: true,
		nav: true,
		dots:true,
		rtl:owl_rtl,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 1
			}
		}
	});
}
if ( $( ".sign-in" ).length )
{
	$('.sign-in').owlCarousel({
		loop: true,
		margin: 0,
		autoplay: false,
		nav: true,
		rtl:owl_rtl,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 1
			}
		}
	});
}

/* owl-carousel comments*/
if ( $( ".explore-slider" ).length )
{
	$('.explore-slider').owlCarousel({
		loop: false,
		margin: 10,
		autoplay: false,
		nav: false,
		rtl:owl_rtl,
		navText: ["<i class='fas fa-long-arrow-alt-left'></i>", "<i class='fas fa-long-arrow-alt-right'></i>"],
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 2
			},
			1000: {
				items: 3
			},
			1200: {
				items: 4
			}
		}
	});
}
if ( $( ".top-lancer-slider" ).length )
{
	$('.top-lancer-slider').owlCarousel({
		loop: true,
		margin: 10,
		autoplay: true,
		nav: true,
		rtl:owl_rtl,
		navText: ["<i class='fas fa-long-arrow-alt-left'></i>", "<i class='fas fa-long-arrow-alt-right'></i>"],
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 1
			}
		}
	});
}
if ( $( ".top-services-2" ).length )
{
	$('.top-services-2').owlCarousel({
		loop: true,
		margin: 20,
		autoplay: true,
		nav: true,
		rtl:owl_rtl,
		navText: ["<i class='fal fa-long-arrow-left'></i>", "<i class='fal fa-long-arrow-right'></i>"],
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 2
			},
			1000: {
				items: 3
			},
			1200: {
				items:4
			}
		}
	});
}
/* owl-carousel comments*/
if ( $( ".recomended-slider" ).length )
{
	$('.recomended-slider').owlCarousel({
		loop: false,
		margin: 10,
		nav: false,
		dots:false,
		rtl:owl_rtl,
		navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 2
			},
			1000: {
				items: 3
			},
			1200: {
				items: 4
			}
			
		}
	});
}

$(document).ready(function() {
    $('.default-select').select2();
});

$(window).load(function() {
  $('.fr-slick-thumb ').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: true,
    slideshow: false,
    itemWidth: 100,
    itemMargin: 10,
    asNavFor: '.fr-slick',
	prevText:'<i class="fas fa-angle-left"></i>',
	nextText:'<i class="fas fa-angle-right"></i>',
  });
  $('.fr-slick').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: true,
    slideshow: false,
    sync: ".fr-slick-thumb ",
	prevText:'<i class="fas fa-angle-left"></i>',
	nextText:'<i class="fas fa-angle-right"></i>',
  });
});


$(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("data-toggle"));
  if (input.attr("type") === "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
	
	
	var counterUp = window.counterUp["default"]; // import counterUp from "counterup2"
    
    var $counters = $(".counter");
    
    /* Start counting, do this on DOM ready or with Waypoints. */
    $counters.each(function (ignore, counter) {
        counterUp(counter, {
            duration: 1000,
            delay: 16
        });
    });
	if ( $( ".elbow" ).length )
	{
		$('.elbow').owlCarousel({
			loop:true,
			margin:0,
			autoplay:true,
			nav:true,
			rtl:owl_rtl,
			responsive:{
				0:{
					items:1
				},
				600:{
					items:1
				},
				1000:{
					items:1
				}
			}
		})
	}
	if($('.my-testimonials').length > 0)
	{
		$(".my-testimonials").owlCarousel({
			margin: 0,
			smartSpeed: 600,
			autoplay: 5000, //Set AutoPlay to 5 seconds

			loop: true,
			responsiveClass: true,
			navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
			nav: false,
			dots: false,
			rtl:owl_rtl,
			responsive: {
				0: {
					items: 1
				},
				480: {
					items: 1
				},
				769: {
					items: 1
				},
				1000: {
					items: 1
				}
			}

		});
	}	
	if ( $( ".brand-carousel" ).length )
	{
		$('.brand-carousel').owlCarousel({
	        loop:true,
	        margin:10,
	        nav:false,
	        dots:false,
	        autoplay:true,
	        autoplayTimeout:5000,
	        autoplayHoverPause:false,
	        responsive:{
	            0:{
	                items:1
	              },
	              600:{
	                  items:3
	              },
	              1000:{
	                  items:6
	              }
	          }
	    })
	}	
	})(jQuery);

