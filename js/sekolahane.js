/**
 * Sekolah Ane — Main Front-End Script (Single Consolidated File)
 *
 * Hanya memuat logika yang benar-benar dipakai oleh template:
 * 1. Floating WhatsApp Customer Care (.cc-contactpop)
 * 2. Owl Carousel (.home-big-slider, #home-sliding, .testimoni-slider)
 * 3. Magnific Popup (.gallery-popup pada artikel single)
 * 4. Mobile Menu (#mobile-menu-active via MeanMenu)
 * 5. Google Maps (.acf-map pada halaman Contact Us)
 * 6. Post Views Cache AJAX (postViewsCache saat WP_CACHE aktif)
 */
(function ($) {
	'use strict';

	/* 1. MeanMenu (untuk #mobile-menu-active) */
	$.fn.meanmenu = function (options) {
		var defaults = {
			meanMenuTarget: $(this),
			meanMenuContainer: 'body',
			meanMenuClose: 'X',
			meanMenuCloseSize: '18px',
			meanMenuOpen: '<span /><span /><span />',
			meanRevealPosition: '',
			meanRevealPositionDistance: '0',
			meanRevealColour: '',
			meanScreenWidth: '991',
			meanNavPush: '',
			meanShowChildren: true,
			meanExpandableChildren: true,
			meanExpand: '+',
			meanContract: '-',
			meanDisplay: 'block'
		};
		options = $.extend(defaults, options);

		var currentWidth = window.innerWidth || document.documentElement.clientWidth;

		return this.each(function () {
			var meanMenu = options.meanMenuTarget;
			var meanContainer = options.meanMenuContainer;
			var meanScreenWidth = parseInt(options.meanScreenWidth, 10);
			var meanRevealClass = '.meanmenu-reveal';
			var menuOn = false;
			var meanMenuExist = false;
			var $navreveal = '';

			var meanRevealPos = '';
			if (options.meanRevealPosition === 'right') {
				meanRevealPos = 'right:' + options.meanRevealPositionDistance + ';left:auto;';
			} else if (options.meanRevealPosition === 'left') {
				meanRevealPos = 'left:' + options.meanRevealPositionDistance + ';right:auto;';
			}

			var meanInner = function () {
				if ($($navreveal).is('.meanmenu-reveal.meanclose')) {
					$navreveal.html(options.meanMenuClose);
				} else {
					$navreveal.html(options.meanMenuOpen);
				}
			};

			var meanOriginal = function () {
				$('.mean-bar,.mean-push').remove();
				$(meanContainer).removeClass('mean-container');
				$(meanMenu).css('display', options.meanDisplay);
				menuOn = false;
				meanMenuExist = false;
			};

			var showMeanMenu = function () {
				var meanStyles = 'background:' + options.meanRevealColour + ';color:' + options.meanRevealColour + ';' + meanRevealPos;
				if (currentWidth <= meanScreenWidth) {
					meanMenuExist = true;
					$(meanContainer).addClass('mean-container');
					$('.mean-container').prepend('<div class="mean-bar"><a href="#nav" class="meanmenu-reveal" style="' + meanStyles + '">Show Navigation</a><nav class="mean-nav"></nav></div>');
					$('.mean-nav').html($(meanMenu).html());

					$(meanMenu).before('<div class="mean-push" />');
					$('.mean-push').css('margin-top', options.meanNavPush);

					$(meanMenu).hide();
					$(meanRevealClass).show().html(options.meanMenuOpen).removeClass('meanclose');
					$navreveal = $(meanRevealClass);
					$('.mean-nav ul').hide();

					if (options.meanShowChildren) {
						if (options.meanExpandableChildren) {
							$('.mean-nav ul ul').each(function () {
								if ($(this).children().length) {
									$(this, 'li:first').parent().append('<a class="mean-expand" href="#" style="font-size: ' + options.meanMenuCloseSize + '">' + options.meanExpand + '</a>');
								}
							});
							$('.mean-expand').on('click', function (e) {
								e.preventDefault();
								if ($(this).hasClass('mean-clicked')) {
									$(this).text(options.meanExpand).prev('ul').slideUp(300);
								} else {
									$(this).text(options.meanContract).prev('ul').slideDown(300);
								}
								$(this).toggleClass('mean-clicked');
							});
						} else {
							$('.mean-nav ul ul').show();
						}
					} else {
						$('.mean-nav ul ul').hide();
					}

					$('.mean-nav ul li').last().addClass('mean-last');
					$navreveal.on('click', function (e) {
						e.preventDefault();
						if (!menuOn) {
							$navreveal.css({ 'text-align': 'center', 'text-indent': '0', 'font-size': options.meanMenuCloseSize });
							$('.mean-nav ul:first').slideDown();
							menuOn = true;
						} else {
							$('.mean-nav ul:first').slideUp();
							menuOn = false;
						}
						$navreveal.toggleClass('meanclose');
						meanInner();
					});
				} else {
					meanOriginal();
				}
			};

			$(window).on('resize', function () {
				currentWidth = window.innerWidth || document.documentElement.clientWidth;
				if (currentWidth <= meanScreenWidth) {
					if (!meanMenuExist) {
						showMeanMenu();
					}
				} else {
					meanOriginal();
				}
			});

			showMeanMenu();
		});
	};

	/* 2. Google Maps Helper (.acf-map) */
	function renderAcfMap($el) {
		if (typeof google === 'undefined' || !google.maps) {
			return;
		}
		var $markers = $el.find('.marker');
		var styles = [
			{ elementType: 'geometry', stylers: [{ color: '#f5f5f5' }] },
			{ elementType: 'labels.icon', stylers: [{ visibility: 'off' }] },
			{ elementType: 'labels.text.fill', stylers: [{ color: '#616161' }] },
			{ elementType: 'labels.text.stroke', stylers: [{ color: '#f5f5f5' }] },
			{ featureType: 'administrative.land_parcel', elementType: 'labels.text.fill', stylers: [{ color: '#bdbdbd' }] },
			{ featureType: 'poi', elementType: 'geometry', stylers: [{ color: '#eeeeee' }] },
			{ featureType: 'poi', elementType: 'labels.text.fill', stylers: [{ color: '#757575' }] },
			{ featureType: 'poi.park', elementType: 'geometry', stylers: [{ color: '#e5e5e5' }] },
			{ featureType: 'poi.park', elementType: 'labels.text.fill', stylers: [{ color: '#9e9e9e' }] },
			{ featureType: 'road', elementType: 'geometry', stylers: [{ color: '#ffffff' }] },
			{ featureType: 'road.arterial', elementType: 'labels.text.fill', stylers: [{ color: '#757575' }] },
			{ featureType: 'road.highway', elementType: 'geometry', stylers: [{ color: '#dadada' }] },
			{ featureType: 'road.highway', elementType: 'labels.text.fill', stylers: [{ color: '#616161' }] },
			{ featureType: 'road.local', elementType: 'labels.text.fill', stylers: [{ color: '#9e9e9e' }] },
			{ featureType: 'transit.line', elementType: 'geometry', stylers: [{ color: '#e5e5e5' }] },
			{ featureType: 'transit.station', elementType: 'geometry', stylers: [{ color: '#eeeeee' }] },
			{ featureType: 'water', elementType: 'geometry', stylers: [{ color: '#c9c9c9' }] },
			{ featureType: 'water', elementType: 'labels.text.fill', stylers: [{ color: '#9e9e9e' }] }
		];

		var map = new google.maps.Map($el[0], {
			zoom: 16,
			center: new google.maps.LatLng(0, 0),
			mapTypeControl: false,
			panControl: false,
			scrollwheel: false,
			draggable: false,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			mapTypeControlOptions: { mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style'] }
		});

		map.mapTypes.set('map_style', new google.maps.StyledMapType(styles, { name: 'Styled Map' }));
		map.setMapTypeId('map_style');
		map.markers = [];

		$markers.each(function () {
			var $marker = $(this);
			var latlng = new google.maps.LatLng($marker.attr('data-lat'), $marker.attr('data-lng'));
			var marker = new google.maps.Marker({ position: latlng, map: map });
			map.markers.push(marker);

			if ($marker.html()) {
				var infowindow = new google.maps.InfoWindow({ content: $marker.html() });
				google.maps.event.addListener(marker, 'click', function () {
					infowindow.open(map, marker);
				});
			}
		});

		var bounds = new google.maps.LatLngBounds();
		$.each(map.markers, function (i, marker) {
			bounds.extend(new google.maps.LatLng(marker.position.lat(), marker.position.lng()));
		});

		if (map.markers.length === 1) {
			map.setCenter(bounds.getCenter());
			map.setZoom(16);
		} else if (map.markers.length > 1) {
			map.fitBounds(bounds);
		}
	}

	/* 3. DOM Ready Initialization */
	$(function () {
		/* Floating WhatsApp Customer Care (.cc-contactpop) */
		var $ccPop = $('.cc-contactpop');
		if ($ccPop.length) {
			$ccPop.find('.kelapa').on('click', function (e) {
				e.stopPropagation();
				$ccPop.toggleClass('is-open');
			});
			$ccPop.find('.cc-close-btn').on('click', function (e) {
				e.stopPropagation();
				$ccPop.removeClass('is-open');
			});
			$(document).on('click', function (e) {
				if (!$(e.target).closest('.cc-contactpop').length) {
					$ccPop.removeClass('is-open');
				}
			});
		}

		/* Owl Carousel */
		if ($.fn.owlCarousel) {
			if ($('.home-big-slider').length) {
				$('.home-big-slider').owlCarousel({
					loop: true,
					nav: false,
					autoplay: true,
					autoplayTimeout: 7000,
					animateOut: 'fadeOut',
					animateIn: 'fadeIn',
					items: 1
				});
			}

			if ($('[id="home-sliding"]').length) {
				$('[id="home-sliding"]').owlCarousel({
					nav: false,
					items: 4,
					autoplay: true,
					margin: 30,
					responsiveClass: true,
					dots: true,
					autoplayHoverPause: true,
					loop: true,
					responsive: {
						0: { items: 1.2, margin: 16 },
						768: { items: 2 },
						1200: { items: 4 }
					}
				});
			}

			if ($('.testimoni-slider').length) {
				$('.testimoni-slider').owlCarousel({
					items: 3,
					dots: false,
					loop: true,
					nav: true,
					margin: 30,
					navText: [
						'<i class="ane-icon" aria-hidden="true"><svg class="ane-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" focusable="false"><path d="M15.41 7.41 14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg></i>',
						'<i class="ane-icon" aria-hidden="true"><svg class="ane-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" focusable="false"><path d="M8.59 16.59 10 18l6-6-6-6-1.41 1.41L13.17 12z"/></svg></i>'
					],
					responsive: {
						0: { items: 1.2, margin: 16 },
						768: { items: 2 },
						1200: { items: 3 }
					}
				});
			}
		}

		/* Magnific Popup (.gallery-popup) */
		if ($.fn.magnificPopup && $('.gallery-popup').length) {
			$('.gallery-popup').magnificPopup({
				type: 'image',
				image: {
					markup:
						'<div class="mfp-figure">' +
						'<div class="mfp-close"></div>' +
						'<div class="mfp-img"></div>' +
						'<div class="mfp-bottom-bar">' +
						'<div class="mfp-title"></div>' +
						'<div class="mfp-description" style="text-align:left;font-size:12px;line-height:16px;color:#f3f3f3;word-break:break-word;padding-right:36px;"></div>' +
						'<div class="mfp-counter"></div>' +
						'</div>' +
						'</div>',
					titleSrc: function (item) {
						var alt = item.el.find('img').attr('alt') || '';
						return $('<strong/>').text(alt).prop('outerHTML');
					}
				},
				gallery: { enabled: true },
				mainClass: 'mfp-with-zoom',
				zoom: {
					enabled: true,
					duration: 300,
					easing: 'ease-in-out',
					opener: function (openerElement) {
						return openerElement.is('img') ? openerElement : openerElement.find('img');
					}
				}
			});
		}

		/* Mobile Menu (#mobile-menu-active) */
		if ($('#mobile-menu-active').length) {
			$('#mobile-menu-active').meanmenu({
				meanScreenWidth: '991',
				meanMenuContainer: '.mobile-menu-area .mobile-menu'
			});
		}

		/* Google Maps (.acf-map) */
		if ($('.acf-map').length) {
			$('.acf-map').each(function () {
				renderAcfMap($(this));
			});
		}

		/* Post Views Cache AJAX (ketika WP_CACHE aktif) */
		if (typeof postViewsCache !== 'undefined' && postViewsCache.admin_ajax_url && postViewsCache.post_id) {
			$.ajax({
				type: 'GET',
				url: postViewsCache.admin_ajax_url,
				data: {
					postviews_id: postViewsCache.post_id,
					action: 'postviews'
				},
				cache: false
			});
		}
	});
})(jQuery);
