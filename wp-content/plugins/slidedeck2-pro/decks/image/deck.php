<?php
class SlideDeck_Image extends SlideDeck {
    // The "friendly" name of this Deck type
    var $name = "Image";
    // The slug to identify this Deck type internally
    var $type = "image";
    
    var $default_source = 'dribbble';
    
    var $default_options = array(
        'medialibrary_ids' => array()
    );
    
    var $options_model = array(
        'Setup' => array(
            'feedCacheDuraton' => array(
                'value' => 30,
                'data' => 'integer',
                'type' => 'hidden'
            ),
            'total_slides' => array(
                'value' => 5,
                'data' => 'integer'
            ),
            'instagram_recent_or_likes' => array(
                'value' => "recent",
                'data' => 'string'
            ),
            'instagram_username' => array(
                'value' => "",
                'data' => 'string'
            ),
            'instagram_access_token' => array(
                'value' => "",
                'data' => 'string'
            ),
            'dribbble_shots_or_likes' => array(
                'value' => "shots",
                'data' => 'string'
            ),
            'dribbble_username' => array(
                'value' => "moonspired",
                'data' => 'string'
            ),
            'flickr_recent_or_favorites' => array(
                'value' => "recent",
                'data' => 'string'
            ),
            'flickr_userid' => array(
                'value' => "76066843@N02",
                'data' => 'string'
            ),
            'flickr_tags_mode' => array(
                'value' => "any",
                'data' => "string"
            ),
            'flickr_tags' => array(
                'value' => "",
                'data' => "string"
            ),
            'gplus_user_id' => array(
                'value' => "105237212888595777019", // Trey Ratcliff
                'data' => 'string'
            ),
            'gplus_images_album' => array(
                'value' => '5623042490481885105', // Portfolio - The Counter-Earth, the one some of us see...
                'data' => "string"
            ),
            'gplus_max_image_size' => array(
                'value' => 1024,
                'data' => "integer"
            )
        ),
        'Content' => array(
            'titleLengthWithImages' => array(
                'type' => 'text',
                'data' => "integer",
                'attr' => array(
                    'size' => 5,
                    'maxlength' => 3
                ),
                'value' => 50,
                'label' => "Title Length",
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
            'excerptLengthWithImages' => array(
                'type' => 'text',
                'data' => "integer",
                'attr' => array(
                    'size' => 3,
                    'maxlength' => 4
                ),
                'value' => 100,
                'label' => "Excerpt Length",
                'description' => "Maximum length of the excerpt (when available) in characters",
                'suffix' => "chars",
                'weight' => 20,
                'interface' => array(
                    'type' => 'slider',
                    'min' => 10,
                    'max' => 500,
                    'step' => 10
                )
            ),
            'show-excerpt' => array(
                'type' => 'checkbox',
                'data' => 'boolean',
                'label' => "Show Excerpt",
                'value' => true,
                'weight' => 22
            )
        ),
        'Playback' => array(
        	'autoPlay' => array(
        		'value' => true
			),
			'autoPlayInterval' => array(
        		'value' => 3
			)
		)
    );
    
    // Available content sources
    var $sources = array(
        'instagram' => array(
            'name' => 'instagram',
            'label' => "Instagram",
            'icon' => '/decks/image/images/instagram-icon.png',
            'chicklet' => '/decks/image/images/instagram-chicklet.png',
            'taxonomies' => array( 'images', 'social' ),
            'default_lens' => "tool-kit"
        ),
        'dribbble' => array(
            'name' => 'dribbble',
            'label' => "Dribbble",
            'icon' => '/decks/image/images/dribbble-icon.png',
            'chicklet' => '/decks/image/images/dribbble-chicklet.png',
            'taxonomies' => array( 'images' ),
            'default_lens' => "tool-kit"
        ),
        'gplusimages' => array(
            'name' => 'gplusimages',
            'label' => "Google+/Picasa Images",
            'icon' => '/decks/image/images/gplus-icon.png',
            'chicklet' => '/decks/image/images/gplus-chicklet.png',
            'taxonomies' => array( 'images' ),
            'default_lens' => "tool-kit"
        ),
        'flickr' => array(
            'name' => 'flickr',
            'label' => "Flickr Photos",
            'icon' => '/decks/image/images/flickr-icon.png',
            'chicklet' => '/decks/image/images/flickr-chicklet.png',
            'taxonomies' => array( 'images' ),
            'default_lens' => "tool-kit"
        ),
        'medialibrary' => array(
            'name' => 'medialibrary',
            'label' => "Your Media Library",
            'icon' => '/decks/image/images/medialibrary-icon.png',
            'chicklet' => '/decks/image/images/medialibrary-chicklet.png',
            'taxonomies' => array( 'images' ),
            'default_lens' => "tool-kit"
        )
    );
    
    function add_hooks() {
        add_filter( "{$this->namespace}_default_create_status", array( &$this, 'slidedeck_default_create_status' ), 10, 2 );
        add_filter( "{$this->namespace}_options", array( &$this, 'slidedeck_options' ), 10, 2 );
        
        add_action( 'admin_init', array( &$this, 'admin_init' ) );
        add_action( "admin_print_scripts-media-upload-popup", array( &$this, 'admin_print_scripts_media_upload_popup' ) );
        add_action( "{$this->namespace}_ajax_edit_source", array( &$this, 'slidedeck_ajax_edit_source' ), 10, 3 );
        add_action( "wp_ajax_update_gplus_albums", array( &$this, 'wp_ajax_update_gplus_albums' ) );
        add_action( "{$this->namespace}_after_create", array( &$this, 'slidedeck_after_create' ), 10, 2 );
        add_action( "{$this->namespace}_after_delete", array( &$this, 'slidedeck_after_delete' ), 10, 2 );
        add_action( "{$this->namespace}_after_save", array( &$this, 'slidedeck_after_save' ), 10, 3 );
        foreach( $this->sources as &$source ) {
            add_action( "{$this->namespace}_form_content_source", array( &$this, "content_source_{$source['name']}" ), 10, 2 );
            
            // Add the extra image area for the media library upload.
            add_action( "{$this->namespace}_form_top", array( &$this, 'add_media_library_images_area' ) );
        }

        add_action( "wp_ajax_{$this->namespace}_medialibrary_add_images", array( &$this, 'ajax_medialibrary_add_images' ) );
        add_action( "wp_ajax_{$this->namespace}_medialibrary_image_properties", array( &$this, 'ajax_medialibrary_image_properties' ) );
    }

    /**
     * WordPress admin_init hook-in
     * 
     * Register additional JavaScripts required by this deck type
     * 
     * @uses wp_create_nonce()
     * @uses wp_register_script()
     */
    function admin_init() {
        global $pagenow;
        
        if( $pagenow == "media-upload.php" ) {
            wp_register_script( "slidedeck-medialibrary-media-upload-popup", SLIDEDECK2_URLPATH . '/decks/image/medialibrary.js', array( 'jquery' ), '1.0.0' );
        }
    }
    
    /**
     * Media Upload tab hook-in
     */
    function admin_print_scripts_media_upload_popup() {
        wp_enqueue_script( 'slidedeck-medialibrary-media-upload-popup' );
        
        echo '<script type="text/javascript">var _medialibrary_nonce = "' . wp_create_nonce( "slidedeck-medialibrary-add-images" ) . '";</script>';
    }
    
    /**
     * Add the Media Library Images Area
     * 
     * This uses the _form_top hook.
     */
    function add_media_library_images_area( $slidedeck ) {
        if( $slidedeck['source'] != 'medialibrary' ){
            return false;
        }
        
        $media = $this->get_media_meta( (array) $slidedeck['options']['medialibrary_ids'] );
        $namespace = $this->namespace;
		
        echo '<div id="slidedeck-medialibrary-images">';
        include( SLIDEDECK2_DIRNAME . '/decks/image/views/medialibrary-images.php' );
        echo '</div>';
    }
    
    /**
     * AJAX response for adding images to a SlideDeck
     * 
     * @uses wp_verify_nonce()
     * @uses wp_die()
     * @uses SlideDeck_Image::get_media_meta()
     */
    function ajax_medialibrary_add_images() {
        if( !wp_verify_nonce( $_REQUEST['_wpnonce'], 'slidedeck-medialibrary-add-images' ) )
            wp_die( __( "You do not have permission to do this!" ), 'slidedeck' );
        
        $media_ids = array_map( 'intval', $_REQUEST['media'] );
        $media = $this->get_media_meta( $media_ids );
        $namespace = $this->namespace;
		
        include( dirname( __FILE__ ) . '/views/medialibrary-images.php' );
        exit;
    }

    /**
     * AJAX response for image properties modal
     */
    function ajax_medialibrary_image_properties() {
        if( !wp_verify_nonce( $_REQUEST['_wpnonce'], 'slidedeck-medialibrary-image-properties' ) )
            wp_die( __( "You do not have permission to do this!" ), 'slidedeck' );
        
        $media_id = intval( $_REQUEST['id'] );
        $media = $this->get_media_meta( $media_id );
        
        // Save submission
        if( !empty( $_POST ) ) {
            $data = slidedeck2_sanitize( $_POST );
            wp_update_post( array(
                'ID' => $data['ID'],
                'post_title' => $data['title'],
                'post_excerpt' => $data['caption']
            ) );
            update_post_meta( $data['ID'], "{$this->namespace}_media_link", $data['media_link'] );
            
            die('Saved!');
        }
        
        include( dirname( __FILE__ ) . '/views/medialibrary-image-properties.php' );
        exit;
    }
	
    /**
     * Ajax function to get the user's albums
     * 
     * @return string A <select> element containing the albums.
     */
    function wp_ajax_update_gplus_albums() {
        $gplus_userid = $_REQUEST['gplus_userid'];
        
        echo $this->get_gplus_albums_from_userid( $gplus_userid );
        exit;
    }
    
    function content_source_instagram( $slidedeck, $form_action ) {
        // Fail silently if the SlideDeck is not this type or source
        if( $slidedeck['type'] != $this->type || $slidedeck['source'] != 'instagram' ) {
            return false;
        }
        
        $source = $this->sources['instagram'];
        
        if( isset( $_GET['token'] ) && !empty( $_GET['token'] ) )
            $token = $_GET['token'];
        else
            $token = $slidedeck['options']['instagram_access_token'];
        
        include( dirname( __FILE__ ) . '/views/source/_instagram.php' );
    }
    
    function content_source_dribbble( $slidedeck, $form_action ) {
        // Fail silently if the SlideDeck is not this type or source
        if( $slidedeck['type'] != $this->type || $slidedeck['source'] != 'dribbble' ) {
            return false;
        }
        
        $source = $this->sources['dribbble'];
        
        include( dirname( __FILE__ ) . '/views/source/_dribbble.php' );
    }
    
    function content_source_flickr( $slidedeck, $form_action ) {
        // Fail silently if the SlideDeck is not this type or source
        if( $slidedeck['type'] != $this->type || $slidedeck['source'] != 'flickr' ) {
            return false;
        }
        
        $source = $this->sources['flickr'];
        
        // Load the list of videos
        $flickr_tags = array();
        $flickr_tags = get_post_meta( $slidedeck['id'], "{$this->namespace}_flickr_tags", true );
        
        if( empty( $flickr_tags ) ) {
            if( isset( $slidedeck['options']['slidedeck_flickr_tags'] ) && !empty( $slidedeck['options']['slidedeck_flickr_tags'] ) ){
                $flickr_tags = $slidedeck['options']['slidedeck_flickr_tags'];
            }
        }
        
        $tags = explode( ",", $flickr_tags );
        $tags = array_filter( $tags, 'strlen' );
        $tags_html = $this->get_flickr_tags_html( $tags );
        
        include( dirname( __FILE__ ) . '/views/source/_flickr.php' );
    }
    
    function content_source_gplusimages( $slidedeck, $form_action ) {
        // Fail silently if the SlideDeck is not this type or source
        if( $slidedeck['type'] != $this->type || $slidedeck['source'] != 'gplusimages' ) {
            return false;
        }
        
        $source = $this->sources['gplusimages'];
		
        $albums_select = $this->get_gplus_albums_from_userid( $slidedeck['options']['gplus_user_id'], $slidedeck );
        
        include( dirname( __FILE__ ) . '/views/source/_gplusimages.php' );
    }
    
    function content_source_medialibrary( $slidedeck, $form_action ) {
        // Fail silently if the SlideDeck is not this type or source
        if( $slidedeck['type'] != $this->type || $slidedeck['source'] != 'medialibrary' ) {
            return false;
        }
        
        $source = $this->sources['medialibrary'];
        
        include( dirname( __FILE__ ) . '/views/source/_medialibrary.php' );
    }
    
    function description_length(){
        return 20; // Words
    }
    
    /**
     * Get Google Plus Image Feed
     * 
     * Fetches a Google Plus feed, caches it and returns the 
     * cached result or the results after caching them.
     * 
     * @param string $feed_url The URL of the gplus feed with a JSON response
     * @param integer $slidedeck_id The ID of the deck (for caching)
     * 
     * @return array An array of arrays containing the images and various meta.
     */
    function get_gplus_feed( $slidedeck ){
        $args = array(
            'sslverify' => false
        );
		
        $gplus_user_id = $slidedeck['options']['gplus_user_id'];
        $max_image_size = $slidedeck['options']['gplus_max_image_size'];
        // API Max: http://code.google.com/apis/picasaweb/docs/2.0/reference.html#Parameters

        switch( $slidedeck['options']['gplus_images_album'] ){
            case 'recent':
                $feed_url = 'http://photos.googleapis.com/data/feed/api/user/' . $gplus_user_id . '?kind=photo&alt=json&imgmax=' . $max_image_size . '&max-results=' . $slidedeck['options']['total_slides'];
            break;
			default:
                $album_id = (string) $slidedeck['options']['gplus_images_album'];
                $feed_url = 'http://photos.googleapis.com/data/feed/api/user/' . $gplus_user_id . '/albumid/' . $album_id . '?alt=json&imgmax=' . $max_image_size . '&max-results=' . $slidedeck['options']['total_slides'];
            break;
        }
		
        // Create a cache key
        $cache_key = $slidedeck['id'] . $feed_url . $slidedeck['options']['feedCacheDuraton'] . $this->type;
        
        // Attempt to read the cache
        $images = slidedeck2_cache_read( $cache_key );
        
        // If cache doesn't exist
        if( !$images ){
            $images = array();
            
            $response = wp_remote_get( $feed_url, $args );
            if( !is_wp_error( $response ) ) {
                $response_json = json_decode( $response['body'] );
                
                if( !empty( $response_json ) ){
                    foreach( (array) $response_json->feed->entry as $index => $entry ){
                        $images[ $index ]['title'] = $entry->title->{'$t'};
                        $images[ $index ]['description'] = $entry->summary->{'$t'};
                        $images[ $index ]['width'] = $entry->{'gphoto$width'}->{'$t'};
                        $images[ $index ]['height'] = $entry->{'gphoto$height'}->{'$t'};
                        $images[ $index ]['created_at'] = strtotime ( $entry->published->{'$t'} );
                        $images[ $index ]['image'] = $entry->content->src;
                        $images[ $index ]['thumbnail'] = $entry->{'media$group'}->{'media$thumbnail'}[1]->url;
                        foreach( $entry->link as $link ){
                            if( $link->rel == 'alternate' ){
                                $images[ $index ]['permalink'] = $link->href;
                            }
                        }
                        $images[ $index ]['comments_count'] = $entry->{'gphoto$commentCount'}->{'$t'};
                        
                        $images[ $index ]['author_name'] = $entry->{'media$group'}->{'media$credit'}[0]->{'$t'};
                    }
                }
            }else{
                return false;
            }
            // Write the cache
            slidedeck2_cache_write( $cache_key, $images, $slidedeck['options']['feedCacheDuraton'] );
        }
        return $images;
    }
	
	/**
	 * Gets the List of albums from a gplus user
	 * 
	 * @return string The HTML necessary for sselecting an album.
	 */
	function get_gplus_albums_from_userid( $user_id = false, $slidedeck = null ){
        $albums = false;
        
        $args = array(
            'sslverify' => false
        );
        
        $feed_url = "https://picasaweb.google.com/data/feed/api/user/{$user_id}?alt=json&orderby=updated";
        
        if( isset( $user_id ) && !empty( $user_id ) ){
            // Create a cache key
            $cache_key = $slidedeck['id'] . $feed_url;
            
            // Attempt to read the cache (no cache)
            $albums = false;
            
            // If cache doesn't exist
            if( !$albums ){
                $albums = array();
                
                $response = wp_remote_get( $feed_url, $args );
                if( !is_wp_error( $response ) ) {
                    $response_json = json_decode( $response['body'] );
                    
					
                    if( !empty( $response_json ) ){
                        foreach( $response_json->feed->entry as $key => $entry ){
                        	// Only if the album has photos in it.
                        	if( intval( $entry->{'gphoto$numphotos'}->{'$t'} ) > 0 ){
	                            $albums[ $key ] = array(
	                                'album_id' => $entry->{'gphoto$id'}->{'$t'},
	                                'title' => $entry->title->{'$t'} . sprintf( _n( " (%d photo)", " (%d photos)", $entry->{'gphoto$numphotos'}->{'$t'}, $this->namespace ), $entry->{'gphoto$numphotos'}->{'$t'} ),
	                                'thumbnail' => $entry->{'media$group'}->{'media$thumbnail'}[0]->url,
	                            );
                        	}
                        }
                    }
                }else{
                    return false;
                }
            }
        }
		
        $albums_select = array( 
            'recent' => __( 'Recent Images', $this->namespace )
        );
		
        if( $albums ){
            foreach( $albums as $album ){
                $albums_select[ $album['album_id'] ] = $album['title'];
            }
        }
		
        return slidedeck2_html_input( 'options[gplus_images_album]', $slidedeck['options']['gplus_images_album'], array( 'type' => 'select', 'label' => "Album", 'attr' => array( 'class' => 'fancy' ), 'values' => $albums_select ), false ); 
	}
    
    /**
     * Get Dribbble Image Feed
     * 
     * Fetches a Dribbble feed, caches it and returns the 
     * cached result or the results after caching them.
     * 
     * @param string $feed_url The URL of the gplus feed with a JSON response
     * @param integer $slidedeck_id The ID of the deck (for caching)
     * 
     * @return array An array of arrays containing the images and various meta.
     */
    function get_dribbble_feed( $slidedeck ){
        $args = array(
            'sslverify' => false
        );
		
        switch( $slidedeck['options']['dribbble_shots_or_likes'] ){
            case 'shots':
                $feed_url = 'http://api.dribbble.com/players/' . $slidedeck['options']['dribbble_username'] . '/shots?per_page=' . $slidedeck['options']['total_slides'];
            break;
            case 'likes':
                $feed_url = 'http://api.dribbble.com/players/' . $slidedeck['options']['dribbble_username'] . '/shots/likes?per_page=' . $slidedeck['options']['total_slides'];
            break;
        }
		
        // Create a cache key
        $cache_key = $slidedeck['id'] . $feed_url . $slidedeck['options']['feedCacheDuraton'] . $this->type;
        
        // Attempt to read the cache
        $images = slidedeck2_cache_read( $cache_key );
        
        // If cache doesn't exist
        if( !$images ){
            $images = array();
            
            $response = wp_remote_get( $feed_url, $args );
            if( !is_wp_error( $response ) ) {
                $response_json = json_decode( $response['body'] );

                foreach( $response_json->shots as $index => $entry ){
                    $images[ $index ]['title'] = $entry->title;
                    $images[ $index ]['width'] = $entry->width;
                    $images[ $index ]['height'] = $entry->height;
                    $images[ $index ]['created_at'] = strtotime ( $entry->created_at );
                    $images[ $index ]['image'] = $entry->image_url;
                    $images[ $index ]['thumbnail'] = $entry->image_teaser_url;
                    $images[ $index ]['permalink'] = $entry->url;
                    $images[ $index ]['comments_count'] = $entry->comments_count;
                    $images[ $index ]['likes_count'] = $entry->likes_count;
                    
                    $images[ $index ]['author_name'] = $entry->player->name;
                    $images[ $index ]['author_username'] = $entry->player->username;
                    $images[ $index ]['author_avatar'] = $entry->player->avatar_url;
                }
            }else{
                return false;
            }
            // Write the cache
            slidedeck2_cache_write( $cache_key, $images, $slidedeck['options']['feedCacheDuraton'] );
        }
        return $images;
    }
        
    /**
     * Get Instagram Image Feed
     * 
     * Fetches an Instagram feed, caches it and returns the 
     * cached result or the results after caching them.
     * 
     * @param string $feed_url The URL of the gplus feed with a JSON response
     * @param integer $slidedeck_id The ID of the deck (for caching)
     * 
     * @return array An array of arrays containing the images and various meta.
     */
    function get_instagram_feed( $slidedeck ){
        $args = array(
            'sslverify' => false
        );
		
        switch( $slidedeck['options']['instagram_recent_or_likes'] ){
            case 'recent':
                // If there are no 
                if( empty( $slidedeck['options']['instagram_username'] ) ){
                    $feed_url = 'https://api.instagram.com/v1/users/self/media/recent?access_token=' . $slidedeck['options']['instagram_access_token'] . '&count=' . $slidedeck['options']['total_slides'];
                }else{
    				$user_id = $this->get_instagram_userid( $slidedeck['options']['instagram_access_token'], $slidedeck['options']['instagram_username'] );
    				if( !empty( $user_id ) ){
    	                $feed_url = 'https://api.instagram.com/v1/users/' . $user_id . '/media/recent?access_token=' . $slidedeck['options']['instagram_access_token'] . '&count=' . $slidedeck['options']['total_slides'];
    				}
                }
            break;
            case 'likes':
                $feed_url = 'https://api.instagram.com/v1/users/self/media/liked?access_token=' . $slidedeck['options']['instagram_access_token'] . '&count=' . $slidedeck['options']['total_slides'];
            break;
        }
		
        // Create a cache key
        $cache_key = $slidedeck['id'] . $feed_url . $slidedeck['options']['feedCacheDuration'] . $this->type;
        
        // Attempt to read the cache
        $images = slidedeck2_cache_read( $cache_key );
        
        // If cache doesn't exist
        if( !$images ){
            $images = array();
            
            $response = wp_remote_get( $feed_url, $args );
            if( !is_wp_error( $response ) ) {
                $response_json = json_decode( $response['body'] );
				
                foreach( (array) $response_json->data as $index => $entry ){
                    $images[ $index ]['title'] = isset( $entry->caption->text ) ? $entry->caption->text : "";
                    //$images[ $index ]['description'] = $entry->caption->text; // Do we need the duped data?
                    $images[ $index ]['width'] = $entry->images->standard_resolution->width;
                    $images[ $index ]['height'] = $entry->images->standard_resolution->height;
                    $images[ $index ]['created_at'] = $entry->created_time;
                    $images[ $index ]['image'] = $entry->images->standard_resolution->url;
                    $images[ $index ]['thumbnail'] = $entry->images->thumbnail->url;
                    $images[ $index ]['permalink'] = $entry->link;
                    $images[ $index ]['comments_count'] = $entry->comments->count;
                    $images[ $index ]['likes_count'] = $entry->likes->count;
                    $images[ $index ]['author_name'] = $entry->user->full_name;
                    $images[ $index ]['author_username'] = $entry->user->username;
                    $images[ $index ]['author_avatar'] = $entry->user->profile_picture;
                }
            } else {
                return false;
            }
            // Write the cache
            slidedeck2_cache_write( $cache_key, $images, $slidedeck['options']['feedCacheDuration'] );
        }

        return $images;
    }

	function get_instagram_userid( $token, $username ){
        $args = array(
            'sslverify' => false
        );
		
		// We do the extra trimming and URL encoding because technically... it's a search.
		$feed_url = 'https://api.instagram.com/v1/users/search?access_token=' . $token . '&q=' . urlencode( trim( $username ) ) . '&count=1';
        
        
        // Create a cache key
        $cache_key = 'instagram-search' . $username;
        
        // Attempt to read the cache
        $response = slidedeck2_cache_read( $cache_key );
        
        // If cache doesn't exist
        if( !$response ){
            $response = wp_remote_get( $feed_url, $args );
            // Write the cache
            slidedeck2_cache_write( $cache_key, $response, 60*60*24 );
        }
		
        if( !is_wp_error( $response ) ) {
            $response_json = json_decode( $response['body'] );
			return (string) $response_json->data[0]->id;
		}
		return false;
	}
    
    /**
     * Get Flickr Image Feed
     * 
     * Fetches a Flickr feed, caches it and returns the 
     * cached result or the results after caching them.
     * 
     * @param string $feed_url The URL of the gplus feed with a JSON response
     * @param integer $slidedeck_id The ID of the deck (for caching)
     * 
     * @return array An array of arrays containing the images and various meta.
     */
    function get_flickr_feed( $slidedeck ){
        switch( $slidedeck['options']['flickr_recent_or_favorites'] ){
            case 'recent':
                $feed_url = 'http://api.flickr.com/services/feeds/photos_public.gne?id=' . $slidedeck['options']['flickr_userid'] . '&format=rss_200_enc';
				$tags_string = get_post_meta( $slidedeck['id'], "{$this->namespace}_flickr_tags", true );
				if( !empty( $tags_string ) ){
					switch( $slidedeck['options']['flickr_tags_mode'] ){
						case 'any':
							$feed_url = 'http://api.flickr.com/services/feeds/photos_public.gne?id=' . $slidedeck['options']['flickr_userid'] . '&tagmode=any&tags=' . $tags_string . '&format=rss_200_enc';
						break;
						case 'all':
							$feed_url = 'http://api.flickr.com/services/feeds/photos_public.gne?id=' . $slidedeck['options']['flickr_userid'] . '&tagmode=all&tags=' . $tags_string . '&format=rss_200_enc';
						break;
					}
				}
            break;
            case 'favorites':
                $feed_url = 'http://api.flickr.com/services/feeds/photos_faves.gne?id=' . $slidedeck['options']['flickr_userid'] . '&format=rss_200_enc';
            break;
        }
		
        // Set a value attached to this object of the current SlideDeck to access it in the wp_feed_options method
        $this->current_slidedeck = $slidedeck;
        // Add a feed options action for this fetch_feed() call
        add_action( 'wp_feed_options', array( &$this, 'wp_feed_options' ), 10, 2 );
        // Fetch our feed
        $rss = fetch_feed( $feed_url );
        // Remove the feed options modification action
        remove_action( 'wp_feed_options', array( &$this, 'wp_feed_options' ), 10, 2 );
        // Remove the temporary SlideDeck value
        unset( $this->current_slidedeck );
        
        // Only process if there were no errors
        if( !is_wp_error( $rss ) ) {
            // Get the total amount of items in the feed, maximum is the user set total slides option
            $maxitems = $rss->get_item_quantity( $slidedeck['options']['total_slides'] );
            $rss_items = $rss->get_items( 0, $maxitems );
            
            // Loop through each item to build an array of slides
            $counter = 0;
            foreach( $rss_items as $index => $item ){
                $images[ $index ]['title'] = $item->get_title();
                $images[ $index ]['width'] = $item->get_enclosure()->width;
                $images[ $index ]['height'] = $item->get_enclosure()->height;
                $images[ $index ]['created_at'] = strtotime ( $item->get_date() );
                $images[ $index ]['image'] = $item->get_enclosure()->link;
                $images[ $index ]['thumbnail'] = $item->get_enclosure()->thumbnails[0];
                $images[ $index ]['permalink'] = $item->get_permalink();
                
                $images[ $index ]['author_name'] = $item->get_enclosure()->credits[0]->name;
            }
        }        
        
        return $images;
    }
    
    /**
     * Get Flickr List of Tags
     * 
     * @param array The Array of tags
     * 
     * @return string The HTML required for display of the tags.
     */
    function get_flickr_tags_html( $tags ) {
        $html = '';
        
        foreach( $tags as $tag ){
            $html .= '<span>';
            $html .= '<a href="#delete" class="delete">X</a> ';
            $html .= $tag;
            $html .= '<input type="hidden" name="flickr_tags[]" value="' . $tag . '" />';
            $html .= '</span> ';
        }
        
        return $html;
    }

    /**
     * Get Images from Media Library
     * 
     * Retrieves all media library ID entries associated with this SlideDeck
     * 
     * @param array $slidedeck The SlideDeck object
     * 
     * @return array
     */
    function get_medialibrary( $slidedeck ) {
        global $SlideDeckPlugin;
        
        $images = array();
        
        $medias = $this->get_media_meta( (array) $slidedeck['options']['medialibrary_ids'] );
        
        $sizes = apply_filters( "{$this->namespace}_sizes", $SlideDeckPlugin->sizes, $slidedeck );
        $width = ( $slidedeck['options']['size'] != "custom" ? $sizes[$slidedeck['options']['size']]['width'] : $slidedeck['options']['width'] );
        $height = ( $slidedeck['options']['size'] != "custom" ? $sizes[$slidedeck['options']['size']]['height'] : $slidedeck['options']['height'] );
        
        foreach( $medias as $media ) {
            $image_src = wp_get_attachment_image_src( $media['post']->ID, array( $width, $height ) );
            
            $author = get_userdata( $media['post']->post_author );
            
            $media_width = isset( $media['meta']['width'] ) ? $media['meta']['width'] : $width;
            $media_height = isset( $media['meta']['height'] ) ? $media['meta']['height'] : $height;
            
            $image = array(
                'title' => $media['post']->post_title,
                'width' => $media_width,
                'height' => $media_height,
                'created_at' => strtotime( $media['post']->post_date ),
                'image' => $image_src[0],
                'description' => $media['post']->post_excerpt,
                'thumbnail' => $media['src'][0],
                'permalink' => $media['media_link'],
                'author_name' => $author->user_nicename,
                'author_url' => $author->user_url,
                'author_email' => $author->user_email,
                'author_avatar' => slidedeck2_get_avatar( $author->user_email )
            );
            
            $images[] = $image;
        }
        
        return $images;
    }
    
    /**
     * Get Media Meta
     * 
     * Retrieves all relevant meta for any media entries and returns an array of
     * data keyed on the media ID.
     * 
     * @param mixed $media_ids Array of media IDs or single integer for one media ID
     * 
     * @uses WP_Query
     * @uses wp_get_attachment_metadata()
     * @uses wp_get_attachment_image_src()
     * 
     * @return array
     */
    function get_media_meta( $media_ids ) {
        $single = false;
        
        if( !is_array( $media_ids ) ) {
            $media_ids = array( $media_ids );
            $single = true;
        }
        
        $query_args = array(
            'post__in' => $media_ids,
            'post_type' => 'attachment',
            'post_status' => 'any',
            'nopaging' => true
        );
        $query = new WP_Query( $query_args );
        
        $media = array();
        foreach( $media_ids as $media_id ) {
            $image = array(
                'meta' => wp_get_attachment_metadata( $media_id ),
                'src' => wp_get_attachment_image_src( $media_id, array( 96, 96 ) )
            );
            
            $media_link = get_post_meta( $media_id, "{$this->namespace}_media_link", true );
            if( empty( $media_link ) )
                $media_link = get_attachment_link( $media_id );
            
            $image['media_link'] = $media_link;
            
            foreach( $query->posts as $post ) {
                if( $post->ID == $media_id )
                $image['post'] = $post;
            }
            
            $media[$media_id] = $image;
        }
        
        if( $single )
            return reset( $media );
        else 
            return $media;
    }
    
    /**
     * Load all slides associated with this SlideDeck
     * 
     * @param integer $slidedeck_id The ID of the SlideDeck being loaded
     * 
     */
    function get_slides( $slidedeck ) {
        $max_slides = 20;
        // Total slides may not be set if this is the Media Library content source
        if( isset( $slidedeck['total_slides'] ) )
            $max_slides = min( $slidedeck['total_slides'], 20 );
        
        $photo_source = $slidedeck['source'];
        
        switch( $photo_source ){
            case 'gplusimages':
                $images = $this->get_gplus_feed( $slidedeck );
            break;
            
            case 'instagram':
                $images = $this->get_instagram_feed( $slidedeck );
            break;
            
            case 'dribbble':
                $images = $this->get_dribbble_feed( $slidedeck );
            break;
            
            case 'flickr':
                $images = $this->get_flickr_feed( $slidedeck );
            break;
            
            case 'medialibrary':
                $images = $this->get_medialibrary( $slidedeck );
            break;
        }
        return $images;
    }

    /**
     * SlideDeck After Creation hook-in
     * 
     * Creates slides for Legacy SlideDecks after creating a new SlideDeck
     * 
     * @param integer $slidedeck_id The ID of the SlideDeck being created
     * @param array $slidedeck The SlideDeck array for the auto-draft just created
     * 
     * @uses wp_insert_post()
     */
    function slidedeck_after_create( $slidedeck_id, $slidedeck ) {
        // Only create slides if the SlideDeck belongs to this Deck type
        if( $slidedeck['type'] != $this->type ) {
            return false;
        }
        
    }
    
    /**
     * SlideDeck After Deletion hook-in
     * 
     * Deletes slides associated with the deleted SlideDeck
     * 
     * @param integer $slidedeck_id The ID of the SlideDeck that was deleted
     * @param string $type The type of SlideDeck being deleted
     */
    function slidedeck_after_delete( $slidedeck_id, $type ) {
        // Only delete other slides if the SlideDeck belongs to this Deck type
        if( $type != $this->type ) {
            return false;
        }
        
        // Nuke the tags associated with this deck
        delete_post_meta( $slidedeck_id, "{$this->namespace}_flickr_tags" );
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
     * Hook-in to slidedeck_options filter
     * 
     * @param array $options Options available
     * @param string $type The SlideDeck type
     * 
     * @return array 
     */
    function slidedeck_options( $options, $type ) {
        if( $type == $this->type ) {
            if( isset( $options['gplus_max_image_size'] ) )
                $options['gplus_max_image_size'] = max( 128, min( (integer) $options['gplus_max_image_size'], 1600 ) );
        }
        
        return $options;
    }

    /**
     * SlideDeck Options Model
     * 
     * @param array $options_model The Options Model
     * @param string $slidedeck SlideDeck object
     * 
     * @return array
     */
    function slidedeck_options_model( $options_model, $slidedeck ) {
        if( $this->type == $slidedeck['type'] ) {
            if( isset( $_REQUEST['source'] ) ) {
                $source = $_REQUEST['source'];
            } else {
                $slidedeck = $this->get( $_REQUEST['slidedeck'] );
                $source = $slidedeck['source'];
            }
            
            if( $source == 'medialibrary' ) {
                $options_model['Setup']['total_slides'] = array(
                    'type' => 'hidden',
                    'name' => 'total_slides',
                    'value' => 999
                );
            }
        }
        
        return $options_model;
    }

    /**
     * SlideDeck After Save hook-in
     * 
     * Saves additional data for this Deck type when saving a SlideDeck
     * 
     * @param integer $id The ID of the SlideDeck being saved
     * @param array $data The data submitted containing information about the SlideDeck to the save method
     * @param string $type The type of SlideDeck being saved
     * 
     * @uses SlideDeck::get()
     * @uses get_post_meta()
     * @uses update_post_meta()
     */
    function slidedeck_after_save( $id, $data, $type ) {
        // Fail silently if the Deck type is not this Deck type
        if( $type != $this->type ) {
            return false;
        }
		
        // Add the Flickr tags
        $tags = array();
        if( isset( $data['flickr_tags'] ) )
            $tags = (array) $data['flickr_tags'];
        
        update_post_meta( $id, "{$this->namespace}_flickr_tags", implode( ",", $tags ) );
        
		// Save the API Key for later use...
		if( !empty( $data['options']['instagram_access_token'] ) ){
			update_option( $this->namespace . '_last_saved_instagram_access_token', $data['options']['instagram_access_token'] );
		}
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
     * @param string $source The SlideDeck source
     * 
     * @return array
     */
    function slidedeck_default_options( $options, $type, $lens, $source ) {
        if( $type == $this->type ) {
            // Check for last_saved_instagram_access_token
            if( $last_saved_instagram_access_token = get_option( $this->namespace . '_last_saved_instagram_access_token' ) ){
                $options['instagram_access_token'] = $last_saved_instagram_access_token;
            }
        }
        
        return $options;
    }
    
    /**
     * Render slides for SlideDecks of this type
     * 
     * Loads the slides associated with this SlideDeck if it matches this Deck type and returns
     * a string of HTML markup.
     * 
     * @param array $slides_arr Array of slides
     * @param object $slidedeck SlideDeck object
     * 
     * @global $SlideDeckPlugin
     * 
     * @uses SlideDeckPlugin::process_slide_content()
     * @uses Legacy::get_slides()
     * 
     * @return string
     */
    function slidedeck_get_slides( $slides, $slidedeck ) {
        global $SlideDeckPlugin;
        
        // How many decks are on the page as of now.
        $deck_iteration = $SlideDeckPlugin->SlideDeck->rendered_slidedecks[ $slidedeck['id'] ];
        
        // Fail silently if not this Deck type
        if( $slidedeck['type'] != $this->type ) {
            return $slides;
        }
        
        // Slides associated with this SlideDeck
        $slides_nodes = $this->get_slides( $slidedeck );
        $slide_counter = 1;
        if( is_array( $slides_nodes ) ){
            foreach( $slides_nodes as &$slide_nodes ) {
                $slide = array(
                    'title' => $slide_nodes['title'],
                    'styles' => "",
                    'classes' => array( 'has-image' ),
                    'content' => "",
                    'thumbnail' => (string) $slide_nodes['thumbnail']
                );
                
                // In-line styles to apply to the slide DD element
                $slide_styles = array(
                    'background-image' => 'url(' . $slide_nodes['image'] . ')'
                );
                
                // Build an in-line style tag if needed
                if( !empty( $slide_styles ) ) {
                    foreach( $slide_styles as $property => $value ) {
                        $slide['styles'] .= "{$property}:{$value};";
                    }
                }
                
                $slide['title'] = $slide_nodes['title'] = slidedeck2_stip_tags_and_truncate_text( $slide_nodes['title'], $slidedeck['options']['titleLengthWithImages'], "&hellip;" );
                $slide_nodes['content'] = isset( $slide_nodes['description'] ) ? $slide_nodes['description'] : "";
                $slide_nodes['excerpt'] = slidedeck2_stip_tags_and_truncate_text( $slide_nodes['content'], $slidedeck['options']['excerptLengthWithImages'], "&hellip;" );
                
				if( !empty( $slide_nodes['title'] ) ) {
					$slide['classes'][] = "has-title";
				} else {
					$slide['classes'][] = "no-title";
				}
				
				if( !empty( $slide_nodes['description'] ) ) {
					$slide['classes'][] = "has-excerpt";
				} else {
					$slide['classes'][] = "no-excerpt";
				}
                
                // Set link target node
                $slide_nodes['target'] = $slidedeck['options']['linkTarget'];
				
                $slide['content'] = $SlideDeckPlugin->Lens->process_template( $slide_nodes, $slidedeck );
                
                $slide_counter++;
                
                $slides[] = $slide;
            }
        }
        
        return $slides;
    }

    /**
     * Hook into wp_feed_options action
     * 
     * Hook into the SimplePie feed options object to modify parameters when looking up
     * feeds for RSS based feed SlideDecks.
     */
    function wp_feed_options( $feed, $url ) {
        $feed->set_cache_duration( $this->current_slidedeck['options']['feedCacheDuraton'] );
    }
}