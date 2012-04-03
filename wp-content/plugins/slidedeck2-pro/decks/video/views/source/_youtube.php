<?php
/**
 * SlideDeck YouTube Content Source
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
<div id="content-source-youtube"> 
    <input type="hidden" name="source" value="<?php echo $slidedeck['source']; ?>" />
    <input type="hidden" name="type" value="<?php echo $this->type; ?>" />
    <div class="inner">
        <ul class="content-source-fields">
            <li>
                <?php slidedeck2_html_input( 'options[search_or_user]', $slidedeck['options']['search_or_user'], array( 'type' => 'radio', 'label' => __( "Videos From", $this->namespace ), 'attr' => array( 'class' => 'fancy' ), 'values' => array( 
                    'search' => __( "Search Term", $this->namespace ),
                    'user' => __( "Username", $this->namespace )
                 ) ) ); ?>
            </li>
            <li class="youtube-search"<?php echo $search_hidden; ?>>
                <?php slidedeck2_html_input( 'options[youtube_q]', $slidedeck['options']['youtube_q'], array( 'label' => __( "Search Terms", $this->namespace ), 'attr' => array( 'size' => 20, 'maxlength' => 255 ), 'required' => true ) ); ?>
            </li>
            <li class="youtube-username"<?php echo $username_hidden; ?>>
                <?php slidedeck2_html_input( 'options[youtube_username]', $slidedeck['options']['youtube_username'], array( 'label' => __( "YouTube Username", $this->namespace ), 'attr' => array( 'size' => 20, 'maxlength' => 255 ), 'required' => true ) ); ?>
                <a class="youtube-username-ajax-update button" href="#update"><?php _e( "Update", $this->namespace ); ?></a>
            </li>
            <li class="youtube-username"<?php echo $username_hidden; ?>>
                <?php if( $playlists_select ): ?>
                <div id="youtube-user-playlists">
                    <?php echo $playlists_select; ?>
                </div>
                <?php endif; ?>
            </li>
            <li class="last youtube cache-duration">
            	<?php 
					$tooltip = __( 'This is how often we will fetch new data from YouTube', $this->namespace );
					include( SLIDEDECK2_DIRNAME . '/views/elements/_feed_cache_dration_slider.php' );
            	?>
            </li>
        </ul>
    </div>
    <?php include( SLIDEDECK2_DIRNAME . '/views/elements/_flyout-action-row.php' ); ?>
</div>
