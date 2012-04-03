<?php
/**
 * SlideDeck Google Plus Posts Content Source
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

<div id="content-source-gplus">
    <input type="hidden" name="source" value="<?php echo $slidedeck['source']; ?>" />
    <input type="hidden" name="type" value="<?php echo $this->type; ?>" />
    <div class="inner">
        <ul class="content-source-fields">
            <li>
				<?php slidedeck2_html_input( 'options[gplus_api_key]', $slidedeck['options']['gplus_api_key'], array( 'label' => "Google+ API key", 'attr' => array( 'size' => 40, 'maxlength' => 255 ), 'required' => true ) ); ?>
				<em class="note-below"><?php printf( __( 'You need an API Key to view your/someone else\'s Google+ Posts.%1$sHere\'s %2$show to get one%3$s. (you only need to do this once)' ), "<br />", "<a id='gplus-how-to' href='#'>", "</a>" ); ?></em>
            </li>
            <li>
				<?php 
					$tooltip = sprintf( __( 'The number in the URL when you visit: %1$sYour Google+ Profile%2$s.' ), "<a href='https://plus.google.com/me' target='_blank'>", "</a>" );
					slidedeck2_html_input( 'options[gplusUserId]', $slidedeck['options']['gplusUserId'], array( 'label' => "Google+ User Id" . '<span class="tooltip" title="' . __( "You can use yours, or someone else's user ID", $namespace ) . '"></span>', 'attr' => array( 'size' => 40, 'maxlength' => 255 ), 'required' => true ) );
				?>
				<em class="note-below"><?php echo $tooltip; ?></em>
            </li>
            <li class="last rss cache-duration">
            	<?php 
					$tooltip = __( 'This is how often we will fetch new data from Google+', $this->namespace );
					include( SLIDEDECK2_DIRNAME . '/views/elements/_feed_cache_dration_slider.php' );
            	?>
            </li>
        </ul>
    </div>
    <?php include( SLIDEDECK2_DIRNAME . '/views/elements/_flyout-action-row.php' ); ?>
</div>