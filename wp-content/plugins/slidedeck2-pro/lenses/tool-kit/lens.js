(function($){
    SlideDeckLens['tool-kit'] = function(slidedeck){
    	
    	var self = this;
        var ns = 'tool-kit';
        var deck = $(slidedeck).slidedeck();
        var elems = {};
			elems.slidedeck = deck.deck,
            elems.frame = elems.slidedeck.closest('.lens-' + ns),
            elems.slides = deck.slides
            elems.deckWrapper = elems.frame.find('.sd-tool-kit-wrapper');
            elems.horizNav = elems.frame.find('.deck-navigation.horizontal');
            elems.horizNavPrev = elems.frame.find('.deck-navigation.horizontal.prev');
            elems.horizNavNext = elems.frame.find('.deck-navigation.horizontal.next');
            
    	
        // Only for IE - detect background image url and update style for DD element
        if( $.browser.msie ){
            if( $.browser.version <= 8.0 ){
                elems.slides.each(function(ind){
                    if( $(elems.slides[ind]).css('background-image') != 'none' ){
                        var imgurl = $(elems.slides[ind]).css('background-image').match( /url\([\"\'](.*)[\"\']\)/ )[1];
                        $(elems.slides[ind]).css({
                            background: 'none'
                        });
                        elems.slides[ind].style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + imgurl + "', sizingMethod='scale')";
                    };
                });
            }
        }
    	
    	this.overlay = function(){
    		if(elems.frame.hasClass('sd2-frame')){
	    		jQuery('<div class="sd-lens-shadow-top"></div><div class="sd-lens-shadow-left"></div><div class="sd-lens-shadow-corner"></div>').appendTo(elems.slidedeck);
			}
    	}
    	
    	this.deckNavigation = function(){
    		if(!elems.frame.hasClass('sd2-nav-none')){
    			deckCount = elems.slides.length;
    			jQuery('<div class="sd-nav-wrapper"></div>').appendTo(elems.deckWrapper);
    			elems.navWrapper = elems.frame.find('.sd-nav-wrapper');
    			jQuery('<dl class="tool-kit-nav-deck"></dl>').appendTo(elems.navWrapper);
    			elems.navDeck = elems.navWrapper.find('.tool-kit-nav-deck');
	    		if(elems.frame.hasClass('sd2-nav-dots')){
	    			// run dot code
					var i = 1;
					while(i <= deckCount && i <= 10){
						jQuery('<dd class="sd-tool-kit-nav-dot"></dd>').appendTo(elems.navDeck);
						i++;
					}
					elems.navDots = elems.navDeck.find('.sd-tool-kit-nav-dot');
					dotSpacing = parseInt(elems.navDots.outerWidth()+10);
					elems.navDeck.css('width', (dotSpacing*elems.navDots.length)-parseInt(elems.navDots.last().css('margin-left'),10));
					elems.navDots.click(function(){
						var $self = jQuery(this);
						var classToRemove = 'active';
						if( elems.frame.hasClass('sd2-nav-hanging') ) {
		        			classToRemove = 'accent-color-background';
		        		}
						elems.navDots.removeClass(classToRemove);
						$self.addClass(classToRemove);
						deck.goTo($self.index()+1);
					});
					if(!elems.frame.hasClass('sd2-nav-bar') && !elems.frame.hasClass('sd2-nav-hanging') || elems.frame.hasClass('sd2-nav-pos-top')){
						var spacingVar = parseInt(elems.frame.css('padding-left'), 10)+20;
						if(elems.frame.hasClass('sd2-nav-pos-top')){
							var topVar = spacingVar;
							var bottomBar = 'auto';
						}else{
							var topVar = 'auto';
							var bottomVar = spacingVar
						}
						
						var marginLeftVar = -(elems.navWrapper.width()/2);
						if(elems.frame.hasClass('sd2-nav-dots') && elems.frame.hasClass('sd2-nav-pos-top') && elems.frame.hasClass('sd2-nav-bar')){
							marginLeftVar = 0;
						}
						
						elems.navWrapper.css({
							'margin-left': marginLeftVar,
							'top': topVar,
							'bottom': bottomVar
						});
					};
					
					var classToRemove = 'active';
					if( elems.frame.hasClass('sd2-nav-hanging') ) {
	        			classToRemove = 'accent-color-background';
	        		}
					$('.sd-tool-kit-nav-dot').eq(deck.current-1).addClass(classToRemove);
					if(elems.frame.hasClass('sd2-nav-default') && !elems.frame.hasClass('sd2-title-pos-top') && !elems.frame.hasClass('sd2-hide-title') && !elems.frame.hasClass('sd2-title-pos-bottom') && elems.frame.hasClass('sd2-nav-dots') && !elems.frame.hasClass('sd2-small') ){
						var titleWidth = elems.frame.find('.sd-node-title-box').outerWidth();
						if(elems.frame.hasClass('sd2-title-pos-right')){
							var marLeftAdjustment = -(titleWidth / 2);
						}else if(elems.frame.hasClass('sd2-title-pos-left')){
							var marLeftAdjustment = titleWidth / 2;
						} 
						elems.navWrapper.css({
							'margin-left': marginLeftVar + marLeftAdjustment
						});
					}
	    		}
	    		if(elems.frame.hasClass('sd2-nav-hanging')){
	    			elems.navWrapper.appendTo(elems.frame);
	    		}
	    		if(elems.frame.hasClass('sd2-nav-thumb')){
					//run thumbnail code
					elems.navDeck.addClass('thumb');
					
					var i = 1;
					
					while(i <= deckCount){
						jQuery('<span class="tool-kit-thumb"><span class="number">'+i+'</span><span class="inner-image"></span></span>').appendTo(elems.navDeck);
                        // Only for IE - detect background image url and update style for DD element
                        if( $.browser.msie && $.browser.version <= 8.0 ){
                            elems.frame.find('span.tool-kit-thumb .inner-image').eq(i-1)[0].style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + elems.slides.eq(i-1).attr('data-thumbnail-src') + "', sizingMethod='scale')";
                        }else{
    						elems.frame.find('span.tool-kit-thumb .inner-image').eq(i-1).css('background-image', 'url('+elems.slides.eq(i-1).attr('data-thumbnail-src')+')' )
                        }
						i++;
					}
					
					// let's dynamically figure out how many thumbnails will fit in our nav
					singleThumb = elems.frame.find('.tool-kit-thumb');
					thumbWidth = parseInt(singleThumb.css('width'), 10),
					thumbSpacing = parseInt(singleThumb.last().css('margin-left'), 10),
					fullThumb = thumbWidth + thumbSpacing,
					thumbsPerSlide = Math.floor(((elems.frame.find('.sd-nav-wrapper').width()+thumbSpacing)/fullThumb)),
					thumbs = elems.navDeck.children('.tool-kit-thumb');
					
					thumbs.remove();
					
					var i = 0;
					while( i < deckCount ){
						if(i == 0 || i % thumbsPerSlide == 0){
							jQuery('<dd class="thumb-slide"></dd>').appendTo(elems.navDeck);
						};
						jQuery(thumbs[i]).appendTo(elems.navDeck.find('.thumb-slide').last());
						i++	
					}
					
					// let's center up these thumbs
					elems.navDeck.children('dd').wrapInner('<div class="nav-centered"></div>');
					elems.navDeck.find('.nav-centered').each(function(){
						var $self = $(this);
						var thumbsCount = $self.find('.tool-kit-thumb').length,
							navCentered = (fullThumb * thumbsCount);
						
    					$self.css('width', navCentered);
					});
					
					
					elems.navDeck.show();
					
					
					//initialize thumbnail slidedeck
					elems.navSlideDeck = elems.navDeck.slidedeck({
						hideSpines: true,
						cycle: true,
						keys: false,
						scroll: false
					});
					
					// add click events to thumbnails
					elems.thumbs = elems.navDeck.find('.tool-kit-thumb');
					elems.navDeck.delegate('.tool-kit-thumb', 'click', function(event){
						event.preventDefault();
						var $this = $.data(this, '$this'),
                            thumbIndex = $.data(this, 'thumbIndex');

                        this.style.backgroundColor = "";

                        elems.thumbs.removeClass('active accent-color-background');
						$this.addClass('active accent-color-background');
						
						deck.goTo(thumbIndex + 1);
					}).delegate('.tool-kit-thumb', 'mouseenter', function(event){
                        var $this = $.data(this, '$this'),
                            thumbIndex = $.data(this, 'thumbIndex');
                        
                        if(!$this){
                            $this = $(this);
                            $.data(this, '$this', $this);
                        }
                        
                        if(!thumbIndex){
                            thumbIndex = elems.thumbs.index($this);
                            $.data(this, 'thumbIndex', thumbIndex);
                        }
                        
                        var accentColor = $this.css('background-color');
                        var rgb = Raphael.getRGB(accentColor);
                        var hsl = Raphael.rgb2hsl(rgb.r, rgb.g, rgb.b);
                            hsl.l = Math.min(100, (120 * hsl.l))/100;
                        var hoverColor = Raphael.hsl(hsl.h, hsl.s, hsl.l);
                        
                        $this.css('background-color', hoverColor);
					}).delegate('.tool-kit-thumb', 'mouseleave', function(event){
                        this.style.backgroundColor = "";
					});
					
					//add arrows to the navigation if they are needed
					elems.navSlides = elems.navDeck.find('dd');
					if(elems.navSlides.length > 1){
						jQuery('<a class="deck-navigation-arrows prev" href="#prev" target="_blank"><span>Prev</span></a><a class="deck-navigation-arrows next" href="#next" target="_blank"><span>Next</span></a>').appendTo(elems.navWrapper);
						elems.navArrows = elems.navWrapper.find('.deck-navigation-arrows');
						elems.navArrows.click(function(event){
							event.preventDefault();
							
							// Prevent automatic pagination if user starts interacting (will be reset on next pagination request)
						    $.data(elems.navDeck[0], 'pauseAutoPaginate', true);
						    
							switch(this.href.split('#')[1]){
								case 'next':
									elems.navSlideDeck.next();
								break;
								case 'prev':
									elems.navSlideDeck.prev();
								break;
							}
						})
					}
					
					//set the current slide's thumbnail to active and move to the appropriate nav slide
					elems.frame.find('.tool-kit-nav-deck .tool-kit-thumb').eq(deck.current-1).addClass('active accent-color-background');
					elems.navSlideDeck.goTo(elems.navDeck.find('.chrome-thumb.active').parents('dd').index()+1);
				}
    		}
    	}
    	
    	this.setOptions = function(){
            // Get the old complete and before options
            var oldBefore = deck.options.before;
    	    
    		deck.setOption('before', function(){
    		    if(typeof(oldBefore) == 'function')
                    oldBefore(deck);
		        
	        	if(elems.frame.hasClass('sd2-nav-dots')){
	        		var classToRemove = 'active';
	        		if( elems.frame.hasClass('sd2-nav-hanging') ) {
	        			classToRemove = 'accent-color-background';
	        		}
		        	elems.navDots.removeClass(classToRemove);
					elems.navDots.eq(deck.current-1).addClass(classToRemove);
				}else if(elems.frame.hasClass('sd2-nav-thumb')){
					elems.thumbs.removeClass('active accent-color-background');
					elems.thumbs.eq(deck.current-1).addClass('active accent-color-background');
					
					if(!$.data(elems.navDeck[0], 'pauseAutoPaginate')){
    					elems.navSlideDeck.goTo(elems.navDeck.find('.tool-kit-thumb.active').parents('dd').index()+1);
					}
					$.data(elems.navDeck[0], 'pauseAutoPaginate', false);
				}
	    	});
    	};
    	
    	this.deckAdjustments = function(){
    		if(elems.frame.hasClass('sd2-nav-hanging')){
    			//elems.hangingWrapper.css('width', elems.slidedeck.width()+2);
    		}
    		if(elems.frame.hasClass('sd2-frame') && elems.frame.hasClass('sd2-nav-pos-top') && elems.frame.hasClass('sd2-nav-bar')){
    			elems.frame.css('padding-bottom', parseInt(elems.frame.css('padding-left'), 10));
    		}
    		if(elems.frame.hasClass('sd2-nav-pos-top') && elems.frame.hasClass('sd2-frame') && elems.frame.hasClass('sd2-nav-hanging')){
    			elems.navWrapper.appendTo(elems.frame);
    		}
    		if(elems.frame.hasClass('sd2-nav-thumb') && elems.frame.hasClass('sd2-nav-arrow-style-2')){
    			var buttonWidth = elems.navWrapper.outerHeight()
    			elems.navWrapper.find('.deck-navigation-arrows').css('width', buttonWidth);
    		}
    		
    		
    		
            var horizOffset;
            var vertOffset = 0;
            if( elems.frame.hasClass('sd2-small') ){
                horizOffset = 3;
            }else if( elems.frame.hasClass('sd2-medium') ){
                horizOffset = 10;
            }else if( elems.frame.hasClass('sd2-large') ){
                horizOffset = 10;
            }
            
            if( elems.frame.hasClass('sd2-frame') ){
                vertOffset = 5;
            }
            
            /**
             * Adjust left/right position for the nav arrows if
             * the frame is used. (not hairline)
             */
            if( elems.frame.hasClass('sd2-frame') ){
                elems.horizNavPrev.css('left', parseInt( elems.horizNavPrev.css('left') ) + horizOffset );
                elems.horizNavNext.css('right', parseInt( elems.horizNavNext.css('right') ) + horizOffset );
            }
            
            /**
             * Adjust the top margin of the nav arrows if the
             * hanging or bar nav is used.
             */
            if( !elems.frame.hasClass('sd2-no-nav') ){
                if( elems.frame.hasClass('sd2-nav-pos-top') ){
                    
                    if( elems.frame.is('.sd2-nav-bar') ){
                        elems.horizNav.css('marginTop', ( parseInt( elems.horizNav.css('marginTop') ) + Math.round( elems.frame.find('.sd-nav-wrapper').outerHeight() / 2 ) - vertOffset ) );
                    }
                    
                }else{
                    if( !elems.frame.hasClass('sd2-frame') || elems.frame.hasClass('sd2-nav-bar') ){
                        if( elems.frame.is('.sd2-nav-bar, .sd2-nav-hanging') ){
                            elems.horizNav.css('marginTop', parseInt( elems.horizNav.css('marginTop') ) - Math.round( elems.frame.find('.sd-nav-wrapper').outerHeight() / 2 ) + vertOffset );
                        }
                    }
                }
            }
    	}
    	
    	
    	    	
		deck.loaded(function(){
            self.deckNavigation();
			self.overlay();
			self.setOptions();
			self.deckAdjustments();
		});
	
    };
    
    $(document).ready(function(){
        $('.lens-tool-kit .slidedeck').each(function(){
            if(typeof($.data(this, 'lens-tool-kit')) == 'undefined' || $.data(this, 'lens-tool-kit') == null){
                $.data(this, 'lens-tool-kit', new SlideDeckLens['tool-kit'](this));
            }
        });
    });
})(jQuery);