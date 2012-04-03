<?php
/**
 * SlideDeck Gplus Content Source
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

<div id="content-source-glpusimages">
    <input type="hidden" name="source" value="<?php echo $slidedeck['source']; ?>" />
    <input type="hidden" name="type" value="<?php echo $this->type; ?>" />
    <div class="inner">
        <ul class="content-source-fields">
            <li>
            	<?php $tooltip = sprintf( __( 'This is either the first part of your Gmail address *****@gmail.com %1$s or the number in the URL when you visit: %2$sYour Google+ Profile%3$s.', $this->namespace ), '<br />', "<a href='https://plus.google.com/me' target='_blank'>", '</a>' ); ?>
			    <?php slidedeck2_html_input( 'options[gplus_user_id]', $slidedeck['options']['gplus_user_id'], array( 'label' => __( "Google+ User ID" . '<span class="tooltip" title="' . $tooltip . '"></span>', $this->namespace ), 'attr' => array( 'size' => 20, 'maxlength' => 255 ), 'required' => true ) ); ?>
				<a class="gplus-images-ajax-update button" href="#update"><?php _e( "Update", $this->namespace ); ?></a>
            </li>
            <li>
				<?php if( $albums_select ): ?>
				<div id="gplus-user-albums" class="select-wrapper">
				    <?php echo $albums_select; ?>
				</div>
				<?php endif; ?>
            </li>
            <li>
            </li>
            <li class="gplusphotos max-image-size">
            	<?php 
            		global $SlideDeckPlugin;
            		$tooltip = sprintf( __( 'Google Allows %1$s to ask for images no larger than the size shown here. %2$s Choose a size appropriate for the deck you\'re making.', $this->namespace ), $SlideDeckPlugin->friendly_name, '<br />' );
            	?>
            	<label class="label" for="options-gplus_max_image_size"><?php _e( "Image Size" . '<span class="tooltip" title="' . $tooltip . '"></span>', $this->namespace ); ?></label>
            	<div class="jqueryui-slider-wrapper">
            		<div id="gplus-image-size-slider" class="image-size-slider"></div>
            		<span class="ui-slider-value gplus-image-size-slider-value"></span>
            	</div>
                <?php slidedeck2_html_input( 'options[gplus_max_image_size]', $slidedeck['options']['gplus_max_image_size'], array( 'type' => 'hidden', 'attr' => array( 'class' => 'feed-cache-duration', 'size' => 5, 'maxlength' => 5 ) ) ); ?>
            </li>
            <li class="last gplusphotos cache-duration">
            	<?php 
					$tooltip = __( 'This is how often we will fetch new data from Google/Picasa', $this->namespace );
					include( SLIDEDECK2_DIRNAME . '/views/elements/_feed_cache_dration_slider.php' );
            	?>
            </li>
        </ul>
    </div>
    <?php include( SLIDEDECK2_DIRNAME . '/views/elements/_flyout-action-row.php' ); ?>
</div>