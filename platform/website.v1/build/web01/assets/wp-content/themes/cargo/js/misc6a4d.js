'use strict';

window.addEventListener("pageshow", function(evt){
        if(evt.persisted){
        setTimeout(function(){
            window.location.reload();
        },10);
    }
}, false);

window.onunload = function(){};

(function( $ ) {

	function bt_video_resize() {
		$( 'iframe' ).not( '.twitter-tweet' ).not( '.bt_custom_iframe' ).each(function() {
			if ( ! $( this ).parent().hasClass( 'boldPhotoBox' ) ) {
				$( this ).css( 'width', '100%' );
				$( this ).css( 'height', $( this ).width() * 9 / 16 );
			}
		});
		
		$( 'embed' ).each(function() {
			if ( ! $( this ).parent().hasClass( 'boldPhotoBox' ) ) {
				$( this ).css( 'width', '100%' );
				$( this ).css( 'height', $( this ).width() * 9 / 16 );
			}
		});	
	}

	$( window ).ready(function() {
		
		bt_video_resize();
		
		$( 'select' ).not( '.btDropdown' ).not( 'table.variations select' ).fancySelect();

		if ( $( '.btGhost' ).length > 0 ) {
			$( 'body' ).addClass( 'btHasGhost' );
		}
		
		$( '.btQuoteSlider' ).wrap( '<div class="btQuoteWrapper"></div>' );

		$( '.btHasGhost .btGhostSliderThumb a' ).on( 'click', function( e ) {
			e.preventDefault();
			$( '.btGhost' ).removeClass( 'btRemoveGhost' );
			$( '.btHasGhost .btGhostSliderThumb' ).removeClass( 'btMarkedImage' );
			bt_disable_scroll();
			$( '.btGhost .slick-slider' ).slick( 'slickGoTo', $( this ).closest( '.btGhostSliderThumb' ).data( 'order-num' ) );
		});
		
		if ( $( window ).scrollTop() > 0 || $( 'html' ).hasClass( 'no-csstransforms3d' ) ) {
			$( '.btGhost' ).addClass( 'btRemoveGhost' );
		}
		
		window.bt_theme_loaded = false;
		
		window.bt_disable_scroll = function() {
			window.onmousewheel = document.onmousewheel = function() {
				if ( window.bt_theme_loaded ) {
					$( '.btCloseGhost' ).trigger( 'click' );
				}
				if ( ! window.bt_theme_loaded || ! window.bt_theme_allow_scroll ) {
					return false;
				}
			};
			$( window ).on( 'DOMMouseScroll', function( e ) {
				if ( window.bt_theme_loaded ) {
					$( '.btCloseGhost' ).trigger( 'click' );
				}			
				if ( ! window.bt_theme_loaded || ! window.bt_theme_allow_scroll ) {
					e.preventDefault();
				}
			});		
		}
		
		window.bt_enable_scroll = function() {
			window.onmousewheel = document.onmousewheel = null;
		}
		
		var articleWithGhost = $( '.btPostOverlay' ).length > 0;
		
		if ( $( '.btRemoveGhost' ).length == 0 && $( '.btGhost' ).length > 0  ) {
			window.bt_theme_allow_scroll = false;
			bt_disable_scroll();
		}		
	});

	$( window ).load(function() {
		
		window.bt_theme_loaded = true;
		
		// remove preloader

		$( '#btPreloader' ).addClass( 'removePreloader' );
		
		// trigger custom load event

		setTimeout( function() { $( window ).trigger( 'btload' ); }, 1000 );		
	});
	
	$( window ).resize(function() {
		bt_video_resize();
	});

	/* Animate elements */

	function btAnimateRows() {
		var winheight = $( window ).height();
		var fullheight = $( document ).height();
		var $elems = $( '.animate' );
		// classic animations
		$elems.each(function() {
			var $elm = $( this );
			if ( $elm.isOnScreen() ) {
				$elm.addClass( 'animated' ).removeClass( 'animate' );
			}
		});
	}

	$( window ).on( 'btload', function() {
		btAnimateRows();
		$( window ).on( 'scroll', function(){
			btAnimateRows();
		});
	});

	$( document ).ready(function() {

		var doc = document.documentElement;
		doc.setAttribute( 'data-useragent', navigator.userAgent );				

		// basic functions

		if ( ! String.prototype.startsWith ) {
			String.prototype.startsWith = function(searchString, position) {
				position = position || 0;
				return this.lastIndexOf(searchString, position) === position;
			};
		}

		if ( ! String.prototype.endsWith ) {
			String.prototype.endsWith = function(searchString, position) {
				var subjectString = this.toString();
				if (position === undefined || position > subjectString.length) {
					position = subjectString.length;
				}
				position -= searchString.length;
				var lastIndex = subjectString.indexOf(searchString, position);
				return lastIndex !== -1 && lastIndex === position;
			};
		}		

		/* scroll handlers */

		function scrollPage() {
			var fromTop = $( this ).scrollTop();
			if ( ! $( '.btGhost' ).hasClass( 'btRemoveGhost' ) ) {
				$( '.btCloseGhost' ).trigger( 'click' );
			}
		}

		function scrollPageTo( val ) {
			val = parseInt( val );
			$( 'body, html' ).animate({ scrollTop: val + 'px' }, 500 );
		}

		function scrollPageToId(id) {
			if ( $( id ).length == 0 ) return false;
			var topOffset = $( id ).offset().top;
			if ( $(window).width() > 990 && stickyEnabled && topOffset > stickyOffset ) {
				topOffset -= $( '.menuHolder' ).height();
			}
			$( 'html, body' ).animate({ scrollTop: topOffset }, 500);
		}

		/* position on screen */

		jQuery.fn.isOnScreen = function() {
			var element = this.get( 0 );
			if ( element == undefined ) return false;
			var bounds = element.getBoundingClientRect();
			return bounds.top + 100 < window.innerHeight && bounds.bottom > 0;
		}

		/* init scroll listener */

		window.addEventListener( 'scroll', scrollPage );
	 	
		// delay click to allow on page leave screen

		$( document ).on( 'click', 'a:not(.lightbox)', function() {
			var href = $( this ).attr( 'href' );
			if ( href !== undefined ) {
				if ( location.href.split('#')[0] != href.split('#')[0] && ! href.startsWith( '#' ) && ! href.startsWith( 'mailto' ) && ! href.startsWith( 'callto' ) ) {
					
					if ( $( this ).attr( 'target' ) != '_blank' && ! href.endsWith( '#respond' ) ) {
						if ( $( '#btPreloader' ).length ) {
							$( '#btPreloader' ).removeClass( 'removePreloader' );
							setTimeout( function() { window.location = href }, 1500 );
							return false;
						}
					}
					
				} else if ( href != "#" ) {
					scrollPageToId( href );
					if ( $(window).width() < 991 ) $( 'body' ).removeClass( 'btMenuVerticalOn' );
					return false;
				}
			}
			
		});

		// Vertical alignment fix

		$( '.rowItem.btMiddleVertical, .rowItem.btBottomVertical' ).parent().addClass( 'btTableRow' );

		/* Footer widgets count and column set */

		$( '#boldSiteFooterWidgetsRow' ).children().addClass( 'rowItem col-md-' + Math.round(12/$( '#boldSiteFooterWidgetsRow' ).children().length) + ' col-sm-12' );

		// Gallery slider info bar toggler

		$( '.btGetInfo' ).on( 'click', function (){
			$(this).toggleClass( 'on' ).next().toggleClass( 'open' );
			return false;
		});	

		// Close gallery slider

		$( '.btCloseGhost' ).on( 'click', function () {
			if ( ! $( '.btGhost' ).hasClass( 'btRemoveGhost' ) ) {
				$( '.btGhost' ).addClass( 'btRemoveGhost' );
				$( window ).trigger( 'resize' );
				var pos = $( this ).parent().find( '.slick-slider' ).first().slick( 'slickCurrentSlide' );
				var num_slides = $( this ).parent().find( '.slick-slider' ).find( '.slick-slide' ).length;
				var thumbs = $( '.btGridGallery' ).first().find( '.btGhostSliderThumb' );
				var num_thumbs = thumbs.length;
				if ( num_slides > num_thumbs && pos > 0 ) {
					$( thumbs[ pos - 1 ] ).addClass( 'btMarkedImage' );
				} else if ( num_slides == num_thumbs ) {
					$( thumbs[ pos ] ).addClass( 'btMarkedImage' );
				}
				setTimeout( function() { window.bt_theme_allow_scroll = true; $( '.btMarkedImage' ).removeClass( 'btMarkedImage' ) }, 800 );
				return false;
			}
		});
		
		// magnific-popup grid gallery
		
		$( '.tilesWall.lightbox, .btLightbox' ).each(function() {
			$( this ).find( 'a' ).addClass( 'lightbox' );
			$( this ).find( 'a' ).magnificPopup({
				type: 'image',
				// other options
				gallery:{
					enabled:true
				},
				closeMarkup:'<button class="mfp-close" type="button"><i class="mfp-close-icn">&times;</i></button>',
				image: {
					titleSrc: 'data-title'
				},
				closeBtnInside:false		
			});
		});
		
		$( '.ui-slider' ).each(function() {
			$( this ).on( 'mousedown', function( e ) {
				e.stopPropagation();
			});
		});		
		
	});

})( jQuery );