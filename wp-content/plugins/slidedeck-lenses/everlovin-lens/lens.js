(function($){
    SlideDeckLens['everlovin-lens'] = function(slidedeck){
        var ns = 'everlovin-lens';
        var deck = $(slidedeck).slidedeck();
        var elems = {};
            // The SlideDeck DOM element itself
            elems.slidedeck = deck.deck;
            // The SlideDeck's frame
            elems.frame = elems.slidedeck.closest('.lens-' + ns);
            // The slides within the SlideDeck
            elems.horizontalSlides = deck.slides;
		
		// Only for IE - detect background image url and update style for DD element
        if( $.browser.msie ){
        	if( $.browser.version <= 8.0 ){
        		elems.horizontalSlides.each(function(ind){
        			if( $(elems.horizontalSlides[ind]).css('background-image') != 'none' ){
        				var imgurl = $(elems.horizontalSlides[ind]).css('background-image').match( /url\([\"\'](.*)[\"\']\)/ )[1];
        				$(elems.horizontalSlides[ind]).css({
        					background: 'none'
        				});
        				elems.horizontalSlides[ind].style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + imgurl + "', sizingMethod='scale')";
        			};
        		});
        	}
        }
    };
    
    $(document).ready(function(){
        $('.lens-everlovin-lens .slidedeck').each(function(){
            if(typeof($.data(this, 'lens-everlovin-lens')) == 'undefined' || $.data(this, 'lens-everlovin-lens') == null){
                $.data(this, 'lens-everlovin-lens', new SlideDeckLens['everlovin-lens'](this));
            }
        });
    });
})(jQuery);