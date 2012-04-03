(function($){
	var ajaxOptions = [
        "options[navigation-style]",
        "options[navigation-area]",
        "options[linkTitle]",
        "options[titleLengthWithImages]"
	];
	for(i = 0; i < ajaxOptions.length; i++){
		SlideDeckPreview.ajaxOptions.push(ajaxOptions[i]);
	}
    
    SlideDeckPreview.updates['options[show-title]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPrefix + 'show-title');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPrefix + 'show-title');
        }
    };
})(jQuery);