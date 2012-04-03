(function($){
    window.VideoSlideDeck = {
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
        
        updateYouTubePlaylists: function(){
            var self = this;
            $.ajax({
                url: ajaxurl + "?action=update_youtube_playlists&youtube_username=" + $('#options-youtube_username').val(),
                type: "GET",
                success: function(data){
                    $('#youtube-user-playlists').html( data ).find('.fancy').fancy();
                    SlideDeckPreview.ajaxUpdate();
                }
            });
        },
        
        updateVimeoPlaylists: function(){
            var self = this;
            
            $.ajax({
                url: ajaxurl + "?action=update_vimeo_playlists&vimeo_username=" + $('#options-vimeo_username').val(),
                type: "GET",
                success: function(data){
                    $('#vimeo-user-playlists').html( data ).find('.fancy').fancy();
                    SlideDeckPreview.ajaxUpdate();
                }
            });
        },
        
        updateDailymotionPlaylists: function(){
            var self = this;
            
            $.ajax({
                url: ajaxurl + "?action=update_dailymotion_playlists&dailymotion_username=" + $('#options-dailymotion_username').val(),
                type: "GET",
                success: function(data){
                    $('#dailymotion-user-playlists').html( data ).find('.fancy').fancy();
                    SlideDeckPreview.ajaxUpdate();
                }
            });
        },
        
        updateVideoThumbnail: function( url, newLi ){
            var self = this;
            
            $.ajax({
                url: ajaxurl + "?action=update_video_thumbnail&video_url=" + url,
                type: "GET",
                success: function(data){
                    if( data.indexOf('invalid') != -1 ){
                        newLi.find('.thumbnail').css({
                            backgroundImage: "url('" + data + "')"
                        });
                    }else{
                        newLi.find('.thumbnail').removeClass('loading').css({
                        	backgroundImage: "url('" + data + "')"
                        });
                    }
                }
            });
        },
        
        updateVideoListStriping: function(){
    		$('#videos-sortable li').removeClass('even');
    		$('#videos-sortable li:odd').addClass('even');
        },
        
        initialize: function(){
            var self = this;
            
            this.elems.form = $('#slidedeck-update-form');
            this.elems.filters = $('#slidedeck-filters');
            this.elems.lensVariations = $('.lens-variation');
            this.elems.lensTemplates = $('.lens-template');
            this.elems.lens = $('#slidedeck-lens');
            
            this.slidedeck_id = $('#slidedeck_id').val();
            
            this.elems.form.delegate('select[name="options[post_type]"]', 'change', function(event){
                var postType = $(this).find('option:selected').val();
                
                self.updateTerms(postType);
            });
            
            this.elems.form.delegate('select[name="options[lens]"]', 'change', function(event){
                self.updateLens();
                self.updateVariations();
                self.updateTemplates();
            });
            
            // YouTube Username 
            this.elems.form.delegate('.youtube-username-ajax-update', 'click', function(event){
                event.preventDefault();
                self.updateYouTubePlaylists();
            });
            // Prevent enter key from submitting text fields
            this.elems.form.delegate('#options-youtube_username', 'keydown', function(event){
                if( 13 == event.keyCode){
                    event.preventDefault();
                    $('.youtube-username-ajax-update').click();
                    return false;
                }
                return true;
            });
            
            // Prevent enter key from submitting text field for add video to list
            this.elems.form.delegate('#add-video-field', 'keydown', function(event){
                if( 13 == event.keyCode){
                    event.preventDefault();
                    $('.list-of-videos-add').click();
                    return false;
                }
                return true;
            });
            
            // Sortable for the List of Videos
            this.elems.form.delegate('.list-of-videos-add', 'click', function(event){
            	event.preventDefault();
            	var currentEntry = $('#add-video-field').val();
            	if( currentEntry ){
	            	$('#add-video-field').val('');
	            	
	            	var newLi = '<li>';
	            	newLi += '<div class="handle"></div>';
	            	newLi += '<div class="thumbnail loading"></div>';
	            	newLi += '<span>';
	            	newLi += currentEntry;
	            	newLi += '</span>';
	            	newLi += '<input type="hidden" name="video_entry[]" value="' + currentEntry + '" />';
	            	newLi += '<a href="#delete" class="delete">X</a>';
	            	newLi += '</li>';
	            	
	            	$('#videos-sortable').append( newLi );
	            	self.updateVideoListStriping();
	            	
	            	var newLi = $('#videos-sortable li:last');
	            	
	            	self.updateVideoThumbnail( currentEntry, newLi );
            	}
            	
            });
            this.elems.form.delegate('#videos-sortable .delete', 'click', function(event){
            	event.preventDefault();
            	$(this).parents('li').remove();
        		self.updateVideoListStriping();
            });
            $('#videos-sortable').sortable({
                handle: '.handle, .thumbnail',
            	create: function(){
            		self.updateVideoListStriping();
            	},
            	stop: function(){
            		self.updateVideoListStriping();
            	}
            });
            
            this.elems.form.delegate('#options-search_or_user-user, #options-search_or_user-search', 'change', function(event){
                switch( event.target.id ){
                    case 'options-search_or_user-user':
                        $('li.youtube-search').hide();
                        $('li.youtube-username').show();
                    break;
                    case 'options-search_or_user-search':
                        $('li.youtube-username').hide();
                        $('li.youtube-search').show();
                    break;
                }
            })
            
            // Vimeo Username 
            this.elems.form.delegate('.vimeo-username-ajax-update', 'click', function(event){
                event.preventDefault();
                self.updateVimeoPlaylists();
            });
            
            // Dailymotion Username 
            this.elems.form.delegate('.dailymotion-username-ajax-update', 'click', function(event){
                event.preventDefault();
                self.updateDailymotionPlaylists();
            });
        }
    };
    
    $(document).ready(function(){
        VideoSlideDeck.initialize();
    });
        
    var ajaxOptions = [
        "options[titleLength]",
        "options[descriptionLength]",
        "options[youtube_playlist]",
        "options[youtube_q]",
        "options[dailymotion_playlist]",
        "options[vimeo_album]",
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
})(jQuery);

