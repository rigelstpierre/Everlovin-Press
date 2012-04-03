(function($){
    window.SmartPostsSlideDeck = {
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
        
        updateTaxonomies: function(postType, filterByTax){
            var self = this;
            
            $.ajax({
                url: ajaxurl + "?action=slidedeck_available_filters&post_type=" + postType + "&slidedeck=" + this.slidedeck_id + "&filter_by_tax=" + filterByTax,
                type: "GET",
                success: function(data){
                    self.elems.filters.html(data);
                    self.elems.taxonomyLoading.hide(); // Hide the loading indicator
					self.elems.filters.find('input.fancy').fancy();
					
                    // Restore the chosen checkboxes...
                    var checkedItems = self.elems.filters.find('input:checked');
                    if( checkedItems.length ){
		                var postType = $('[name="options[post_type]"]').find('option:selected').val();
                    	for (var i=0; i < checkedItems.length; i++) {
					  		var taxonomy = checkedItems[i].id.split('-')[2];
							self.updateTerms(postType, taxonomy);
						}
                    }
                }
            });
        },
        
        /**
         * Looks at the list of popular terms and if and of them
         * are checked in the main list, it checks them too. Usually
         * this is handled by WordPress in the PHP layer, but a post ID and
         * associated taxonomy info is needed for that and we don't have that.
         */
        checkPopularTermList: function(){
        	var fullList = this.elems.terms.find('.tabs-panel[id$="-all"] li');
        	var popList = this.elems.terms.find('.tabs-panel[id$="-pop"] li');
        	
        	for (var i=0; i < popList.length; i++) {
				var popularItem = $(popList[i]).find('input');
				
				if( fullList.find('input[value="' + popularItem.val() + '"]').is(':checked') ){
					$(popularItem).attr('checked', true);
				}
			};
        },
        
        /**
         * Looks at the number of term areas.
         * If there's more than one, we show the any/all dropdown.
         */
        rightSideModules: function(){
            var self = this;
            var moduleCount = self.elems.rightSide.find('div.taxonomy').length;
            var anyAllTaxonomies = self.elems.rightSide.find('#any-or-all-taxonomies');
            var trailblazer = self.elems.rightSide.find('.trailblazer');
            
            /**
             * Ooooohhhh! Fancy logic!!1!
             */
            if( moduleCount == 0 ){
                anyAllTaxonomies.hide();
                trailblazer.show();
            }else if( moduleCount > 1 ){
                anyAllTaxonomies.show();
                trailblazer.hide();
            }else{
                anyAllTaxonomies.hide();
                trailblazer.hide();
            }
        },
        
        /**
         * Updates the list of terms for a specific taxonomy.
         */
        updateTerms: function(postType, taxonomy){
            var self = this;
            
            $.ajax({
                url: ajaxurl + "?action=slidedeck_available_terms&post_type=" + postType + "&slidedeck=" + this.slidedeck_id + "&taxonomy=" + taxonomy,
                type: "GET",
                success: function(data){
                	self.elems.terms.find('.' + taxonomy).remove();
                    self.elems.terms.append(data);
                    
                    // Hide the loading indicator
                    self.elems.termsLoading.hide();
                    
                    // Uses WordPress' default functionality
                    self.tagBoxInit( self.elems.terms.find('.' + taxonomy) );
                    
                    // Syncs the checkboxes for categories
                    self.checkPopularTermList();
                    
                    // Decides whether or not to show the any/all dropdown.
                    self.rightSideModules();
                }
            });
        },
        
        tagBoxInit: function( box ){
            var t = tagBox;
            var ajaxtag = box.find('div.ajaxtag');
    
            box.find('.tagsdiv').each( function() {
                tagBox.quickClicks(this);
            });
    
            box.find('input.tagadd', ajaxtag).click(function(){
                t.flushTags( $(this).closest('.tagsdiv') );
            });
    
            box.find('div.taghint', ajaxtag).click(function(){
                $(this).css('visibility', 'hidden').parent().siblings('.newtag').focus();
            });
    
            box.find('input.newtag', ajaxtag).blur(function() {
                if ( this.value == '' )
                    $(this).parent().siblings('.taghint').css('visibility', '');
            }).focus(function(){
                $(this).parent().siblings('.taghint').css('visibility', 'hidden');
            }).keyup(function(e){
                if ( 13 == e.which ) {
                    tagBox.flushTags( $(this).closest('.tagsdiv') );
                    return false;
                }
            }).keypress(function(e){
                if ( 13 == e.which ) {
                    e.preventDefault();
                    return false;
                }
            }).each(function(){
                var tax = $(this).closest('div.tagsdiv').attr('id');
                $(this).suggest( ajaxurl + '?action=ajax-tag-search&tax=' + tax, { delay: 500, minchars: 2, multiple: true, multipleSep: "," } );
            });
        
            // tag cloud
            box.find('a.tagcloud-link').click(function(){
                tagBox.get( $(this).attr('id') );
                $(this).unbind().click(function(){
                    $(this).siblings('.the-tagcloud').toggle();
                    return false;
                });
                return false;
            });
        },
        
        initialize: function(){
            var self = this;
            
            this.elems.form = $('#slidedeck-update-form');
            this.elems.filters = $('#slidedeck-filters');
            this.elems.terms = $('#slidedeck-terms');
            this.elems.leftSide = $('#slidedeck-content-source #content-source-posts .left');
            this.elems.rightSide = $('#slidedeck-content-source #content-source-posts .right');
            this.elems.taxonomyLoading = self.elems.leftSide.find('.slidedeck-ajax-loading');
            this.elems.termsLoading = self.elems.rightSide.find('.slidedeck-ajax-loading');
            this.elems.lensVariations = $('.lens-variation');
            this.elems.lensTemplates = $('.lens-template');
            this.elems.lens = $('#slidedeck-lens');
            
            this.slidedeck_id = $('#slidedeck_id').val();
            
            // Check off the popular terms initially...
            self.checkPopularTermList();
            
            /**
             * Fired when the post type is changed or the 
             * filter option is toggled on or off.
             */
            this.elems.form.delegate('[name="options[filter_by_tax]"], [name="options[post_type]"]', 'change', function(event){
                var postType = $('[name="options[post_type]"]').find('option:selected').val();
                var filterByTax = $('[name="options[filter_by_tax]"]:checked').val();
                if( !filterByTax ){
                    filterByTax = 0;
                }
                
                if( filterByTax ){
                	self.elems.rightSide.show();
                	self.elems.taxonomyLoading.show(); // Show the loading indicator
                }else{
                	self.elems.rightSide.hide();
                }
                
                // Cleanup... This proveides a snappier feedback cycle.
                self.elems.terms.find('.taxonomy').remove();
                self.elems.filters.find('ul').remove();
                
                // Get the new taxonomies.
                self.updateTaxonomies(postType, filterByTax);
                
                // Decides whether or not to show the any/all dropdown.
                self.rightSideModules();
            });
            
            /**
             * Tab Switcher for hierarchial taxonomies
             */
            this.elems.form.delegate('.category-tabs li a', 'click', function(event){
            	event.preventDefault();
            	
				var t = $(this).attr("href");
				var taxonomy = $(this).parents('.categorydiv').attr('id').split('-')[1];
			    $(this).parent().addClass("tabs").siblings("li").removeClass("tabs");
			    $("#" + taxonomy + "-tabs").siblings(".tabs-panel").hide();
			    $(t).show();
			    return false;            	
            });
            // Mirror the choice for the popular -> all lists.
            this.elems.form.delegate('.categorydiv input', 'click', function(event){
            	var id = $(this).val();
            	var checked = $(this).is(':checked');
            	
            	var targets = self.elems.form.find('input[value="' + id + '"]');
            	targets.attr('checked', checked);
            });
            
            /**
             * This handles the display of the terms 
             * list for each taxonomy.
             * Triggered when a taxonomy checkbox is ticked or when
             * the page loads with initial selections.
             */
            this.elems.form.delegate('#slidedeck-filters input', 'change', function(event){
                var postType = $('[name="options[post_type]"]').find('option:selected').val();
                var taxonomy = $(this).attr('id').split('-')[2];
                
                if( $(this).is(':checked') ){
                	// Append the chooser
                	self.elems.termsLoading.show(); // Show the loading indicator
	                self.updateTerms(postType, taxonomy);
                }else{
                	// Remove the chooser
                	self.elems.terms.find('.' + taxonomy).remove();
                }
                
                // Decides whether or not to show the any/all dropdown.
                self.rightSideModules();
            });
            
            this.elems.form.delegate('select[name="options[lens]"]', 'change', function(event){
                self.updateLens();
                self.updateVariations();
                self.updateTemplates();
            });
        }
    };
    
    $(document).ready(function(){
        SmartPostsSlideDeck.initialize();
        
        $('#options-feedUrl').bind('keyup', function(event){
            if(event.keyCode == 13){
                event.preventDefault();
                SlideDeckPreview.ajaxUpdate();
                $('#slidedeck-content-source').addClass('hidden');
            }
        });
    });
    
    var ajaxOptions = [
        "options[excerptLengthWithImages]",
        "options[excerptLengthWithoutImages]",
        "options[titleLengthWithImages]",
        "options[titleLengthWithoutImages]",
        "options[linkAuthorName]",
        "options[linkTitle]",
        "options[linkTarget]",
        "options[validateImages]",
        "options[imageSource]",
        "options[use-custom-post-excerpt]",
        "options[navigation]"
    ];
    for(var o in ajaxOptions){
        SlideDeckPreview.ajaxOptions.push(ajaxOptions[o]);
    }

    SlideDeckPreview.updates['options[show-author]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPrefix + 'show-author');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPrefix + 'show-author');
        }
    };
    
    SlideDeckPreview.updates['options[show-excerpt]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPrefix + 'show-excerpt');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPrefix + 'show-excerpt');
        }
    };
    
    SlideDeckPreview.updates['options[show-title]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPrefix + 'show-title');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPrefix + 'show-title');
        }
    };
    
    SlideDeckPreview.updates['options[show-readmore]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPrefix + 'show-readmore');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPrefix + 'show-readmore');
        }
    };
    
    SlideDeckPreview.updates['options[show-author-avatar]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPrefix + 'show-author-avatar');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPrefix + 'show-author-avatar');
        }
    };
    
})(jQuery);
