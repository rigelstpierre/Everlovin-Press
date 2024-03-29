<?php
/**
 * SlideDeck Widget control form
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
<p><?php _e( "Display a SlideDeck in a widget area. <em><strong>NOTE:</strong> since most widget areas are narrow sidebars, your SlideDeck may not appear correctly. We only recommend placing SlideDecks in wider widget areas like headers and footers.</em>", $namespace ); ?></p>
<p><label><strong><?php _e( "Choose a SlideDeck", $namespace ); ?>:</strong><br />
<select name="<?php echo $this->get_field_name( 'slidedeck_id' ); ?>" id="<?php echo $this->get_field_id( 'slidedeck_id' ); ?>" class="widefat">
    <?php foreach( (array) $slidedecks as $slidedeck ): ?>
    <option value="<?php echo $slidedeck['id']; ?>"<?php echo $slidedeck_id == $slidedeck['id'] ? ' selected="selected"' : ''; ?>><?php echo $slidedeck['title']; ?></option>
    <?php endforeach; ?>
</select>
</label></p>
<p>
    <label>
        <input type="checkbox" value="1" name="<?php echo $this->get_field_name( $namespace . '_deploy_as_iframe' ); ?>" id="<?php echo $this->get_field_id( $namespace . '_deploy_as_iframe'); ?>"<?php if( $deploy_as_iframe ) echo ' checked="checked"'; ?> />
        <?php _e( "Deploy SlideDeck using an iframe", $namespace ); ?>
    </label>
</p>
