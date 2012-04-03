(function($){
	var ajaxOptions = [
        "options[navigation-type]",
        "options[frame]",
        "options[titleLengthWithImages]",
        "options[navigation-style]",
        "options[navigation-position]",
        "options[text-position]",
        "options[nav-arrow-style]",
        "options[deck-arrows]",
        "options[linkTitle]"
	];
	for(i = 0; i < ajaxOptions.length; i++){
		SlideDeckPreview.ajaxOptions.push(ajaxOptions[i]);
	}
    
    SlideDeckPreview.updates['options[nav-opaque]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPrefix + 'nav-opaque');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPrefix + 'nav-opaque');
        }
    };
    
    SlideDeckPreview.updates['options[arrow-style]'] = function($elem, value){
        $elem.find('option').each(function(){
            if(this.value != value){
                SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPrefix + this.value);
            } else {
                SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPrefix + this.value);
            }
        });
    };
    
    SlideDeckPreview.updates['options[text-color]'] = function($elem, value){
        $elem.find('option').each(function(){
            if(this.value != value){
                SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPrefix + this.value);
            } else {
                SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPrefix + this.value);
            }
        });
    };
    
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
    
    SlideDeckPreview.updates['options[show-excerpt]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPrefix + 'show-excerpt');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPrefix + 'show-excerpt');
        }
    };
    
    SlideDeckPreview.updates['options[show-readmore]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPrefix + 'show-readmore');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPrefix + 'show-readmore');
        }
    };
    
    SlideDeckPreview.updates['options[nav-opaque]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPrefix + 'nav-opaque');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPrefix + 'nav-opaque');
        }
    };
    
})(jQuery);