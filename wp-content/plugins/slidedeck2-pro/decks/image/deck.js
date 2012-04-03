(function($){
    window.ImageSlideDeck = {
        elems: {},
        
        thumbnailSort: function(){
            var self = this;
            
            if(this.elems.thumbnails.length < 1)
                return false;
            
            this.elems.thumbnails.sortable({
                items: '.media-image',
                stop: function(){
                    SlideDeckPreview.ajaxUpdate();
                }
            });
            
            this.mediaLibraryModal = new SimpleModal({
                context: "medialibrary-properties"
            });
            
            
            $('#slidedeck-medialibrary-properties-simplemodal').delegate('.close-modal', 'click', function(event){
                self.mediaLibraryModal.close();
            }).delegate('form', 'submit', function(event){
                event.preventDefault();
                
                var $this = $(this);
                var dataArray = $this.serializeArray();
                
                $.ajax({
                    url: $this.attr('action'),
                    data: $this.serialize(),
                    type: "POST",
                    success: function(data){
                        self.mediaLibraryModal.close();
                        SlideDeckPreview.ajaxUpdate();
                    }
                });
            });
            
            this.elems.thumbnails.delegate('.slidedeck-medialibrary-image-properties', 'click', function(event){
                event.preventDefault();
                
                $.ajax({
                    url: this.href,
                    type: "GET",
                    success: function(data){
                        self.mediaLibraryModal.open(data);
                    }
                })
            });
        },
        
        updateSkin: function(){
            this.selectedSkin = this.elems.skin.find('option:selected').val();
        },
        
        updateTemplates: function(){
            if(this.elems.skinTemplates.filter('#skin-template-' + this.selectedSkin).length){
                this.elems.skinTemplates.hide().prop('disabled', true).filter('#skin-template-' + this.selectedSkin).show().removeProp('disabled');
            } else {
                this.elems.skinTemplates.hide().prop('disabled', true);
            }
        },
        
        updateVariations: function(){
            if(this.elems.skinVariations.filter('#skin-variation-' + this.selectedSkin).length){
                this.elems.skinVariations.hide().prop('disabled', true).filter('#skin-variation-' + this.selectedSkin).show().removeProp('disabled');
            } else {
                this.elems.skinVariations.hide().prop('disabled', true);
            }
        },
        
        updateGplusAlbums: function(){
            var self = this;
            $.ajax({
                url: ajaxurl + "?action=update_gplus_albums&gplus_userid=" + $('#options-gplus_user_id').val(),
                type: "GET",
                success: function(data){
                    $('#gplus-user-albums').html( data ).find('.fancy').fancy();
                    SlideDeckPreview.ajaxUpdate();
                }
            });
        },
        
        initialize: function(){
            var self = this;
            
            this.elems.form = $('#slidedeck-update-form');
            this.elems.skinVariations = $('.skin-variation');
            this.elems.skinTemplates = $('.skin-template');
            this.elems.skin = $('#slidedeck-skin');
            this.elems.thumbnails = $('#slidedeck-medialibrary-images');
            
            this.slidedeck_id = $('#slidedeck_id').val();
            
            this.elems.form.delegate('select[name="options[skin]"]', 'change', function(event){
                self.updateSkin();
                self.updateVariations();
                self.updateTemplates();
            });
            
            // Get ready to trigger the ajax update.
            $(window).bind( 'load.instagram_token',function(){
                if( document.location.search.match(/&token=(.+)/) ){
                    SlideDeckPreview.ajaxUpdate();
                    $(window).unbind('load.instagram_token');
                }
            });
            
            // Gplus Userid 
            self.elems.form.delegate('.gplus-images-ajax-update', 'click', function(event){
                event.preventDefault();
                self.updateGplusAlbums();
            });
            // Prevent enter key from submitting text fields
            this.elems.form.delegate('#options-gplus_user_id', 'keydown', function(event){
                if( 13 == event.keyCode){
                    event.preventDefault();
                    $('.gplus-images-ajax-update').click();
                    return false;
                }
                return true;
            })
            
	        // Gplus Image Size Slider
	        if( $('#slidedeck-content-source .image-size-slider').length ){
	        	// Map the minute values to an array of 10 items (0-9)
	        	var pixelValues = [64, 128, 256, 512, 768, 800, 1024, 2048]; // Seconds
	        	var currentValue = $.inArray( parseInt( $('#options-gplus_max_image_size').val() ), pixelValues );
	        	
	        	// If the current value is not found, default to 3 or 30 mins.
	        	if( currentValue == -1 ){
	        		currentValue = 3;
	        	}
		        $('#gplus-image-size-slider').slider({
		        	value: currentValue,
		        	animate: true,
		        	min: 0,
					max: 7,
					step: 1,
					slide: function( event, ui ) {
						$( "#slidedeck-content-source .gplus-image-size-slider-value" ).html( pixelValues[ ui.value ] + ' pixels' );
						$('#options-gplus_max_image_size').val( pixelValues[ ui.value ] );
					},
					create: function( event, ui ){
						// Assign the current value (on page load) to the label. 
						$( "#slidedeck-content-source .gplus-image-size-slider-value" ).html( pixelValues[ currentValue ] );
					},
					change: function(){
						SlideDeckPreview.ajaxUpdate();
					}
		        });
	        }
	        
	        
            // Prevent enter key from submitting text field for adding flickr tags
            this.elems.form.delegate('#flickr-add-tag-field', 'keydown', function(event){
                if( 13 == event.keyCode){
                    event.preventDefault();
                    $('.flickr-tag-add').click();
                    return false;
                }
                return true;
            });
	        
	        // Flickr Tags adder
            self.elems.form.delegate('.flickr-tag-add', 'click', function(event){
                event.preventDefault();
                
                var currentEntry = $('#flickr-add-tag-field').val();
                if( currentEntry ){
                    $('#flickr-add-tag-field').val('');
                    
                    var tags = currentEntry.split(',');
                    
                    for (var i=0; i < tags.length; i++) {
                        var tag = $.trim(tags[i]);
                        var newTag = '<span>';
                        newTag += '<a href="#delete" class="delete">X</a> ';
                        newTag += tag;
                        newTag += '<input type="hidden" name="flickr_tags[]" value="' + tag + '" />';
                        newTag += '</span> ';
                        
                        $('#flickr-tags-wrapper').append( newTag );
                        SlideDeckPreview.ajaxUpdate();
                    };
                    
                }
            });
            
            // Flickr Tags Delete
            self.elems.form.delegate('#flickr-tags-wrapper .delete', 'click', function(event){
                event.preventDefault();
                $(this).parents('span').remove();
                
                if (self.elems.form.timer)
                    clearTimeout(self.elems.form.timer);
                
                // Set delay timer so a check isn't done on every single key stroke
                self.elems.form.timer = setTimeout(function(){
                    SlideDeckPreview.ajaxUpdate();
                }, 500 );
                
            });
	        
            
		    var ajaxOptions = [
		        "options[flickr_tags_mode]",
		        "options[flickr_recent_or_favorites]",
		    ];
		    for(var o in ajaxOptions){
		        SlideDeckPreview.ajaxOptions.push(ajaxOptions[o]);
		    }
		    
		    this.thumbnailSort();
		    
		    // Remove media image from thumbnail list for Media Library source
		    this.elems.thumbnails.delegate('.media-image .remove', 'click', function(event){
		        event.preventDefault();
		        
		        var $mediaImage = $(this).closest('.media-image');
		        
		        $mediaImage.fadeOut(125, function(){
		            $mediaImage.remove();
		            
                    if (self.elems.form.timer)
                        clearTimeout(self.elems.form.timer);
                    
                    // Set delay timer so a check isn't done on every single key stroke
                    self.elems.form.timer = setTimeout(function(){
                        SlideDeckPreview.ajaxUpdate();
                    }, 1000 );

		        });
		    });
        }
    };
    
    var ajaxOptions = [
        "options[gplus_images_album]",
        "options[dribbble_shots_or_likes]",
        "options[instagram_username]",
        "options[instagram_access_token]",
        "options[instagram_recent_or_likes]",
        "options[excerptLengthWithImages]"
    ];
    for(var o in ajaxOptions){
        SlideDeckPreview.ajaxOptions.push(ajaxOptions[o]);
    }
    
    SlideDeckPreview.updates['options[show-author]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPreview + 'show-author');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPreview + 'show-author');
        }
    };
    
    SlideDeckPreview.updates['options[show-title]'] = function($elem, value){
        if(value){
            SlideDeckPreview.elems.slidedeckFrame.addClass(SlideDeckPreview + 'show-title');
        } else {
            SlideDeckPreview.elems.slidedeckFrame.removeClass(SlideDeckPreview + 'show-title');
        }
    };
    
    $(document).ready(function(){
        ImageSlideDeck.initialize();
    });
})(jQuery);
