(function($){
	SlideDeckLens['half-moon'] = function(slidedeck){
	    var self = this;
		var slidedeck = $(slidedeck);
		var slidedeckFrame = slidedeck.closest('.slidedeck-frame');
		var deck = slidedeck.slidedeck();
		var deckElement = slidedeck;
		
		// After loaded callback
        deck.loaded(function( thedeck ){
            // Only for IE - detect background image url and update style for DD element
            if( $.browser.msie ){
                if( $.browser.version <= 8.0 ){
                    thedeck.slides.each(function(ind){
                        if( $(thedeck.slides[ind]).css('background-image') != 'none' ){
                            var imgurl = $(thedeck.slides[ind]).css('background-image').match( /url\([\"\'](.*)[\"\']\)/ )[1];
                            $(thedeck.slides[ind]).css({
                                background: 'none'
                            });
                            thedeck.slides[ind].style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + imgurl + "', sizingMethod='crop')";
                        };
                    });
                }
            }
            
            if(slidedeckFrame.find('dd.slide').eq(deck.current-1).hasClass('no-image')){
				slidedeckFrame.find('.half-moon-dot-nav').css('margin-left', -(slidedeckFrame.find('.half-moon-dot-nav').outerWidth() / 2)).addClass('no-image');
    		}
        });
        
		this.dateAdjustments = function(){
			$('.date').each(function(){
				var thisDay = $(this).children('.day');
				if(thisDay.html().length == 2){
					thisDay.css('font-size', parseInt(thisDay.css('font-size'),10) - 5 );
				}
			});
			deckArrows = slidedeckFrame.find('a.deck-navigation.horizontal');
			deckArrows.mouseenter(function(){
				var $self = $(this);
				$self.addClass('accent-color-background');
			});
			
			deckArrows.mouseleave(function(){
				var $self = $(this);
				$self.removeClass('accent-color-background');
			});
		}
		
		this.dotNavigation = function(){
			if( !slidedeckFrame.hasClass('no-nav') ) {			
				var slideCount = slidedeck.find('dd.slide').length;
				var navHtml = '<ul class="half-moon-dot-nav"></ul>';
				$(navHtml).appendTo(slidedeckFrame);
				var dotNav = slidedeckFrame.find('.half-moon-dot-nav');
				for( i = 0; i < slideCount; i++ ) {
					$('<li />').appendTo(dotNav);
				}
				var navDots = dotNav.find('li');
				dotNav.css('width', slideCount * (navDots.outerWidth() + 10) - 10 )
				if( !slidedeckFrame.hasClass('sd2-nav-outside') && !slidedeckFrame.hasClass('sd2-small') ) {
					dotNav.css('margin-left', ((slidedeckFrame.find('.slide-content').outerWidth()/2) - (dotNav.outerWidth() / 2) ))
				}else{
					dotNav.css('margin-left', -(dotNav.outerWidth() / 2));
				}
				navDots.eq(deck.current-1).addClass('accent-color-background');
				// ADD CLICK FUNCTIONS
				navDots.bind('click', function(){
					var $self = $(this);
					deck.goTo(($self).index()+1);
					navDots.removeClass('accent-color-background');
					$self.addClass('accent-color-background');
				})
			}
		}
		
		// Get the old complete option
		var oldComplete = deck.options.complete;
		
		
    	deck.setOption('complete', function(){
	        // If the old complete option was a function, run it
		    if(typeof(oldComplete) == 'function') {
	            oldComplete(deck);
            }
    	});
    	
    	var oldBefore = deck.options.before;
    	deck.setOption('before', function(deck){
    	    if(typeof(oldBefore) == 'function')
    	       oldBefore(deck);
    	    
            var navDots = slidedeckFrame.find('.half-moon-dot-nav').find('li');
            navDots.removeClass('accent-color-background');
        	navDots.eq(deck.current-1).addClass('accent-color-background');
    		if( !slidedeckFrame.hasClass('sd2-small') ) {
    			if( !slidedeckFrame.hasClass('sd2-nav-outside') ) {
    			
		    		if(slidedeckFrame.find('dd.slide').eq(deck.current-1).hasClass('no-image')){
		    			slidedeckFrame.find('.half-moon-dot-nav').fadeOut( Math.round( deck.options.speed / 2 ), function(){
		    				slidedeckFrame.find('.half-moon-dot-nav').css('margin-left', -(slidedeckFrame.find('.half-moon-dot-nav').outerWidth() / 2));
		    				jQuery.data( slidedeckFrame.find('.half-moon-dot-nav')[0], 'centered', true );
		    				slidedeckFrame.find('.half-moon-dot-nav').fadeIn( Math.round( deck.options.speed / 2 ) );
		    			});
		    		}else if( jQuery.data( slidedeckFrame.find('.half-moon-dot-nav')[0], 'centered' ) ){
		    			slidedeckFrame.find('.half-moon-dot-nav').fadeOut( Math.round( deck.options.speed / 2 ), function(){
			    			slidedeckFrame.find('.half-moon-dot-nav').css('margin-left', (slidedeckFrame.find('.slide-content').outerWidth()/2)-(slidedeckFrame.find('.half-moon-dot-nav').outerWidth() / 2));
			    			jQuery.data( slidedeckFrame.find('.half-moon-dot-nav')[0], 'centered', false );
		    				slidedeckFrame.find('.half-moon-dot-nav').fadeIn( Math.round( deck.options.speed / 2 ) );
		    			});
		    		}
	    		}
    		};
    	})
		
		this.deckSizes = function(){
			if( slidedeckFrame.hasClass('sd2-small') ) {
				slidedeckFrame.find('dd.slide').each(function(){
					var $self = $(this);
					barFix($self);
				})
			}
		}
       
       	this.dotNavigation();
        this.dateAdjustments();
        this.deckSizes();
		return true;
	};
    
    $(document).ready(function(){
        $('.lens-half-moon .slidedeck').each(function(){
            if(typeof($.data(this, 'lens-half-moon')) == 'undefined'){
                $.data(this, 'lens-half-moon', new SlideDeckLens['half-moon'](this));
            }
        });
        
        if($('.lens-half-moon.v2 dd .slide-content .read-more-link').length){
			$('.lens-half-moon.v2 dd .slide-content .read-more-link').each(function(){
				$(this).css('width', $(this).parent('.slide-content').outerHeight());
			});
		}
		
		$('.no-image.no-excerpt .slide-title').each(function(){
			$(this).css('margin-top', -($(this).outerHeight()/2));
		});
    });
    
})(jQuery);