(function($){
    var ajaxOptions = [
        "options[navigation-type]",
        "options[linkAuthorName]"
    ];
    for(i = 0; i < ajaxOptions.length; i++){
        SlideDeckPreview.ajaxOptions.push(ajaxOptions[i]);
    }
    
    SlideDeckPreview.updates['options[show-author]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPrefix+ 'show-author');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPrefix + 'show-author');
        }
    };
    
    SlideDeckPreview.updates['options[show-title-rule]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPrefix + 'show-title-rule');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPrefix + 'show-title-rule');
        }
    };
    
    SlideDeckPreview.updates['options[show-shadow]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPrefix + 'show-shadow');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPrefix + 'show-shadow');
        }
    };
})(jQuery);