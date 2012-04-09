<?php
add_action( 'after_setup_theme', 'lps_theme_setup' );
add_action( 'wp_print_scripts', 'lps_load_scripts' );
add_action( 'init', 'customwork_posttype' );
add_action( 'init', 'readymade_posttype' );
add_action( 'init', 'faq_posttype' );
add_filter('body_class','expand_body_classes'); // Adds page slug to the body class

// Includes
include_once 'includes/excerpts.php'; // Custom Excerpts
include_once 'includes/scripts.php'; // Enqued Scripts
include_once 'includes/custom_field_functions.php'; // Functions for including/processing content from custom fields. See Readme for usage.
include_once 'includes/document_title.php';
include_once 'includes/meta.php'; // Creates a <ul> with post meta information.
include_once 'includes/bodyclass.php'; // Add page slug as body class. Also include the page parent


/* Uncomment to create custom post types and custom taxonomies
	include_once 'includes/post_types.php'; // Template for creating custom post types and custom taxonomies
*/

function lps_theme_setup() {
	
	global $content_width;
	/* Set the $content_width for things such as video embeds. */
	if ( !isset( $content_width ) )
		$content_width = 600;

	add_action( 'init', 'lps_register_menus' );
	add_action( 'widgets_init', 'lps_register_sidebars' );
	add_filter( 'stylesheet_uri','wpi_stylesheet_uri',10,2);
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails');
	//add_image_size( 'name', width, hight, crop);
}

function customwork_posttype() {
	register_post_type( 'customwork',
		array(
			'labels' => array(
			'name' => __( 'Custom Work' ),
			'singular_name' => __( 'Custom Work' ),
			'add_new' => __( 'Add New' ),
			'add_new_item' => __( 'Add New Custom Work' ),
			'edit' => __( 'Edit' ),
			'edit_item' => __( 'Edit Custom Work' ),
			'new_item' => __( 'New Custom Work' ),
			'view' => __( 'View Custom Work' ),
			'view_item' => __( 'View Custom Work' ),
			'search_items' => __( 'Search Custom Work' ),
			'not_found' => __( 'No Custom Work found' ),
			'not_found_in_trash' => __( 'No Custom Work found in Trash' ),
			),
			'public' => true,
			'menu_position' => 4,
			'supports' => array( 'title', 'editor', 'thumbnail' ),
		)
	);
}

function readymade_posttype() {
	register_post_type( 'readymade',
		array(
			'labels' => array(
			'name' => __( 'Readymades' ),
			'singular_name' => __( 'Readymade' ),
			'add_new' => __( 'Add New' ),
			'add_new_item' => __( 'Add New Readymades' ),
			'edit' => __( 'Edit' ),
			'edit_item' => __( 'Edit Readymade' ),
			'new_item' => __( 'New Readymade' ),
			'view' => __( 'View Readymade' ),
			'view_item' => __( 'View Readymade' ),
			'search_items' => __( 'Search Readymades' ),
			'not_found' => __( 'No Readymades found' ),
			'not_found_in_trash' => __( 'No Readymades found in Trash' ),
			),
			'public' => true,
			'menu_position' => 4,
			'supports' => array( 'title', 'editor', 'thumbnail' ),
		)
	);
}

function faq_posttype() {
	register_post_type( 'faq',
		array(
			'labels' => array(
			'name' => __( 'FAQs' ),
			'singular_name' => __( 'FAQ' ),
			'add_new' => __( 'Add FAQ' ),
			'add_new_item' => __( 'Add New FAQ' ),
			'edit' => __( 'Edit' ),
			'edit_item' => __( 'Edit FAQ' ),
			'new_item' => __( 'New FAQ' ),
			'view' => __( 'View FAQ' ),
			'view_item' => __( 'View FAQ' ),
			'search_items' => __( 'Search FAQs' ),
			'not_found' => __( 'No FAQs found' ),
			'not_found_in_trash' => __( 'No FAQs found in Trash' ),
			),
			'public' => true,
			'menu_position' => 4,
			'supports' => array( 'title', 'editor' ),
		)
	);
}

function wpi_stylesheet_uri($stylesheet_uri, $stylesheet_dir_uri){
    return $stylesheet_dir_uri.'/css/style.css';
	}

function lps_register_menus() {
	register_nav_menus(array('primary'=>__('Primary Nav'),));
	register_nav_menus(array('work'=>__('Work Nav'),));
	register_nav_menus(array('hire'=>__('Hire The Press Man Nav'),));
}

function lps_register_sidebars() {
	register_sidebar(
		array(
			'id' => 'primary',
			'name' => __( 'Primary Sidebar' ),
			'description' => __( 'The following widgets will appear in the main sidebar div.' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4>',
			'after_title' => '</h4>'
		)
	);
}
/* Removes Unused menus in Wordpress Admin Panel */
function remove_menus () {
global $menu;
	$restricted = array(__('Media'), __('Links'), __('Comments'), __('Users'));
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
}
add_action('admin_menu', 'remove_menus');

// Clean up <head> and improve security.
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');

?>