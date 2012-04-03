/**
 * Custom Media Library modal window interaction
 * 
 * @package SlideDeck
 * @author dtelepathy
 * @version 1.0.0
 */

var SlideDeckMediaLibrary = function(){
    // Class for single add buttons
    this.singleAddClass = "add-to-slidedeck-button";
    // ID for multi add button
    this.addAllId = "slidedeck-add-all-images";
    // ID for add-selected button
    this.addSelectedId = "slidedeck-add-selected-images";
    // Class for add multiple checkboxes
    this.addMultipleCheckboxClass = "slidedeck-add-multiple";
    // Buttons used by this Class
    this.buttons = {};
    // Current Add Media tab
    this.tab = "upload";
    
    // Image container on parent document
    this.imageContainer;
    // Content Source Flyout
    this.contentSource;
    
    // Initiate Class
    this.__construct();
};

(function($){
    // Class construct routine
    SlideDeckMediaLibrary.prototype.__construct = function(){
        var self = this;
        
        // This isn't a SlideDeck media upload, do NOT process further
        if(!parent.document.location.search.match(/page\=slidedeck2\.php/))
            return false;
        
        if(parent.jQuery('input[name="source"]').val() != "medialibrary")
            return false;
        
        $(document).ready(function(){
            self.initialize();
        });
    };
    
    // Add images to the SlideDeck - accepts a single ID or an array of IDs
    SlideDeckMediaLibrary.prototype.addImages = function(mediaIds){
        var self = this;
        
        // Convert a single ID to an array for consistent data submission
        if(!$.isArray(mediaIds)){
            mediaIds = [mediaIds];
        }
        
        var queryString = 'action=slidedeck_medialibrary_add_images';
        for (var i=0; i < mediaIds.length; i++) {
            queryString += '&media[]=' + mediaIds[i];
        };
        queryString += '&_wpnonce=' + _medialibrary_nonce;
        
        $.ajax({
            url: ajaxurl,
            data: queryString,
            success: function(data){
                // Add the images
                self.imageContainer.append(data);
                
                // Hide the flyout
                self.contentSource.addClass('hidden');
                
                // Close the Thickbox
                parent.tb_remove();
                
                // Update the preview
                parent.SlideDeckPreview.ajaxUpdate();
            }
        });
    };
    
    // Bind all submission events to appropriate buttons
    SlideDeckMediaLibrary.prototype.bind = function(){
        var self = this;
        
        $('body').delegate('.' + this.singleAddClass, 'click', function(event){
            event.preventDefault();
            
            var mediaId = $.data(this, 'mediaId');
            
            self.addImages(mediaId);
        });
        
        $('#' + this.addAllId).bind('click', function(event){
            event.preventDefault();
            
            var mediaIds = [];
            $('.' + self.singleAddClass).each(function(ind){
                var mediaId = $.data(this, 'mediaId');
                mediaIds.push(mediaId);
            });
            
            self.addImages(mediaIds);
        });
        
        $('#' + this.addSelectedId).bind('click', function(event){
            event.preventDefault();
            
            var mediaIds = [];
            $('.' + self.addMultipleCheckboxClass).each(function(ind){
                if(this.checked)
                    mediaIds.push(this.value);
            });
            
            self.addImages(mediaIds);
        });
    };
    
    // Route which tab initialize routine to run
    SlideDeckMediaLibrary.prototype.initialize = function(){
        // Get the current tab
        var location = document.location.search.match(/tab\=([a-zA-Z0-9\-_]+)/);
        if(location)
            this.tab = location[1];
        
        this.imageContainer = parent.jQuery('#slidedeck-medialibrary-images');
        this.contentSource = parent.jQuery('#slidedeck-content-source');
        
        // Hide the gallery tab to prevent confusion
        $('#tab-gallery').remove();
        // Hide the from URL tab since we can't accommodate for this
        $('#tab-type_url').remove();
        
        switch(this.tab){
            case "upload":
            case "type":
                this.tabUpload();
            break;
            
            case "library":
                this.tabLibrary();
            break;
        }
    };
    
    // Method for replacing "Insert into Post" buttons with "Add to SlideDeck" buttons
    SlideDeckMediaLibrary.prototype.replaceButton = function(el){
        var $button = $(el);
        var buttonId = $button.attr('id');
        var mediaId = buttonId.match(/\[(\d+)\]/)[1];
        
        $button.replaceWith('<input type="button" id="' + buttonId + '" class="button add-to-slidedeck-button" value="Add to SlideDeck" />');
        
        // Map the mediaId for the image as a data property for access later
        $.data(document.getElementById(buttonId), 'mediaId', mediaId);
    };
    
    // Media Library tab
    SlideDeckMediaLibrary.prototype.tabLibrary = function(){
        var self = this;
        var $mediaItems = $('#media-items');
        var $buttons = $mediaItems.find('input[type="submit"]');
        
        $buttons.each(function(ind){
            self.replaceButton(this);
        });
        
        $mediaItems.find('.toggle.describe-toggle-on').each(function(){
            var $this = $(this);
            var mediaId = $this.closest('.media-item').attr('id').split('-')[2];
            
            $this.before('<input type="checkbox" value="' + mediaId + '" class="' + self.addMultipleCheckboxClass + '" style="float:right;margin:12px 15px 0 5px;" />');
        });
        
        $mediaItems.find('.media-item:first-child').before('<p style="margin:5px;text-align:right;"><label style="margin-right:8px;font-weight:bold;font-style:italic;">Select All to add to SlideDeck <input type="checkbox" id="slidedeck-add-multiple-select-all" style="margin-left:5px;" /></label></p>');
        $('#slidedeck-add-multiple-select-all').bind('click', function(event){
            var selectAll = this;
            
            $mediaItems.find('.' + self.addMultipleCheckboxClass).each(function(){
                this.checked = selectAll.checked;
            });
        });
        
        $('.ml-submit').append('<a href="#" id="' + this.addSelectedId + '" class="button" style="margin-left: 10px;">Add Selected to SlideDeck</a>');
        
        this.bind();
    };
    
    // Upload tab
    SlideDeckMediaLibrary.prototype.tabUpload = function(){
        $('.savebutton.ml-submit').append('<a href="#" id="' + this.addAllId + '" class="button" style="margin-left: 10px;">Add all to SlideDeck</a>');
        
        new this.Watcher('image-form');
        
        this.bind();
    };
    
    // Watcher Class for Upload tab - watches for addition of "Insert into Post" buttons to replace them
    SlideDeckMediaLibrary.prototype.Watcher = function(el){
        var self = this;
        this.el = document.getElementById(el);
        
        this.getButtons = function(){
            var inputs = self.el.getElementsByTagName('input'),
                count = 0,
                buttons = [];
                
            for(var i in inputs){
                if(inputs[i].type == "submit" && inputs[i].id.match(/send\[(\d+)\]/)){
                    buttons.push(inputs[i]);
                }
            }
            
            return buttons;
        };
        
        this.checker = function(){
            var buttons = self.getButtons();
            
            for(var b in buttons){
                SlideDeckMediaLibrary.prototype.replaceButton(buttons[b]);
            }
        };
        
        this.interval = setInterval(this.checker, 100);
    };
    
    new SlideDeckMediaLibrary();
})(jQuery);
