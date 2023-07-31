'use strict';

var stickyOffset;
var stickyEnabled;

var bt_enquire = {};

bt_enquire.sizes = {};

(function( $ ) {

	bt_enquire.register = function( size, handler ) {
		size = parseInt( size.split( ':' )[1] );
		bt_enquire.sizes[ size ] = {};
		bt_enquire.sizes[ size ].handler = handler;
	}

	bt_enquire.handle = function() {
		var width = ( window.innerWidth > 0 ) ? window.innerWidth : screen.width;
		$.each( bt_enquire.sizes, function( size, obj ) {
			if ( width <= size ) {
				if ( obj.state != 'matched' ) {
					obj.handler.match();
					obj.state = 'matched';
				}
			} else {
				if ( obj.state == 'matched' ) {
					obj.handler.unmatch();
					obj.state = 'unmatched';
				}
			}
		});
	}

	$( document ).ready(function() {
		
		var isTouchDevice = ( 'ontouchstart' in window ) || ( navigator.MaxTouchPoints > 0 ) || ( navigator.msMaxTouchPoints > 0 );
		
		if ( isTouchDevice ) {
			$( 'html' ).addClass( 'touch' );
			$( 'html' ).removeClass( 'no-touch' );
		} else {
			$( 'html' ).addClass( 'no-touch' );
			$( 'html' ).removeClass( 'touch' );
		}
		
		var hasCentralMenu = $( 'body' ).hasClass( 'btMenuCenterEnabled' );
		var verticalMenuEnabled = $( 'body' ).hasClass( 'btMenuVerticalLeftEnabled' ) || $( 'body' ).hasClass( 'btMenuVerticalRightEnabled' );
		var belowMenu = $( 'body' ).hasClass( 'btBelowMenu' );
		var touchDevice = $( 'html' ).hasClass( 'touch' );
		stickyEnabled = $( 'body' ).hasClass( 'btStickyEnabled' );
		stickyOffset = 250;
		var swapHeaderStyle = belowMenu && stickyEnabled && $( '.btAltLogo' ).length > 0; // If alt logo exists we will swap header skin

		var skinToSwap = $( 'body' ).hasClass( 'btDarkSkin' ) ? "btLightSkin" : "btDarkSkin";
		$( '.btPageWrap .btAltLogo' ).hide( );
		$( '.btPageWrap .btMainLogo' ).show( );
		

		
		function divide_menu( ) {
			if ( ! hasCentralMenu ) return false;
			var logoWidth = $( '.mainHeader .logo' ).outerWidth();
			
			if ( logoWidth == 0 ) {
				logoWidth = 200;
			}
			
			$( '.menuPort nav' ).addClass( 'leftNav' );
			$( '.menuPort' ).append( '<nav class="rightNav"><ul></ul></nav>' );
			var halfItems = Math.ceil( $( '.mainHeader nav.leftNav ul>li:not(li li)' ).length * .5 );
			$( '.mainHeader nav.rightNav > ul' ).append( $( '.mainHeader nav.leftNav > ul > li' ).slice ( halfItems ) );
			$( '.mainHeader nav.leftNav > ul > li' ).slice ( halfItems ).remove();
			
			$( '.mainHeader .logo' ).css( 'transform', 'translateX(' + Math.round(-logoWidth * .5) + 'px)' );
			$( '.mainHeader nav.leftNav' ).css( 'margin-right', Math.round(logoWidth * .5) + 'px' );
			$( '.mainHeader nav.rightNav' ).css( 'margin-left', Math.round(logoWidth * .5) + 'px' );
		}

		function undivide_menu() {
			if ( ! hasCentralMenu ) return false;
			$( '.mainHeader nav.leftNav>ul:not(ul ul)' ).append( $( '.mainHeader nav.rightNav ul>li:not(li li)' ) );
			$( '.mainHeader nav.rightNav' ).remove();
			$( '.mainHeader .leftNav' ).removeAttr( 'style' );
			$( '.menuPort nav' ).removeClass( 'leftNav' );
			$( '.mainHeader .logo' ).removeAttr( 'style' );
		}

		/* Vertical menu setup */
		function init_menu() {
			if ( verticalMenuEnabled ) {
				if ( $( 'body' ).hasClass( 'btMenuVerticalLeftEnabled' )) $( 'body' ).addClass( 'btMenuVerticalLeft btMenuVertical' );
				if ( $( 'body' ).hasClass( 'btMenuVerticalRightEnabled' )) $( 'body' ).addClass( 'btMenuVerticalRight btMenuVertical' );
				$( '.menuPort' ).prependTo( 'body' );
				$( '.mainHeader .logo' ).clone().prependTo( ".menuPort" );
				$( '.mainHeader .topBar' ).appendTo( ".menuPort" );
			} else {
				$( 'body' ).removeClass( 'btMenuVerticalLeft btMenuVerticalRight btMenuVerticalOn' );
				if ( $( 'body' ).hasClass( 'btMenuRightEnabled' )) $( 'body' ).addClass( 'btMenuRight' );
				if ( $( 'body' ).hasClass( 'btMenuLeftEnabled' )) $( 'body' ).addClass( 'btMenuLeft' );
				if ( $( 'body' ).hasClass( 'btMenuCenterEnabled' )) $( 'body' ).addClass( 'btMenuCenter' );				
			}	
			
		}

		/* activate sticky */
		
		function activate_sticky ( ) {
			var fromTop = $( window ).scrollTop();
			if ( stickyEnabled ) {
				if ( fromTop > stickyOffset ) {
					$( 'body' ).addClass( 'btStickyHeaderActive' );
					if( swapHeaderStyle ) {
						$( '.mainHeader' ).removeClass( skinToSwap );
						$( '.btPageWrap .btAltLogo' ).hide( );
						$( '.btPageWrap .btMainLogo' ).show( );
					}
					setTimeout( function() { $( 'body' ).addClass( 'btStickyHeaderOpen' ) }, 100 );
				} else {
					$( 'body' ).removeClass( 'btStickyHeaderOpen btStickyHeaderActive' );
					if( swapHeaderStyle ) {
						$( '.mainHeader' ).addClass( skinToSwap );	
						if ( swapHeaderStyle )	{
							$( '.btPageWrap .btAltLogo' ).show( );	
							$( '.btPageWrap .btMainLogo' ).hide( );
						}
					}
				}
			}
		}

		$( window ).on( 'load', function() {
			activate_sticky();
			if ( location.hash != '' ) {
				if ( $( 'body' ).hasClass( 'btStickyHeaderActive' ) ) {
					$( 'html, body' ).animate({
						scrollTop: $( location.hash ).offset().top - $( '.mainHeader .port' ).height() - $( '.mainHeader .btCurveHeader' ).height()
					}, 0 );
				}
			}
			$( window ).scroll(function(){
				activate_sticky();
			});
		});

		/* Show hide menu */

		$( '.btHorizontalMenuTrigger' ).on( 'click', function (){
			$( '.menuHolder' ).toggleClass( 'btShowMenu' );
			return false;
		});

		/* responsive menu toggler */

		$( '.btVerticalMenuTrigger' ).on( 'click', function() {
			$( 'body' ).toggleClass( 'btMenuVerticalOn' );
		});

		/* responsive menu sub togglers */

		$( '.menuPort ul ul' ).parent().prepend( '<div class="btIco borderless extrasmall subToggler"><a href="#" data-ico-fa="&#xf107;" class="btIcoHolder"></a></div>');
		$( '.subToggler' ).on( 'click', function(){
			$( this ).toggleClass( 'on' ).next().next().toggleClass( 'on' );
			return false;
		});

		/* custome menu subtoggler */
		$( '.btCustomMenu  ul ul' ).parent().prepend( '<div class="btIco borderless extrasmall customSubToggler"><a href="#" data-ico-fa="&#xf107;" class="btIcoHolder"></a></div>');
		$( '.customSubToggler' ).on( 'click', function(){
			$( this ).toggleClass( 'on' ).next().next().toggle('300');
			return false;
		});
		
		/* menu split */

		if ( hasCentralMenu ) divide_menu();

		/* Top tools search */
		
		$('.btTopBox .btSearchInner').prependTo('body').addClass( 'btFromTopBox' );

		$( '.btSearch .btIco, .btSearchInnerClose' ).on( 'click', function (){
			$( 'body' ).toggleClass( 'btTopToolsSearchOpen' );
			return false;
		});

		/* Vertical menu setup */
		
		init_menu();

		/* Load enquire */

		// turn on responsive menu for all touch devices

		var responsiveResolution;
		if ( $( 'body' ).hasClass( 'btIsMobile' ) ) {
			responsiveResolution = '5000';
		} else {
			responsiveResolution = '990';
		}

		bt_enquire.register( 'screen and (max-width:' + responsiveResolution + 'px)', {
			match: function() {
				undivide_menu();
				/* Force vertical menu */
				if ( !verticalMenuEnabled ) {
					$( 'body' ).addClass( 'btMenuVerticalLeft' ).removeClass( 'btMenuLeft btMenuCenter btMenuRight btMenuVerticalRight' );	
					$( '.menuPort' ).prependTo( 'body' );
					$( '.mainHeader .logo' ).clone().prependTo( ".menuPort" );
					$( '.menuPort' ).prepend( '<div class="btCloseVertical"></div>');
					$( '.btCloseVertical' ).on( 'click', function() {
						$( 'body' ).toggleClass( 'btMenuVerticalOn' );
					});
					$( '.mainHeader .topBar' ).appendTo( ".menuPort" );
					if( ! belowMenu ) $( '.btContentWrap' ).css( 'padding-top', $( '.mainHeader' ).height() +'px');
				}
			},
			unmatch: function () {
				
				if ( !verticalMenuEnabled ) {
					$( '.menuPort .logo' ).remove();
					$( '.menuPort .btCloseVertical' ).remove();
					init_menu();
					$( '.menuPort' ).appendTo( '.menuHolder' );
					$( '.menuPort .topBar' ).prependTo( ".mainHeader" );
					if( ! belowMenu ) $( '.btContentWrap' ).css( 'padding-top', $( '.mainHeader' ).height() +'px');
				}
				divide_menu();
			}
		});
	
		// move content bellow menu

		if( ! belowMenu ) {
			$( '.btContentWrap' ).css( 'padding-top', $( '.mainHeader' ).height() +'px');
			$( window ).resize(function() {
				$( '.btContentWrap' ).css( 'padding-top', $( '.mainHeader' ).height() +'px');
			});
		} else {
			if( swapHeaderStyle ) {
				$( '.mainHeader' ).addClass( skinToSwap );
				$( '.btAltLogo' ).show( );	
				$( '.btMainLogo' ).hide( );
			}
		}
		
		bt_enquire.handle();
		
		$( window ).resize(function() {
			
			bt_enquire.handle();
			
		});

	});

})( jQuery );