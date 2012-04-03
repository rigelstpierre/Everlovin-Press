<?php
/**
 * SlideDeck Media Library Content Source
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

<div id="content-source-medialibrary">
    <input type="hidden" name="source" value="<?php echo $slidedeck['source']; ?>" />
    <input type="hidden" name="type" value="<?php echo $this->type; ?>" />
    <div class="inner">
        <span class="label"><?php printf( __( 'Start adding %1$s media files from %1$s your computer.', $this->namespace ), '<br />' ); ?></span>
        <a href="<?php echo admin_url( 'media-upload.php?post_id=' . $slidedeck['id'] . '&TB_iframe=1&width=640&height=515' ); ?>" class="button button-primary thickbox" title="<?php _e( "Add Media" ); ?>"><?php _e( "Upload/Add Media", $this->namespace ); ?></a>
    </div>
</div>