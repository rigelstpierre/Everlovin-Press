(function($){
    window.SocialSlideDeck = {
        elems: {},
        
        updateVariations: function(){
            if(this.elems.lensVariations.filter('#lens-variation-' + this.selectedLens).length){
                this.elems.lensVariations.hide().prop('disabled', true).filter('#lens-variation-' + this.selectedLens).show().removeProp('disabled');
            } else {
                this.elems.lensVariations.hide().prop('disabled', true);
            }
        },
        
        updateLens: function(){
            this.selectedLens = this.elems.lens.find('option:selected').val();
        },
        
        updateTemplates: function(){
            if(this.elems.lensTemplates.filter('#lens-template-' + this.selectedLens).length){
                this.elems.lensTemplates.hide().prop('disabled', true).filter('#lens-template-' + this.selectedLens).show().removeProp('disabled');
            } else {
                this.elems.lensTemplates.hide().prop('disabled', true);
            }
        },
        
        updateTerms: function(postType){
            var self = this;
            
            $.ajax({
                url: ajaxurl + "?action=slidedeck_available_filters&post_type=" + postType + "&slidedeck=" + this.slidedeck_id,
                type: "GET",
                success: function(data){
                    self.elems.filters.html(data);
                }
            });
        },
        
        initialize: function(){
            var self = this;
            
            this.elems.form = $('#slidedeck-update-form');
            this.elems.filters = $('#slidedeck-filters');
            this.elems.lensVariations = $('.lens-variation');
            this.elems.lensTemplates = $('.lens-template');
            this.elems.lens = $('#slidedeck-lens');
            
            this.slidedeck_id = $('#slidedeck_id').val();
            
            this.elems.form.delegate('#options-search_or_user-user, #options-search_or_user-search', 'change', function(event){
                switch( event.target.id ){
                    case 'options-search_or_user-user':
                        $('li.twitter-search').hide();
                        $('li.twitter-username').show();
                    break;
                    case 'options-search_or_user-search':
                        $('li.twitter-username').hide();
                        $('li.twitter-search').show();
                    break;
                }
            })
            
            this.elems.form.delegate('select[name="options[lens]"]', 'change', function(event){
                self.updateLens();
                self.updateVariations();
                self.updateTemplates();
            });
        }
    };
    
    $(document).ready(function(){
        SocialSlideDeck.initialize();
    });
    
    var ajaxOptions = [
        "options[validateImages]",
        "options[twitter_username]",
        "options[twitter_q]",
        "options[search_or_user]",
        "options[navigation-style]",
        "options[show-author-avatar]",
        "options[navigation]",
        "options[useGeolocationImage]"
    ];
    for(var o in ajaxOptions){
        SlideDeckPreview.ajaxOptions.push(ajaxOptions[o]);
    }
    
    SlideDeckPreview.updates['options[hide-author]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPreview + 'hide-author');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPreview + 'hide-author');
        }
    };
    
    SlideDeckPreview.updates['options[hide-excerpt]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPreview + 'hide-excerpt');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPreview + 'hide-excerpt');
        }
    };
    
    SlideDeckPreview.updates['options[hide-title]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPreview + 'hide-title');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPreview + 'hide-title');
        }
    };
    
    SlideDeckPreview.updates['options[hide-readmore]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPreview + 'hide-readmore');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPreview + 'hide-readmore');
        }
    };
    
    SlideDeckPreview.updates['options[show-author-avatar]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPreview + 'show-author-avatar');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPreview + 'show-author-avatar');
        }
    };
    
    SlideDeckPreview.updates['options[show-title-rule]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPreview + 'show-title-rule');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPreview + 'show-title-rule');
        }
    };
    
    SlideDeckPreview.updates['options[show-shadow]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPreview + 'show-shadow');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPreview + 'show-shadow');
        }
    };
    
})(jQuery);
