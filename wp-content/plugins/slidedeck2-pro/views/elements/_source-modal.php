<?php
/**
 * SlideDeck Source Modal
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
<h3><?php _e( "Select a Source Type", $namespace ); ?></h3>

<form action="<?php echo admin_url( 'admin.php' ); ?>" method="GET">
    
    <input type="hidden" name="page" value="<?php echo SLIDEDECK2_BASENAME; ?>" />
    <input type="hidden" name="action" value="<?php echo $action; ?>" />
    <?php if( $action == "slidedeck_edit_source" ): ?>
        <input type="hidden" name="slidedeck" value="<?php echo $slidedeck_id; ?>" />
        <?php wp_nonce_field( 'slidedeck-edit-source' ); ?>
    <?php endif; ?>
    
    <ul class="sources">
        <?php foreach( $sources as &$source ): ?>
            
            <li class="source">
                <label>
                    <span class="thumbnail">
                        <img src="<?php echo SLIDEDECK2_URLPATH . $source['icon']; ?>" alt="<?php echo $source['label']; ?>" />
                    </span>
                    <?php echo $source['label']; ?>
                    <input type="radio" name="source" value="<?php echo $source['name']; ?>" />
                </label>
            </li>
            
        <?php endforeach; ?>
    </ul>
    
</form>
