<?php
/**
 * SlideDeck 2 Pro for WordPress - Slider Widget
 * 
 * Create SlideDecks on your WordPress blogging platform. Manage SlideDeck 
 * content and insert them into templates and posts.
 * 
 * @package SlideDeck
 * @subpackage SlideDeck 2 Pro for WordPress
 * @author dtelepathy
 */
/*
Plugin Name: SlideDeck 2 Pro for WordPress
Plugin URI: http://www.slidedeck.com/wordpress
Description: Create SlideDecks on your WordPress blogging platform and insert them into templates and posts. Get started creating SlideDecks from the new SlideDeck menu in the left hand navigation.
Version: 2.0.20120327
Author: digital-telepathy
Author URI: http://www.dtelepathy.com

Copyright (c) 2012 digital-telepathy (http://www.dtelepathy.com)

BY USING THIS SOFTWARE, YOU AGREE TO THE TERMS OF THE SLIDEDECK 
LICENSE AGREEMENT FOUND AT http://www.slidedeck.com/license. 
IF YOU DO NOT AGREE TO THESE TERMS, DO NOT USE THE SOFTWARE.

More information on this project:
http://www.slidedeck.com/

Full Usage Documentation: http://www.slidedeck.com/usage-documentation 
*/

// SlideDeck Plugin Basename
define( 'SLIDEDECK2_BASENAME', basename( __FILE__ ) );

// Include constants file
require_once( dirname( __FILE__ ) . '/lib/constants.php' );

// Include auto upgrade
require_once( dirname( __FILE__ ) . '/lib/slidedeck-auto-upgrade.php' );

class SlideDeckPlugin {
    var $namespace = "slidedeck";
    var $friendly_name = "SlideDeck 2";
    
    var $decks = array();
    
    // Default plugin options
    var $defaults = array(
        'disable_wpautop' => false,
        'dont_enqueue_scrollwheel_library' => false,
        'dont_enqueue_easing_library' => false,
        'disable_edit_create' => false,
        'twitter_user' => ""
    );
    
    // JavaScript to be run in the footer of the page
    var $footer_scripts = "";
    
    // Styles to override Lens and Deck styles
    var $footer_styles = "";
    
    // WordPress Menu Items
    var $menu = array();
    
    // Name of the option_value to store plugin options in
    var $option_name = "slidedeck_global_options";
    
    var $sizes = array(
        'small' => array(
            'label' => "Small",
            'width' => 300,
            'height' => 300
        ),
        'medium' => array(
            'label' => "Medium",
            'width' => 500,
            'height' => 500
        ),
        'large' => array(
            'label' => "Large",
            'width' => 960,
            'height' => 500
        ),
        'custom' => array(
            'label' => "Custom",
            'width' => 500,
            'height' => 500
        )
    );
    
    // Available slide animation transitions
    var $slide_transitions = array(
        'stack' => "Card Stack",
        'fade' => "Cross-fade",
        'flipHorizontal' => "Flip Horizontal",
        'flip' => "Flip Vertical",
        'slide' => "Slide (Default)"
    );
    
    // Taxonomy categories for SlideDeck types
    var $taxonomies = array(
        'images' => array(
            'label' => "Images",
            'color' => "#9a153c",
            'thumbnail' => '/images/taxonomy-images.png',
            'icon' => '/images/taxonomy-images-icon.png'
        ),
        'social' => array(
            'label' => "Social",
            'color' => "#024962",
            'thumbnail' => '/images/taxonomy-social.png',
            'icon' => '/images/taxonomy-social-icon.png'
        ),
        'posts' => array(
            'label' => "Posts",
            'color' => "#3c7120",
            'thumbnail' => '/images/taxonomy-posts.png',
            'icon' => '/images/taxonomy-posts-icon.png'
        ),
        'videos' => array(
            'label' => "Videos",
            'color' => "#434343",
            'thumbnail' => '/images/taxonomy-videos.png',
            'icon' => '/images/taxonomy-videos-icon.png'
        ),
        'feeds' => array(
            'label' => "Feeds",
            'color' => "#b24702",
            'thumbnail' => '/images/taxonomy-feeds.png',
            'icon' => '/images/taxonomy-feeds-icon.png'
        )
    );
    
    // Array of lenses that need loading on a page
    var $lenses_included = array();
    
    // Boolean of whether or not the Lenses have been loaded in the view yet
    var $lenses_loaded = false;
    
    // SlideDeck types being loaded on the page
    var $types_included = array();
    
    // SlideDeck font @imports being loaded on the page
    var $font_imports_included = array();
    
	// Options model groups for display in the order to be displayed
	var $options_model_groups = array( 'Appearance', 'Interface', 'Content', 'Behavior', 'Playback' );
    
    // Backgrounds for editor area
    var $stage_backgrounds = array(
        'light' => "Light", 
        'dark' => "Dark", 
        'wood' => "Wood"
    );
    
    var $order_options = array(
        'post_title' => "Alphabetical",
        'post_modified' => "Last Modified",
        'slidedeck_source' => "SlideDeck Source"
    );
    
    /**
     * Instantiation construction
     * 
     * @uses add_action()
     * @uses SlideDeckPlugin::wp_register_scripts()
     * @uses SlideDeckPlugin::wp_register_styles()
     */
    function __construct() {
        /**
         * Make this plugin available for translation.
         * Translations can be added to the /languages/ directory.
         */
        load_theme_textdomain( $this->namespace, SLIDEDECK2_DIRNAME . '/languages' );
        
        // Load all library files used by this plugin
        $lib_files = glob( SLIDEDECK2_DIRNAME . '/lib/*.php' );
        foreach( $lib_files as $filename ) {
            include_once( $filename );
        }
        
        // WordPress Pointers helper
        $this->Pointers = new SlideDeckPointers();
        
        // The Lens primary class
        include_once( SLIDEDECK2_DIRNAME . '/classes/slidedeck-lens.php' );
        $this->Lens = new SlideDeckLens();
        
        // The Cover primary class
        include_once( SLIDEDECK2_DIRNAME . '/classes/slidedeck-covers.php' );
        $this->Cover = new SlideDeckCovers();
        
        // The Lens scaffold
        include_once( SLIDEDECK2_DIRNAME . '/classes/slidedeck-lens-scaffold.php' );
        
        // The Deck primary class for Deck types to child from
        include_once( SLIDEDECK2_DIRNAME . '/classes/slidedeck.php' );
        
        // Stock Lenses that come with SlideDeck distribution
        $lens_files = glob( SLIDEDECK2_DIRNAME . '/lenses/*/lens.php' );
        if( is_dir( SLIDEDECK2_CUSTOM_LENS_DIR ) ) {
            if( is_readable( SLIDEDECK2_CUSTOM_LENS_DIR ) ) {
                // Get additional uploaded custom Lenses
                $custom_lens_files = (array) glob( SLIDEDECK2_CUSTOM_LENS_DIR . '/*/lens.php' );
                // Merge Lenses available and loop through to load
                $lens_files = array_merge( $lens_files, $custom_lens_files );
            }
        }
        
        // Load all the custom Lens types
        foreach( (array) $lens_files as $filename ) {
            if( is_readable( $filename ) ) {
                include_once( $filename );
                
                $classname = $this->get_classname( dirname( $filename ) );
                $prefix_classname = "SlideDeckLens_{$classname}";
                if( class_exists( $prefix_classname ) ) {
                    $this->lenses[$classname] = new $prefix_classname;
                }
            }
        }
        
        // Stock decks that come with SlideDeck distribution
        $deck_files = glob( SLIDEDECK2_DIRNAME . '/decks/*/deck.php' );
        if( is_dir( SLIDEDECK2_CUSTOM_DECKS_DIR ) ) {
            if( is_readable( SLIDEDECK2_CUSTOM_DECKS_DIR ) ) {
                // Get additional uploaded custom decks
                $custom_deck_files = (array) glob( SLIDEDECK2_CUSTOM_DECKS_DIR . '/*/deck.php' );
                // Merge decks available and loop through to load
                $deck_files = array_merge( $deck_files, $custom_deck_files );
            }
        }
        
        // Load all the custom deck types
        foreach( (array) $deck_files as $filename ) {
            if( is_readable( $filename ) ) {
                include_once( $filename );
                
                $classname = $this->get_classname( dirname( $filename ) );
                $prefix_classname = "SlideDeck_{$classname}";
                if( class_exists( $prefix_classname ) ) {
                    $this->decks[$classname] = new $prefix_classname;
                }
            }
        }
        
        $this->SlideDeck = new SlideDeck();
        
        $this->add_hooks();
    }

    /**
     * Save a SlideDeck autodraft
     * 
     * Saves a SlideDeck auto-draft and returns an array with dimension information, the ID
     * of the auto-draft and the URL for the iframe preview.
     * 
     * @param integer $slidedeck_id The ID of the parent SlideDeck
     * @param array $data All data about the SlideDeck being auto-drafted
     * 
     * @return array
     */
    private function _save_autodraft( $slidedeck_id, $data ) {
        // Preview SlideDeck object
        $preview = $this->SlideDeck->save_preview( $slidedeck_id, $data );
        
        $dimensions = $this->get_dimensions( $preview );
        
        $iframe_url =  $this->get_iframe_url( $preview['id'], $dimensions['width'], $dimensions['height'], $dimensions['outer_width'], $dimensions['outer_height'] );
        
        $response = $dimensions;
        $response['preview_id'] = $preview['id'];
        $response['preview'] = $preview;
        $response['url'] = $iframe_url;
        
        return $response;
    }
    
    /**
     * Get the URL for the specified plugin action
     * 
     * @param object $str [optional] Expects the handle passed in the menu definition
     * 
     * @uses admin_url()
     * 
     * @return The absolute URL to the plugin action specified
     */
    function action( $str = "" ) {
        $path = admin_url( "admin.php?page=" . SLIDEDECK2_BASENAME );
        
        if ( !empty( $str ) ) {
            return $path . $str;
        } else {
            return $path;
        }
    }

    /**
     * Hook into register_activation_hook action
     * 
     * Put code here that needs to happen when your plugin is first activated (database
     * creation, permalink additions, etc.)
     * 
     * @uses wp_remote_fopen()
     */
    static function activate() {
        if( !is_dir( SLIDEDECK2_CUSTOM_LENS_DIR ) ) {
            if( is_writable( dirname( SLIDEDECK2_CUSTOM_LENS_DIR ) ) ) {
                mkdir( SLIDEDECK2_CUSTOM_LENS_DIR, 0777 );
            }
        }
        
        if( !is_dir( SLIDEDECK2_CUSTOM_DECKS_DIR ) ) {
            if( is_writable( dirname( SLIDEDECK2_CUSTOM_DECKS_DIR ) ) ) {
                mkdir( SLIDEDECK2_CUSTOM_DECKS_DIR, 0777 );
            }
        }
		
        self::check_plugin_updates();
        
		$installed_version = get_option( "slidedeck_version", false );
		$installed_license = get_option( "slidedeck_license", false );
		
		if( $installed_license ) {
			if( strtolower( $installed_license ) == "lite" && strtolower( SLIDEDECK2_LICENSE ) == "pro" ) {
				// Upgrade from Lite to PRO
				slidedeck2_km( "Upgrade to PRO" );
			}
		}
		
		if( !$installed_version ) {
			// First time installation
			slidedeck2_km( "SlideDeck Installed" );
		}
		
		if( $installed_version && version_compare( SLIDEDECK2_VERSION,  $installed_version, '>' ) ) {
			// Upgrade to new version
			slidedeck2_km( "SlideDeck Upgraded" );
		}
		
		update_option( "slidedeck_version", SLIDEDECK2_VERSION );
		update_option( "slidedeck_license", SLIDEDECK2_LICENSE );
		
		// Activation
        slidedeck2_km( "SlideDeck Activated" );
    }

    /**
     * Add help tab to a page
     * 
     * Loads a help file and render's its content to an output buffer, using its content as content
     * for a help tab. Runs the WP_Screen::add_help_tab() method to create a help tab. Returns a boolean
     * value for success of the help addition. Will return boolean(false) if the help file could not
     * be found.
     * 
     * @param string $help_id The slug of the help content to get (the name of the help PHP file without the .php extension)
     * 
     * @return boolean
     */
    function add_help_tab( $help_id, $title ) {
        $help_filename = SLIDEDECK2_DIRNAME . '/views/help/' . $help_id . '.php';
        
        $success = false;
        
        if( file_exists( $help_filename ) ) {
            // Get the help file's HTML content
            ob_start();
                include( $help_filename );
                $html = ob_get_contents();
            ob_end_clean();
            
            get_current_screen()->add_help_tab( array(
                'id' => $help_id,
                'title' => __( $title, $this->namespace ),
                'content' => $html
            ) );
            
            $success = true;
        }
        
        return $success;
    }
    
    /**
     * Add in various hooks
     * 
     * Place all add_action, add_filter, add_shortcode hook-ins here
     */
    function add_hooks() {
        // Upload/Insert Media Buttons
        add_action( 'media_buttons', array( &$this, 'media_buttons' ), 20 );
        
        // Add SlideDeck button to TinyMCE navigation
        add_action( 'admin_init', array( &$this, 'add_tinymce_buttons' ) );
        
        // Options page for configuration
        add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
        add_action( 'admin_menu', array( &$this, 'license_key_check' ) );
        
        // Add JavaScript for pointers
        add_action( 'admin_print_footer_scripts', array( &$this, 'admin_print_footer_scripts' ) );

        // Add the JavaScript constants
        add_action( 'admin_print_footer_scripts', array( &$this, 'print_javascript_constants' ) );
        add_action( "{$this->namespace}_print_footer_scripts", array( &$this, 'print_javascript_constants' ) );
        add_action( 'wp_print_footer_scripts', array( &$this, 'print_javascript_constants' ) );

        // Add JavaScript and Stylesheets for admin interface on appropriate pages
        add_action( 'admin_print_scripts-slidedeck-2_page_slidedeck2/options', array( &$this, 'admin_print_scripts' ) );
        add_action( 'admin_print_styles-slidedeck-2_page_slidedeck2/options', array( &$this, 'admin_print_styles' ) );
        add_action( 'admin_print_scripts-toplevel_page_slidedeck2', array( &$this, 'admin_print_scripts' ) );
        add_action( 'admin_print_styles-toplevel_page_slidedeck2', array( &$this, 'admin_print_styles' ) );
        add_action( 'admin_print_scripts-slidedeck-2_page_slidedeck2/lenses', array( &$this, 'admin_print_scripts' ) );
        add_action( 'admin_print_styles-slidedeck-2_page_slidedeck2/lenses', array( &$this, 'admin_print_styles' ) );
        
        // Print editor page only styles
        add_action( 'admin_print_styles', array( &$this, 'admin_print_editor_styles' ) );
        
        // Load IE only stylesheets
        add_action( 'admin_print_styles', array( &$this, 'admin_print_ie_styles' ), 1000 );
        
        // Add custom post type
        add_action( 'init', array( &$this, 'register_post_types' ) );
        
        // Route requests for form processing
        add_action( 'init', array( &$this, 'route' ) );
        
        // Register all JavaScript files used by this plugin
        add_action( 'init', array( &$this, 'wp_register_scripts' ), 1 );
        
        // Register all Stylesheets used by this plugin
        add_action( 'init', array( &$this, 'wp_register_styles' ), 1 );
        
        // Hook into post save to save featured flag and featured title name
        add_action( 'save_post', array( &$this, 'save_post' ) );
        
        // Add AJAX actions
        add_action( "wp_ajax_{$this->namespace}2_blog_feed", array( &$this, 'ajax_blog_feed' ) );
        add_action( "wp_ajax_{$this->namespace}_change_lens", array( &$this, 'ajax_change_lens' ) );
        add_action( "wp_ajax_{$this->namespace}_change_source_view", array( &$this, 'ajax_change_source_view' ) );
        add_action( "wp_ajax_{$this->namespace}_create_new_with_slidedeck", array( &$this, 'ajax_create_new_with_slidedeck' ) );
        add_action( "wp_ajax_{$this->namespace}_covers_modal", array( &$this, 'ajax_covers_modal' ) );
        add_action( "wp_ajax_{$this->namespace}_edit_source", array( &$this, 'ajax_edit_source' ) );
        add_action( "wp_ajax_{$this->namespace}_first_save_dialog", array( &$this, 'ajax_first_save_dialog' ) );
        add_action( "wp_ajax_{$this->namespace}_getcode_dialog", array( &$this, 'ajax_getcode_dialog' ) );
        add_action( "wp_ajax_{$this->namespace}_gplus_posts_how_to_modal", array( &$this, 'ajax_gplus_posts_how_to_modal' ) );
        add_action( "wp_ajax_{$this->namespace}_insert_iframe", array( &$this, 'ajax_insert_iframe' ) );
        add_action( "wp_ajax_{$this->namespace}_insert_iframe_update", array( &$this, 'ajax_insert_iframe_update' ) );
        add_action( "wp_ajax_{$this->namespace}_preview_iframe", array( &$this, 'ajax_preview_iframe' ) );
        add_action( "wp_ajax_nopriv_{$this->namespace}_preview_iframe", array( &$this, 'ajax_preview_iframe' ) );
        add_action( "wp_ajax_{$this->namespace}_preview_iframe_update", array( &$this, 'ajax_preview_iframe_update' ) );
        add_action( "wp_ajax_{$this->namespace}_sort_manage_table", array( &$this, 'ajax_sort_manage_table' ) );
        add_action( "wp_ajax_{$this->namespace}_source_modal", array( &$this, 'ajax_source_modal' ) );
        add_action( "wp_ajax_{$this->namespace}_stage_background", array( &$this, 'ajax_stage_background' ) );
        add_action( "wp_ajax_{$this->namespace}2_tweet_feed", array( &$this, 'ajax_tweet_feed' ) );
        add_action( "wp_ajax_{$this->namespace}_validate_copy_lens", array( &$this, 'ajax_validate_copy_lens' ) );
        add_action( "wp_ajax_{$this->namespace}_verify_license_key", array( &$this, 'ajax_verify_license_key' ) );
        
        // Append necessary lens and initialization script commands to the bottom of the DOM for proper loading
        add_action( 'wp_print_footer_scripts', array( &$this, 'print_footer_scripts' ) );
        
        // Add required JavaScript and Stylesheets for displaying SlideDecks in public view    
        add_action( 'wp_print_scripts', array( &$this, 'wp_print_scripts' ) );
        
        // Front-end only actions
        if( !is_admin() ) {
            // Pre-loading for lenses used by SlideDeck(s) in post(s) on a page
            add_action( 'wp', array( &$this, 'wp_hook' ) );
            
            // Print required lens stylesheets
            add_action( 'wp_print_styles', array( &$this, 'wp_print_styles' ) );
        }
        
        add_action( 'update-custom_upload-slidedeck-lens', array( &$this, 'upload_lens' ) );
        
        // Add full screen buttons to post editor
        add_filter( 'wp_fullscreen_buttons', array( &$this, 'wp_fullscreen_buttons' ) );
        // Add a settings link next to the "Deactivate" link on the plugin listing page
        add_filter( 'plugin_action_links', array( &$this, 'plugin_action_links' ), 10, 2 );
        
		add_filter( "{$this->namespace}_options_model", array( &$this, 'slidedeck_options_model' ), 9999, 2 );
		
        // Add shortcode to replace SlideDeck shortcodes in content with SlideDeck contents
        add_shortcode( 'SlideDeck2', array( &$this, 'shortcode' ) );
    }

    /**
     * Setup TinyMCE button for fullscreen editor
     * 
     * @uses add_filter()
     */
    function add_tinymce_buttons() {
        add_filter( 'mce_external_plugins', array( &$this, 'add_tinymce_plugin' ) );
    }

    /**
     * Add the SlideDeck TinyMCE plugin to the TinyMCE plugins list
     * 
     * @param object $plugin_array The TinyMCE options array
     * 
     * @uses slidedeck_is_plugin()
     * 
     * @return object $plugin_array The modified TinyMCE options array
     */
    function add_tinymce_plugin( $plugin_array ) {
        if( !$this->is_plugin() ) {
            $plugin_array['slidedeck'] = SLIDEDECK2_URLPATH . '/js/tinymce3/editor-plugin.js';
        }
    
        return $plugin_array;
    }
    
    /**
     * Process update page form submissions
     * 
     * @uses slidedeck2_sanitize()
     * @uses wp_redirect()
     * @uses wp_verify_nonce()
     * @uses wp_die()
     * @uses update_option()
     * @uses esc_html()
     * @uses wp_safe_redirect()
     */
    function admin_options_update() {
        // Verify submission for processing using wp_nonce
        if( !wp_verify_nonce( $_REQUEST['_wpnonce'], "{$this->namespace}-update-options" ) )
            wp_die( __( "Unauthorized form submission!", $this->namespace ) );
    
        $data = array();
        /**
         * Loop through each POSTed value and sanitize it to protect against malicious code. Please
         * note that rich text (or full HTML fields) should not be processed by this function and 
         * dealt with directly.
         */
        foreach( $_POST['data'] as $key => $val ) {
            $data[$key] = slidedeck2_sanitize( $val );
        }
        
        // Get the old options
        $old_options = get_option( $this->option_name );
        
        $options = array( 
            'disable_wpautop' => isset( $data['disable_wpautop'] ) ? true : false,
            'dont_enqueue_scrollwheel_library' => isset( $data['dont_enqueue_scrollwheel_library'] ) ? true : false,
            'dont_enqueue_easing_library' => isset( $data['dont_enqueue_easing_library'] ) ? true : false,
            'disable_edit_create' => isset( $data['disable_edit_create'] ) ? true : false,
            'twitter_user' => str_replace( "@", "", $data['twitter_user'] ),
            'license_key' => $old_options['license_key']
        );
		
        /**
         * Verify License Key
         */
        $response_json = $this->is_license_key_valid( $data['license_key'] );
        if( $response_json !== false ){
            if( $response_json->valid == true ){
                $options['license_key'] = $data['license_key'];
            }
        } else {
            $options['license_key'] = $data['license_key'];
        }
        
        if( empty( $data['license_key'] ) )
            $options['license_key'] = '';
        
		/**
		 * Updating the options that
		 * need to be updated by themselves.
		 */
		// Update the Instagram Key
		update_option( $this->namespace . '_last_saved_instagram_access_token' , slidedeck2_sanitize( $_POST['last_saved_instagram_access_token'] ) );
		// Update the Google+ API  Key
		update_option( $this->namespace . '_last_saved_gplus_api_key' , slidedeck2_sanitize( $_POST['last_saved_gplus_api_key'] ) );

		/**
		 * Updating the options that can be serialized.
		 */
        // Update the options value with the data submitted
        update_option( $this->option_name, $options );
        
        slidedeck2_set_flash( "<strong>" . esc_html( __( "Options Successfully Updated", $this->namespace ) ) . "</strong>" );
        
		// Flush WordPress' memory of plugin updates.
		self::check_plugin_updates();
		
        // Redirect back to the options page with the message flag to show the saved message
        wp_safe_redirect( $_REQUEST['_wp_http_referer'] );
        exit;
    }

    /**
     * Print editor only styles
     */
    function admin_print_editor_styles() {
        if( in_array( basename( $_SERVER['PHP_SELF'] ), array( 'post.php', 'post-new.php' ) ) ) {
            include( SLIDEDECK2_DIRNAME . '/views/elements/_editor-styles.php' );
        }
    }

    /**
     * Load footer JavaScript for admin pages
     * 
     * @uses SlideDeckPlugin::is_plugin()
     * @uses SlideDeckPointers::render()
     */
    function admin_print_footer_scripts() {
        if( $this->is_plugin() ) {
            $this->Pointers->render();
			
			// Feedback tab
			echo '<a href="' . admin_url( 'admin.php?page=' . SLIDEDECK2_BASENAME . '/feedback' ) . '" target="_blank" id="slidedeck2-submit-ticket"><span>' . __( "Give Feedback", $this->namespace ) . '</span></a>';
        }
		
		// Add target="_blank" to feedback navigation element
		echo '<script type="text/javascript">var feedbacktab=jQuery("#toplevel_page_' . str_replace( ".php", "", SLIDEDECK2_BASENAME ) . '").find(".wp-submenu ul li a[href$=\'/feedback\']").attr("target", "_blank");jQuery(window).load(function(){jQuery("#slidedeck2-submit-ticket").addClass("visible")});</script>';
    }
    
    /**
     * Load JavaScript for the admin options page
     * 
     * @uses SlideDeckPlugin::is_plugin()
     * @uses wp_enqueue_script()
     */
    function admin_print_scripts() {
        echo '<script type="text/javascript">var SlideDeckInterfaces = {};</script>';
        
        wp_enqueue_script( "{$this->namespace}-library-js" );
        wp_enqueue_script( "{$this->namespace}-admin" );
        wp_enqueue_script( "{$this->namespace}-public" );
        wp_enqueue_script( "{$this->namespace}-preview" );
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_script( 'jquery-ui-slider' );
        wp_enqueue_script( 'thickbox' );
        wp_enqueue_script( 'editor' );
        wp_enqueue_script( 'media-upload' );
        wp_enqueue_script( 'quicktags' );
        wp_enqueue_script( 'fancy-form' );
        wp_enqueue_script( 'tooltipper' );
        wp_enqueue_script( 'simplemodal' );
        wp_enqueue_script( 'jquery-minicolors' );
	    wp_enqueue_script( 'wp-pointer' );
		wp_enqueue_script( 'zeroclipboard' );
		wp_enqueue_script( 'codemirror' );
		wp_enqueue_script( 'codemirror-mode-css' );
		wp_enqueue_script( 'codemirror-mode-javascript' );
		wp_enqueue_script( 'codemirror-mode-clike' );
		wp_enqueue_script( 'codemirror-mode-php' );
    }
    
    /**
     * Load stylesheets for the admin pages
     * 
     * @uses wp_enqueue_style()
     * @uses SlideDeckPlugin::is_plugin()
     * @uses SlideDeck::get()
     * @uses SlideDeckPlugin::wp_print_styles()
     */
    function admin_print_styles() {
        wp_enqueue_style( "{$this->namespace}-admin" );
        wp_enqueue_style( 'thickbox' );
        wp_enqueue_style( 'editor-buttons' );
        wp_enqueue_style( 'fancy-form' );
        
        // Make accommodations for the editing view to only load the lens files for the SlideDeck being edited
        if( $this->is_plugin() ){
            if( isset( $_GET['slidedeck'] ) ) {
                $slidedeck = $this->SlideDeck->get( $_GET['slidedeck'] );
                $lens = $slidedeck['lens'];
            } else {
                $lens = SLIDEDECK2_DEFAULT_LENS;
            }
            
            if( $this->SlideDeck->current_source == "gplus" ) {
                wp_enqueue_style( "gplus-how-to-modal" );
            }
            
            $this->lenses_included = array( $lens => 1 );
        }
        
		if( $this->is_plugin() ) {
		    wp_enqueue_style( 'wp-pointer' );
			wp_enqueue_style( 'codemirror' );
			wp_enqueue_style( 'codemirror-theme-default' );
            wp_enqueue_style( 'jquery-minicolors' );
		}
        
        // Run the non-admin print styles method to load required lens CSS files
        $this->wp_print_styles();
    }
    
    /**
     * Load IE only stylesheets for admin pages
     * 
     * @uses SlideDeckPlugin::is_plugin()
     */
    function admin_print_ie_styles() {
        if( $this->is_plugin() ) {
            echo '<!--[if lte IE 8]><link rel="stylesheet" type="text/css" href="' . SLIDEDECK2_URLPATH . '/css/ie.css" /><![endif]-->';
            echo '<!--[if gte IE 9]><link rel="stylesheet" type="text/css" href="' . SLIDEDECK2_URLPATH . '/css/ie9.css" /><![endif]-->';
        }
    }

    /**
     * Define the admin menu options for this plugin
     * 
     * @uses add_action()
     * @uses add_options_page()
     */
    function admin_menu() {
        $show_menu = true;
        if( $this->get_option( 'disable_edit_create' ) == true ) {
            if( !current_user_can('manage_options') ) {
                $show_menu = false;
            }
        }
        if( $show_menu === true ) {
            add_menu_page( 'SlideDeck 2', 'SlideDeck 2', 'publish_posts', SLIDEDECK2_BASENAME, array( &$this, 'page_route' ), SLIDEDECK2_URLPATH . '/images/icon.png', 37 );
            
            $this->menu['manage'] = add_submenu_page( SLIDEDECK2_BASENAME, 'Manage SlideDecks', 'Manage', 'publish_posts', SLIDEDECK2_BASENAME, array( &$this, 'page_route' ) );
            $this->menu['lenses'] = add_submenu_page( SLIDEDECK2_BASENAME, 'SlideDeck Lenses', 'Lenses', 'publish_posts', SLIDEDECK2_BASENAME . '/lenses', array( &$this, 'page_lenses_route' ) );
            $this->menu['options'] = add_submenu_page( SLIDEDECK2_BASENAME, 'SlideDeck Options', 'Advanced Options', 'publish_posts', SLIDEDECK2_BASENAME . '/options', array( &$this, 'page_options' ) );
            $this->menu['feedback'] = add_submenu_page( SLIDEDECK2_BASENAME, 'Give Feedback', 'Give Feedback', 'publish_posts', SLIDEDECK2_BASENAME . '/feedback', array( &$this, 'page_route' ) );
            
            add_action( "load-{$this->menu['manage']}", array( &$this, "load_admin_page" ) );
            add_action( "load-{$this->menu['lenses']}", array( &$this, "load_admin_page" ) );
            add_action( "load-{$this->menu['options']}", array( &$this, "load_admin_page" ) );
        }
    }

    /**
     * Outputs an <ul> for the SlideDeck Blog on the "Overview" page
     * 
     * @uses fetch_feed() 
     * @uses wp_redirect()
     * @uses SlideDeckPlugin::action()
     * @uses is_wp_error()
     * @uses SimplePie::get_item_quantity()
     * @uses SimplePie::get_items()
     */
    function ajax_blog_feed() {
        if( !SLIDEDECK2_IS_AJAX_REQUEST ) {
            wp_redirect( $this->action() );
            exit;
        }
        
        $rss = fetch_feed( array(
            'http://feeds.feedburner.com/Slidedeck',
            'http://feeds.feedburner.com/digital-telepathy'
        ) );
        
        // Checks that the object is created correctly
        if( !is_wp_error( $rss ) ) {
            // Figure out how many total items there are, but limit it to 5. 
            $maxitems = $rss->get_item_quantity( 3 ); 
        
            // Build an array of all the items, starting with element 0 (first element).
            $rss_items = $rss->get_items(0, $maxitems);
            
            include( SLIDEDECK2_DIRNAME . '/views/elements/_blog-feed.php' );
            exit;
        }
        
        die( "Could not connect to SlideDeck blog feed..." );
    }
    
    /**
     * Outputs SlideDeck Markup for the latest tweets deck
     * 
     * @uses fetch_feed() 
     * @uses wp_redirect()
     * @uses SlideDeckPlugin::action()
     * @uses is_wp_error()
     * @uses SimplePie::get_item_quantity()
     * @uses SimplePie::get_items()
     */
    function ajax_tweet_feed() {
        if( !SLIDEDECK2_IS_AJAX_REQUEST ) {
            wp_redirect( $this->action() );
            exit;
        }
        
        // Combines the dt and sd feeds:
        $rss = fetch_feed( array(
            'http://api.twitter.com/1/statuses/user_timeline.rss?screen_name=slidedeck',
            'http://api.twitter.com/1/statuses/user_timeline.rss?screen_name=dtelepathy',
        ) );
        
        // Checks that the object is created correctly
        if( !is_wp_error( $rss ) ) {
            // Figure out how many total items there are, but limit it to 5. 
            $maxitems = $rss->get_item_quantity( 5 ); 
        
            // Build an array of all the items, starting with element 0 (first element).
            $rss_items = $rss->get_items(0, $maxitems);
            
            $url_regex = '/((https?|ftp|gopher|telnet|file|notes|ms-help):((\/\/)|(\\\\))+[\w\d:#@%\/\;$()~_?\+-=\\\.&]*)/';
            $formatted_rss_items = array();
            foreach( $rss_items as $key => $value ) {
                $tweet = $value->get_title();
                
                // Remove the 'dtelepathy: ' part at the beginning of the feed:
                $tweet = preg_replace('/^[^\s]+:\s/', '', $tweet);
                // Link all the links:
                $tweet = preg_replace($url_regex, '<a href="$1" target="_blank">'. "$1" .'</a>', $tweet);
                // Link the hashtags and mentions 
                $tweet = preg_replace( array(
                    '/\@([a-zA-Z0-9_]+)/',    # Twitter Usernames
                    '/\#([a-zA-Z0-9_]+)/'    # Hash Tags
                ), array(
                    '<a href="http://twitter.com/$1" target="_blank">@$1</a>',
                    '<a href="http://twitter.com/search?q=%23$1" target="_blank">#$1</a>'
                ), $tweet );
                
                $formatted_rss_items[] = array(
                    'tweet' => $tweet,
                    'time_ago' => human_time_diff( strtotime( $value->get_date() ), current_time( 'timestamp' ) ) . " ago",
                    'permalink' => $value->get_permalink()
               );
            }
            
            include( SLIDEDECK2_DIRNAME . '/views/elements/_latest-tweets.php' );
            exit;
        }
        
        die( "Could not connect to Twitter..." );
    }
    
    /**
     * Change Lens for the current SlideDeck
     * 
     * @uses wp_verify_nonce()
     * @uses SlideDeckPlugin::_save_autodraft()
     * @uses apply_filters()
     */
    function ajax_change_lens() {
        // Fail silently if the request could not be verified
        if( !wp_verify_nonce( $_REQUEST['_wpnonce_lens_update'], 'slidedeck-lens-update' ) ) {
            die( "false" );
        }
        
		$namespace = $this->namespace;
		
        $slidedeck_id = intval( $_REQUEST['id'] );
        $response = $this->_save_autodraft( $slidedeck_id, $_REQUEST );
        
        $slidedeck = $response['preview'];
        
        $options_model = $this->get_options_model( $slidedeck );
		
		$lens = $this->Lens->get( $slidedeck['lens'] );
		$lens_classname = $this->get_classname( $slidedeck['lens'] );
		// If this Lens has an options model, loop through it and set the new defaults
		if( isset( $this->lenses[$lens_classname]->options_model) ) {
			$lens_options_model = $this->lenses[$lens_classname]->options_model;
            // Loop through Lens' option groups
			foreach( $lens_options_model as $lens_options_group => $lens_group_options ) {
			    // Loop through Lens' option group options
				foreach( $lens_group_options as $name => $properties ) {
				    // If the filtered options model has a value set, use it as an override to the saved value
					if( isset( $options_model[$lens_options_group][$name]['value'] ) )
						$slidedeck['options'][$name] = $options_model[$lens_options_group][$name]['value'];
				}
			}
		}
        
        $response['sizes'] = apply_filters( "{$this->namespace}_sizes", $this->sizes, $slidedeck );
        
		uksort( $options_model['Appearance']['titleFont']['values'], 'strnatcasecmp' );
		uksort( $options_model['Appearance']['bodyFont']['values'], 'strnatcasecmp' );
		
        // Trim out the Setup key
        $trimmed_options_model = $options_model;
        unset($trimmed_options_model['Setup']);
        $options_groups = $this->options_model_groups;
        
        $sizes = apply_filters( "{$this->namespace}_sizes", $this->sizes, $slidedeck );
        
        ob_start();
            include( SLIDEDECK2_DIRNAME . '/views/elements/_options.php' );
            $response['options_html'] = ob_get_contents();
        ob_end_clean();
        
		$response['lens'] = $lens;
		
        die( json_encode( $response ) );
    }

	/**
	 * AJAX event for changing which source view is used on the Manage page
	 * 
	 * @uses slidedeck2_km()
	 */
	function ajax_change_source_view() {
	    global $current_user;
        get_currentuserinfo();
        
        // Store the setting for later use
	    update_user_option( $current_user->ID, "{$this->namespace}_default_manage_view", $_REQUEST['view'] );
        
		slidedeck2_km( "Change Source View", array( 'view' => $_REQUEST['view'] ) );
	}
    
    /**
     * AJAX response for Covers edit modal
     */
    function ajax_covers_modal() {
        global $slidedeck_fonts; 
        
        $slidedeck_id = $_REQUEST['slidedeck'];
        
        $slidedeck = $this->SlideDeck->get( $slidedeck_id );
        $cover = $this->Cover->get( $slidedeck_id );
        
        $dimensions = $this->SlideDeck->get_dimensions( $slidedeck );
        $scaleRatio = 516 / $dimensions['outer_width'];
        if( $scaleRatio > 1 ) $scaleRatio = 1;
        
        $size_class = $slidedeck['options']['size'];
        if( $slidedeck['options']['size'] == "custom" ) {
            $size_class = $this->SlideDeck->get_closest_size( $slidedeck );
        }
        
        $namespace = $this->namespace;
        
        $cover_options_model = $this->Cover->options_model;
        
        // Options for both front and back covers
        $global_options = array(
            'title_font',
            'accent_color',
            'cover_style',
            'variation',
            'peek'
        );
        // Front cover options
        $front_options = array(
            'front_title',
            'show_curator'
        );
        // Back cover options
        $back_options = array(
            'back_title',
            'button_label',
            'button_url'
        );
        
		$variations = $this->Cover->variations;
		$cover_options_model['variation']['values'] = $variations[$cover['cover_style']];
        
        include( SLIDEDECK2_DIRNAME . '/views/cover-modal.php' );
        exit;
    }

    /**
     * Create a new post/page with a SlideDeck
     * 
     * @uses admin_url()
     * @uses current_user_can()
     * @uses get_post_type_object()
     * @uses wp_die()
     * @uses wp_insert_post()
     * @uses wp_redirect()
     */
    function ajax_create_new_with_slidedeck() {
        // Allowed post types to start with a SlideDeck
        $acceptable_post_types = array( 'post', 'page' );
        $post_type = in_array( $_REQUEST['post_type'], $acceptable_post_types ) ? $_REQUEST['post_type'] : 'post';
        
        // Get the post type object
        $post_type_object = get_post_type_object( $post_type );

        // Make sure the user can actually edit this post type, if not fail
        if( !current_user_can( $post_type_object->cap->edit_posts ) )
            wp_die( __( "You are not authorized to do that", $this->namespace ) );
        
        $slidedeck_id = intval( $_REQUEST['slidedeck'] );
        
        $params = array(
            'post_type' => $post_type,
            'post_status' => 'auto-draft',
            'post_title' => "",
            'post_content' => "<p>[SlideDeck2 id={$slidedeck_id}]</p>"
        );
        
        $new_post_id = wp_insert_post( $params );
        
        wp_redirect( admin_url( 'post.php?post=' . $new_post_id . '&action=edit' ) );
        exit;
    }
	
    /**
     * Delete a SlideDeck
     * 
     * AJAX response for deletion of a SlideDeck
     * 
     * @uses wp_verify_nonce()
     * @uses wp_delete_post()
     * @uses SlideDeckPlugin::load_slides()
     * @uses wp_remote_fopen()
     */
    function ajax_delete() {
        if( !SLIDEDECK2_IS_AJAX_REQUEST ) {
            wp_redirect( $this->action() );
            exit;
        }
        
        if( !wp_verify_nonce( $_REQUEST['_wpnonce'], "{$this->namespace}-delete-slidedeck" ) ) {
            die( "false" );
        }
        
        $slidedeck_id = $_REQUEST['slidedeck'];
        
        $this->SlideDeck->delete( $slidedeck_id );
        
        $redirect = $this->action() . "&msg_deleted=1";
        
		slidedeck2_km( "SlideDeck Deleted" );
		
        die( $redirect );
    }
    
    /**
     * Delete a lens
     * 
     * AJAX response for deleting a SlideDeck lens
     * 
     * @uses SlideDeckLens::delete()
     */
    function ajax_delete_lens() {
        if( !wp_verify_nonce( $_REQUEST['_wpnonce'], "{$this->namespace}-delete-lens" ) ) {
            die( "false" );
        }
        
        header( "Content Type: application/json" );
        
        $data = slidedeck2_sanitize( $_POST );
        $response = array(
            'message' => "Lens deleted successfuly",
            'error' => false
        );
        
        if( !isset( $data['lens'] ) ) {
            $response['message'] = "No lens was specified";
            $response['error'] = true;
            die( json_encode( $response ) );
        }
        
        if( !$response['error'] ) {
            $lens = $this->Lens->delete( $data['lens'] );
        }
        
        die( json_encode( $response ) );
    }
    
    /**
     * First save dialog box
     * 
     * AJAX response for display of first save dialog box
     * 
     * @uses SlideDeck::get()
     */
    function ajax_first_save_dialog() {
        $slidedeck_id = intval( $_REQUEST['slidedeck'] );
        $slidedeck = $this->SlideDeck->get( $slidedeck_id );
        $namespace = $this->namespace;
        
        include( SLIDEDECK2_DIRNAME . '/views/first-save-dialog.php' );
        exit;
    }
	
    /**
     * Get code dialog box
     * 
     * AJAX response for display of get code dialog box
     * 
     * @uses SlideDeck::get()
     */
    function ajax_getcode_dialog() {
        $slidedeck_id = intval( $_REQUEST['slidedeck'] );
        $slidedeck = $this->SlideDeck->get( $slidedeck_id );
        $namespace = $this->namespace;
        
        include( SLIDEDECK2_DIRNAME . '/views/getcode-dialog.php' );
        exit;
    }
	
    /**
     * Google+ Posts How to Modal
     * 
     * AJAX response for Google+ Posts How to Modal
     */
    function ajax_gplus_posts_how_to_modal() {
        $namespace = $this->namespace;
        
        include( SLIDEDECK2_DIRNAME . '/views/gplus-posts-how-to.php' );
        exit;
    }
	
    /**
     * Update a SlideDeck's source interface
     * 
     * AJAX response for getting a different content type's source interface
     */
    function ajax_edit_source() {
        if( !wp_verify_nonce( $_REQUEST['_wpnonce'], "{$this->namespace}-edit-source" ) ) {
            die( "false" );
        }
        
        // Deck types should hook in here and do their own processing
        do_action( "{$this->namespace}_ajax_edit_source", $_REQUEST['type'], $_REQUEST['source'], $_REQUEST['slidedeck'] );
        exit;
    }
    
    /**
     * Insert SlideDeck iframe
     * 
     * Generates a list of SlidDecks available to insert into a post
     * 
     * @global $wp_scripts
     * 
     * @uses SlideDeckPlugin::get_insert_iframe_table()
     */
    function ajax_insert_iframe() {
        global $wp_scripts;
        
        $order_options = $this->order_options;
        $orderby = isset( $_GET['orderby'] ) ? $_GET['orderby'] : get_option( "{$this->namespace}_manage_table_sort", reset( array_keys( $this->order_options ) ) );
        
        $namespace = $this->namespace;
        $previous_slidedeck_type = "";
        
        $insert_iframe_table = $this->get_insert_iframe_table( $orderby );
        
        include( SLIDEDECK2_DIRNAME . '/views/insert-iframe.php' );
        exit;
    }
    
    /**
     * AJAX update of Insert SlideDeck iframe table
     * 
     * Changes the ordering of the SlideDecks in the insert table
     * 
     * @uses wp_verify_nonce()
     * @uses wp_die()
     * @uses SlideDeckPlugin::get_insert_iframe_table()
     */
    function ajax_insert_iframe_update() {
        if( !wp_verify_nonce($_REQUEST['_wpnonce_insert_update'], "slidedeck-update-insert-iframe" ) )
            wp_die( __( "Unauthorized form submission!", $this->namespace ) );
        
        $selected = isset( $_REQUEST['slidedecks'] ) ? $_REQUEST['slidedecks'] : array();
        
        $insert_iframe_table = $this->get_insert_iframe_table( $_REQUEST['orderby'], (array) $selected );
        
        die( $insert_iframe_table );
    }
    
    /**
     * AJAX function for previewing a SlideDeck in an iframe
     * 
     * @param int $_GET['slidedeck_id'] The ID of the SlideDeck to load 
     * @param int $_GET['width'] The width of the preview window 
     * @param int $_GET['height'] The height of the preview window
     * @param int $_GET['outer_width'] The width of the SlideDeck in the preview window
     * @param int $_GET['outer_height'] The height of the SlideDeck in the preview window
     * 
     * @return the preview window as templated in views/preview-iframe.php
     */
    function ajax_preview_iframe() {
        global $wp_scripts, $wp_styles;

        $slidedeck_id = $_GET['slidedeck'];
        // $width = $_GET['width'];
        // $height = $_GET['height'];
        if( isset( $_GET['outer_width'] ) && is_numeric( $_GET['outer_width'] ) ) $outer_width = $_GET['outer_width'];
        // $outer_height = $_GET['outer_height'];
        
        $slidedeck = $this->SlideDeck->get( $slidedeck_id );
        
        $lens = $this->Lens->get( $slidedeck['lens'] );
        
		$preview = true;
		$namespace = $this->namespace;
		
        if( isset( $outer_width ) ) {
    		$preview_scale_ratio = $outer_width / 347;
    		$preview_font_size = intval( min( $preview_scale_ratio * 1000, 1139 ) ) / 1000;
        }
		
        $scripts = apply_filters( "{$this->namespace}_iframe_scripts", array( 'jquery', 'jquery-easing', 'scrolling-js', 'slidedeck-library-js', 'slidedeck-public' ), $slidedeck );
        
        $content_url = defined( 'WP_CONTENT_URL' )? WP_CONTENT_URL : '';
        $base_url = !site_url() ? wp_guess_url() : site_url();
        
        include( SLIDEDECK2_DIRNAME . '/views/preview-iframe.php' );
        exit;
    }
    
    /**
     * AJAX function for getting a new preview URL in an iframe
     * 
     * Saves an auto-draft of the SlideDeck being worked on and renders a JSON response
     * with the URL to update the preview iframe, showing the auto-draft values.
     */
    function ajax_preview_iframe_update() {
        // Fail silently if the request could not be verified
        if( !wp_verify_nonce( $_REQUEST['_wpnonce_preview'], 'slidedeck-preview-iframe-update' ) ) {
            die( "false" );
        }
        
        // Parent SlideDeck ID
        $slidedeck_id = intval( $_REQUEST['id'] );
        $response = $this->_save_autodraft( $slidedeck_id, $_REQUEST );
        
        die( json_encode( $response ) );
    }
    
    /**
     * AJAX sort of manage table
     * 
     * AJAX response to change sort of the manage view table of the user's SlideDecks.
     * Updates the chosen sort method as well and uses it here and the insert modal.
     * 
     * @uses wp_verify_nonce()
     * @uses SlideDeck::get()
     * @uses update_option()
     */
    function ajax_sort_manage_table() {
        if( !wp_verify_nonce( $_REQUEST['_wpnonce'], 'slidedeck-sort-manage-table' ) ) {
            die( "false" );
        }
        
        $orderby = in_array( $_REQUEST['orderby'], array_keys( $this->order_options ) ) ? $_REQUEST['orderby'] : reset( array_keys( $this->order_options ) );
        $order = $orderby == 'post_modified' ? 'DESC' : 'ASC';
        
        $namespace = $this->namespace;
        $slidedecks = $this->SlideDeck->get( null, $orderby, $order, 'publish' );
        
        update_option( "{$this->namespace}_manage_table_sort", $orderby );
        
        include( SLIDEDECK2_DIRNAME . '/views/elements/_manage-table.php' );
        exit;
    }
    
    /**
     * AJAX function for the source choice modal
     * 
     * @uses wp_verify_nonce()
     * @uses SlideDeckPlugin::get_sources_by_taxonomy()
     */
    function ajax_source_modal() {
        // Fail silently if the request could not be verified
        if( !wp_verify_nonce( $_REQUEST['_wpnonce'], 'slidedeck-source-modal' ) ) {
            die( "false" );
        }
        
        $taxonomy = $_REQUEST['taxonomy'];
        $sources = $this->get_sources_by_taxonomy( $taxonomy );
        $namespace = $this->namespace;
        
        $action = "create";
        if( isset( $_REQUEST['slidedeck'] ) && !empty( $_REQUEST['slidedeck'] ) ) {
            $action = "slidedeck_edit_source";
            $slidedeck_id = intval( $_REQUEST['slidedeck'] );
        }
        
        include( SLIDEDECK2_DIRNAME . '/views/elements/_source-modal.php');
        exit;
    }
    
    /**
     * AJAX response to save stage background preferences
     * 
     * @global $current_user
     * 
     * @uses get_currentuserinfo()
     * @uses wp_verify_nonce()
     * @uses update_post_meta()
     * @uses update_user_meta()
     */
    function ajax_stage_background() {
        global $current_user;
        get_currentuserinfo();
        
        // Fail silently if not authorized
        if( !wp_verify_nonce( $_REQUEST['_wpnonce'], "{$this->namespace}-stage-background" ) ) {
            exit;
        }
        
        $slidedeck_id = intval( $_POST['slidedeck'] );
        
        if( in_array( $_POST['background'], array_keys( $this->stage_backgrounds ) ) ) {
            update_post_meta( $slidedeck_id, "{$this->namespace}_stage_background", $_POST['background'] );
            update_user_meta( $current_user->ID, "{$this->namespace}_default_stage_background", $_POST['background'] );
        }
    }
    
    /**
     * AJAX response to validate a lens for copying 
     * 
     * @uses slidedeck2_sanitize()
     * @uses SlideDeckLens::get()
     */
    function ajax_validate_copy_lens() {
        header( "Content Type: application/json" );
        
        $data = slidedeck2_sanitize( $_REQUEST );
        $response = array(
            'valid' => true
        );
        
        if( !isset( $data['slug'] ) ) {
            $response['valid'] = false;
        }
        
        if( $response['valid'] !== false ) {
            $lens = $this->Lens->get( $data['slug'] );
            
            if( $lens !== false ) {
                $response['valid'] = false;
            }
        }
        
        die( json_encode( $response ) );
    }
    
    /**
     * Ajax Verify License Key
     * 
     * This function sends a request to the lciense server and
     * attempts to get a status on the lciense key in question.
     * 
	 * @uses wp_verify_nonce()
	 * @uses wp_die()
	 * @uses slidedeck2_sanitize()
	 * @uses wp_remote_post()
	 * @uses get_bloginfo()
	 * @uses is_wp_error()
	 * 
     * @return string
     */
    function ajax_verify_license_key() {
        if( !wp_verify_nonce( $_REQUEST['verify_license_nonce'], "{$this->namespace}_verify_license_key" ) )
            wp_die( __( "Unauthorized request!", $this->namespace ) );
        
        $key = $_REQUEST['key'];

        $response_json = $this->is_license_key_valid( $key );
        
        if( $response_json !== false ){
            if( $response_json->valid == true ) {
                // If the response is true, we save the key.
                
                // Get the options and then save em.
                $options = get_option( $this->option_name );
                $options['license_key'] = $key;
                update_option( $this->option_name, $options );
                
            }
            echo $response_json->message;
        } else {
            echo 'Connection error';
        }
        exit;
    }
    
    /**
     * Is Key Vaild?
     * 
     * @return object Response Object
     */
    function is_license_key_valid( $key ) {
        $key = slidedeck2_sanitize( $key );
        $upgrade_url = 'http://update.slidedeck.com/wordpress-update/' . md5( $key );
        
        $response = wp_remote_post( $upgrade_url, array(
                'method' => 'POST', 
                'timeout' => 4, 
                'redirection' => 5, 
                'httpversion' => '1.0', 
                'blocking' => true,
                'headers' => array(
                    'SlideDeck-Version' => SLIDEDECK2_VERSION,
                    'User-Agent' => 'WordPress/' . get_bloginfo("version"),
                    'Referer' => get_bloginfo("url"),
                    'Verify' => '1'
                ),
                'body' => null, 
                'cookies' => array(),
                'sslverify' => false
            )
        );
        
        if( !is_wp_error( $response ) ) {
            $response_body = $response['body'];
            $response_json = json_decode( $response_body );
            
            // Only return if the response is a JSON response
            if( is_object( $response_json ) ) {
                return $response_json;
            }
        }
        
        // Return boolean(false) if this request was not valid
        return false;
    }

	/**
	 * Copy a lens
	 * 
	 * Form submission response for copying a SlideDeck lens
	 * 
	 * @uses SlideDeckLens::copy()
	 */
	function copy_lens() {
        if( !wp_verify_nonce( $_REQUEST['_wpnonce'], "{$this->namespace}-copy-lens" ) ) {
            die( "false" );
        }
        
		$data = slidedeck2_sanitize( $_POST );
		
		if( !isset( $data['new_lens_slug'] ) ) {
		    slidedeck2_set_flash( "<strong>ERROR:</strong> " . esc_html( __( "No lens slug was specified", $this->namespace ) ), true );
            wp_redirect( $_REQUEST['_wp_http_referer'] );
            exit;
		}
        
        if( $this->Lens->get( $data['new_lens_slug'] ) !== false ) {
		    slidedeck2_set_flash( "<strong>ERROR:</strong> " . esc_html( __( "The lens slug must be unique", $this->namespace ) ), true );
            wp_redirect( $_REQUEST['_wp_http_referer'] );
            exit;
        }
		
	    // A new suggested lens name from the user
	    $new_lens_name = isset( $data['new_lens_name'] ) ? $data['new_lens_name'] : "";
        // A new suggested slug name from the user
        $new_lens_slug = isset( $data['new_lens_slug'] ) ? $data['new_lens_slug'] : "";
        
		$replace_js = false;
		if( $_REQUEST['create_or_copy'] == "create" )
			$replace_js = true;
		
		$lens = $this->Lens->copy( $data['lens'], $new_lens_name, $new_lens_slug, $replace_js );
		
        if( $lens ) {
            slidedeck2_set_flash( "<strong>" . esc_html( __( "Lens Copied Successfully", $this->namespace ) ) .  "</strong>" );
            slidedeck2_km( "New Lens Copied/Created" );
        } else {
            slidedeck2_set_flash( __( "<strong>ERROR:</strong> Could not copy skin because the " . SLIDEDECK2_CUSTOM_LENS_DIR . " directory is not writable or does not exist.", 'slidedeck' ), true );
        }
        
        wp_redirect( $this->action( "/lenses" ) );
        exit;
	}
    
	/**
	 * Delete plugin update record meta to re-check plugin for version update
	 * 
	 * @uses delete_option()
	 * @uses wp_update_plugins()
	 */
    public static function check_plugin_updates() {
        delete_option( '_site_transient_update_plugins' );
        wp_update_plugins();
    }
    
    /**
     * Hook into register_deactivation_hook action
     * 
     * Put code here that needs to happen when your plugin is deactivated
     * 
	 * @uses SlideDeckPlugin::check_plugin_updates()
     * @uses wp_remote_fopen()
     */
    static function deactivate() {
        self::check_plugin_updates();
        
		include( dirname( __FILE__ ) . '/lib/template-functions.php' );
		
        slidedeck2_km( "SlideDeck Deactivated" );
    }
    
    /**
     * Get the classname from a file name
     * 
     * Creates a string of the name of a class based off the name of a file.
     * All "-" characters in a file name will be treated as spaces, which will
     * then be eliminated to return a Pascal case class name. An optional class
     * prefix can be passed in as the second parameter.
     * 
     * @param string $filename The name of the file to get the class name from
     * @param string $prefix The optional prefix to use for the class name
     */
    function get_classname( $filename = "", $prefix = "" ) {
        $classname = $prefix . str_replace( " ", "", ucwords( preg_replace( array( '/\.php$/', '/\-/' ), array( "", " " ), basename( $filename ) ) ) );
        
        return $classname;
    }
    
    /**
     * Get dimensions of a SlideDeck
     * 
     * Returns an array of the inner and outer dimensions of the SlideDeck
     * 
     * @param array $slidedeck The SlideDeck object
     * 
     * @return array
     */
    function get_dimensions( $slidedeck ) {
        $dimensions = array();
        
        $sizes = apply_filters( "{$this->namespace}_sizes", $this->sizes, $slidedeck );
        
        $dimensions['width'] = $slidedeck['options']['size'] != "custom" ? $sizes[$slidedeck['options']['size']]['width'] : $slidedeck['options']['width'];
        $dimensions['height'] = $slidedeck['options']['size'] != "custom" ? $sizes[$slidedeck['options']['size']]['height'] : $slidedeck['options']['height'];
        $dimensions['outer_width'] = $dimensions['width'];
        $dimensions['outer_height'] = $dimensions['height'];
        
        do_action_ref_array( "{$this->namespace}_dimensions", array( &$dimensions['width'], &$dimensions['height'], &$dimensions['outer_width'], &$dimensions['outer_height'], &$slidedeck ) );
        
        return $dimensions;
    }
    
    /**
     * Get the URL for an iframe preview
     * 
     * @param integer $id The ID of the SlideDeck to preview
     * @param integer $width Optional width of the SlideDeck itself
     * @param integer $height Optional height of the SlideDeck itself
     * @param integer $outer_width Optional outer width of the SlideDeck iframe area
     * @param integer $outer_height Optional outer height of the SlideDeck iframe area
     */
    function get_iframe_url( $id, $width = null, $height = null, $outer_width = null, $outer_height = null ) {
        if( func_num_args() < 5 ) {
            $slidedeck = $this->SlideDeck->get( $id );
            if( empty( $slidedeck ) )
                return '';
            
            $slidedeck_dimensions = $this->get_dimensions( $slidedeck );
        }
        
        if( !isset( $width ) )
            $width = $slidedeck_dimensions['width'];
        
        if( !isset( $height ) )
            $height = $slidedeck_dimensions['height'];
        
        if( !isset( $outer_width ) )
            $outer_width = $slidedeck_dimensions['outer_width'];
        
        if( !isset( $outer_height ) )
            $outer_height = $slidedeck_dimensions['outer_height'];
        
        $dimensions = array(
            'width' => $width,
            'height' => $height,
            'outer_width' => $outer_width,
            'outer_height' => $outer_height
        );
        
        $url = admin_url( "admin-ajax.php?action={$this->namespace}_preview_iframe&slidedeck={$id}&" . http_build_query( $dimensions ) );
        
        return $url;
    }
    
    /**
     * Insert SlideDeck iframe URL
     * 
     * @global $post
     * 
     * @return string
     */
    function get_insert_iframe_src() {
        global $post;
        
        $url = admin_url( "admin-ajax.php?action={$this->namespace}_insert_iframe&post_id={$post->ID}&TB_iframe=1&width=640&height=515" );
        
        return $url;
    }
    
    /**
     * Get Insert SlideDeck iframe table
     * 
     * @param string $orderby What to order by (post_date|post_title|slidedeck_source)
     * @param array $selected Optional array of pre-selected SlideDecks
     * 
     * @uses SlideDeck::get()
     * 
     * @return string
     */
    function get_insert_iframe_table( $orderby, $selected = array() ) {
        // Swap direction when ordering by date so newest is first
        $order = $orderby == "post_modified" ? 'DESC' : 'ASC';
        // Get all SlideDecks
        $slidedecks = $this->SlideDeck->get( null, $orderby, $order, 'publish' );
        // Namespace for use in the view
        $namespace = $this->namespace;
        
        ob_start();
            include( SLIDEDECK2_DIRNAME . '/views/elements/_insert-iframe-table.php' );
            $html = ob_get_contents();
        ob_end_clean();
        
        return $html;
    }
    
    /**
     * Get License Key
     * 
     * Gets the current stored License Key
     * 
     * @return string
     */
    function get_license_key(){
        return (string) $this->get_option( 'license_key' );
    }
    
    /**
     * Retrieve the stored plugin option or the default if no user specified value is defined
     * 
     * @param string $option_name The name of the option you wish to retrieve
     * 
     * @uses get_option()
     * 
     * @return mixed Returns the option value or false(boolean) if the option is not found
     */
    function get_option( $option_name ) {
        // Load option values if they haven't been loaded already
        if( !isset( $this->options ) || empty( $this->options ) ) {
            $this->options = get_option( $this->option_name, $this->defaults );
        }
        
        if( array_key_exists( $option_name, $this->options ) ) {
            return $this->options[$option_name];    // Return user's specified option value
        } elseif( array_key_exists( $option_name, $this->defaults ) ) {
            return $this->defaults[$option_name];   // Return default option value
        }
        return false;
    }
    
    /**
     * Get the options model for this SlidDeck and lens
     * 
     * @param array $slidedeck The SlideDeck object
     */
    function get_options_model( $slidedeck ) {
        $options_model = apply_filters( "{$this->namespace}_options_model", $this->SlideDeck->options_model, $slidedeck );
        
        return $options_model;
    }
        
    /**
     * Get the source descriptor model array
     * 
     * Loops through all Deck instances and examines their sources. Returns the array
     * associated with the source requested if it could be found. If no source type was
     * found, returns an empty array.
     * 
     * @param string $source The source to retrieve
     * 
     * @return array
     */
    function get_source_model( $source ) {
        $source_model = array();
        
        foreach( $this->decks as $deck ) {
            if( array_key_exists( $source, $deck->sources ) ) {
                $source_model = $deck->sources[$source];
            }
        }
        
        return $source_model;
    }
	
	/**
	 * Get a content source's primary taxonomy
	 * 
	 * @param string $source Content source key
	 * 
	 * @uses SlideDeckPlugin::get_source_model()
	 * 
	 * @return string
	 */
	function get_source_primary_taxonomy( $source ) {
		$source_model = $this->get_source_model( $source );
		
		return reset( $source_model['taxonomies'] );
	}
    
    /**
     * Get all sources by their taxonomy
     * 
     * Returns an array of all the available content sources
     * 
     * @param string $taxonomy The taxonomy to retrieve
     * 
     * @return array
     */
    function get_sources_by_taxonomy( $taxonomy = "" ) {
        $sources_by_taxonomies = array();
        foreach( array_keys( $this->taxonomies ) as $tax )
            $sources_by_taxonomies[$tax] = array();
        
        foreach( $this->decks as &$deck ) {
            if( isset( $deck->sources ) ) {
                foreach( $deck->sources as $source => $source_properties ) {
                    if( isset( $source_properties['taxonomies'] ) ) {
                        foreach( $source_properties['taxonomies'] as $tax ) {
                            $sources_by_taxonomies[$tax][$source] = $source_properties;
                        }
                    }
                }
            }
        }
        
        $taxonomies = $sources_by_taxonomies;
        if( !empty( $taxonomy ) ) {
            $taxonomies = $sources_by_taxonomies[$taxonomy];
        }
        
        return $taxonomies;
    }
    
    /**
     * Get the type of deck by its source
     * 
     * Returns a string of the deck type
     * 
     * @param string $source The source to retrieve
     * 
     * @return string
     */
    function get_type_by_source( $source ) {
        $type = "";
        
        foreach( $this->decks as $deck )
            foreach( (array) $deck->sources as $deck_source )
                if( $deck_source['name'] == $source )
                    $type = $deck->type;
        
        return $type;
    }
    
    /**
     * Initialization function to hook into the WordPress init action
     * 
     * Instantiates the class on a global variable and sets the class, actions
     * etc. up for use.
     */
    static function instance() {
        global $SlideDeckPlugin;
        
        // Only instantiate the Class if it hasn't been already
        if( !isset( $SlideDeckPlugin ) ) $SlideDeckPlugin = new SlideDeckPlugin();
    }
    
    /**
     * Convenience method to determine if we are viewing a SlideDeck plugin page
     * 
     * @global $pagenow
     * 
     * @return boolean
     */
    function is_plugin() {
        global $pagenow;
		
        if( !function_exists( 'get_current_screen' ) )
            return false;
        
        $is_plugin = (boolean) in_array( get_current_screen()->id, array_values( $this->menu ) );
        
        return $is_plugin;
    }
    
    /**
     * License Key Check
     * 
     * Checks to see whether or not we need to hook into the admin
     * notices area and let the user know that they have not 
     * entered their lciense key.
     * 
     * @return boolean
     */
    function license_key_check() {
        global $current_user;
        wp_get_current_user();
        
        $license_key = $this->get_license_key();
        if ( empty( $license_key ) && !isset( $_POST['submit'] ) ) {
            add_action( 'admin_notices', array( &$this, 'license_key_notice' ) );
            return false;
        }
        return true;
    }
    
    /**
     * License Key Notice
     * 
     * Echoes the standard message for a license key 
     * that has not been entered.
     * 
     */
    function license_key_notice() {
        $message = "<div id='{$this->namespace}-license-key-warning' class='error fade'><p><strong>";
        $message .= sprintf( __( '%s is not activated yet.', $this->namespace ), $this->friendly_name );
        $message .= "</strong> ";
        $message .= sprintf( __( 'You must %1$senter your license key%2$s to show your SlideDecks on your site and receive automatic updates.', $this->namespace ), '<a class="button" style="text-decoration:none;color:#333;" href="admin.php?page=slidedeck2.php/options">', '</a>' );
        $message .= "</p></div>";
        
        echo $message;
    }
    
    /**
     * Hook into load-$page action
     * 
     * Implement help tabs for various admin pages related to SlideDeck
     */
    function load_admin_page() {
        $screen = get_current_screen();
        
        if( !in_array( $screen->id, $this->menu ) ) {
            return false;
        }
        
        // Page action for sub-section handling
        $action = isset( $_GET['action'] ) ? $_GET['action'] : "";
        
        switch( $screen->id ) {
            // SlideDeck Manage Page
            case $this->menu['manage']:
                
                switch( $action ) {
                    case "create":
                    case "edit":
                    break;
                    
                    default:
                        /**
                         * TODO: Add FAQ and Help Tab elements
                         * 
                         * $this->add_help_tab( 'whats-new', "What's New?" );
                         * $this->add_help_tab( 'faqs', "FAQs" );
                         */
                    break;
                }
                
            break;
        }
        
        do_action( "{$this->namespace}_help_tabs", $screen, $action );
    }
    
    /**
     * Hook into WordPress media_buttons action
     * 
     * Adds Insert SlideDeck button next to Upload/Insert media button on post and page editor pages
     */
    function media_buttons() {
        global $post;
        
        if ( in_array( basename( $_SERVER['PHP_SELF'] ), array( 'post-new.php', 'page-new.php', 'post.php', 'page.php' ) ) ) {
            $img = '<img src="' . esc_url( SLIDEDECK2_URLPATH . '/images/icon-15x15.png?v=' . SLIDEDECK2_VERSION ) . '" width="15" height="15" />';
            
            echo '<a href="' . esc_url( $this->get_insert_iframe_src() ) . '" class="thickbox add_slidedeck" id="add_slidedeck" title="' . esc_attr__( 'Insert your SlideDeck', $this->namespace ) . '" onclick="return false;"> ' .  $img . '</a>';
        }
    }
    
    /**
     * Create/Edit SlideDeck Page
     * 
     * Expects either a "slidedeck" or "type" URL parameter to be present. If a "slidedeck"
     * URL parameter is found, it will attempt to load the requested ID. If no "slidedeck"
     * URL parameter is found and a "type" parameter is found, a new SLideDeck of that type
     * will be created.
     * 
     * @global $current_user
     * 
     * @uses get_currentuserinfo()
     * @uses get_post_meta()
     * @uses get_user_meta()
     * @uses slidedeck2_set_flash()
     * @uses wp_redirect()
     * @uses SlideDeckPlugin::action()
     * @uses SlideDeck::get()
     * @uses SlideDeck::create()
     * @uses SlideDeckLens::get()
     * @uses apply_filters()
     */
    function page_create_edit() {
        global $current_user;
        get_currentuserinfo();
        
        $form_action = "create";
        if( isset( $_REQUEST['slidedeck'] ) ) {
            $form_action = "edit";
        }
        
        // Redirect to the manage page if creating and no type was specififed
        if( $form_action == "create" && !isset( $_REQUEST['source'] ) ) {
            slidedeck2_set_flash( "You must specify a valid SlideDeck type", true );
            wp_redirect( $this->action() );
            exit;
        }
        
        if( $form_action == "edit" ) {
            $slidedeck = $this->SlideDeck->get( $_REQUEST['slidedeck'] );
            
            // SlideDeck's saved stage background
            $the_stage_background = get_post_meta( $slidedeck['id'], "{$this->namespace}_stage_background", true );
        } else {
            $type = $this->get_type_by_source( $_REQUEST['source'] );
            $slidedeck = $this->SlideDeck->create( $type, (string) $_REQUEST['source'] );
            
            // Default stage background
            $the_stage_background = get_user_meta( $current_user->ID, "{$this->namespace}_default_stage_background", true );
        }
        
        if( !$slidedeck ) {
            slidedeck2_set_flash( "Requested SlideDeck could not be loaded or created", true );
            wp_redirect( $this->action() );
            exit;
        }
        
        // SlideDeck Type
        $type = $slidedeck['type'];
		
        // Legacy support
        if( $type == "legacy" ) {
            do_action( "{$this->namespace}_form", $slidedeck, $form_action );
            return false;
        }
        
        $sizes = apply_filters( "{$this->namespace}_sizes", $this->sizes, $slidedeck );
        $lenses = $this->Lens->get();
		
		$toolkit_index = -1;
		for( $i = 0; $i < count( $lenses ); $i++ ) {
			if( $lenses[$i]['slug'] == "tool-kit" ) {
				$toolkit_index = $i;
			}
		}
        
		if( $toolkit_index != -1 ) {
			$toolkit = $lenses[$toolkit_index];
			array_splice( $lenses, $toolkit_index, 1 );
			array_unshift( $lenses, $toolkit );
		}
        
        // Set preview rendering dimensions to chosen size
        $dimensions = $this->get_dimensions( $slidedeck );
        
        // Iframe URL for preview
        $iframe_url = $this->get_iframe_url( $slidedeck['id'], $dimensions['width'], $dimensions['height'], $dimensions['outer_width'], $dimensions['outer_height'] );
        
        $options_model = $this->get_options_model( $slidedeck );
        
		uksort( $options_model['Appearance']['titleFont']['values'], 'strnatcasecmp' );
		uksort( $options_model['Appearance']['bodyFont']['values'], 'strnatcasecmp' );
		
        // Trim out the Setup key
        $trimmed_options_model = $options_model;
        unset($trimmed_options_model['Setup']);
        $options_groups = $this->options_model_groups;
        
        $namespace = $this->namespace;
        
        // Get all available fonts
        $fonts = $this->SlideDeck->get_fonts( $slidedeck );
        
        // Get the source model array
        $source = $this->get_source_model( $slidedeck['source'] );
        
        // Backgrounds for the editor area
        $stage_backgrounds = $this->stage_backgrounds;
        
        $form_title = apply_filters( "{$namespace}_form_title", __( ucwords( $form_action ) . " SlideDeck", $this->namespace ), $slidedeck, $form_action );
        
        $has_saved_covers = $this->Cover->has_saved_covers( $slidedeck['id'] );
        
        include( SLIDEDECK2_DIRNAME . '/views/form.php' );
    }
    
    /**
     * Manage Existing SlideDecks Page
     * 
     * Loads all SlideDecks created by user and new creation options
     * 
     * @uses SlideDeck::get()
     */
    function page_manage() {
        $order_options = $this->order_options;
        $orderby = get_option( "{$this->namespace}_manage_table_sort", reset( array_keys( $this->order_options ) ) );
        $order = $orderby == 'post_modified' ? 'DESC' : 'ASC';
        
        // Get a list of all SlideDecks in the system
        $slidedecks = $this->SlideDeck->get( null, $orderby, $order, 'publish' );
        
        // Available SlideDeck types
        $decks = $this->decks;
        
        // Available taxonomies for SlideDeck types
        $taxonomies = $this->taxonomies;
        
        $all_sources = array();
        foreach( $decks as $deck ) {
            if( isset( $deck->sources ) )
                $all_sources = array_merge( $all_sources, (array) $deck->sources );
        }
		
        // Sources organized by taxonomy
        $sources_by_taxonomies = $this->get_sources_by_taxonomy();
        
        $sources_ordered = array();
        $sources_order = array( 'posts', 'medialibrary',
        'dailymotion',
        'dribbble',
        'flickr',
        'gplus',
        'gplusimages',
        'instagram',
        'listofvideos',
        'rss',
        'vimeo',
        'twitter',
        'youtube',
        );
        foreach( $sources_order as $source_slug ){
            $sources_ordered[$source_slug] = $all_sources[$source_slug];
        }
        
        $all_sources = $sources_ordered;
        
        // Initiate pointers on this page
        //$this->Pointers->pointer_lens_management();
        
		$default_view = get_user_option( "{$this->namespace}_default_manage_view" );
        if(!$default_view) $default_view = 'decks';
		
		$namespace = $this->namespace;
		
        // Render the overview list
        include( SLIDEDECK2_DIRNAME . '/views/manage.php' );
    }

    /**
     * The admin section options page rendering method
     * 
     * @uses current_user_can()
     * @uses wp_die()
     */
    function page_options() {
        if( !current_user_can( 'manage_options' ) )
            wp_die( __( "You do not have privileges to access this page", $this->namespace ) );
        
        $data = get_option( $this->option_name, array( 
            'disable_wpautop' => false,
            'dont_enqueue_scrollwheel_library' => false,
            'dont_enqueue_easing_library' => false,
            'disable_edit_create' => false,
            'license_key' => "",
            'twitter_user' => ""
        ) );
		
		$namespace = $this->namespace;
		
		/**
		 * We handle these separately due to the funky characters.
		 * Let's not risk breaking serialization.
		 */
		// Get the Instagram Key
		$last_saved_instagram_access_token = get_option( $this->namespace . '_last_saved_instagram_access_token' );
		// Get the Google+ API  Key
		$last_saved_gplus_api_key = get_option( $this->namespace . '_last_saved_gplus_api_key' );
        
        include( SLIDEDECK2_DIRNAME . '/views/admin-options.php' );
    }
	
	/**
	 * SlideDeck Lens Add New View
	 * 
	 * Page to upload a new lens to the user's WordPress installation.
	 * 
	 * @uses current_user_can()
	 * @uses wp_die()
	 */
	function page_lenses_add() {
		if( !current_user_can( 'install_themes' ) )
			wp_die( __( "You do not have privileges to access this page", $this->namespace ) );
		
		$namespace = $this->namespace;
		
		include( SLIDEDECK2_DIRNAME . '/views/lenses/add.php' );
	}
    
    /**
     * SlideDeck Lens Copy View
     * 
     * Page to enter new SlideDeck lens name and slug. This is an interim page for copying a lens.
     * 
     * @uses current_user_can()
     * @uses wp_die()
     * @uses SlideDeckPlugin::action()
     * @uses slidedeck2_sanitize()
     * @uses SlideDeckLens::copy_inc()
     */
    function page_lenses_copy() {
        if( !current_user_can( 'edit_themes' ) )
            wp_die( __( "You do not have privileges to access this page", $this->namespace ) );
        
        if( !isset( $_REQUEST['lens'] ) )
            wp_die( '<h3>' . __( "You did not specify a lens", $this->namespace ) . '</h3><p><a href="' . $this->action( '/lenses' ) . '">' . __( "Return to Manage Lenses", $this->namespace ) . '</a></p>' );
        
        $lens_slug = slidedeck2_sanitize( $_REQUEST['lens'] );
        $lens = $this->Lens->get( $lens_slug );
        $namespace = $this->namespace;
        
		$new_lens_slug_base = isset( $_REQUEST['new_lens_slug'] ) ? $_REQUEST['new_lens_slug'] : $lens['slug'];
		$new_lens_name_base = isset( $_REQUEST['new_lens_name'] ) ? $_REQUEST['new_lens_name'] : $lens['meta']['name'];
		
        // Find an incremented value to use as a suffix for what copy of the lens this would be
        $copy_inc = $this->Lens->copy_inc( $new_lens_slug_base );
        
        // Suggested new lens name
        $new_lens_name = $new_lens_name_base;
        if( $copy_inc > 0 ) $new_lens_name .= " (Copy $copy_inc)";
        // Suggested new lens slug
        $new_lens_slug = "$new_lens_slug_base";
        if( $copy_inc > 0 ) $new_lens_slug .= "-$copy_inc";
        
		$create_or_copy = isset( $_REQUEST['create_or_copy'] ) && $_REQUEST['create_or_copy'] == "create" ? 'create' : 'copy';
		
        include( SLIDEDECK2_DIRNAME . '/views/lenses/copy.php' );
    }
    
    /**
     * SlideDeck Lens Editor View
     * 
     * Page to edit SlideDeck lenses. This page will load the requested lens' primary lens CSS
     * file by default and can also load other lens CSS and JavaScript files for editing as well.
     * Lenses are intelligently displayed to prevent modification of protected lens files.
     * 
     * @uses current_user_can()
     * @uses wp_die()
     * @uses SlideDeckPlugin::action()
     * @uses SlideDeckLens::get()
     * @uses SlideDeckLens::is_protected()
     * @uses esc_textarea()
     * @uses SlideDeckLens::get_content()
     */
    function page_lenses_edit() {
        // Die if user cannot edit themes
        if( !current_user_can( 'edit_themes' ) )
            wp_die( __( "You do not have privileges to access this page", $this->namespace ) );
        
        $lens_slug = array_key_exists( 'slidedeck-lens', $_REQUEST ) ? $_REQUEST['slidedeck-lens'] : "";
        
        // Redirect back to lens management page if no lens was specified
        if( empty( $lens_slug ) )
            wp_die( '<h3>' . __( "You did not specify a lens", $this->namespace ) . '</h3><p><a href="' . $this->action( '/lenses' ) . '">' . __( "Return to Manage Lenses", $this->namespace ) . '</a></p>' );
        
		// Namespace
		$namespace = $this->namespace;
        // This lens
        $lens = $this->Lens->get( $lens_slug );
		// All lenses for drop-down selection
		$lenses = $this->Lens->get();
        // Available Deck types
        $decks = $this->decks;
        
        // Editable lens files and their labels
        $lens_file_labels = array(
            'lens.css' => __( "Lens Stylesheet", $namespace ),
            'lens.ie.css' => __( "Lens Stylesheet (IE)", $namespace ),
            'lens.ie7.css' => __( "Lens Stylesheet (IE 7)", $namespace ),
            'lens.ie8.css' => __( "Lens Stylesheet (IE 8)", $namespace ),
            'lens.php' => __( "Lens PHP Logic", $namespace ),
            'lens.js' => __( "Lens JavaScript", $namespace ),
            'lens.admin.js' => __( "Lens Admin JavaScript", $namespace ),
            'template.thtml' => __( "Default Slide Template", $namespace )
        );
        foreach( $this->taxonomies as $taxonomy => $tax_properties ) {
        	$lens_file_labels["template.{$taxonomy}.thtml"] = __( "{$tax_properties['label']} Template", $namespace );
        }
		
		$sources = array();
		foreach( $this->decks as $deck ) {
			foreach( $deck->sources as $source => $source_model ) {
				$sources[$source] = $source_model;
			}
		}
        
        // Check for editable source templates
        foreach( $sources as $source => $source_properties ) {
        	$lens_file_labels["template.source.{$source}.thtml"] = __( "{$source_properties['label']} Template", $namespace );
        }
        
        // Get the lens file to load from the lens itself or the requested file
        $lens_filename = isset( $_REQUEST['filename'] ) ? dirname( $lens['files']['css'] ) . "/" . $_REQUEST['filename'] : $lens['files']['css'];
        
        // Check writable status of lens
        $read_only = !is_writable( $lens_filename );
        
        // Check if this is a protected lens and set it to un-writable
        if( $this->Lens->is_protected( $lens_filename ) )
            $read_only = true;
        
        // Make sure that the lens filename being requested for editing is a valid file to edit
        if( !in_array( basename( $lens_filename ), array_keys( $lens_file_labels ) ) )
            wp_die( '<h3>' . __( "Invalid file specified", $this->namespace ) . '</h3><p>' . __( "The lens file you requested is not a valid editable file.", $this->namespace ) . '</p><p><a href="' . $this->action( '/lenses' ) . '">' . __( "Return to Manage Lenses", $this->namespace ) . '</a></p>' );
        
		// Raw CSS content of the lens.css file (without the meta comment)
		$lens_file_content = esc_textarea( $this->Lens->get_content( $lens_filename, ( basename( $lens_filename ) == basename( $lens['files']['meta'] ) ) ) );
        
        // Get all editable lens files
        $lens_files = array();
        foreach( glob( dirname( $lens['files']['css'] ) . "/*" ) as $file )
            if( in_array( basename( $file ), array_keys( $lens_file_labels ) ) )
                $lens_files[] = $file;
        
        include( SLIDEDECK2_DIRNAME . '/views/lenses/edit.php' );
    }
    
    /**
     * SlideDeck Lens Management Page
     * 
     * Renders the primary lens management page where a user can see their existing lenses, upload
     * new lenses, make copies of lenses, access a lens for editing and delete existing lenses.
     * 
     * @uses current_user_can()
     */
    function page_lenses_manage() {
        // Die if user cannot manage options
        if( !current_user_can( 'manage_options' ) )
            wp_die( __( "You do not have privileges to access this page", $this->namespace ) );
        
        $namespace = $this->namespace;
		
		$sources = array();
		foreach( $this->decks as $deck ) {
			foreach( $deck->sources as $source => $source_model ) {
				$sources[$source] = $source_model;
			}
		}
        
        $lenses = $this->Lens->get();
        foreach( $lenses as &$lens ) {
            $lens['is_protected'] = $this->Lens->is_protected( $lens['files']['meta'] );
        }
        
        $is_writable = $this->Lens->is_writable();
        
        include( SLIDEDECK2_DIRNAME . '/views/lenses/manage.php' );
    }
    
    /**
     * SlideDeck Lenses Page Router
     * 
     * Routes admin page requests to the appropriate SlideDeck Lens page for managing, editing
     * and uploading new lenses.
     */
    function page_lenses_route() {
        $action = array_key_exists( 'action', $_REQUEST ) ? $_REQUEST['action'] : "";
        
        switch( $action ) {
            case "edit":
                $this->page_lenses_edit();
            break;
            
            case "copy":
                $this->page_lenses_copy();
            break;
            
            case "add":
                $this->page_lenses_add();
            break;
            
            case "manage":
            default:
                $this->page_lenses_manage();
            break;
        }
    }
    
    /**
     * SlideDecks Page Router
     * 
     * Based off the action requested the page will either display the manage view for managing 
     * existing SlideDecks (default) or the editing/creation view for a SlideDeck.
     * 
     * @uses SlideDeckPlugin::page_manage()
     * @uses SlideDeckPlugin::page_create_edit()
     */
    function page_route() {
        $action = array_key_exists( 'action', $_REQUEST ) ? $_REQUEST['action'] : "";
        
        switch( $action ) {
            // Create a new SlideDeck
            case "create":
                $this->page_create_edit();
            break;
                
            // Edit existing SlideDecks
            case "edit":
                $this->page_create_edit();
            break;
            
            // Manage existing SlideDecks
            default:
                $this->page_manage();
            break;
        }
    }

    /**
     * Hook into plugin_action_links filter
     * 
     * Adds a "Settings" link next to the "Deactivate" link in the plugin listing page
     * when the plugin is active.
     * 
     * @param object $links An array of the links to show, this will be the modified variable
     * @param string $file The name of the file being processed in the filter
     */
    function plugin_action_links( $links, $file ) {
        $new_links = array();
        
        if( $file == plugin_basename( SLIDEDECK2_DIRNAME . '/' . SLIDEDECK2_BASENAME ) ) {
            $new_links[] = '<a href="admin.php?page=' . SLIDEDECK2_BASENAME . '">' . __( 'Create New SlideDeck' ) . '</a>';
        }
        
        return array_merge( $new_links, $links );
    }

    /**
     * Truncate the title string
     * 
     * Truncate a title string for better visual display in Smart SlideDecks.This
     * function is multibyte aware so it should handle UTF-8 strings correctly.
     * 
     * @param $text str The text to truncate
     * @param $length int (100) The length in characters to truncate to
     * @param $ending str The ending to tack onto the end of the truncated title (if the title was truncated)
     */
    function prepare_title( $text, $length = 100, $ending = '&hellip;' ) {
        $truncated = mb_substr( strip_tags( $text ), 0, $length, 'UTF-8' );
        
        $original_length = function_exists( 'mb_strlen' ) ? mb_strlen( $text, 'UTF-8' ) : strlen( $text );
        
        if( $original_length > $length ) {
            $truncated.= $ending;
        }
        
        return $truncated;
    }
    
    /**
     * Used for printing out the JavaScript commands to load SlideDecks and appropriately
     * read the DOM for positioning, sizing, dimensions, etc.
     * 
     * @return Echo out the JavaScript tags generated by slidedeck_process_template;
     */
    function print_footer_scripts() {
        echo $this->footer_scripts;
        echo '<style type="text/css" id="' . $this->namespace . '-footer-styles">' . $this->footer_styles . '</style>';
        
        do_action( "{$this->namespace}_print_footer_scripts" );
    }
    
    /**
     * Print JavaScript Constants
     * 
     * prints some JavaScript constants that are used for
     * covers and other UI elements.
     */
    function print_javascript_constants() {
        echo '<script type="text/javascript">' . "\n";
        echo 'var slideDeck2URLPath = "' . SLIDEDECK2_URLPATH . '"' . "\n";
        echo '</script>' . "\n";
    }

    /**
     * Run the the_content filters on the passed in text
     * 
     * @param object $content The content to process
     * @param object $editing Process for editing or for viewing (viewing is default)
     * 
     * @uses do_shortcode()
     * @uses get_user_option()
     * @uses SlideDeckPlugin::get_option()
     * @uses wpautop()
     * 
     * @return object $content The formatted content
     */
    function process_slide_content( $content, $editing = false ) {
        $content = stripslashes( $content );
        
        if( $editing === false ) {
            $content = do_shortcode( $content );
        }
        
        if( 'true' == get_user_option( 'rich_editing' ) || ( $editing === false ) ){
            if( $this->get_option( 'disable_wpautop' ) != true ) {
                $content = wpautop( $content );
            }
        }
        
        $content = str_replace( ']]>', ']]&gt;', $content );
        
        return $content;
    }

    /**
     * Add the SlideDeck button to the TinyMCE interface
     * 
     * @param object $buttons An array of buttons for the TinyMCE interface
     * 
     * @return object $buttons The modified array of TinyMCE buttons
     */
    function register_button( $buttons ) {
        array_push( $buttons, "separator", "slidedeck" );
        return $buttons;
    }

    /**
     * Register post types used by SlideDeck 
     * 
     * @uses register_post_type
     */
    function register_post_types() {
        register_post_type( 'slidedeck2',
            array(
                'labels' => array(
                    'name' => 'slidedeck2',
                    'singular_name' => __( 'SlideDeck 2', $this->namespace )
                ),
                'public' => false
            )
        );
        register_post_type( 'slidedeck_slide',
            array(
                'labels' => array(
                    'name' => 'slidedeck_slide',
                    'singular_name' => __( 'SlideDeck Slide', $this->namespace )
                ),
                'public' => false
            )
        );
    }
    
    /**
     * Render a SlideDeck in an iframe
     * 
     * Generates an iframe tag with a SlideDeck rendered in it. Only accessible via
     * the shortcode with the iframe property set.
     * 
     * @param integer $id SlideDeck ID
     * @param integer $width Width of SlideDeck
     * @param integer $height Height of SlideDeck
     * @param boolean $nocovers Whether or not to include covers in the render
     * 
     * @global $wp_scripts
     * 
     * @uses SlideDeck::get()
     * @uses SlideDeck::get_unique_id()
     * @uses SlideDeckPlugin::get_dimensions()
     * @uses SlideDeckPlugin::get_iframe_url()
     * 
     * @return string
     */
    private function _render_iframe( $id, $width = null, $height = null, $nocovers = false ) {
        global $wp_scripts;
        
        // Load the SlideDeck itself
        $slidedeck = $this->SlideDeck->get( $id );
        
        // Get the inner and outer dimensions for the SlideDeck
        $dimensions = $this->get_dimensions( $slidedeck );
        
        // Get the IFRAME source URL
        $iframe_url = $this->get_iframe_url( $id );
        
        if( $nocovers )
            $iframe_url .= "&nocovers=1";
        
        // Generate a unique HTML ID
        $slidedeck_unique_id = $this->SlideDeck->get_unique_id( $id );
        
        $html = '<iframe class="slidedeck-iframe-embed" id="' . $slidedeck_unique_id . '" frameborder="0" allowtransparency="yes"  src="' . $iframe_url . '" style="width:' . $dimensions['outer_width'] . 'px;height:' . $dimensions['outer_height'] . 'px;"></iframe>';
        
        return $html;
    }

    /**
     * Route the user based off of environment conditions
     * 
     * This function will handling routing of form submissions to the appropriate
     * form processor.
     * 
     * @uses wp_verify_nonce()
     * @uses SlideDeckPlugin::admin_options_update()
     * @uses SlideDeckPlugin::save()
     * @uses SlideDeckPlugin::ajax_delete()
     */
    function route() {
        $uri = $_SERVER['REQUEST_URI'];
        $protocol = isset( $_SERVER['HTTPS'] ) ? 'https' : 'http';
        $hostname = $_SERVER['HTTP_HOST'];
        $url = "{$protocol}://{$hostname}{$uri}";
        $is_post = (bool) ( strtoupper( $_SERVER['REQUEST_METHOD'] ) == "POST" );
        $nonce = isset( $_REQUEST['_wpnonce'] ) ? $_REQUEST['_wpnonce'] : false;
        
        // Check if a nonce was passed in the request
        if( $nonce ) {
            // Handle POST requests
            if( $is_post ) {
                if( wp_verify_nonce( $nonce, "{$this->namespace}-update-options" ) ) {
                    $this->admin_options_update();
                }
                
                if( wp_verify_nonce( $nonce, "{$this->namespace}-create-slidedeck" ) || wp_verify_nonce( $nonce, "{$this->namespace}-edit-slidedeck" ) ) {
                    $this->save();
                }
                
                if( wp_verify_nonce( $nonce, "{$this->namespace}-delete-slidedeck" ) ) {
                    $this->ajax_delete();
                }
				
				if( wp_verify_nonce( $nonce, "{$this->namespace}-save-lens" ) ) {
					$this->save_lens();
				}
				
				if( wp_verify_nonce( $nonce, "{$this->namespace}-copy-lens" ) ) {
					$this->copy_lens();
				}
				
				if( wp_verify_nonce( $nonce, "{$this->namespace}-delete-lens" ) ) {
					$this->ajax_delete_lens();
				}
				
				if( wp_verify_nonce( $nonce, "{$this->namespace}-upload-lens" ) ) {
					add_action( 'admin_init', array( &$this, 'upload_lens' ) );
					$this->upload_lens();
				}
				
                if( wp_verify_nonce( $nonce, "{$this->namespace}-cover-update" ) ) {
                    $this->update_cover();
                }
            }
            // Handle GET requests
            else {
                
            }
        }
        
        if( $this->is_plugin() && isset( $_GET['msg_deleted'] ) )
            slidedeck2_set_flash( __( "SlideDeck successfully deleted!", $this->namespace ) );
        
		if( preg_match( "/admin\.php\?.*page\=" . SLIDEDECK2_BASENAME . "\/feedback/", $uri ) ) {
			wp_redirect( "https://dtelepathy.zendesk.com/requests/new" );
			exit;
		}
		
        do_action( "{$this->namespace}_route", $uri, $protocol, $hostname, $url, $is_post, $nonce );
    }

    /**
     * Save a SlideDeck
     */
    function save() {
        if( !isset( $_POST['id'] ) ) {
            return false;
        }
        
        $slidedeck_id = intval( $_POST['id'] );
        
        $slidedeck = $this->SlideDeck->save( $slidedeck_id, $_POST );
        
		$action = '&action=edit&slidedeck=' . $slidedeck_id;
		
		if( $_POST['action'] == "create") {
            $action.= '&firstsave=1';
			slidedeck2_km( "New SlideDeck Created", array( 'source' => $slidedeck['source'], 'lens' => $slidedeck['lens'], 'type' => $slidedeck['type'] ) );
		}
		
        wp_redirect( $this->action( $action ) );
        exit;
    }

    /**
     * Process saving of SlideDeck custom meta information for posts and pages
     * 
     * @uses wp_verify_nonce()
     * @uses update_post_meta()
     * @uses delete_post_meta()
     */
    function save_post() {
        if( isset( $_POST['slidedeck-for-wordpress-dynamic-meta_wpnonce'] ) && !empty( $_POST['slidedeck-for-wordpress-dynamic-meta_wpnonce'] ) ) {
            if( !wp_verify_nonce( $_POST['slidedeck-for-wordpress-dynamic-meta_wpnonce'], 'slidedeck-for-wordpress' ) ) {
                return false;
            }
        
            $slidedeck_post_meta = array( '_slidedeck_slide_title', '_slidedeck_post_featured' );
            
            foreach( $slidedeck_post_meta as $meta_key ) {
                if( isset( $_POST[$meta_key] ) && !empty( $_POST[$meta_key] ) ) {
                    update_post_meta( $_POST['ID'], $meta_key, $_POST[$meta_key] );
                } else {
                    delete_post_meta( $_POST['ID'], $meta_key );
                }
            }
        }
    }

	/**
	 * Lens Edit Form Submission
	 * 
	 * @uses slidedeck2_sanitize()
	 * @uses SlideDeckLens::save()
	 */
	function save_lens() {
        $lens = $this->Lens->get( slidedeck2_sanitize( $_POST['lens'] ) );
        $lens_filename = dirname( $lens['files']['meta'] ) . "/" . slidedeck2_sanitize( $_POST['filename'] );
        
        if( $this->Lens->is_protected( $lens_filename ) )
            wp_die( '<h3>' . __( "Cannot Update Protected File", $this->namespace ) . '</h3><p>' . __( "The file you tried to write to is a protected file and cannot be overwritten.", $this->namespace ) . '</p><p><a href="' . $this->action( '/lenses' ) . '">' . __( "Return to Lens Manager", $this->namespace ) . '</a></p>' );
        
		// Lens CSS Content
		$lens_content = $_POST['lens_content'];
		
        $lens_meta = slidedeck2_sanitize( $_POST['data'] );
		
        // Save JSON meta if it was submitted
        if( !empty( $lens_meta ) ) {
            $lens_meta['contributors'] = array_map( 'trim', explode( ",", $lens_meta['contributors'] ) );
            
            $variations = array_map( 'trim', explode( ",", $lens_meta['variations'] ) );
            $lens_meta['variations'] = array();
            foreach( $variations as $variation ) {
                $lens_meta['variations'][strtolower($variation)] = ucwords( $variation );
            }
			
            $this->Lens->save( $lens['files']['meta'], "", $lens['slug'], $lens_meta );
        }
        
		// Save the lens file
		$lens = $this->Lens->save( $lens_filename, $lens_content, $lens['slug'] );
		
		// Mark response as an error or not
		$error = (boolean) ( $lens === false );
		
		// Set response message default
		$message = "<strong>" . esc_html( __( "Update Successful!", $this->namespace ) ) . "</strong>";
		if( $error )
			$message = "<strong>ERROR:</strong> " . esc_html( __( "Could not write the lens.css file for this lens. Please check file write permissions.", $this->namespace ) );
		
		slidedeck2_set_flash( $message, $error );
		
		wp_redirect( $this->action( '/lenses&action=edit&slidedeck-lens=' . $lens['slug'] . "&filename=" . basename( $lens_filename ) ) );
		exit;
	}

    /**
     * Process the SlideDeck shortcode
     * 
     * @param object $atts Attributes of the shortcode
     * 
     * @uses shortcode_atts()
     * @uses slidedeck_process_template()
     * 
     * @return object The processed shortcode
     */
    function shortcode( $atts ) {
        extract( shortcode_atts( array(
            'id' => false,
            'width' => null,
            'height' => null,
            'include_lens_files' => (boolean) true,
            'iframe' => false,
            'nocovers' => (boolean) false,
            'preview' => (boolean) false
        ), $atts ) );
        
        if ( $id !== false ) {
            if( $iframe !== false ) {
                return $this->_render_iframe( $id, $width, $height, $nocovers );
            } else {
                return $this->SlideDeck->render( $id, array( 'width' => $width, 'height' => $height ), $include_lens_files, $preview );
            }
        } else {
            return "";
        }
    }
	
	/**
	 * Sort all options by weight
	 * 
	 * @param array $options_model The Options Model Array
	 * @param array $slidedeck The SlideDeck object
	 * 
	 * @return array
	 */
	function slidedeck_options_model( $options_model, $slidedeck ) {
		// Sorted options model to return
		$sorted_options_model = array();
		
		foreach( $options_model as $options_group => $options ) {
			$sorted_options_model[$options_group] = array();
			
			$sorted_options_group = $options;
			uasort( $sorted_options_group, array( &$this, 'sort_by_weight' ) );
			
			$sorted_options_model[$options_group] = $sorted_options_group;
		}
		
		return $sorted_options_model;
	}
    
	/**
	 * Sort an array by its weight key
	 * 
	 * Used to sort an array of arrays by the child array's "weight" key value. If
	 * no weight key value exists, a default weight will be used instead. This function
	 * is meant for use by uasort() functions.
	 * 
	 * @param array $a First array
	 * @param array $b Next array
	 * 
	 * @return boolean
	 */
	function sort_by_weight( $a, $b ) {
		$default_weight = 100;
		
		$a['weight'] = isset( $a['weight'] ) ? $a['weight'] : $default_weight;
		$b['weight'] = isset( $b['weight'] ) ? $b['weight'] : $default_weight;
		
		return $a['weight'] > $b['weight'];
	}
	
    /**
     * Save SlideDeck Cover data
     * 
     * @uses slidedeck2_sanitize()
     * @uses SlideDeckCovers::save()
     */
    function update_cover() {
        $data = slidedeck2_sanitize( $_REQUEST );
        
        $this->Cover->save( $data['slidedeck'], $data );
        
        die( "Saved!" );
    }
    
	/**
	 * Upload lens request submission
	 * 
	 * Adaptation of WordPress core theme upload and install routines for uploading and
	 * installing lenses via a ZIP file upload.
	 * 
	 * @uses wp_verify_nonce()
	 * @uses wp_die()
	 * @uses wp_enqueue_style()
	 * @uses add_query_tag()
	 * @uses slidedeck2_action()
	 * @uses SlideDeckLens::copy_inc()
	 * @uses File_Upload_Upgrader
	 * @uses SlideDeck_Lens_Installer_Skin
	 * @uses SlideDeck_Lens_Upload
	 * @uses SlideDeck_Lens_Upload::install()
	 * @uses is_wp_error()
	 * @uses File_Upload_Upgrader::cleanup()
	 */
	function upload_lens() {
		if( !current_user_can( 'install_themes' ) )
			wp_die( __( 'You do not have sufficient permissions to install SlideDeck lenses on this site.', $this->namespace ) );
        
        check_admin_referer( "{$this->namespace}-upload-lens" );

		// Load the SlideDeck Lens Upload Classes
		if( !class_exists( 'SlideDeckLensUpload' ) )
			include( SLIDEDECK2_DIRNAME . '/classes/slidedeck-lens-upload.php' );
		
		$file_upload = new File_Upload_Upgrader( 'SlideDeckLenszip', 'package' );
		
        $title = __( "Upload SlideDeck Lens", $this->namespace );
        $parent_file = "";
        $submenu_file = "";
		wp_enqueue_style( "{$this->namespace}-admin" );
		require_once( ABSPATH . 'wp-admin/admin-header.php' );
		
		$title = sprintf( __( "Installing SlideDeck Lens from uploaded file: %s", 'slidedeck' ), basename( $file_upload->filename ) );
		$nonce = "{$this->namespace}-upload-lens";
		$url = add_query_arg( array( 'package' => $file_upload->id ), 'update.php?action=upload-slidedeck-lens' );
		$type = 'upload'; //Install type, From Web or an Upload.
		
		$lens_dirname = preg_replace( "/\.([a-zA-Z0-9]+)$/", "", basename( $file_upload->filename ) );
		$copy_inc = $this->Lens->copy_inc( $lens_dirname );
		if( $copy_inc > 0 ) {
			$lens_dirname.= "-{$copy_inc}";
		}
        
		$upgrader = new SlideDeck_Lens_Upload( new SlideDeck_Lens_Installer_Skin( compact( 'type', 'title', 'lens_dirname', 'nonce', 'url' ) ) );
		$result = $upgrader->install( $file_upload->package );
		
		if ( $result || is_wp_error( $result ) )
			$file_upload->cleanup();
        
		include( ABSPATH . 'wp-admin/admin-footer.php' );
	}
	
	/**
     * Hook into wp_fullscreen_buttons filter
     * 
     * Adds insert SlideDeck button to fullscreen TinyMCE editor
     * 
     * @param array $buttons Array of buttons to render
     * 
     * @return array
     */
	function wp_fullscreen_buttons( $buttons ) {
	    $buttons[] = 'separator';
        
        $buttons['slidedeck'] = array(
            'title' => __( "Insert SlideDeck", $this->namespace ),
            'onclick' => "tinyMCE.execCommand('mceSlideDeck');",
            'both' => false
        );
        
	    return $buttons;
	}
	
    /**
     * Determine which SlideDecks are being loaded on this page
     * 
     * @uses SlideDeck::get()
     */
    function wp_hook() {
        global $posts;
        
        if( isset( $posts ) && !empty( $posts ) ) {
            $slidedeck_ids = array();
        
            // Process through $posts for the existence of SlideDecks
            foreach( (array) $posts as $post ) {
                $matches = array();
                preg_match_all( '/\[SlideDeck2( ([a-zA-Z0-9]+)\=\'?([a-zA-Z0-9\%\-_\.]+)\'?)*\]/', $post->post_content, $matches );
                if( !empty( $matches[0] ) ) {
                    foreach( $matches[0] as $match ) {
                        $str = $match;
                        $str_pieces = explode( " ", $str );
                        foreach( $str_pieces as $piece ) {
                            $attrs = explode( "=", $piece );
                            if( $attrs[0] == "id" ) {
                                // Add the ID of this SlideDeck to the ID array for loading
                                $slidedeck_ids[] = intval( str_replace( "'", '', $attrs[1] ) );
                            }
                        }
                    }
                }
            }
            
            if( !empty( $slidedeck_ids ) ) {
                // Load SlideDecks used on this URL passing the array of IDs
                $slidedecks = $this->SlideDeck->get( $slidedeck_ids );
                
                // Loop through SlideDecks used on this page and add their lenses to the $lenses_included array for later use
                foreach( (array) $slidedecks as $slidedeck ) {
                    $lens_slug = isset( $slidedeck['lens'] ) && !empty( $slidedeck['lens'] ) ? $slidedeck['lens'] : 'default';
                    $type_slug = isset( $slidedeck['type'] ) && !empty( $slidedeck['type'] ) ? $slidedeck['type'] : 'legacy';
                    
                    $this->lenses_included[$lens_slug] = true;
                    $this->types_included[$type_slug] = true;
                    
                    do_action( "{$this->namespace}_pre_load", $slidedeck, $lens_slug, $type_slug );
                }
            }
        }
    }
    
    /**
     * Load the SlideDeck library JavaScript and support files in the public views to render SlideDecks
     * 
     * @uses wp_register_script()
     * @uses wp_enqueue_script()
     * @uses SlideDeck::get()
     * @uses SlideDeckPlugin::is_plugin()
     * @uses SlideDeckLens::get()
     */
    function wp_print_scripts() {
        // Create variable in global namespace for lenses to exist in
        echo '<script type="text/javascript">var SlideDeckLens={};</script>';
        
        wp_enqueue_script( 'jquery' );
        
        if( $this->get_option( 'dont_enqueue_scrollwheel_library' ) != true ) {
            wp_enqueue_script( 'scrolling-js' );
        }
        
        if( $this->get_option( 'dont_enqueue_easing_library' ) != true ) {
            wp_enqueue_script( 'jquery-easing' );
        }
        
        if( !is_admin() ) {
            wp_enqueue_script( "{$this->namespace}-library-js" );
            wp_enqueue_script( "{$this->namespace}-public" );
            wp_enqueue_script( "twitter-intent-api" );
        }
        
        // Make accommodations for the editing view to only load the lens files for the SlideDeck being edited
        if( $this->is_plugin() ){
            if( isset( $_GET['slidedeck'] ) ) {
                $slidedeck = $this->SlideDeck->get( $_GET['slidedeck'] );
                $lens = $slidedeck['lens'];
                $this->lenses_included = array( $lens => 1 );
            }
        }
		
        foreach( (array) $this->lenses_included as $lens_slug => $val ) {
            $lens = $this->Lens->get( $lens_slug );
            if( isset( $lens['script_url'] ) ) {
                wp_register_script( "{$this->namespace}-lens-js-{$lens_slug}", $lens['script_url'], array( 'jquery', "{$this->namespace}-library-js" ), SLIDEDECK2_VERSION );
                wp_enqueue_script( "{$this->namespace}-lens-js-{$lens_slug}" );
                if( $this->is_plugin() ) {
		            if( isset( $lens['admin_script_url'] ) ) {
		                wp_register_script( "{$this->namespace}-lens-admin-js-{$lens_slug}", $lens['admin_script_url'], array( 'jquery', "{$this->namespace}-admin" ), SLIDEDECK2_VERSION, true );
		                wp_enqueue_script( "{$this->namespace}-lens-admin-js-{$lens_slug}" );
		            }
                }
            }
        }
        
        $this->lenses_loaded = true;
    }
    
    /**
     * Load SlideDeck support CSS files for lenses used by SlideDecks on a page
     * 
     * @uses SlideDeckLens::get()
     * @uses SlideDeckLens::get_css()
     */
    function wp_print_styles() {
        foreach( (array) $this->lenses_included as $lens_slug => $val ) {
            $lens = $this->Lens->get( $lens_slug );
            echo $this->Lens->get_css( $lens );
        }
        
        wp_enqueue_style( $this->namespace );
    } 
    
    /**
     * Register scripts used by this plugin for enqueuing elsewhere
     * 
     * @uses wp_register_script()
     */
    function wp_register_scripts() {
        // Admin JavaScript
        wp_register_script( "{$this->namespace}-admin", SLIDEDECK2_URLPATH . "/js/{$this->namespace}-admin" . ( SLIDEDECK2_ENVIRONMENT == 'development' ? '.dev' : '' ) . ".js", array( 'jquery', 'media-upload', 'fancy-form', 'simplemodal' ), SLIDEDECK2_VERSION, true );
        // SlideDeck JavaScript Core
        wp_register_script( "{$this->namespace}-library-js", SLIDEDECK2_URLPATH . '/js/slidedeck.jquery.js', array( 'jquery' ), SLIDEDECK2_VERSION );
        // Public Javascript
        wp_register_script( "{$this->namespace}-public", SLIDEDECK2_URLPATH . '/js/slidedeck-public' . ( SLIDEDECK2_ENVIRONMENT == 'development' ? '.dev' : '' ) . '.js', array( 'jquery', 'slidedeck-library-js' ), '1.0.7' );
        // Mouse Scrollwheel jQuery event library 
        wp_register_script( "scrolling-js", SLIDEDECK2_URLPATH . '/js/jquery-mousewheel/jquery.mousewheel.min.js', array( 'jquery' ), '3.0.6' );
        // Fancy Form Elements jQuery library 
        wp_register_script( "fancy-form", SLIDEDECK2_URLPATH . '/js/fancy-form' . ( SLIDEDECK2_ENVIRONMENT == 'development' ? '.dev' : '' ) . '.js', array( 'jquery' ), '1.0.0' );
        // Tooltipper jQuery library 
        wp_register_script( "tooltipper", SLIDEDECK2_URLPATH . '/js/tooltipper' . ( SLIDEDECK2_ENVIRONMENT == 'development' ? '.dev' : '' ) . '.js', array( 'jquery' ), '1.0.0' );
        // jQuery Easing Library 
        wp_register_script( "jquery-easing", SLIDEDECK2_URLPATH . '/js/jquery.easing.1.3.js', array( 'jquery' ), '1.3' );
        // jQuery MiniColors Color Picker
        wp_register_script( "jquery-minicolors", SLIDEDECK2_URLPATH . '/js/jquery-minicolors/jquery.minicolors.min.js', array( 'jquery' ), '7d21e3c363' );
        // SlideDeck Preview Updater
        wp_register_script( "{$this->namespace}-preview", SLIDEDECK2_URLPATH . '/js/slidedeck-preview' . ( SLIDEDECK2_ENVIRONMENT == 'development' ? '.dev' : '' ) . '.js', array( 'jquery' ), '1.0.0' );
        // Simple Modal Library
        wp_register_script( "simplemodal", SLIDEDECK2_URLPATH . '/js/simplemodal' . ( SLIDEDECK2_ENVIRONMENT == 'development' ? '.dev' : '' ) . '.js', array( 'jquery' ), '1.0.0' );
        // Zero Clipboard
        wp_register_script( "zeroclipboard", SLIDEDECK2_URLPATH . '/js/zeroclipboard/ZeroClipboard.js', array( 'jquery' ), '1.0.7' );
        // Twitter Intent API
        wp_register_script( "twitter-intent-api", ( is_ssl() ? 'https:' : 'http:' ) . "//platform.twitter.com/widgets.js", array(), '1316526300' );
        
        // CodeMirror JavaScript Library
        wp_register_script( "codemirror", SLIDEDECK2_URLPATH . "/js/codemirror/codemirror.js", array(), '2.2.0', true );
        wp_register_script( "codemirror-mode-css", SLIDEDECK2_URLPATH . "/js/codemirror/mode/css.js", array( 'codemirror' ), '2.2.0', true );
        wp_register_script( "codemirror-mode-htmlmixed", SLIDEDECK2_URLPATH . "/js/codemirror/mode/htmlmixed.js", array( 'codemirror' ), '2.2.0', true );
        wp_register_script( "codemirror-mode-javascript", SLIDEDECK2_URLPATH . "/js/codemirror/mode/javascript.js", array( 'codemirror' ), '2.2.0', true );
        wp_register_script( "codemirror-mode-clike", SLIDEDECK2_URLPATH . "/js/codemirror/mode/clike.js", array( 'codemirror' ), '2.2.0', true );
        wp_register_script( "codemirror-mode-php", SLIDEDECK2_URLPATH . "/js/codemirror/mode/php.js", array( 'codemirror', 'codemirror-mode-clike' ), '2.2.0', true );
    }
    
    /**
     * Register styles used by this plugin for enqueuing elsewhere
     * 
     * @uses wp_register_style()
     */
    function wp_register_styles() {
        // Admin Stylesheet
        wp_register_style( "{$this->namespace}-admin", SLIDEDECK2_URLPATH . "/css/{$this->namespace}-admin.css", array(), SLIDEDECK2_VERSION, 'screen' );
        // Gplus How-to Modal Stylesheet
        wp_register_style( "gplus-how-to-modal", SLIDEDECK2_URLPATH . "/css/gplus-how-to-modal.css", array(), SLIDEDECK2_VERSION, 'screen' );
        // Public Stylesheet
        wp_register_style( $this->namespace, SLIDEDECK2_URLPATH . "/css/slidedeck.css", array(), SLIDEDECK2_VERSION, 'screen' );
		// CodeMirror Library
        wp_register_style( "codemirror", SLIDEDECK2_URLPATH . "/css/codemirror.css", array(), '2.1.8', 'screen' );
        // Fancy Form Elements library 
        wp_register_style( "fancy-form", SLIDEDECK2_URLPATH . '/css/fancy-form.css', array(), '1.0.0', 'screen' );
        // jQuery MiniColors Color Picker
        wp_register_style( "jquery-minicolors", SLIDEDECK2_URLPATH . '/css/jquery.minicolors.css', array(), '7d21e3c363', 'screen' );
    }
}
if( !isset( $SlideDeckPlugin ) ) {
    SlideDeckPlugin::instance();
}

register_activation_hook( __FILE__, array( 'SlideDeckPlugin', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'SlideDeckPlugin', 'deactivate' ) );
