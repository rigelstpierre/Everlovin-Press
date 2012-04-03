<?php

add_action('init', 'posttype_register', 0); // <- Post type registration
add_action("admin_init", "meta_boxes"); // <- Meta boxes for post types
add_action('save_post', 'save_details'); // <- Save input from post type admin screen
add_filter( 'pre_get_posts' , 'ucc_include_custom_post_types' ); // <- Include custom post types on archive pages


/*
	Note: Change all instances of "posttype" to the name of your post type,
		  and "custom_taxonomy" to the name of your taxonomy.
*/

function posttype_register() { // The perameters of your custom post type.
	
	// Labels for your post type
	$labels = array(
		'name' => _x('posttype', 'post type general name'),
		'singular_name' => _x('posttype', 'post type singular name'),
		'add_new' => _x('Add New', 'posttype'),
		'add_new_item' => __('Add New posttype'),
		'edit_item' => __('Edit posttype'),
		'new_item' => __('New posttype'),
		'view_item' => __('View posttype'),
		'search_items' => __('Search posttype'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	// For all available arguments go to http://codex.wordpress.org/Function_Reference/register_post_type
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'taxonomies' => array('custom_taxonomy'), // Uses the custom taxonomy created in this template
		'public' => true,
		'publicly_queryable' => true,
		'has_archive' => true,
		'supports' => array('title','editor','thumbnail')
	  ); 

	register_post_type( 'posttype' , $args );
	
	// Custom taxonomy
	register_taxonomy( "custom_taxonomy", array("posttype"), array("hierarchical" => true, "label" => "Custom Taxonomy", "singular_label" => "Custom Taxonomy Term", "rewrite" => true));
	
	}
	
	
// Meta boxes for custom post type
function meta_boxes() {
	add_meta_box("metabox-meta", "Meta Box", "metabox_function", "posttype", "side", "default");
	}


// Function for the specific meta box registered in the previous function
function metabox_function() {

	global $post;
	$custom = get_post_custom($post->ID);
	$field = $custom["field"][0];
	?>
	<label>Custom Field</label><br />
	<input name="field" value="<?php echo $field; ?>" style="width: 240px; margin: .5em 0"/>
	<?php
	}
	

// Save infrmation input in the custom post type admin form
function save_details(){
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		return $post_id;
		global $post;
		
		update_post_meta($post->ID, "field", $_POST["field"]);
	}


// Include custom post types in archive pages

		function ucc_include_custom_post_types( $query ) {
		  global $wp_query;

		  /* Don't break admin or preview pages. This is also a good place to exclude feed with !is_feed() if desired. */
		  if ( !is_preview() && !is_admin() && !is_singular() ) {
		    $args = array(
		      'public' => true ,
		      '_builtin' => false
		    );
		    $output = 'names';
		    $operator = 'and';

		    $post_types = get_post_types( $args , $output , $operator );

		    /* Add 'link' and/or 'page' to array() if you want these included:
		     * array( 'post' , 'link' , 'page' ), etc.
		     */
		    $post_types = array_merge( $post_types , array( 'post' ) );

		    if ($query->is_feed) {
		      /* Do feed processing here if you did not exclude it previously. This if/else
		       * is not necessary if you want custom post types included in your feed.
		       */
		    } else {
		      $my_post_type = get_query_var( 'post_type' );
		      if ( empty( $my_post_type ) )
		        $query->set( 'post_type' , $post_types );
		    }
		  }

		  return $query;
		}

?>