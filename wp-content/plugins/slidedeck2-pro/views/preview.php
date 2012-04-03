<?php
/**
 * Preview SlideDeck tempalte
 * 
 * SlideDeck 2 Pro for WordPress 2.0.20120327
 * Copyright (c) 2012 digital-telepathy (http://www.dtelepathy.com)
 * 
 * BY USING THIS SOFTWARE, YOU AGREE TO THE TERMS OF THE SLIDEDECK 
 * LICENSE AGREEMENT FOUND AT http://www.slidedeck.com/license. 
 * IF YOU DO NOT AGREE TO THESE TERMS, DO NOT USE THE SOFTWARE.
 * 
 * More information on this project:
 * http://www.slidedeck.com/
 * 
 * Full Usage Documentation: http://www.slidedeck.com/usage-documentation 
 * 
 * @package SlideDeck
 * @subpackage SlideDeck 2 Pro for WordPress
 * @author dtelepathy
 */
?>
<div id="slidedeck_preview_mask"></div>
<div id="slidedeck_preview_window" class="preview-window"<?php if( $first_preview ) echo ' style="visibilty:hidden;"'; ?>>
	<div style="margin:0 auto 20px;padding:0;width:<?php echo $preview_w; ?>;position:relative;overflow:hidden;">
		<?php slidedeck( $slidedeck_id, array( 'width' => $preview_w, 'height' => $preview_h ), false ); ?>
	</div>
	<div id="slidedeck_preview_window_form">
		<h4><strong>Preview Your SlideDeck at a Different Size</strong></h4>
		<input type="hidden" name="slidedeck_id" value="<?php echo $slidedeck_id; ?>" />
        <input type="hidden" name="refresh" value="0" /> 
		<label>
		    <?php if( ( $lens['meta']['Lens Type'] == "fixed" ) ): ?>
                Width:
            <?php else: ?>
                Dimensions:
            <?php endif; ?>
        </label> <input type="text" name="preview_w" value="<?php echo $preview_w; ?>" id="preview_w" onkeyup="updateSlideDeckPreview(this);" onblur="updateSlideDeckPreview(this);" />
			 <?php if( ( $lens['meta']['Lens Type'] == "fixed" ) ): ?>
                 <?php if( $lens['meta']['Lens Type'] == "fixed" ): $preview_h = $lens['meta']['Lens Height']; endif; ?>
			 	 <input type="hidden" name="preview_h" value="<?php echo $preview_h; ?>" id="preview_h" />
			 <?php else: ?>
                  x <input type="text" name="preview_h" value="<?php echo $preview_h; ?>" id="preview_h" onkeyup="updateSlideDeckPreview(this);" onblur="updateSlideDeckPreview(this);" />
			 <?php endif; ?>
         <a href="<?php echo admin_url('admin-ajax.php'); ?>?action=slidedeck_preview&preview_w=<?php echo $preview_w; ?>&preview_h=<?php echo $preview_h; ?>&slidedeck=<?php echo $slidedeck_id; ?>&width=<?php echo $width; ?>&height=<?php echo $height; ?>" id="btn_slidedeck_preview_submit" class="thickbox button-primary" onclick="cleanUpSlideDecks();" title="Preview SlideDeck">Update Preview</a>
	</div>
    <p id="preview_note"><em><strong>NOTE:</strong> This is only a preview, your mileage may vary. Place this SlideDeck in a post and preview the post for a more accurate preview.</em></p>
</div>
<script type="text/javascript">
(function($){
    if($('#slidedeck_preview_mask').length){
        setTimeout(function(){
            updateTBSize();
            
            var slidedeckPreviewWindow = $('#slidedeck_preview_window');
            var classes = slidedeckPreviewWindow.find('.slidedeck_frame')[0].className;
            var classes = classes.split(' ');
            var namespace = "";
            for(var i = 0; i < classes.length; i++){
                if(classes[i].match('lens-([a-zA-Z0-9\-_]+)')){
                    namespace = classes[i].replace('lens-', "");
                }
            }
            if(typeof(SlideDeckLens) != 'undefined'){
                if(typeof(SlideDeckLens[namespace]) == 'function'){
                    slidedeckPreviewWindow.find('.slidedeck').each(function(){
                        if(!$.data(this, 'lens-' + namespace)){
                            $.data(this, 'lens-' + namespace, new SlideDeckLens[namespace](this));
                        }
                    });
                }
            }

            $('#slidedeck_preview_mask').fadeOut();
        }, 500);
    }
})(jQuery);
</script>