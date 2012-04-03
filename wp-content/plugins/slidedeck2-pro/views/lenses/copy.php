<?php
/**
 * SlideDeck Copy Lens Page
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
<div class="wrap">
    <div class="icon32" id="icon-themes"><br /></div>
    <h2><?php _e( ( $create_or_copy == 'create' ? "Create New Lens" : "Copy Lens" ), $namespace ); ?></h2>
    
    <?php slidedeck2_flash(); ?>
    
    <form action="<?php echo slidedeck2_action( '/lenses' ); ?>" method="post" id="slidedeck-copy-lens">
        
        <?php if( $create_or_copy == 'copy' ): ?>
        	
	        <p><?php _e( "You are about to make a copy of the lens:", $namespace ); ?> <em><?php echo $lens['meta']['name']; ?></em>. <?php _e( "Please choose a new name for this lens and a new slug to use as the lens' primary CSS class and directory name.", $namespace ); ?></p>
	        <p><?php _e( "The new lens' CSS files will automatically be updated with the new CSS class, but you must manually modify any lens JavaScript and PHP files to use the new CSS class.", $namespace ); ?></p>
        
        <?php else: ?>
        	
        	<p><?php _e( "You are about to create a new lens. Please choose a new, unique name for this lens and a new slug to use as the lens' primary CSS class and directory name.", $namespace ); ?></p>
    	<?php endif; ?>
    	
        <fieldset>
            
            <?php wp_nonce_field( "{$namespace}-copy-lens" ); ?>
            
        	<input type="hidden" name="create_or_copy" value="<?php echo $create_or_copy; ?>" />
            <input type="hidden" name="lens" value="<?php echo $lens['slug']; ?>" />
            
            <p><label>Lens Name: <input type="text" name="new_lens_name" size="40" maxlength="255" value="<?php echo $new_lens_name; ?>" /></label></p>
            <p><label>Lens CSS class: <input type="text" name="new_lens_slug" id="new-lens-slug" size="40" maxlength="255" value="<?php echo $new_lens_slug; ?>" /></label></p>
            
            <p><input type="submit" value="Copy Lens" class="button-primary" /></p>
            
        </fieldset>
        
    </form>
</div>