jQuery(document).ready(function($) {
    $( document ).ready(function() {

        // let's Hide Items
        $( ".cc-contactpop form").hide();
        $( ".cc-contactpop i").hide();
        $( ".cc-contactpop p").hide();
        $( ".cc-contactpop ul").hide();

        // Show on elements ".slideDown"
        $( ".cc-contactpop" ).click(function() {
            $( ".cc-contactpop form").slideDown(500)
            $( ".cc-contactpop p").slideDown(500)
            $( ".cc-contactpop i").slideDown(500)
            $( ".cc-contactpop ul").slideDown(500)
        });

        // Close Hidden Part
        $( ".cc-contactpop i" ).click(function() {
            $(this).slideUp(500)
                $( ".cc-contactpop p").slideUp(500)
                $( ".cc-contactpop ul").slideUp(500)
                $( ".cc-contactpop form").slideUp(500)
            return false
        });

    });

    $('body').on('click', '.search-button', function(e){
        e.preventDefault();
        $('.search-bar').css({'max-width':'100%', 'opacity': '1'});
        $('.search-bar input').focus();
    });
    $('body').on('click', '.search-back', function(e){
        e.preventDefault();
        $('.search-bar').css({'max-width':'0px', 'opacity': '0'});
    });

    $('.search-button').click(function(){
      $(this).parent().toggleClass('open');
    });
    /* slider active */
    $('.slider-active').owlCarousel({
        loop: true,
        nav: false,
        autoplay: true,
        autoplayTimeout: 7000,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        item: 1,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    })
    /*Search Icon working*/
        $(document).on('click','#search-icon',function(e){
            e.preventDefault();
           $('.search-box').addClass('active');
        });
        $(document).on('click','#serach-close-btn',function(e){
            e.preventDefault();
           $('.search-box').removeClass('active');
        });
        // one Item Carousel
        if ($('.one-item-carousel').length) {
            $('.one-item-carousel').owlCarousel({
                loop:true,
                margin:15,
                nav:true,
                smartSpeed: 500,
                autoplay: 5000,
                navText: [ '<i class="ane-chevron-left"></i>', '<i class="ane-chevron-right"></i>' ],
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:1
                    },
                    800:{
                        items:1
                    },
                    1024:{
                        items:1
                    },
                    1200:{
                        items:1
                    },
                    1400:{
                        items:1
                    }
                }
            });
        }
        /*========================
        trending topics
        ==========================*/
           if ($('#home-sliding,#post-block-slider').length > 0) {
        	$('#home-sliding,#post-block-slider').owlCarousel({
        		nav: false,
        		items: 4,
                autoplay: true,
        		margin: 30,
        		reponsiveClass: true,
        		dots: true,
        		autoplayHoverPause: true,
        		loop:true,
        		responsive: {
        			// breakpoint from 0 up
        			0: {
        				items: 2,
        			},
        			// breakpoint from 480 up
        			480: {
        				items: 2,
        			},
        			// breakpoint from 768 up
        			768: {
        				items: 2,
        			},
        			// breakpoint from 768 up
        			1200: {
        				items: 4,
        			}
        		}
        	});
        }

        // Four Item Carousel
        if ($('.four-item-carousel').length) {
            $('.four-item-carousel').owlCarousel({
                loop:true,
                margin:15,
                nav:true,
                smartSpeed: 500,
                autoplay: 5000,
                navText: [ '<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>' ],
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:2
                    },
                    800:{
                        items:2
                    },
                    1024:{
                        items:3
                    },
                    1200:{
                        items:3
                    },
                    1400:{
                        items:4
                    }
                }
            });
        }
	/*========================
    Testimoni Slider
    ==========================*/
    if ($('.testimoni-slider').length > 0) {
    $('.testimoni-slider').owlCarousel({
    	items: 3,
    	dots: false,
    	loop: true,
    	nav: true,
    	margin: 30,
    	navText: ["<i class='ane-chevron-left'></i>", "<i class='ane-chevron-right'></i>"],
    	responsive: {
    		// breakpoint from 0 up
    		0: {
    			items: 1,
    		},
    		// breakpoint from 480 up
    		480: {
    			items: 2,
    		},
    		// breakpoint from 768 up
    		768: {
    			items: 2,
    		},
    		// breakpoint from 768 up
    		1200: {
    			items: 3,
    		}
    	}
    });
    }
	/* -------------- */
	/*  All image Popup
	/* ---------------------- */

    if ($('.gallery-popup').length > 0) {
        $('.gallery-popup').magnificPopup({
            type: 'image',
            image: {
			markup: '<div class="mfp-figure">'+
			'<div class="mfp-close"></div>'+
			'<div class="mfp-img"></div>'+
			'<div class="mfp-bottom-bar">'+
			'<div class="mfp-title"></div>'+
			'<div class="mfp-description" style="text-align: left;font-size: 12px;line-height: 16px;color: #f3f3f3;word-break: break-word;padding-right: 36px;"></div>'+
			'<div class="mfp-counter"></div>'+
			'</div>'+
			'</div>',
			titleSrc: function(item) {
				return '<strong>' + item.el.find('img').attr('alt') + '</strong>';
			}
		},
            gallery:{enabled:true},
            mainClass: 'mfp-with-zoom',

            zoom: {
                enabled: true, // By default it's false, so don't forget to enable it

                duration: 300, // duration of the effect, in milliseconds
                easing: 'ease-in-out', // CSS transition easing function

                opener: function (openerElement) {
                    return openerElement.is('img') ? openerElement : openerElement.find('img');
                }
            }
        });
    }



      // scroll body to 0px on click
    $('#back-to-top').on('click', function () {
         $('#back-to-top').tooltip('hide');
         $('body,html').animate({
              scrollTop: 0
         }, 800);
         return false;
    });

    $('#back-to-top').tooltip('hide');
   /* jQuery MeanMenu */
    $('#mobile-menu-active').meanmenu({
        meanScreenWidth: "991",
        meanMenuContainer: ".mobile-menu-area .mobile-menu",
    });

    $('.commrnt-toggle a').on('click', function(e) {
        e.preventDefault();
        $('.blog-comment-content-wrap').slideToggle(1000);
    });

});
