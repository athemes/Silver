(function($) {
	
	slider = $('.header-carousel');
	slider.flickity({
	  	// options
	  	cellSelector: '.carousel-cell',
	  	contain: true,
	  	imagesLoaded: true,
		wrapAround: true,
		autoPlay: slider.data('speed'),
		pauseAutoPlayOnHover: false,
		adaptiveHeight: true, //add css transition
		friction: 0.5,
		selectedAttraction: 0.03,
  		prevNextButtons: true,
  		pageDots: false,
		arrowShape: { 
		  x0: 10,
		  x1: 60, y1: 50,
		  x2: 65, y2: 45,
		  x3: 20
		}
	});

})( jQuery );

/* Sticky menu */
(function($) {

	function stickyHeader() {
		if ( matchMedia( 'only screen and (min-width: 1024px)' ).matches ) {
			$('body.admin-bar .top-bar').sticky({
				topSpacing:32,
				responsiveWidth: true
			});

			$('body:not(.admin-bar) .top-bar').sticky({
				topSpacing:0,
				responsiveWidth: true
			});			

			var headerHeight = $('.top-bar').outerHeight();
			$('#masthead-sticky-wrapper').css('min-height', headerHeight);
		} else {
			$('.top-bar').unstick();
		}
	}
	$(document).ready( stickyHeader );
	$(window).on('resize', stickyHeader );

})( jQuery );

/* Social links in new window */
(function($) {
     $('.social-navigation li a').attr( 'target','_blank' );
})( jQuery );

/* Mobile menu */
(function($) {
		var	menuType = 'desktop';

		$(window).on('load resize', function() {
			var currMenuType = 'desktop';

			if ( matchMedia( 'only screen and (max-width: 1199px)' ).matches ) {
				currMenuType = 'mobile';
			}

			if ( currMenuType !== menuType ) {
				menuType = currMenuType;

				if ( currMenuType === 'mobile' ) {
					var $mobileMenu = $('#site-navigation').attr('id', 'mainnav-mobi').hide();
					var hasChildMenu = $('#mainnav-mobi').find('li:has(ul)');

					hasChildMenu.children('ul').hide();
					hasChildMenu.children('a').after('<span class="btn-submenu"></span>');
					$('.btn-menu .icon-menu').removeClass('active');
				} else {
					var $desktopMenu = $('#mainnav-mobi').attr('id', 'site-navigation').removeAttr('style');

					$desktopMenu.find('.submenu').removeAttr('style');
					$('.btn-submenu').remove();
				}
			}
		});

		$('.btn-menu .icon-menu, .btn-close-menu').on('click', function() {
			$('#mainnav-mobi').slideToggle(300);
			$(this).toggleClass('active');
		});

		$(document).on('click', '#mainnav-mobi li .btn-submenu', function(e) {
			$(this).toggleClass('active').next('ul').slideToggle(300);
			e.stopImmediatePropagation()
		});	
})( jQuery );