<?php
/**
 * Constants used by this plugin
 * 
 * @package SlideDeck
 * @author dtelepathy
 */

// The current version of this plugin
if( !defined( 'SLIDEDECK2_VERSION' ) ) define( 'SLIDEDECK2_VERSION', '2.0.20120327' );

// Environment - change to "development" to load .dev.js JavaScript files (DON'T FORGET TO TURN IT BACK BEFORE USING IN PRODUCTION)
if( !defined( 'SLIDEDECK2_ENVIRONMENT' ) ) define( 'SLIDEDECK2_ENVIRONMENT', 'production' );

// The license of this plugin
if( !defined( 'SLIDEDECK2_LICENSE' ) ) define( 'SLIDEDECK2_LICENSE', 'PRO' );

// The directory the plugin resides in
if( !defined( 'SLIDEDECK2_DIRNAME' ) ) define( 'SLIDEDECK2_DIRNAME', dirname( dirname( __FILE__ ) ) );

// The URL path of this plugin
if( !defined( 'SLIDEDECK2_URLPATH' ) ) define( 'SLIDEDECK2_URLPATH', ( is_ssl() ? str_replace( "http://", "https://", WP_PLUGIN_URL ) : WP_PLUGIN_URL ) . "/" . plugin_basename( SLIDEDECK2_DIRNAME ) );

define( 'SLIDEDECK2_POST_TYPE',                      'slidedeck2' );
define( 'SLIDEDECK2_SLIDE_POST_TYPE',                'slidedeck_slide' );
define( 'SLIDEDECK1_POST_TYPE',                      'slidedeck' );
define( 'SLIDEDECK1_SLIDE_POST_TYPE',                'slidedeck_slide' );
define( 'SLIDEDECK2_CUSTOM_LENS_DIR',                WP_PLUGIN_DIR . "/slidedeck-lenses" );
define( 'SLIDEDECK2_CUSTOM_DECKS_DIR',               WP_PLUGIN_DIR . "/slidedeck-decks" );
define( 'SLIDEDECK2_IS_AJAX_REQUEST',                ( !empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) );
define( 'SLIDEDECK2_DEFAULT_LENS',                   'tool-kit' );

// SlideDeck anonymous user hash
define( 'SLIDEDECK2_USER_HASH', sha1( $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'] ) );
// KISS Metrics API Key
define( 'SLIDEDECK2_KMAPI_KEY', "d1b65dbd653f5c7f63692c5a3a17a7ad5d8d5d4d" );