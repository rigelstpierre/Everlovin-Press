<?php
/**
 * SlideDeck Instagram Content Source
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

<div id="content-source-instagram">
    <input type="hidden" name="source" value="<?php echo $slidedeck['source']; ?>" />
    <input type="hidden" name="type" value="<?php echo $this->type; ?>" />
    <div class="inner">
        <ul class="content-source-fields">
            <li>
				<?php $tooltip =  __( 'Choose whether to show a user&rsquo;s recent photos, or photos that <em>you</em> have Liked!', $this->namespace ) ?>
			    <?php slidedeck2_html_input( 'options[instagram_recent_or_likes]', $slidedeck['options']['instagram_recent_or_likes'], array( 'type' => 'radio', 'attr' => array( 'class' => 'fancy' ), 'label' => __( 'Which Photos?' . '<span class="tooltip" title="' . $tooltip . '"></span>' , $this->namespace ), 'values' => array(
			        'recent' => __( 'Recent Photos', $this->namespace ),
			        'likes' => __( 'Your Likes', $this->namespace )
			    ) ) ); ?>
            </li>
            <li>
				<?php 
					$tooltip =  __( 'Instagram\'s API requires an access token to access your photos.', $this->namespace );
					$tooltip .= '<br />';
					$tooltip .= sprintf( __( 'Click %1$shere%2$s to get your token. (You only need to do this once)', $this->namespace ), "<a href='https://instagram.com/oauth/authorize/?client_id=529dede105394ad79dd253e0ec0ac090&redirect_uri=http%3A%2F%2Fwww.slidedeck.com%2Finstagram%3Fautofill_url%3D" . urlencode( WP_PLUGIN_URL ) . "%2F&response_type=code' target='_blank'>", '</a>' )
				?>
				<?php slidedeck2_html_input( 'options[instagram_access_token]', $token, array( 'label' => __( "Access Token" . '<span class="tooltip" title="' . $tooltip . '"></span>', $this->namespace ), array( 'size' => 40, 'maxlength' => 255 ), 'required' => true ) ); ?>
				<em class="note-below">Get your access token <a href="https://instagram.com/oauth/authorize/?client_id=529dede105394ad79dd253e0ec0ac090&redirect_uri=http%3A%2F%2Fwww.slidedeck.com%2Finstagram%3Fautofill_url%3D<?php echo base64_encode( admin_url( 'admin.php?' ) . http_build_query( $_GET ) ); ?>&response_type=code">here</a>.</em>
            </li>
            <li>
				<?php $tooltip =  __( 'This can be your Username or another user\'s Username', $this->namespace ) ?>
			    <?php slidedeck2_html_input( 'options[instagram_username]', $slidedeck['options']['instagram_username'], array( 'label' => __( "Username" . '<span class="tooltip" title="' . $tooltip . '"></span>', $this->namespace ), array( 'size' => 20, 'maxlength' => 255 ) ) ); ?>
            </li>
            <li class="last dribbble cache-duration">
            	<?php 
					$tooltip = __( 'This is how often we will fetch new data from Instagram', $this->namespace );
					include( SLIDEDECK2_DIRNAME . '/views/elements/_feed_cache_dration_slider.php' );
            	?>
            </li>
        </ul>
    </div>
    <?php include( SLIDEDECK2_DIRNAME . '/views/elements/_flyout-action-row.php' ); ?>
</div>