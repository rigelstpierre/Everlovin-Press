<?php
/**
 * SlideDeck Dribbble Content Source
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

<div id="content-source-dribbble">
    <input type="hidden" name="source" value="<?php echo $slidedeck['source']; ?>" />
    <input type="hidden" name="type" value="<?php echo $this->type; ?>" />
    <div class="inner">
        <ul class="content-source-fields">
            <li>
                <?php slidedeck2_html_input( 'options[dribbble_username]', $slidedeck['options']['dribbble_username'], array( 'label' => __( "Dribbble Username", $this->namespace ), 'attr' => array( 'size' => 20, 'maxlength' => 255 ), 'required' => true ) ); ?>
            </li>
            <li>
                <?php slidedeck2_html_input( 'options[dribbble_shots_or_likes]', $slidedeck['options']['dribbble_shots_or_likes'], array( 'type' => 'radio', 'attr' => array( 'class' => 'fancy' ), 'label' => __( 'Show My', $this->namespace ), 'values' => array(
                    'shots' => __( 'Shots', $this->namespace ),
                    'likes' => __( 'Likes', $this->namespace )
                ) ) ); ?>
            </li>
            <li class="last dribbble cache-duration">
            	<?php 
					$tooltip = __( 'This is how often we will fetch new data from Dribbble', $this->namespace );
					include( SLIDEDECK2_DIRNAME . '/views/elements/_feed_cache_dration_slider.php' );
            	?>
            </li>
        </ul>
    </div>
    <?php include( SLIDEDECK2_DIRNAME . '/views/elements/_flyout-action-row.php' ); ?>
</div>