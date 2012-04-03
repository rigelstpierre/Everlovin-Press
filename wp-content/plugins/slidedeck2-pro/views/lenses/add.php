<?php
/**
 * SlideDeck Add Lens Page
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

<h4>Install a lens in .zip format</h4>

<p class="install-help">If you have a lens in a .zip format, you may install it by uploading it here.</p>

<form action="<?php echo admin_url( 'update.php?action=upload-slidedeck-lens' ); ?>" method="post" enctype="multipart/form-data">
    <?php wp_nonce_field( "{$namespace}-upload-lens" ); ?>
    <input type="file" name="slidedecklenszip" />
    <input type="submit" value="Install Now" class="button" />
</form>
