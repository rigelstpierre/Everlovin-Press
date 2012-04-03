<?php
/**
 * SlideDeck Administrative Options
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
<div class="wrap" id="slidedeck_lens_management">
    <div class="slidedeck-header">
        <h1>SlideDeck Lenses</h1>
        
        <a class="button<?php if( $is_writable->valid !== true ) echo ' disabled' ?>" href="<?php echo slidedeck2_action( '/lenses&action=add' ); ?>">Upload Lens</a>
        <a class="button<?php if( $is_writable->valid !== true ) echo ' disabled' ?>" href="<?php echo slidedeck2_action( "/lenses&action=copy&lens=proto&new_lens_name=My%20Lens&new_lens_slug=my-lens&create_or_copy=create" ); ?>">Create New</a>
    </div>
    
    
    <div id="slidedeck-lenses-wrapper">
        
        <?php slidedeck2_flash( 5000 ); ?>
        
        <?php if( $is_writable->valid !== true ): ?>
            <div class="slidedeck-flash-message error"><p><?php _e( $is_writable->error, $namespace ); ?></p></div>
        <?php endif; ?>
        
        <?php if( !empty( $lenses ) ): ?>
                
            <div id="slidedeck-lenses" class="lenses clearfix">
                
                <?php foreach( $lenses as &$lens ): ?>
                    
                    <?php include( SLIDEDECK2_DIRNAME . '/views/elements/_lens.php' ); ?>
                
                <?php endforeach; ?>
                
            </div>
            
        <?php endif; ?>
        
    </div>
    
</div>
