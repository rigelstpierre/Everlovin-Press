<?php
/**
 * SlideDeck Vimeo Content Source
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
<div id="content-source-vimeo">
    <input type="hidden" name="source" value="<?php echo $slidedeck['source']; ?>" />
    <input type="hidden" name="type" value="<?php echo $this->type; ?>" />
    <div class="inner">
        <ul class="content-source-fields">
            <li>
                <?php slidedeck2_html_input( 'options[vimeo_username]', $slidedeck['options']['vimeo_username'], array( 'label' => __( "Vimeo Username", $this->namespace ), 'attr' => array( 'size' => 20, 'maxlength' => 255 ), 'required' => true ) ); ?>
                <a class="vimeo-username-ajax-update button" href="#update"><?php _e( "Update", $this->namespace ); ?></a>
            </li>
            <li>
                <?php if( $playlists_select ): ?>
                <div id="vimeo-user-playlists">
                    <?php echo $playlists_select; ?>
                </div>
                <?php endif; ?>
            </li>
            <li class="last vimeo cache-duration">
            	<?php 
					$tooltip = __( 'This is how often we will fetch new data from Vimeo', $this->namespace );
					include( SLIDEDECK2_DIRNAME . '/views/elements/_feed_cache_dration_slider.php' );
            	?>
            </li>
        </ul>
    </div>
    <?php include( SLIDEDECK2_DIRNAME . '/views/elements/_flyout-action-row.php' ); ?>
</div>