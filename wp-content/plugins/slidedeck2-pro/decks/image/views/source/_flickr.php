<?php
/**
 * SlideDeck Flickr Content Source
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

<div id="content-source-flickr">
    <input type="hidden" name="source" value="<?php echo $slidedeck['source']; ?>" />
    <input type="hidden" name="type" value="<?php echo $this->type; ?>" />
    <div class="inner">
        <ul class="content-source-fields">
            <li>
                <?php slidedeck2_html_input( 'options[flickr_recent_or_favorites]', $slidedeck['options']['flickr_recent_or_favorites'], array( 'type' => 'radio', 'attr' => array( 'class' => 'fancy' ), 'label' => __( 'Photos to get', $this->namespace ), 'values' => array(
                    'recent' => __( 'Recent', $this->namespace ),
                    'favorites' => __( 'Favorites', $this->namespace )
                ) ) ); ?>
            </li>
            <li>
                <?php 
                $tooltip = sprintf(__('This is your Flickr ID, not username. Check here for yours: %1$sidGettr.com%2$s.'), "<a href='http://idgettr.com/' target='_blank'>", '</a>');
                slidedeck2_html_input( 'options[flickr_userid]', $slidedeck['options']['flickr_userid'], array( 'label' => __( "User/Group ID", $this->namespace ), 'attr' => array( 'size' => 20, 'maxlength' => 255 ), 'required' => true ) );
                ?>
                <em><?php echo $tooltip; ?></em>
            </li>
            <li>
                <?php slidedeck2_html_input( 'options[flickr_tags_mode]', $slidedeck['options']['flickr_tags_mode'], array( 'type' => 'radio', 'attr' => array( 'class' => 'fancy' ), 'label' => __( 'Tag mode: ', $this->namespace ), 'values' => array(
                    'any' => __( 'Any of these', $this->namespace ),
                    'all' => __( 'All of these', $this->namespace )
                ) ) ); ?>
            </li>
            <li class="add-button-li">
                <div class="add-button-wrapper flickr">
                    <?php 
                    $tooltip = __('Enter one or more tags separated by commas.') . "<br />" . __('Tags can only be used with recent photos.');
                    slidedeck2_html_input( 'flickr-add-tag-field', '', array( 'label' => __( "Flickr Tags" . '<span class="tooltip" title="' . $tooltip . '"></span>', $this->namespace ), 'attr' => array( 'size' => 10, 'maxlength' => 255 ) ) );
                    ?>
                    <a class="flickr-tag-add add-button" href="#add"><?php _e( "Add", $this->namespace ); ?></a>
                </div>
                <div id="flickr-tags-wrapper"><?php echo $tags_html; ?></div>
            </li>
            <li class="last flickr cache-duration">
            	<?php 
					$tooltip = __( 'This is how often we will fetch new data from Flickr', $this->namespace );
					include( SLIDEDECK2_DIRNAME . '/views/elements/_feed_cache_dration_slider.php' );
            	?>
            </li>
        </ul>
    </div>
    <?php include( SLIDEDECK2_DIRNAME . '/views/elements/_flyout-action-row.php' ); ?>
</div>