<?php
class SlideDeck_Feeds extends SlideDeck {
    // The "friendly" name of this Deck type
    var $name = "Feeds";
    // The slug to identify this Deck type internally
    var $type = "feeds";
    // Deck identifying color
    var $color = "";
    // Amount of slides to start with
    var $default_slide_count = 5;
    // Default options for this Deck type
    var $default_options = array(
        'feedUrl' => "http://feeds.feedburner.com/digital-telepathy",
        'gplusUserId' => "",
        'gplusApiKey' => ""
    );
    var $default_source = 'posts';
    
    // The available sorting methods for posts
    var $post_type_sorts = array(
        'recent' => "Recent",
        'popular' => "Popular"
    );
    
    // Available content sources
    var $sources = array(
        'posts' => array(
            'name' => 'posts',
            'label' => "Your Posts",
            'icon' => '/decks/feeds/images/posts-icon.png',
            'chicklet' => '/decks/feeds/images/posts-chicklet.png',
            'taxonomies' => array( 'posts' ),
            'default_lens' => "tool-kit"
        ),
        'gplus' => array(
            'name' => 'gplus',
            'label' => "Google+ Public Posts",
            'icon' => '/decks/feeds/images/gplus-icon.png',
            'chicklet' => '/decks/feeds/images/gplus-chicklet.png',
            'taxonomies' => array( 'social', 'posts', 'feeds' ),
            'default_lens' => "tool-kit"
        ),
        'rss' => array(
            'name' => 'rss',
            'label' => "RSS",
            'icon' => '/decks/feeds/images/rss-icon.png',
            'chicklet' => '/decks/feeds/images/rss-chicklet.png',
            'taxonomies' => array( 'feeds', 'posts' ),
            'default_lens' => "tool-kit"
        )
    );
    
    var $options_model = array(
        'Setup' => array(
            'feedCacheDuration' => array(
                'name' => "feedCacheDuration",
                'type' => "text",
                'data' => "integer",
                'value' => 30
            ),
            'post_type' => array(
                'name' => 'post_type',
                'type' => "text",
                'data' => "string",
                'value' => 'post'
            ),
            'post_type_sort' => array(
                'name' => 'post_type_sort',
                'type' => "text",
                'data' => "string",
                'value' => 'recent'
            ),
            'total_slides' => array(
                'name' => 'total_slides',
                'type' => "text",
                'data' => "integer",
                'value' => 10
            ),
            'filter_terms' => array(
                'name' => 'filter_terms',
                'type' => "text",
                'data' => "string",
                'value' => array()
            ),
            'filter_by_tax' => array(
                'type' => 'checkbox',
                'data' => 'boolean',
                'value' => false
            ),
            'query_any_all' => array(
                'name' => "query_any_all",
                'type' => "select",
                'data' => "string",
                'value' => 'any',
                'values' => array(
                    'any' => "Any of these taxonomies",
                    'all' => "All of these taxonomies"
                ),
                'attr' => array(
                    'class' => "fancy"
                )
            )
         ),
        'Interface' => array(
            'show-author' => array(
                'type' => 'checkbox',
                'data' => 'boolean',
                'label' => "Show Author",
                'value' => true,
                'description' => "Show or hide the author of the content, when that info is available.",
                'weight' => 60
            ),
            'show-author-avatar' => array(
                'type' => 'checkbox',
                'data' => 'boolean',
                'label' => "Show Author Avatar",
                'value' => true,
                'description' => "Show the author's avatar image when available",
                'weight' => 61
            ),
            'linkAuthorName' => array(
                'type' => 'checkbox',
                'data' => 'boolean',
                'value' => false,
                'label' => "Link Author Name",
                'description' => "If the author URL is available",
                'weight' => 62
            ),
        ),
        'Content' => array(
            'titleLengthWithImages' => array(
                'type' => 'text',
                'data' => "integer",
                'attr' => array(
                    'size' => 3,
                    'maxlength' => 3
                ),
                'value' => 50,
                'label' => "Title Length (with Images)",
                'description' => "Title length when an image is displayed",
                'suffix' => "chars",
                'weight' => 1,
                'interface' => array(
                    'type' => 'slider',
                    'min' => 10,
                    'max' => 100,
                    'step' => 5
                )
            ),
            'titleLengthWithoutImages' => array(
                'type' => 'text',
                'data' => "integer",
                'attr' => array(
                    'size' => 3,
                    'maxlength' => 3
                ),
                'value' => 35,
                'label' => "Title Length (no Images)",
                'description' => "Title length when no image is displayed",
                'suffix' => "chars",
                'weight' => 2,
                'interface' => array(
                    'type' => 'slider',
                    'min' => 10,
                    'max' => 100,
                    'step' => 5
                )
            ),
            'show-title' => array(
                'type' => 'checkbox',
                'data' => 'boolean',
                'label' => "Show Title",
                'value' => true,
                'weight' => 3
            ),
            'linkTitle' => array(
                'type' => 'checkbox',
                'data' => 'boolean',
                'value' => true,
                'label' => "Link Title",
                'description' => "Choose whether to make the title on each slide clickable",
                'weight' => 10
            ),
            'excerptLengthWithImages' => array(
                'type' => 'text',
                'data' => "integer",
                'attr' => array(
                    'size' => 3,
                    'maxlength' => 4
                ),
                'value' => 100,
                'label' => "Excerpt Length (with Images)",
                'description' => "Excerpt length when an image is displayed",
                'suffix' => "chars",
                'weight' => 20,
                'interface' => array(
                    'type' => 'slider',
                    'min' => 10,
                    'max' => 500,
                    'step' => 10
                )
            ),
            'excerptLengthWithoutImages' => array(
                'type' => 'text',
                'data' => "integer",
                'attr' => array(
                    'size' => 3,
                    'maxlength' => 4
                ),
                'value' => 200,
                'label' => "Excerpt Length (no Images)",
                'description' => "Excerpt length when no image is displayed",
                'suffix' => "chars",
                'weight' => 21,
                'interface' => array(
                    'type' => 'slider',
                    'min' => 10,
                    'max' => 1000,
                    'step' => 20
                )
            ),
            'show-excerpt' => array(
                'type' => 'checkbox',
                'data' => 'boolean',
                'label' => "Show Excerpt",
                'value' => true,
                'weight' => 22
            ),
            'use-custom-post-excerpt' => array(
                'type' => 'hidden',
                'label' => "Use Custom Excerpt?",
                'description' => "Turn on to use your custom crafted excerpt for posts (instead of the post content) when available",
                'data' => 'boolean',
                'value' => false,
                'weight' => 23
            ),
            'show-readmore' => array(
                'type' => 'checkbox',
                'data' => 'boolean',
                'label' => "Show Read More",
                'value' => true,
                'weight' => 24
            ),
            'linkTarget' => array(
                'type' => 'select',
                'data' => 'string',
                'value' => "_blank",
                'values' => array(
                    '_top' => "Same Window",
                    '_blank' => "New Window/Tab"
                ),
                'label' => "Open links in...",
                'description' => "This will not be reflected in the preview",
                'weight' => 50
            ),
            'imageSource' => array(
                'name' => "imageSource",
                'type' => "select",
                'data' => "string",
                'value' => 'gallery',
                'values' => array(
                    'content' => "First image in content",
                    'thumbnail' => "Featured image",
                    'gallery' => "First image in gallery",
                    'enclosure' => "Media attachment (RSS only)"
                ),
                'attr' => array(
                    'class' => "fancy"
                ),
                'label' => "Preferred Image Source",
                'description' => "Preferred location where an image be pulled from (will automatically fall back to other sources if none are found in the preferred location)",
                'weight' => 70
            ),
            'validateImages' => array(
                'type' => 'hidden',
                'data' => 'boolean',
                'value' => true,
                'label' => "Validate Images",
                'description' => "Helps with some website feeds that include advertisement pixel images in their posts",
                'weight' => 80
            ),
            'verticalTitleLength' => array(
                'type' => 'hidden',
                'data' => "integer",
                'value' => 25,
                'label' => "Vertical Title Length"
            )
        )
    );
	
	function _get_post_thumbnail( $post_id, $image_url ) {
		global $wpdb;
		
		$thumbnail_src = $image_url;
		$thumbnail_html = "";
		
		// Use the post thumbnail if possible
		if( current_theme_supports( 'post-thumbnails' ) ) {
			$thumbnail_html = get_the_post_thumbnail( $post_id, 'thumbnail' );
		}
		
		// Process for a thumbnail version of the background image
		$url_parts = parse_url( $image_url ); // Get array of URL parts of the image
		$wp_upload_dir = wp_upload_dir(); // Get array of URL parts of the upload directory
		$relative_upload_base = str_replace( ABSPATH, "", str_replace( $wp_upload_dir['subdir'], "", $wp_upload_dir['path'] ) );
		if( $url_parts['host'] == $_SERVER['HTTP_HOST'] && strpos( $url_parts['path'], "/" . $relative_upload_base ) !== false ) {
			$image_url_original = preg_replace( "/\-[0-9]+x[0-9]+\.(jpeg|jpg|gif|png|bmp)$/", ".$1", $image_url );
			$post = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->posts} WHERE guid = %s", $image_url_original ) );
			if( !empty( $post ) ) {
				$thumbnail_html = wp_get_attachment_image( $post->ID, 'thumbnail' );
			}
		}
		
		if( !empty( $thumbnail_html ) ) {
			$matches = array();
			preg_match( "/ src\=\"([^\"]+)\"/", $thumbnail_html, $matches );
			if( count( $matches ) > 1 ) {
				$thumbnail_src = $matches[1];
			}
		}
		
		return $thumbnail_src;
	}
    
    function add_hooks() {
        add_filter( "{$this->namespace}_classes", array( &$this, 'slidedeck_classes' ), 10, 2 );
        add_filter( "{$this->namespace}_default_create_status", array( &$this, 'slidedeck_default_create_status' ), 10, 2 );
        add_filter( "{$this->namespace}_frame_classes", array( &$this, 'slidedeck_frame_classes' ), 10, 2 );
        add_filter( "{$this->namespace}_options", array( &$this, 'slidedeck_options' ), 10, 2 );
        
        add_action( "{$this->namespace}_ajax_edit_source", array( &$this, 'slidedeck_ajax_edit_source' ), 10, 3 );
        add_action( "{$this->namespace}_after_save", array( &$this, 'slidedeck_after_save' ), 10, 3 );
        
        add_action( "wp_ajax_{$this->namespace}_available_filters", array( &$this, 'ajax_available_filters' ) );
        add_action( "wp_ajax_{$this->namespace}_available_terms", array( &$this, 'ajax_available_terms' ) );
		
		add_action( "admin_print_scripts-toplevel_page_slidedeck2", array( &$this, 'admin_print_scripts' ) );
		
        foreach( $this->sources as &$source ) {
            add_action( "{$this->namespace}_form_content_source", array( &$this, "content_source_{$source['name']}" ), 10, 2 );
        }
    }
    
	/**
	 * Hook into admin_print_scripts for edit pages of SlideDeck 2 plugin
	 * 
	 * @uses wp_enqueue_script()
	 */
	function admin_print_scripts() {
		wp_enqueue_script( 'post' );
	}

    /**
     * AJAX response for available terms options for a post type
     * 
     * @uses SlideDeck::get()
     * @uses SlideDeck_Posts::available_terms()
     */
    function ajax_available_terms() {
        $slidedeck_id = (integer) $_REQUEST['slidedeck'];
        $filter_by_tax = (integer) $_REQUEST['filter_by_tax'];
        $taxonomy = (string) $_REQUEST['taxonomy'];
        $post_type = $_REQUEST['post_type'];
        
		// Get the SlideDeck
        $slidedeck = $this->get( $slidedeck_id );
		// Add the filter by tax option (passed in via Ajax to the unsaved deck)
        $slidedeck['options']['filter_by_tax'] = $filter_by_tax;
        
        $html = $this->available_terms( $post_type, $slidedeck, $taxonomy );
        
        die( $html );
    }
    
    /**
     * Available terms
     * 
     * @param string $post_type The slug of the post type to query by
     * @param object $slidedeck The optional SlideDeck object being rendered to pre-check selected options
	 * @param string $taxonomy The Taxonomy slug being queried
     * 
     * @return string
     */
    function available_terms( $post_type, $slidedeck = null, $taxonomy = '' ) {
        $html = "";
		
        // Get existing filtered parameters for this SlideDeck
        // In other words, these are checked...
        $filtered = array();
        if( isset( $slidedeck ) ) {
            $filtered = (array) $slidedeck['options']['filter'][$taxonomy]['terms'];
        }
		
		$taxonomy_object = get_taxonomy( $taxonomy );

        $terms = get_terms( $taxonomy, array(
            'orderby' => 'name',
            'hierarchical' => true,
            'hide_empty' => false
        ) );
        
        // Process HTML output
        ob_start();
        
            include( dirname( __FILE__ ) . '/views/_available_terms.php' );
            $html = ob_get_contents();
        
        ob_end_clean();

        return $html;
    }
    
    /**
     * AJAX response for available filtering options for a post type
     * 
     * @uses SlideDeck::get()
     * @uses SlideDeck_Posts::available_filters()
     */
    function ajax_available_filters() {
        $slidedeck_id = (integer) $_REQUEST['slidedeck'];
        $filter_by_tax = (integer) $_REQUEST['filter_by_tax'];
        $post_type = $_REQUEST['post_type'];
        
        $slidedeck = $this->get( $slidedeck_id );
        $slidedeck['options']['filter_by_tax'] = $filter_by_tax;
        
        $html = $this->available_filters( $post_type, $slidedeck );
        
        die( $html );
    }
    
    /**
     * Available filtering options for a post type
     * 
     * Loads all available taxonomies or categories associated with a specific post type and returns
     * an HTML string of the available taxonomy tags and/or categories to filter by. If a SlideDeck is
     * passed in, selected options will be pre-checked.
     * 
     * @param string $post_type The slug of the post type to query by
     * @param object $slidedeck The optional SlideDeck object being rendered to pre-check selected options
     * 
     * @return string
     */
    function available_filters( $post_type, $slidedeck = null ) {
        $html = "";
        if( isset( $slidedeck ) ){
            if( !$slidedeck['options']['filter_by_tax'] ){
                return $html;
            }
        }
        
        // Get existing filtered parameters for this SlideDeck
        $filtered = array();
        if( isset( $slidedeck ) ) {
            $filtered = (array) $slidedeck['options']['filter_terms'];
        }
        
        // Get all taxonomy types (including categories) for this post type
        $taxonomies = get_object_taxonomies( $post_type, 'objects' );
        
        // Get all terms for each taxonomy type and get its terms
        foreach( $taxonomies as &$taxonomy ) {
            $taxonomy->terms = get_terms( $taxonomy->name, array(
                'orderby' => 'name',
                'hide_empty' => false
            ) );
        }
        
        // Process HTML output
        ob_start();
        
            include( dirname( __FILE__ ) . '/views/_available_taxonomies.php' );
            $html = ob_get_contents();
        
        ob_end_clean();
        
        return $html;
    }
    
    
    function content_source_rss( $slidedeck, $form_action ) {
        // Fail silently if the SlideDeck is not this type or source
        if( $slidedeck['type'] != $this->type || $slidedeck['source'] != 'rss' ) {
            return false;
        }
        
        $source = $this->sources['rss'];
        $slidedeck['options'] = array_merge( $this->default_options, $slidedeck['options'] );
        $namespace = $this->namespace;
        
        include( dirname( __FILE__ ) . '/views/source/_rss.php' );
    }
    
    function content_source_gplus( $slidedeck, $form_action ) {
        // Fail silently if the SlideDeck is not this type or source
        if( $slidedeck['type'] != $this->type || $slidedeck['source'] != 'gplus' ) {
            return false;
        }
        
        $source = $this->sources['gplus'];
        $slidedeck['options'] = array_merge( $this->default_options, $slidedeck['options'] );
        $namespace = $this->namespace;
        
        include( dirname( __FILE__ ) . '/views/source/_gplus.php' );
    }
    
    /**
     * Content Source form section for Posts
     * 
     * Loads necessary data for sourcing a SlideDeck based off of Posts and renders out
     * the form interaction.
     * 
     * @uses get_post_types()
     * @uses current_theme_supports()
     */
    function content_source_posts( $slidedeck, $form_action ) {
        // Fail silently if the SlideDeck is not this type or source
        if( $slidedeck['type'] != $this->type || $slidedeck['source'] != 'posts' ) {
            return false;
        }
        
        // Available post types to choose from excluding SlideDeck related post types and invalid post types like navigation and revisions
        $post_types = get_post_types( array(), 'objects' );
        $invalid_post_types = array( 'revision', 'attachment', 'nav_menu_item', SLIDEDECK1_POST_TYPE, SLIDEDECK1_SLIDE_POST_TYPE, SLIDEDECK2_POST_TYPE, SLIDEDECK2_SLIDE_POST_TYPE );
        foreach( $invalid_post_types as &$invalid_post_type )
            unset( $post_types[$invalid_post_type] );
        
        foreach( $post_types as &$post_type )
            $post_type = $post_type->labels->name;
        
        // Post sorting methods
        $post_type_sorts = $this->post_type_sorts;
        
        // Image sources
        $image_sources = array(
            'content' => "First Image in Content",
            'gallery' => "First Image in Gallery",
        );
        
        if( current_theme_supports( 'post-thumbnails' ) )
            $image_sources['thumbnail'] = "Featured Image";
        
        $namespace = $this->namespace;
        
        $image_sources['none'] = "No Image";
        
        $source = $this->sources['posts'];
        
        include( dirname( __FILE__ ) . '/views/source/_posts.php' );
    }

    /**
     * Get the image for a slide
     * 
     * Looks up the type of image that is supposed to be retrieved and returns its URL or boolean(false) if
     * no image could be found.
     * 
     * @param array $slide The slide object to process
     * @param array $slidedeck The SlideDeck object to process
     * @param string $source Optional image source
     * 
     * @return mixed
     */
    function get_image( $slide, $slidedeck, $source = null, $tried_sources = array() ) {
        global $SlideDeckPlugin;
		
		/**
		 * Grab the width and height of the deck. Then we should
		 * create an expansion factor that will hopefully grab images _just_
		 * larger than we need. Grabbing the big size automatically makes
		 * some browsers (mostly Chrome) chug and is bad for the end user too.
		 */
        $slidedeck_dimensions = $this->get_dimensions( $slidedeck );
		$expansion_factor = 1.2; // 120%
		$expanded_width = $slidedeck_dimensions['outer_width'] * $expansion_factor;
		$expanded_height = $slidedeck_dimensions['outer_height'] * $expansion_factor;
        
        // Set default return value
        $image_src = false;
        
		// If the image is actually set already, just use it.
		if( isset( $slide['image'] ) && !empty( $slide['image'] ) ){
			$image_src = $slide['image'];
			return $image_src;
		}
		
        if( !isset( $slidedeck['options']['imageSource'] ) )
            $slidedeck['options']['imageSource'] = "content";
        
        if( $slidedeck['source'] == "gplus" )
            $source = $source;
        
        $sources = array( 'content', 'gallery', 'thumbnail', 'enclosure' );
        
        if( !isset( $source ) )
            $source = $slidedeck['options']['imageSource'];
        
        switch( $source ) {
            default:
            case "content":
                $images = $SlideDeckPlugin->Lens->parse_html_for_images( $slide['content'] );
                if( !empty( $images ) ) {
                    $first_image = reset( $images );
                    $image_src = $first_image['src'];
                }
            break;
            
            case "gallery":
                if( is_numeric( $slide['id'] ) ) {
                    $query_args = array(
                        'post_parent' => $slide['id'],
                        'posts_per_page' => 1,
                        'post_type' => 'attachment',
                        'post_status' => 'any'
                    );
                    $attachments = new WP_Query( $query_args );
                    
                    if( !empty( $attachments->posts ) ) {
                        $first_image = reset( $attachments->posts );
                        $thumbnail = wp_get_attachment_image_src( $first_image->ID, array( $expanded_width, $expanded_height ) );
                        $image_src = $thumbnail[0];
                    }
                }
            break;
            
            case "thumbnail":
                if( is_numeric( $slide['id'] ) ) {
                    $thumbnail_id = get_post_thumbnail_id( $slide['id'] );
                    if( $thumbnail_id ) {
                        $thumbnail = wp_get_attachment_image_src( $thumbnail_id, array( $expanded_width, $expanded_height ) );
                        $image_src = $thumbnail[0];
                    }
                }
            break;
            
            case "enclosure":
                
                if( isset( $slide['enclosures'] ) ) {
                    $previous_diff = 9999;
                    foreach( $slide['enclosures'] as $enclosure ) {
                        $enclosure_width = (integer) $enclosure->get_width();
                        
                        $slidedeck_lens = $SlideDeckPlugin->Lens->get( $slidedeck['lens'] );
                        $slidedeck_width = (integer) $slidedeck['options']['size'] != "custom" ? $slidedeck_lens['meta']['sizes'][$slidedeck['options']['size']]['width'] : $slidedeck['options']['width'];
                        
                        $this_diff = abs( $slidedeck_width - $enclosure_width );
                        
                        if( $this_diff < $previous_diff ) {
                            $previous_diff = $this_diff;
                            $image_src = $enclosure->get_link();
                        }
                        
                        if( $slidedeck_width < $enclosure_width ) {
                            $image_src = $enclosure->get_link();
                        }
                    }
                }
            break;
        }
        
        if( $image_src == false ) {
            $tried_sources[] = $source;
            // Only try other sources if we haven't tried them all
            if( count( array_intersect( $sources, $tried_sources ) ) < count( $sources ) ) {
                // Loop through sources to find an untried source to try
                $next_source = false;
                foreach( $sources as $untried_source ) {
                    if( !in_array( $untried_source, $tried_sources ) ) {
                        $next_source = $untried_source;
                    }
                }
                
                if( $next_source ) {
                    $image_src = $this->get_image( $slide, $slidedeck, $next_source, $tried_sources );
                }
            }
        }
        
        return $image_src;
    }

    /**
     * Load slides for SlideDecks sourced from WordPress posts
     * 
     * @param array $slidedeck The SlideDeck object
     * 
     * @uses WP_Query
     * @uses get_the_title()
     * @uses maybe_unserialize()
     */
    function get_posts_slides( $slidedeck ) {
        $post_type = $slidedeck['options']['post_type'];
        $post_type_sort = $slidedeck['options']['post_type_sort'];
        
        // Default Query Arguments
        $query_args = array(
            'post_type' => $post_type,
            'post_status' => 'publish',
            'posts_per_page' => $slidedeck['options']['total_slides'],
            'ignore_sticky_posts' => 1
        );
        
        switch( $post_type_sort ) {
            case "recent":
                $query_args['orderby'] = "date";
                $query_args['order'] = "DESC";
            break;
            
            case "popular":
                $query_args['orderby'] = "comment_count date";
                $query_args['order'] = "DESC";
            break;
        }
        
        // If filtering is on...
        if( $slidedeck['options']['filter_by_tax'] ){
        	
			
            // Set up the tag/category filtering 
            $filter_terms = array();
            if( isset( $slidedeck['options']['filter'] ) )
                $filter_terms = $slidedeck['options']['filter'];
            // Loop through the taxonomies and the terms.
            if( isset( $filter_terms ) && !empty( $filter_terms ) ) {
            	
				// Are we getting any of the taxonomies or all of them?
				if( $slidedeck['options']['query_any_all'] == 'any' ){
					$query_args['tax_query']['relation'] = 'OR';
				}else{
					$query_args['tax_query']['relation'] = 'AND';
				}
				
                foreach( $filter_terms as $taxonomy => $terms ) {
					// Get the taxonomy object
                	$taxonomy_object = get_taxonomy( $taxonomy );
					
					// Which field to we query?
					if( $taxonomy_object->hierarchical ) {
						$field = 'id';
					}else{
						$field = 'name';
					}
					// Add each taxonomy query to the tax query array...
                    foreach( $terms as $term_ids ) {
                        $query_args['tax_query'][] = array(
                            'taxonomy' => $taxonomy,
                            'field' => $field,
                            'terms' => $term_ids
                        );
                    }
                }
            }
        }
        
        $query = new WP_Query( $query_args );
        
        $slides = array();
        foreach( (array) $query->posts as $post ) {
            $post_id = $post->ID;
            
			/**
			 * Set the author and the default post_content.
			 */
            $author = get_userdata( $post->post_author );
			$post_content = strip_shortcodes( $post->post_content );
			
			/**
			 * If the users would like to override their post content with their 
			 * post excerpt. We love our users. Really we do!
			 * TODO: Figure out a way for users to use shortcodes in post_content if they _really really really_ want to.
			 */
			if( isset( $slidedeck['options']['use-custom-post-excerpt'] ) && !empty( $slidedeck['options']['use-custom-post-excerpt'] ) )
                if( $slidedeck['options']['use-custom-post-excerpt'] && !empty( $post->post_excerpt ) )
				$post_content = strip_shortcodes( $post->post_excerpt );
			
            $slide = array(
                'id' => $post_id,
                'title' => get_the_title( $post_id ),
                'permalink' => get_permalink( $post_id ),
                'author_id' => $post->post_author,
                'author_name' => $author->user_nicename,
                'author_url' => $author->user_url,
                'author_email' => $author->user_email,
                'author_avatar' => slidedeck2_get_avatar( $author->user_email ),
                'content' => $post_content,
                'created_at' => $post->post_date_gmt,
                'local_created_at' => $post->post_date
            );
            
            $slides[] = $slide;
        }
        
        return $slides;
    }

    /**
     * Load slides for RSS feed sourced SlideDecks
     * 
     * @uses fetch_feed()
     * 
     * @return array
     */
    function get_rss_slides( $slidedeck ) {
        $slides = array();
        
        // Set a reference to the current SlideDeck for reference in actions
        $this->__transient_slidedeck = &$slidedeck;
        // Add a feed options action for this fetch_feed() call
        add_action( 'wp_feed_options', array( &$this, 'wp_feed_options' ), 10, 2 );
        // Fetch our feed
        $rss = fetch_feed( wp_specialchars_decode( esc_url( $slidedeck['options']['feedUrl'] ) ) );
        // Remove the feed options modification action
        remove_action( 'wp_feed_options', array( &$this, 'wp_feed_options' ), 10, 2 );
        // Unset the SlideDeck reference
        unset( $this->__transient_slidedeck );
        
        // Only process if there were no errors
        if( !is_wp_error( $rss ) ) {
            // Get the total amount of items in the feed, maximum is the user set total slides option
            $maxitems = $rss->get_item_quantity( $slidedeck['options']['total_slides'] );
            $rss_items = $rss->get_items( 0, $maxitems );
            
            // Loop through each item to build an array of slides
            foreach( $rss_items as &$item ) {
                $author = $item->get_author();
                
                $slide = array(
                    'id' => $item->get_id(),
                    'title' => $item->get_title(),
                    'permalink' => $item->get_permalink(),
                    'author_name' => isset( $author ) ? $item->get_author()->get_name() : "",
                    'author_url' => isset( $author ) ? $item->get_author()->get_link() : "",
                    'author_email' => isset( $author ) ? $item->get_author()->get_email() : "",
                    'author_avatar' => isset( $author ) ? slidedeck2_get_avatar( $item->get_author()->get_email() ) : "",
                    'content' => $item->get_content(),
                    'excerpt' => strip_tags( $item->get_content(), "<b><strong><i><em><a>" ),
                    'created_at' => $item->get_date(),
                    'local_created_at' => $item->get_local_date(),
                    'latitude' => $item->get_latitude(),
                    'longitude' => $item->get_longitude()
                );
                
                if( $enclosures = $item->get_enclosures() ) {
                    $slide['enclosures'] = $enclosures;
                }
                
                $slides[] = $slide;
            }
        }
        
        return $slides;
    }

    /**
     * Load slides for Google+ feed sourced SlideDecks
     * 
     * @uses fetch_feed()
	 * @uses $SlideDeck->get_dimensions()
     * 
     * @return array
     */
    function get_gplus_slides( $slidedeck ) {
        $slides = array();
		$slidedeck_id = $slidedeck['id'];
        $slidedeck_dimensions = $this->get_dimensions( $slidedeck );
		$expansion_factor = 1; // We may want to adjust this to multiply the size later
		$expanded_width = $slidedeck_dimensions['outer_width'] * $expansion_factor;
		$expanded_height = $slidedeck_dimensions['outer_height'] * $expansion_factor;
		
        $args = array(
            'sslverify' => false
        );
		
        if( isset( $slidedeck['options']['gplusUserId'] ) && !empty( $slidedeck['options']['gplusUserId'] ) && isset( $slidedeck['options']['gplus_api_key'] ) && !empty( $slidedeck['options']['gplus_api_key'] )){
    		// https Google Plus public posts feed:
    		$feed_url = 'https://www.googleapis.com/plus/v1/people/' . $slidedeck['options']['gplusUserId'] . '/activities/public?key=' . $slidedeck['options']['gplus_api_key'] . '&maxResults=' . $slidedeck['options']['total_slides'] . '&alt=json';
        }else{
            return $slides;
        }
		
        // Set a reference to the current SlideDeck for reference in actions
        $this->__transient_slidedeck &= $slidedeck;

        // Create a cache key
        $cache_key = $slidedeck_id . $feed_url . $slidedeck['options']['feedCacheDuration'] . $this->type;
        
        // Attempt to read the cache
		// TODO: Cache the response from Google instead of caching the array we build (what we're doing now).
        $gplus_posts = slidedeck2_cache_read( $cache_key );
        
        // If cache doesn't exist
        if( !$gplus_posts ){
            $gplus_posts = array();
            
            $response = wp_remote_get( $feed_url, $args );
            if( !is_wp_error( $response ) ) {
                $response_json = json_decode( $response['body'] );
                
                if( !empty( $response_json ) ){
                    foreach( (array) $response_json->items as $entry ){
						/**
						 * If the post was a re-share then hanle differently.
						 */
						if( $entry->verb == 'share' ){
							$author_name = $entry->object->actor->displayName;
							$author_first_name = $entry->object->actor->displayName;
							$author_url = $entry->object->actor->url;
							$author_avatar = $entry->object->actor->image->url;
						}else{
							$author_name = $entry->actor->displayName;
							$author_first_name = $entry->actor->name->givenName;
							$author_url = $entry->actor->url;
							$author_avatar = $entry->actor->image->url;
						}
						
                        // Set default title
                        $title = $entry->title;
                        // Extra excerpt
                        $article_excerpt = '';
                        
						// Look for images:
						$post_image = false;
						if( !empty( $entry->object->attachments ) && isset( $entry->object->attachments ) ){
							foreach( $entry->object->attachments as $attachment ){
								
								// If there's an image, grab it...
								if( property_exists( $attachment, 'image' ) ){
									$post_image = $attachment->image->url;
								}
								
								// if there's a full image, grab it too!
                                if( property_exists( $attachment, 'fullImage' ) ){
                                    $post_image = $attachment->fullImage->url;
                                }
								
                                // Override title if an article is attached ie: A link with images
                                if( $attachment->objectType == 'article' ){
                                    // Add the article title if one exists.
                                    if( isset( $attachment->displayName ) && !empty( $attachment->displayName ) )
                                        $title = $attachment->displayName;
                                    // Fill the extra excerpt content if it exists.
                                    if( isset( $attachment->content ) && !empty( $attachment->content ) )
                                        $article_excerpt = $attachment->content;
                                    
                                }
							}
						}

						/**
						 * If the post was a checkin (business level location attached)
						 * 
						 * For Checkins, it would be nice to say that 'User' Checked in 'Place',
						 * so let's modify the title so it says so. G+ has no titles really 
						 * anyway, so it's no big deal... I think.
						 */
						if( $entry->verb == 'checkin' ){
							if( isset( $entry->placeName ) && !empty( $entry->placeName ) )
							$title = "{$author_first_name} checked in at {$entry->placeName}";
							
							/**
							 * If we've gotten this far, and there's no image, let's use a map!
							 * We love images! Images are good m'kay?
							 */
							if( empty( $post_image ) ){
								$geocode = str_replace( ' ', ',', $entry->geocode ); // lat,lon
								$scale_factor = 2; // Integer!
								$map_zoom_level = 16; // Integer!
								$post_image = 'http://maps.googleapis.com/maps/api/staticmap?sensor=false&format=png8&markers=' . $geocode . '&center=' . $geocode . '&zoom=' . $map_zoom_level . '&maptype=roadmap&scale=' . $scale_factor . '&size=' . round( $expanded_width/$scale_factor ) . 'x' . round( $expanded_height/$scale_factor );
							}
						}

						/**
						 * Build the final array of cool stuff for the Google+ Slide: 
						 */
		                $gplus_posts[] = array(
		                    'id' => $entry->id,
		                    'title' => $title,
		                    'permalink' => $entry->url,
		                    'image' => $post_image,
		                    'author_name' => $author_name,
		                    'author_url' => $author_url,
		                    'author_email' => false,
		                    'author_avatar' => $author_avatar,
		                    'content' => empty( $entry->object->content ) ? $entry->object->content : false,
		                    'comment_count' => $entry->object->replies->totalItems,
		                    'plusone_count' => $entry->object->plusoners->totalItems,
		                    'reshare_count' => $entry->object->resharers->totalItems,
		                    'excerpt' => strip_tags( $entry->object->content . ' ' . $article_excerpt, "<b><strong><i><em><a>" ),
		                    'created_at' => $entry->published,
		                    'local_created_at' => $entry->published,
		                );
                    }
                }
            }else{
                return false;
            }
            // Write the cache
            slidedeck2_cache_write( $cache_key, $gplus_posts, $slidedeck['options']['feedCacheDuration'] );
        }

        return $gplus_posts;
    }

    /**
     * SlideDeck After Save hook-in
     * 
     * Saves additional data for this Deck type when saving a SlideDeck
     * 
     * @param integer $id The ID of the SlideDeck being saved
     * @param array $data The data submitted containing information about the SlideDeck to the save method
     * @param string $type The type of SlideDeck being saved
     */
    function slidedeck_after_save( $id, $data, $type ) {
        // Fail silently if the Deck type is not this Deck type
        if( $type != $this->type ) {
            return false;
        }
		
		// Save the API Key for later use...
		if( !empty( $data['options']['gplus_api_key'] ) ){
			update_option( $this->namespace . '_last_saved_gplus_api_key', $data['options']['gplus_api_key'] );
		}
    }
    
    /**
     * SlideDeck Edit Source AJAX response
     * 
     * @param string $type The type of SlideDeck being processed
     * @param string $source The source being switched to
     */
    function slidedeck_ajax_edit_source( $type, $source, $slidedeck_id ) {
        // Fail silently if the Deck type is not this Deck type
        if( $type != $this->type ) {
            return false;
        }
        
        if( !array_key_exists( $source, $this->sources ) ) {
            die("false");
        }
        
        $slidedeck = $this->get( $slidedeck_id, '', '', '' );
        $slidedeck['type'] = $type;
        $slidedeck['source'] = $source;
        
        call_user_func( array( &$this, "content_source_{$source}" ), $slidedeck, "" );
    }

    /**
     * SlideDeck element class hook-in
     * 
     * Add additional variation classes to the SlideDeck element
     * 
     * @return array
     */
    function slidedeck_classes( $slidedeck_classes, $slidedeck ) {
        if( $slidedeck['type'] == $this->type ) {
            if( !empty( $slidedeck['options']['lensVariation'] ) ) {
                $slidedeck_classes[] = $slidedeck['options']['lensVariation'];
            }
        }
        
        return $slidedeck_classes;
    }
    
    /**
     * SlideDeck default create status hook-in
     * 
     * Hook to override the default create status of the SlideDeck
     * 
     * @return string
     */
    function slidedeck_default_create_status( $post_status, $type ) {
        // Make sure this is this SlideDeck type
        if( $type == $this->type ) {
            $post_status = "auto-draft";
        }
        
        return $post_status;
    }
    
    /**
     * SlideDeck default options hook-in
     * 
     * @param array $options The SlideDeck Options
     * @param string $type The SlideDeck Type
     * @param string $lens The SlideDeck Lens
     * 
     * @return array
     */
    function slidedeck_default_options( $options, $type, $lens, $source ) {
        if( $type == $this->type ) {
            // Check for last_saved_gplus_api_key
            if( $last_saved_gplus_api_key = get_option( $this->namespace . '_last_saved_gplus_api_key' ) ){
                $this->default_options['gplus_api_key'] = $last_saved_gplus_api_key;
            }
        }
        
        return $options;
    }
    
        /**
     * Add appropriate classes for this Lens to the SlideDeck frame
     * 
     * @param array $slidedeck_classes Classes to be applied
     * @param array $slidedeck The SlideDeck object being rendered
     * 
     * @return array
     */
    function slidedeck_frame_classes( $slidedeck_classes, $slidedeck ) {
        if( $slidedeck['type'] == $this->type ) {
            $slidedeck_classes[] = "date-format-{$slidedeck['options']['date-format']}";
        }
        
        return $slidedeck_classes;
    }
    
	function slidedeck_options( $options, $type ){
        if( $type == $this->type ) {
			// Convert the taxonomy terms
			/**
			 * We're doing it this was because we're using the
			 * default WordPress cateogry box. This is a better user
			 * experience as it's familiar, but requires a bit more work
			 * to translate from WP language to SD language.
			 */
			if( $options['filter_by_tax'] ){
				// For each taxonomy type...
				foreach( (array) $options['taxonomies'] as $taxonomy => $value ){
					if( isset( $_REQUEST['tax_input'][$taxonomy] ) ){
						/**
						 * Is this tax type sent with the tax_input prefix?
						 * If so then it's probably a custom taxonomy...
						 */
						if( is_array( $_REQUEST['tax_input'][$taxonomy] ) ) {
							/**
							 * OK, we're getting mightly tricky now. ^^
							 * If the tax_input is an array, it's probably categories.
							 */
							$options['filter'][$taxonomy]['terms'] = $_REQUEST['tax_input'][$taxonomy];
						}else{
							/**
							 * If it's a string, then it's probably some tags.
							 */
							$tag_tax = reset( array_keys( $_REQUEST['newtag'] ) );
							$tags = explode( ',', $_REQUEST['tax_input'][$taxonomy] );
							foreach( $tags as &$tag )
								$tag = trim( $tag );
							
							$options['filter'][$tag_tax]['terms'] = $tags;
						}
					}else{
						/**
						 * Else... this is probably a default category taxonomy.
						 */
						$options['filter'][$taxonomy]['terms'] = $_REQUEST['post_'.$taxonomy];
					}
				}
			}
		}
		
		return $options;
	}

    /**
     * Filter options model
     */
    function slidedeck_options_model( $options_model, $slidedeck ) {
        if( $slidedeck['type'] == $this->type ) {
        	// Remove the image source options for gallery and thumbnail, select the content as the image source if RSS
            if( $slidedeck['source'] == "rss" ) {
                unset( $options_model['Content']['imageSource']['values']['gallery'] );
                unset( $options_model['Content']['imageSource']['values']['thumbnail'] );
                $options_model['Content']['imageSource']['value'] = "content";
            }
			// Hide the image source selector if Google Plus Posts
            if( $slidedeck['source'] == "gplus" ) {
                $options_model['Content']['imageSource']['type'] = "hidden";
                $options_model['Content']['imageSource']['value'] = "content";
            }
			// Show the extra option for using a custom excerpt when it's WordPress Posts
            if( $slidedeck['source'] == "posts" ){
                $options_model['Content']['use-custom-post-excerpt']['type'] = 'checkbox';
            }
        }
        return $options_model;
    }
    
    /**
     * Get slides for SlideDecks of this type
     * 
     * Loads the slides associated with this SlideDeck if it matches this Deck type and returns
     * an array of structured slide data.
     * 
     * @param array $slides_arr Array of slides
     * @param object $slidedeck SlideDeck object
     * 
     * @global $SlideDeckPlugin
     * 
     * @uses SlideDeckPlugin::process_slide_content()
     * @uses SlideDeck_Posts::get_slides()
     * 
     * @return array
     */
    function slidedeck_get_slides( $slides, $slidedeck ) {
        global $SlideDeckPlugin;
        
        // Fail silently if not this Deck type
        if( $slidedeck['type'] != $this->type ) {
            return $slides;
        }
        
        // Slides associated with this SlideDeck
        switch( $slidedeck['source'] ) {
            case "posts":
                $slides_nodes = $this->get_posts_slides( $slidedeck );
            break;
                
            case "rss":
                $slides_nodes = $this->get_rss_slides( $slidedeck );
            break;
			
            case "gplus":
                $slides_nodes = $this->get_gplus_slides( $slidedeck );
            break;
        }
        
        // Loop through all slide nodes to build a structured slides array
        foreach( $slides_nodes as &$slide_nodes ) {
            $slide = array(
                'title' => $slide_nodes['title'],
                'styles' => "",
                'classes' => array(),
                'content' => ""
            );
            
            // Look to see if an image is associated with this slide
            $has_image = $this->get_image( $slide_nodes, $slidedeck );
            
            if( $has_image ) {
                $slide['styles'] = 'background-image: url(' . $has_image . ');';
                $slide['classes'][] = "has-image";
				$slide['thumbnail'] = $has_image;
				
				if( $slidedeck['source'] == "posts" ) {
					$slide['thumbnail'] = $this->_get_post_thumbnail( $slide_nodes['id'], $has_image );
				}
            } else {
                $slide['classes'][] = "no-image";
            }
            
            // Excerpt node
            if( !array_key_exists( 'excerpt', $slide_nodes) || empty( $slide_nodes['excerpt'] ) )
                $slide_nodes['excerpt'] = $slide_nodes['content'];
            
            // Truncate excerpt node length
            $excerpt_length = $has_image ? $slidedeck['options']['excerptLengthWithImages'] : $slidedeck['options']['excerptLengthWithoutImages'];
            $slide_nodes['excerpt'] = slidedeck2_stip_tags_and_truncate_text( $slide_nodes['excerpt'], $excerpt_length, "&hellip;" );
            
            // Truncate title node length
            $title_length = $has_image ? $slidedeck['options']['titleLengthWithImages'] : $slidedeck['options']['titleLengthWithoutImages'];
            $slide_nodes['title'] = slidedeck2_stip_tags_and_truncate_text( $slide['title'], $title_length, "&hellip;" );
            
			if( !empty( $slide_nodes['excerpt'] ) ) {
				$slide['classes'][] = "has-excerpt";
			} else {
				$slide['classes'][] = "no-excerpt";
			}
			
			if( !empty( $slide_nodes['title'] ) ) {
				$slide['classes'][] = "has-title";
			} else {
				$slide['classes'][] = "no-title";
			}
			
            // Set image node
            if( $has_image ) $slide_nodes['image'] = $has_image;
            
            // Set link target node
            $slide_nodes['target'] = $slidedeck['options']['linkTarget'];
            
            $slide['content'] = $SlideDeckPlugin->Lens->process_template( $slide_nodes, $slidedeck );
            
            $slides[] = $slide;
        }
        
        return $slides;
    }
	
    /**
     * Hook into wp_feed_options action
     * 
     * Hook into the SimplePie feed options object to modify parameters when looking up
     * feeds for RSS based feed SlideDecks.
     * 
     * @uses SimplePie::set_cache_location()
     * @uses SimplePie::set_cache_duration()
     */
    function wp_feed_options( $feed, $url ) {
        $feed->set_cache_duration( $this->__transient_slidedeck['options']['feedCacheDuration'] * 60 );
    }
}