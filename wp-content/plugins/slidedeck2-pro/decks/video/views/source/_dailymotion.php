<?php
/**
 * SlideDeck Dailymotion Content Source
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

<div id="content-source-dailymotion">
    <input type="hidden" name="source" value="<?php echo $slidedeck['source']; ?>" />
    <input type="hidden" name="type" value="<?php echo $this->type; ?>" />
    <div class="inner">
        <ul class="content-source-fields">
            <li>
			    <?php slidedeck2_html_input( 'options[dailymotion_username]', $slidedeck['options']['dailymotion_username'], array( 'label' => __( "Username", $this->namespace ), 'attr' => array( 'size' => 20, 'maxlength' => 255 ), 'required' => true ) ); ?>
			    <a class="dailymotion-username-ajax-update button" href="#update"><?php _e( "Update", $this->namespace ); ?></a>
            </li>
            <li>
				<?php if( $playlists_select ): ?>
				<div id="dailymotion-user-playlists">
				    <?php echo $playlists_select; ?>
				</div>
				<?php endif; ?>
            </li>
            <li class="last dailymotion cache-duration">
            	<?php 
					$tooltip = __( 'This is how often we will fetch new data from Dailymotion', $this->namespace );
					include( SLIDEDECK2_DIRNAME . '/views/elements/_feed_cache_dration_slider.php' );
            	?>
            </li>
        </ul>
    </div>
    <?php include( SLIDEDECK2_DIRNAME . '/views/elements/_flyout-action-row.php' ); ?>
</div>