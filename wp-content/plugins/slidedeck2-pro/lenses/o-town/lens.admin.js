(function($){
	var ajaxOptions = [
        "options[navigation-type]",
        "options[autoplay-indicator]"
	];
	for(i = 0; i < ajaxOptions.length; i++){
		SlideDeckPreview.ajaxOptions.push(ajaxOptions[i]);
	}
    
    SlideDeckPreview.updates['options[show-author]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPrefix + 'show-author');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPrefix + 'show-author');
        }
    };
    
    SlideDeckPreview.updates['options[show-author-avatar]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPrefix + 'show-author-avatar');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPrefix + 'show-author-avatar');
        }
    };
    
    SlideDeckPreview.updates['options[show-title]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPrefix + 'show-title');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPrefix + 'show-title');
        }
    };
})(jQuery);