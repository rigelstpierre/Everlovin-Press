<?php
/**
 * SlideDeck RSS Content Source
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

<div id="content-source-rss">
    <input type="hidden" name="source" value="<?php echo $slidedeck['source']; ?>" />
    <input type="hidden" name="type" value="<?php echo $this->type; ?>" />
    <div class="inner">
        <ul class="content-source-fields">
            <li>
				<?php 
					slidedeck2_html_input( 'options[feedUrl]', $slidedeck['options']['feedUrl'], array( 'label' => __( "RSS Feed URL", $this->namespace ), 'attr' => array( 'size' => 40, 'maxlength' => 255 ), 'required' => true ) );
				?>
				<em><?php echo sprintf( __( 'Needs to be a valid RSS feed. See the %1$sW3C Feed Validator Service%2$s to check your feed. NOTE: Some servers are not configured to follow redirects, make sure you are using the feed URL&rsquo;s final destination URL.', $this->namespace ), "<a href='http://validator.w3.org/feed/' target='_blank'>", "</a>" ); ?></em>
            </li>
            <li class="last rss cache-duration">
            	<?php 
					$tooltip = __( 'This is how often we will fetch new data from the RSS feed', $this->namespace );
					include( SLIDEDECK2_DIRNAME . '/views/elements/_feed_cache_dration_slider.php' );
            	?>
            </li>
        </ul>
    </div>
    <?php include( SLIDEDECK2_DIRNAME . '/views/elements/_flyout-action-row.php' ); ?>
</div>