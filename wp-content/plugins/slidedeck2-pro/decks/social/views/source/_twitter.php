<?php
/**
 * SlideDeck Twitter Content Source
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
$search_hidden = ( $slidedeck['options']['search_or_user'] == 'user' ) ? ' style="display: none;"' : '';
$username_hidden = ( $slidedeck['options']['search_or_user'] == 'search' ) ? ' style="display: none;"' : '';
?>

<div id="content-source-twitter">
    <input type="hidden" name="source" value="<?php echo $slidedeck['source']; ?>" />
    <input type="hidden" name="type" value="<?php echo $this->type; ?>" />
    <div class="inner">
        <ul class="content-source-fields">
            <li>
                <?php slidedeck2_html_input( 'options[search_or_user]', $slidedeck['options']['search_or_user'], array( 'type' => 'radio', 'attr' => array( 'class' => 'fancy' ), 'label' => __( 'Tweets from', $this->namespace ), 'values' => array(
                    'user' => __( 'Username', $this->namespace ),
                    'search' => __( 'Search Term', $this->namespace )
                ) ) ); ?>
            </li>
            <li class="twitter-search"<?php echo $search_hidden; ?>>
        		<?php slidedeck2_html_input( 'options[twitter_q]', $slidedeck['options']['twitter_q'], array( 'label' => __( 'Search Term', $this->namespace ), 'attr' => array( 'size' => 20, 'maxlength' => 255 ), 'required' => true ) ); ?>
            </li>
            <li class="twitter-username"<?php echo $username_hidden; ?>>
        		<?php slidedeck2_html_input( 'options[twitter_username]', $slidedeck['options']['twitter_username'], array( 'label' => __( 'Twitter Username', $this->namespace ), 'attr' => array( 'size' => 20, 'maxlength' => 255 ), 'required' => true ) ); ?>
            </li>
            <?php if( false ): ?>
            <li>
                <?php slidedeck2_html_input( 'options[twitter_scrape_images]', $slidedeck['options']['twitter_scrape_images'], array( 'type' => 'checkbox', 'label' => __( "Image Scraping?", $this->namespace ), 'attr' => array( 'class' => 'fancy' ) ) ); ?>
            </li>
            <?php endif; ?>
            <li class="last twitter cache-duration">
            	<?php 
					$tooltip = __( 'This is how often we will fetch new data from Twitter', $this->namespace );
					include( SLIDEDECK2_DIRNAME . '/views/elements/_feed_cache_dration_slider.php' );
            	?>
            </li>
        </ul>
    </div>
    <?php include( SLIDEDECK2_DIRNAME . '/views/elements/_flyout-action-row.php' ); ?>
</div>