<?php
/**
 * SlideDeck Administrative Options
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
<div class="slidedeck-wrapper advanced-options">
    <?php slidedeck2_flash(); ?>
    <div class="wrap">
        <div class="slidedeck-header">
            <h1><?php _e( "SlideDeck Advanced Options", $namespace ); ?></h2>
        </div>
        <div id="slidedeck-option-wrapper">
            <p class="intro"><?php _e( "These options are for situations where SlideDeck might not be working correctly. Only change them if you are having difficulty with your SlideDeck installation, <em>or if you are certain of what they do</em>.", $namespace ); ?></p>
            <form action="" method="post" id="overview_options_form">
                <formset>
                    <div class="inner">
                        <?php wp_nonce_field( "{$this->namespace}-update-options" ); ?>
                        <ul>
                            <li>
                                <div class="slidedeck-license-key-wrapper">
                                	<?php slidedeck2_html_input( 'data[license_key]', slidedeck2_get_license_key(), array( 'attr' => array( 'class' => 'fancy license-key-text-field' ), 'label' => "Your SlideDeck License Key" ) ); ?>
                                	<?php wp_nonce_field( "{$this->namespace}_verify_license_key", 'verify_license_nonce' ); ?>
                                	<a href="#verify" class="verify-license-key button">Verify</a>
                                	<div class="license-key-verification-response"><span class="waiting">Waiting...</span></div>
                                </div>
                            </li>
                            <li>
                            	<?php slidedeck2_html_input( 'data[disable_wpautop]', $data['disable_wpautop'], array( 'attr' => array( 'class' => 'fancy' ), 'type' => 'checkbox', 'label' => "Disable <code>wpautop()</code> function?" ) ); ?>
                            </li>
                            <li>
                            	<?php slidedeck2_html_input( 'data[dont_enqueue_scrollwheel_library]', $data['dont_enqueue_scrollwheel_library'], array( 'attr' => array( 'class' => 'fancy' ), 'type' => 'checkbox', 'label' => "Don't enqueue the jquery.mousewheel.js library (if you have your own solution)" ) ); ?>
                            </li>
                            <li>
                            	<?php slidedeck2_html_input( 'data[dont_enqueue_easing_library]', $data['dont_enqueue_easing_library'], array( 'attr' => array( 'class' => 'fancy' ), 'type' => 'checkbox', 'label' => "Don't enqueue the jquery.easing.1.3.js library (if you have your own solution)" ) ); ?>
                            </li>
                            <li>
                            	<?php slidedeck2_html_input( 'data[disable_edit_create]', $data['disable_edit_create'], array( 'attr' => array( 'class' => 'fancy' ), 'type' => 'checkbox', 'label' => "Disable the ability to Add New and Edit SlideDecks for non Admins" ) ); ?>
                            </li>
                            <li>
                            	<?php slidedeck2_html_input( 'data[twitter_user]', $data['twitter_user'], array( 'attr' => array( 'class' => 'fancy' ), 'label' => "Twitter user to tweet via for overlays" ) ); ?>
                            </li>
                            <li>
                            	<?php slidedeck2_html_input( 'last_saved_instagram_access_token', $last_saved_instagram_access_token, array( 'attr' => array( 'class' => 'fancy' ), 'label' => "Last used Instagram Access Token" ) ); ?>
                            </li>
                            <li>
                            	<?php slidedeck2_html_input( 'last_saved_gplus_api_key', $last_saved_gplus_api_key, array( 'attr' => array( 'class' => 'fancy' ), 'label' => "Last used Google+ API Key" ) ); ?>
                            </li>
                        </ul>
                    </div>
                    <input type="submit" class="button-primary" value="Update Options" />
                </formset>
            </form>
        </div>
    </div>
</div>
