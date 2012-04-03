<?php
class SlideDeck_Video extends SlideDeck {
    // The "friendly" name of this Deck type
    var $name = "Video";
    // The slug to identify this Deck type internally
    var $type = "video";
    // Amount of slides to start with
    var $default_slide_count = 5;
    // Default options for this Deck type
    var $default_options = array(
        'feedCacheDuration' => 1800 // seconds
    );
    
    var $default_source = 'listofvideos';
    
    // Available content sources
    var $sources = array(
        'listofvideos' => array(
            'name' => 'listofvideos',
            'label' => "List of video URLs",
            'icon' => '/decks/video/images/list-icon.png',
            'chicklet' => '/decks/video/images/list-chicklet.png',
            'taxonomies' => array( 'videos' ),
            'default_lens' => "tool-kit"
        ),
        'youtube' => array(
            'name' => 'youtube',
            'label' => "YouTube Videos",
            'icon' => '/decks/video/images/youtube-icon.png',
            'chicklet' => '/decks/video/images/youtube-chicklet.png',
            'taxonomies' => array( 'videos' ),
            'default_lens' => "tool-kit"
        ),
        'dailymotion' => array(
            'name' => 'dailymotion',
            'label' => "Dailymotion Videos",
            'icon' => '/decks/video/images/dailymotion-icon.png',
            'chicklet' => '/decks/video/images/dailymotion-chicklet.png',
            'taxonomies' => array( 'videos' ),
            'default_lens' => "tool-kit"
        ),
        'vimeo' => array(
            'name' => 'vimeo',
            'label' => "Vimeo Videos",
            'icon' => '/decks/video/images/vimeo-icon.png',
            'chicklet' => '/decks/video/images/vimeo-chicklet.png',
            'taxonomies' => array( 'videos' ),
            'default_lens' => "tool-kit"
        )
    );
    
    var $options_model = array(
        'Setup' => array(
            'search_or_user' => array(
                'type' => 'radio',
                'data' => "string",
                'value' => 'user',
            ),
            'size' => array(
                'value' => 'medium'
            ),
            'slidedeck_list_of_videos' => array(
                'value' => "
                http://www.youtube.com/watch?v=a6cNdhOKwi0\n
                http://vimeo.com/28408829\n
                http://www.dailymotion.com/video/xmueia\n
                http://www.youtube.com/watch?v=u6XAPnuFjJc\n
                "
            ),
            'youtube_username' => array(
                'value' => 'TEDtalksDirector'
            ),
            'youtube_q' => array(
                'value' => 'parkour'
            ),
            'youtube_playlist' => array(
                'value' => 'recent'
            ),
            'vimeo_username' => array(
                'value' => 'madebyhand'
            ),
            'vimeo_album' => array(
                'value' => 'recent'
            ),
            'dailymotion_username' => array(
                'value' => 'ign'
            ),
            'dailymotion_playlist' => array(
                'value' => 'recent'
            )
        ),
        'Content' => array(
            'titleLength' => array(
                'type' => 'text',
                'data' => "integer",
                'attr' => array(
                    'size' => 5,
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
            'descriptionLength' => array(
                'type' => 'text',
                'data' => "integer",
                'attr' => array(
                    'size' => 5,
                    'maxlength' => 3
                ),
                'value' => 100,
                'label' => "Description Length",
                'description' => "Description length measured in characters",
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
            )
        ),
        'Playback' => array(
            'slideTransition' => array(
            	'value' => "slide",
                'values' => array(
                	'fade' => "Cross-fade",
                	'slide' => "Slide"
				)
            )
		)
    );
            
    function add_hooks() {
        add_action( "{$this->namespace}_ajax_edit_source", array( &$this, 'slidedeck_ajax_edit_source' ), 10, 3 );
        add_filter( "{$this->namespace}_default_create_status", array( &$this, 'slidedeck_default_create_status' ), 10, 2 );

        add_action('init', array( &$this, 'init' ) );
        add_action('wp_ajax_update_youtube_playlists', array( &$this, 'wp_ajax_update_youtube_playlists' ) );
        add_action('wp_ajax_update_vimeo_playlists', array( &$this, 'wp_ajax_update_vimeo_playlists' ) );
        add_action('wp_ajax_update_dailymotion_playlists', array( &$this, 'wp_ajax_update_dailymotion_playlists' ) );
        add_action('wp_ajax_update_video_thumbnail', array( &$this, 'wp_ajax_update_video_thumbnail' ) );
        add_action( "{$this->namespace}_after_create", array( &$this, 'slidedeck_after_create' ), 10, 2 );
        add_action( "{$this->namespace}_after_delete", array( &$this, 'slidedeck_after_delete' ), 10, 2 );
        add_action( "{$this->namespace}_after_save", array( &$this, 'slidedeck_after_save' ), 10, 3 );
        add_action( "{$this->namespace}_footer_scripts", array( &$this, 'slidedeck_footer_scripts' ), 10, 2 );
        
        foreach( $this->sources as &$source ) {
            add_action( "{$this->namespace}_form_content_source", array( &$this, "content_source_{$source['name']}" ), 10, 2 );
        }
    }

    function init() {
        global $SlideDeckPlugin;
        
        wp_register_script( 'froogaloop', SLIDEDECK2_URLPATH . '/decks/' . $this->type . '/javascripts/froogaloop.min.js', array(), SLIDEDECK2_VERSION, true );
        if( is_ssl() ){
            wp_register_script( 'youtube-api', 'https://www.youtube.com/player_api', array(), SLIDEDECK2_VERSION, true );
            wp_register_script( 'dailymotion-api', 'https://api.dmcdn.net/all.js', array(), SLIDEDECK2_VERSION, true );
        }else{
            wp_register_script( 'youtube-api', 'http://www.youtube.com/player_api', array(), SLIDEDECK2_VERSION, true );
            wp_register_script( 'dailymotion-api', 'http://api.dmcdn.net/all.js', array(), SLIDEDECK2_VERSION, true );
        }
    }
    
    function content_source_listofvideos( $slidedeck, $form_action ) {
        // Fail silently if the SlideDeck is not this type or source
        if( $slidedeck['type'] != $this->type || $slidedeck['source'] != 'listofvideos' )
            return false;
        
        $source = $this->sources['listofvideos'];
        
        // Load the list of videos
        $slidedeck_list_of_videos = get_post_meta( $slidedeck['id'], "{$this->namespace}_list_of_videos", true );
		
		if( empty( $slidedeck_list_of_videos ) )
			$slidedeck_list_of_videos = $slidedeck['options']['slidedeck_list_of_videos'];

        $cleaned_urls = trim( preg_replace( '/[\n\r]+/', "\n", $slidedeck_list_of_videos ) );
        $urls = explode( "\n", $cleaned_urls );
        
		// Nice little trick to empty an array!
		// http://briancray.com/2009/04/25/remove-null-values-php-arrays/
        $urls = array_filter( $urls, 'strlen' );
		$urls_html = $this->get_video_list_html( $urls );
        
        include( dirname( __FILE__ ) . '/views/source/_listofvideos.php' );
    }
    
    function content_source_youtube( $slidedeck, $form_action ) {
        // Fail silently if the SlideDeck is not this type or source
        if( $slidedeck['type'] != $this->type || $slidedeck['source'] != 'youtube' ) {
            return false;
        }
        
        $source = $this->sources['youtube'];
        
        $playlists_select = $this->get_youtube_playlists_from_username( $slidedeck['options']['youtube_username'], $slidedeck );
        
        include( dirname( __FILE__ ) . '/views/source/_youtube.php' );
    }
    
    function content_source_vimeo( $slidedeck, $form_action ) {
        // Fail silently if the SlideDeck is not this type or source
        if( $slidedeck['type'] != $this->type || $slidedeck['source'] != 'vimeo' ) {
            return false;
        }
        
        $source = $this->sources['vimeo'];
        
        $playlists_select = $this->get_vimeo_playlists_from_username( $slidedeck['options']['vimeo_username'], $slidedeck );
        
        include( dirname( __FILE__ ) . '/views/source/_vimeo.php' );
    }
    
    function content_source_dailymotion( $slidedeck, $form_action ) {
        // Fail silently if the SlideDeck is not this type or source
        if( $slidedeck['type'] != $this->type || $slidedeck['source'] != 'dailymotion' ) {
            return false;
        }
        
        $source = $this->sources['dailymotion'];
        
        $playlists_select = $this->get_dailymotion_playlists_from_username( $slidedeck['options']['dailymotion_username'], $slidedeck );
        
        include( dirname( __FILE__ ) . '/views/source/_dailymotion.php' );
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
     * Ajax function to get the user's playlists
     * 
     * @return string A <select> element containing the playlists.
     */
    function wp_ajax_update_youtube_playlists() {
        $youtube_username = $_REQUEST['youtube_username'];
        
        echo $this->get_youtube_playlists_from_username( $youtube_username );
        exit;
    }
    
    /**
     * Ajax function to get the user's playlists
     * 
     * @return string A <select> element containing the playlists.
     */
    function wp_ajax_update_vimeo_playlists() {
        $vimeo_username = $_REQUEST['vimeo_username'];
        
        echo $this->get_vimeo_playlists_from_username( $vimeo_username );
        exit;
    }
    
    /**
     * Ajax function to get the user's playlists
     * 
     * @return string A <select> element containing the playlists.
     */
    function wp_ajax_update_dailymotion_playlists() {
        $dailymotion_username = $_REQUEST['dailymotion_username'];
        
        echo $this->get_dailymotion_playlists_from_username( $dailymotion_username );
        exit;
    }
    
    /**
     * Ajax function to get the video's thumbnail
     * 
     * @return string an image URL.
     */
    function wp_ajax_update_video_thumbnail() {
        $video_url = $_REQUEST['video_url'];
        
        echo $this->get_video_thumbnail( $video_url );
        exit;
    }
    
    function get_video_meta( $service, $video_id ){
        $args = array(
            'sslverify' => false
        );
        
        // Create a cache key
        $cache_key = $service . $video_id . $this->type;
        
        // Attempt to read the cache
        $video_meta = slidedeck2_cache_read( $cache_key );
        
        // if cache doesn't exist
        if( !$video_meta ){
            $video_meta = array();
            switch( $service ){
                case 'youtube':
                    $response = wp_remote_get( 'http://gdata.youtube.com/feeds/api/videos/' . $video_id . '?v=2&alt=json', $args );
                    if( !is_wp_error( $response ) ) {
                        $response_json = json_decode( $response['body'] );
                        $video_meta['title'] = $response_json->entry->title->{'$t'};
                        $video_meta['permalink'] = 'http://www.youtube.com/watch?v=' . $video_id;
                        $video_meta['description'] = $response_json->entry->{'media$group'}->{'media$description'}->{'$t'};
                        $video_meta['thumbnail'] = 'http://img.youtube.com/vi/' . $video_id . '/2.jpg';
                        $video_meta['full_image'] = 'http://img.youtube.com/vi/' . $video_id . '/0.jpg';
                    }
                break;
                case 'vimeo':
                    $response = wp_remote_get( 'http://vimeo.com/api/v2/video/' . $video_id . '.json', $args );
                    if( !is_wp_error( $response ) ) {
                        $response_json = json_decode( $response['body'] );
                        $video = reset( $response_json );
                        $video_meta['title'] = $video->title;
                        $video_meta['permalink'] = 'http://vimeo.com/' . $video_id;
                        $video_meta['description'] =  $video->description;
                        $video_meta['thumbnail'] = $video->thumbnail_medium;
                        $video_meta['full_image'] = $video->thumbnail_large;
                    }
                break;
                case 'dailymotion':
                    $response = wp_remote_get( 'https://api.dailymotion.com/video/' . $video_id . '?fields=id,title,description,views_total,taken_time,thumbnail_medium_url,thumbnail_large_url', $args );
                    if( !is_wp_error( $response ) ) {
                        $response_json = json_decode( $response['body'] );
                        $video_meta['title'] = $response_json->title;
                        $video_meta['permalink'] = 'http://www.dailymotion.com/video/' . $video_id;
                        $video_meta['description'] = $response_json->description;
                        $video_meta['thumbnail'] = $response_json->thumbnail_medium_url;
                        $video_meta['full_image'] = $response_json->thumbnail_large_url;
                    }
                break;
            }
            // Write the cache
            slidedeck2_cache_write( $cache_key, $video_meta, $this->default_options['feedCacheDuration'] );
        }
        return $video_meta;
    }
    
    /**
     * Get Video ID From URL
     * 
     * @param string $url of a (standard) video from YouTube, Dailymotion or Vimeo
     * 
     * @return string The ID of the video for the service detected.
     */
    function get_video_id_from_url( $url ){
        preg_match( '/((youtube\.com|youtu.be|vimeo\.com|dailymotion\.com))/i', $url, $matches );
        $domain = $matches[1];

        switch( $domain ){
            case 'youtube.com':
                if( preg_match( '/^[^v]+v.(.{11}).*/i', $url, $youtube_matches)){
                    return $youtube_matches[1];
                }elseif( preg_match( '/youtube.com\/user\/(.*)\/(.*)$/i', $url, $youtube_matches)){
                    return $youtube_matches[2];
                }elseif( preg_match( '/youtu.be\/(.*)$/i', $url, $youtube_matches)){
                    return $youtube_matches[1];
                }
            break;
            case 'youtu.be':
                if( preg_match( '/youtu.be\/(.*)$/i', $url, $youtube_matches)){
                    return $youtube_matches[1];
                }
            break;
            case 'vimeo.com':
                preg_match( '/(clip\:)?(\d+).*$/i', $url, $vimeo_matches );
                return $vimeo_matches[2];
            break;
            case 'dailymotion.com':
                preg_match( '/(.+)\/([0-9a-zA-Z]+)\_?(.*?)/i', $url, $dailymotion_matches );
                return $dailymotion_matches[2];
            break;
        }
    }
	
	function get_video_thumbnail( $video_url ){
		$video_id = $this->get_video_id_from_url( $video_url );
		$video_provider = $this->get_video_provider_slug_from_url( $video_url );
		
        switch( $video_provider ){
            case 'youtube':
				return 'http://img.youtube.com/vi/' . $video_id . '/1.jpg';
            break;
            case 'dailymotion':
				return 'http://www.dailymotion.com/thumbnail/160x120/video/' . $video_id;
            break;
            case 'vimeo':
		        // Create a cache key
		        $cache_key = 'video-' . $video_provider . $video_id . 'vimeo-thumbs';
		        
		        // Attempt to read the cache
		        $thumbnail_url = slidedeck2_cache_read( $cache_key );
		        
		        // if cache doesn't exist
		        if( !$thumbnail_url ){
	                $response = wp_remote_get( 'http://vimeo.com/api/v2/video/' . $video_id . '.json' );
	                if( !is_wp_error( $response ) ) {
	                    $response_json = json_decode( $response['body'] );
	                    $video = reset( $response_json );
						$thumbnail_url = $video->thumbnail_small;
						
			            // Write the cache
			            slidedeck2_cache_write( $cache_key, $thumbnail_url, $this->default_options['feedCacheDuration'] );
	                }
		        }
				return $thumbnail_url;
            break;
        }
		return SLIDEDECK2_URLPATH . '/images/icon-invalid.png';
	}
	
    /**
     * Get Video Provider Slug From URl
     * 
     * @param string $url of a (standard) video from YouTube, Dailymotion or Vimeo
     * 
     * @return string The slug of the video service.
     */
    function get_video_provider_slug_from_url( $url ){
        // Return a youtube reference for a youtu.be URL
        if( preg_match( '/(youtu\.be)/i', $url ) ){
            return 'youtube';
        }
        
        // Detect the dotcoms normally.
        preg_match( '/((youtube|vimeo|dailymotion)\.com)/i', $url, $matches );
        $domain = $matches[2];
        
        return $domain;
    }
    
    function get_youtube_playlists_from_username( $user_id = false, $slidedeck = null ){
        $playlists = false;
        
        $args = array(
            'sslverify' => false
        );
        
        $feed_url = "https://gdata.youtube.com/feeds/api/users/{$user_id}/playlists?alt=json&orderby=updated";
        
        if( isset( $user_id ) && !empty( $user_id ) ){
            // Create a cache key
            $cache_key = $slidedeck['id'] . $feed_url;
            
            // Attempt to read the cache (no cache)
            $playlists = false;
            
            // If cache doesn't exist
            if( !$playlists ){
                $playlists = array();
                
                $response = wp_remote_get( $feed_url, $args );
                if( !is_wp_error( $response ) ) {
                    $response_json = json_decode( $response['body'] );
                    
                    /**
                     * If this is empty, the user probably has no playlists
                     */
                    if( isset( $response_json->feed->entry ) && !empty( $response_json->feed->entry )){
                        foreach( (array) $response_json->feed->entry as $key => $entry ){
                            $first_feed_link = reset( $entry->{'gd$feedLink'} );
                            
                            $playlists[ ] = array(
                                'href' => $first_feed_link->href,
                                'title' => $entry->title->{'$t'},
                                'created' => $entry->published->{'$t'},
                                'updated' => $entry->updated->{'$t'}
                            );
                        }
                    }
                }else{
                    return false;
                }
            }
        }

        // YouTube User playlists Call
        $playlists_select = array( 
            'recent' => __( 'Recent Uploads', $this->namespace )
        );
        
        if( $playlists ){
            foreach( $playlists as $playlist ){
                $playlists_select[ $playlist['href'] ] = $playlist['title'];
            }
        }
        
        $html_input = array(
            'type' => 'select',
            'label' => "YouTube Playlist",
            'attr' => array( 'class' => 'fancy' ),
            'values' => $playlists_select
        );

        return slidedeck2_html_input( 'options[youtube_playlist]', $slidedeck['options']['youtube_playlist'], $html_input, false ); 
    }

    function get_vimeo_playlists_from_username( $user_id = false, $slidedeck = null ){
        $playlists = false;
        
        $args = array(
            'sslverify' => false
        );

        
        $feed_url = "http://vimeo.com/api/v2/{$user_id}/albums.json";
        
        if( isset( $user_id ) && !empty( $user_id ) ){
            // Attempt to read the cache (no cache here)
            $playlists = false;
            
            // If cache doesn't exist
            if( !$playlists ){
                $playlists = array();
                
                $response = wp_remote_get( $feed_url, $args );
                if( !is_wp_error( $response ) ) {
                    $response_json = json_decode( $response['body'] );
                    
                    if( !empty( $response_json ) ){
                        foreach( $response_json as $key => $entry ){
                            $playlists[ ] = array(
                                'href' => "http://vimeo.com/api/v2/album/{$entry->id}/videos.json",
                                'title' => $entry->title,
                                'created' => $entry->created_on,
                                'updated' => $entry->last_modified
                            );
                        }
                    }
                }else{
                    return false;
                }
            }
        }

        // Vimeo User playlists Call
        $playlists_select = array( 
            'recent' => __( 'Recent Uploads', $this->namespace )
        );

        if( $playlists ){
            foreach( $playlists as $playlist ){
                $playlists_select[ $playlist['href'] ] = $playlist['title'];
            }
        }
        
        $html_input = array(
            'type' => 'select',
            'label' => "Vimeo Album",
            'attr' => array( 'class' => 'fancy' ),
            'values' => $playlists_select
        );
        
        return slidedeck2_html_input( 'options[vimeo_album]', $slidedeck['options']['vimeo_album'], $html_input, false ); 
    }


    function get_dailymotion_playlists_from_username( $user_id = false, $slidedeck = null ){
        $playlists = false;
        
        $args = array(
            'sslverify' => false
        );

        // Get the last 100 playlists (max)
        $feed_url = "https://api.dailymotion.com/user/{$user_id}/playlists?limit=100&fields=id,name,created_time";
        
        if( isset( $user_id ) && !empty( $user_id ) ){
            // Attempt to read the cache (no cache here)
            $playlists = false;
            
            // If cache doesn't exist
            if( !$playlists ){
                $playlists = array();
                
                $response = wp_remote_get( $feed_url, $args );
                if( !is_wp_error( $response ) ) {
                    $response_json = json_decode( $response['body'] );
                    
                    if( !empty( $response_json ) ){
                        foreach( $response_json->list as $key => $entry ){
                            $playlists[ ] = array(
                                'href' => "https://api.dailymotion.com/playlist/{$entry->id}/videos",
                                'title' => $entry->name,
                                'created' => $entry->created_time,
                                'updated' => $entry->created_time
                            );
                        }
                    }
                }else{
                    return false;
                }
            }
        }

        // Dailymotion User playlists Call
        $playlists_select = array( 
            'recent' => __( 'Recent Uploads', $this->namespace )
        );
        
        if( $playlists ){
            foreach( $playlists as $playlist ){
                $playlists_select[ $playlist['href'] ] = $playlist['title'];
            }
        }
        
        $html_input = array(
            'type' => 'select',
            'label' => "Playlist", 
            'attr' => array( 'class' => 'fancy' ), 
            'values' => $playlists_select
        );
        
        return slidedeck2_html_input( 'options[dailymotion_playlist]', $slidedeck['options']['dailymotion_playlist'], $html_input, false ); 
    }
	
	/**
	 * Get HTML for a list of videos
	 * 
	 * @param array The Array of Video URLs
	 */
	function get_video_list_html( $urls ){
		$html = '';
		
		if( !empty( $urls ) ){
			foreach( (array) $urls as $url ){
				$html .= '<li>';
				$html .= '<div class="handle"></div>';
				$html .= '<div class="thumbnail" style="background-image: url(' . $this->get_video_thumbnail( $url ) . ');"></div>';
				$html .= '<span>';
				$html .= $url;
				$html .= '</span>';
				$html .= '<input type="hidden" name="video_entry[]" value="' . $url . '" />';
            	$html .= '<a href="#delete" class="delete">X</a>';
				$html .= '</li>';
			}
		}
		
		return $html;
	}

    /**
     * Load all slides associated with this SlideDeck
     * 
     * @param integer $slidedeck_id The ID of the SlideDeck being loaded
     * 
     * @uses WP_Query
     * @uses get_the_title()
     * @uses maybe_unserialize()
     */
    function get_slides( $slidedeck ) {
        $args = array(
            'sslverify' => false
        );
        $slidedeck_id = $slidedeck['id'];
        
        switch( $slidedeck['source'] ){
            
            
            /**
             * List of Video URLs from YouTube, Dailymotion, Vimeo
             */
            case 'listofvideos':
                $slidedeck_list_of_videos = get_post_meta( $slidedeck_id, "{$this->namespace}_list_of_videos", true );
				
				if( empty( $slidedeck_list_of_videos ) )
					$slidedeck_list_of_videos = $slidedeck['options']['slidedeck_list_of_videos'];

                $cleaned_urls = trim( preg_replace( '/[\n\r]+/', "\n", $slidedeck_list_of_videos ) );
                $urls = explode( "\n", $cleaned_urls );
                $videos = array();
                
                foreach( $urls as $key => $url ){
                    // Add the ID.
                    $videos[ $key ]['id'] = $this->get_video_id_from_url( $url );
                    // Add the provider.
                    $videos[ $key ]['service'] = $this->get_video_provider_slug_from_url( $url );
                    if( !empty( $videos[ $key ]['service'] ) && isset( $videos[ $key ]['service'] ) ){
                         // Get the meta.
                        $videos[ $key ]['meta'] = $this->get_video_meta( $videos[ $key ]['service'], $videos[ $key ]['id'] );
                    }
               }
            break; // List
            
            
            /**
             * YouTube API User's recent videos and playlists
             */
            case 'youtube':
                if( isset( $slidedeck['options']['youtube_playlist'] ) && !empty( $slidedeck['options']['youtube_playlist'] ) ){
                    switch( $slidedeck['options']['search_or_user'] ){
                        case 'user':
                            switch( $slidedeck['options']['youtube_playlist'] ){
                                case 'recent':
                                    // Feed of the user's recent Videos
                                    $feed_url = 'https://gdata.youtube.com/feeds/api/users/' . $slidedeck['options']['youtube_username'] . '/uploads?alt=json&max-results=' . $slidedeck['options']['total_slides'];
                                break;
                                default:
                                    // Feed of the Playlist's Videos
                                    $feed_url = $slidedeck['options']['youtube_playlist'] . '?alt=json&max-results=' . $slidedeck['options']['total_slides'];
                                break;
                            }
                        break;
                        case 'search':
                            $feed_url = 'https://gdata.youtube.com/feeds/api/videos?alt=json&max-results=' . $slidedeck['options']['total_slides'] . '&q=' . urlencode( $slidedeck['options']['youtube_q'] );
                        break;
                    }
                    
                    // Create a cache key
                    $cache_key = $slidedeck_id . $feed_url . $slidedeck['options']['feedCacheDuration'] . $this->type;
                    
                    // Attempt to read the cache
                    $videos = slidedeck2_cache_read( $cache_key );
                    
                    // If cache doesn't exist
                    if( !$videos ){
                        $videos = array();
                        
                        $response = wp_remote_get( $feed_url, $args );
                        if( !is_wp_error( $response ) ) {
                            $response_json = json_decode( $response['body'] );
                            
                            if( !empty( $response_json ) ){
                                foreach( $response_json->feed->entry as $key => $entry ){
                                    /**
                                     * Loop through the links and grab the
                                     * rel link.
                                     */
                                    foreach( $entry->link as $link ){
                                        if( $link->rel == 'alternate' ){
                                            $url = $link->href;
                                        }
                                    }
                                    
                                    // Add the ID.
                                    $videos[ $key ]['id'] = $this->get_video_id_from_url( $url );
                                    // Add the provider.
                                    $videos[ $key ]['service'] = $this->get_video_provider_slug_from_url( $url );
                                    
                                    if( !empty( $videos[ $key ]['service'] ) && isset( $videos[ $key ]['service'] ) ){
                                         // Get the meta.
                                        $videos[ $key ]['meta'] = $this->get_video_meta( $videos[ $key ]['service'], $videos[ $key ]['id'] );
                                    }
                                }
                            }
                        }else{
                            return false;
                        }
                        // Write the cache
                        slidedeck2_cache_write( $cache_key, $videos, $slidedeck['options']['feedCacheDuration'] );
                    }
                }
            break; // YouTube
            
            
            /**
             * Vimeo API User's recent videos and playlists
             */
            case 'vimeo':
                if( isset( $slidedeck['options']['vimeo_album'] ) && !empty( $slidedeck['options']['vimeo_album'] ) ){
                    switch( $slidedeck['options']['vimeo_album'] ){
                        case 'recent':
                            $feed_url = 'http://vimeo.com/api/v2/' . $slidedeck['options']['vimeo_username'] . '/videos.json?page=1';
                        break;
                        default:
                            // Feed of the Playlist's Videos
                            $feed_url = $slidedeck['options']['vimeo_album'];
                        break;
                    }
                    
                    // Create a cache key
                    $cache_key = $slidedeck_id . $feed_url . $slidedeck['options']['feedCacheDuration'] . $slidedeck['options']['total_slides'] . $this->type;
                    
                    // Attempt to read the cache
                    $videos = slidedeck2_cache_read( $cache_key );
                    
                    // If cache doesn't exist
                    if( !$videos ){
                        $videos = array();
                        
                        $response = wp_remote_get( $feed_url, $args );
                        if( !is_wp_error( $response ) ) {
                            $response_json = json_decode( $response['body'] );
                            
                            if( !empty( $response_json ) ){
                                $count = 0;
                                foreach( $response_json as $key => $entry ){
                                    if( $count < $slidedeck['options']['total_slides'] ){
                                        $url = $entry->url;
                                        
                                        // Add the ID.
                                        $videos[ $key ]['id'] = $this->get_video_id_from_url( $url );
                                        // Add the provider.
                                        $videos[ $key ]['service'] = $this->get_video_provider_slug_from_url( $url );
                                        
                                        if( !empty( $videos[ $key ]['service'] ) && isset( $videos[ $key ]['service'] ) ){
                                             // Get the meta.
                                            $videos[ $key ]['meta'] = $this->get_video_meta( $videos[ $key ]['service'], $videos[ $key ]['id'] );
                                        }
                                    }
                                    $count++;
                                }
                            }
                        }else{
                            return false;
                        }
                        // Write the cache
                        slidedeck2_cache_write( $cache_key, $videos, $slidedeck['options']['feedCacheDuration'] );
                    }
                }
            break; // Vimeo
            
            
            /**
             * Dailymotion API User's recent videos and playlists
			 * This has been somewhat unreliable.
             */
            case 'dailymotion':
                if( isset( $slidedeck['options']['dailymotion_playlist'] ) && !empty( $slidedeck['options']['dailymotion_playlist'] ) ){
                    switch( $slidedeck['options']['dailymotion_playlist'] ){
                        case 'recent':
                            $feed_url = 'https://api.dailymotion.com/user/' . $slidedeck['options']['dailymotion_username'] . '/videos?limit=' . $slidedeck['options']['total_slides'];
                        break;
                        default:
                            // Feed of the Playlist's Videos
                            $feed_url = $slidedeck['options']['dailymotion_playlist'] . '?limit=' . $slidedeck['options']['total_slides'];
                        break;
                    }
                    
                    // Create a cache key
                    $cache_key = $slidedeck_id . $feed_url . $slidedeck['options']['feedCacheDuration'] . $slidedeck['options']['total_slides'] . $this->type;
                    
                    // Attempt to read the cache
                    $videos = slidedeck2_cache_read( $cache_key );
                    
                    // If cache doesn't exist
                    if( !$videos ){
                        $videos = array();
                        
                        $response = wp_remote_get( $feed_url, $args );
                        if( !is_wp_error( $response ) ) {
                            $response_json = json_decode( $response['body'] );
                            
                            if( !empty( $response_json ) ){
                                
                                foreach( $response_json->list as $key => $entry ){
                                    $url = 'http://www.dailymotion.com/video/' . $entry->id;
                                    
                                    // Add the ID.
                                    $videos[ $key ]['id'] = $this->get_video_id_from_url( $url );
                                    // Add the provider.
                                    $videos[ $key ]['service'] = $this->get_video_provider_slug_from_url( $url );
                                    
                                    if( !empty( $videos[ $key ]['service'] ) && isset( $videos[ $key ]['service'] ) ){
                                         // Get the meta.
                                        $videos[ $key ]['meta'] = $this->get_video_meta( $videos[ $key ]['service'], $videos[ $key ]['id'] );
                                    }
                                }
                            }
                        }else{
                            return false;
                        }
                        // Write the cache
                        slidedeck2_cache_write( $cache_key, $videos, $this->default_options['feedCacheDuration'] );
                    }
                }
            break; // Dailymotion
        }
        
        
        return $videos;
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
        
        for( $i = 0; $i < $this->default_slide_count; $i++ ) {
            $slide_id = wp_insert_post( array(
                'post_content' => "",
                'post_title' => "Slide " . ( $i + 1 ),
                'post_status' => "publish",
                'comment_status' => "closed",
                'ping_status' => "closed",
                'post_parent' => $slidedeck_id,
                'menu_order' => $i,
                'post_type' => SLIDEDECK2_SLIDE_POST_TYPE,
                'supress_filters' => 1
            ) );
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
        
        delete_post_meta( $slidedeck_id, "slidedeck_list_of_videos" );
    }
    
    /**
     * SlideDeck After Save hook-in
     * 
     * Saves additional data for this Deck type when saving a SlideDeck
     * 
     * @param integer $id The id of the deck.
     * @param array $data The data submitted containing information about the SlideDeck to the save method
     * @param string $type The type of SlideDeck being saved
     * 
     * @uses SlideDeck::get()
     * @uses get_post_meta()
     * @uses update_post_meta()
     */
    function slidedeck_after_save( $id, $data, $type ) {
        // Only create slides if the SlideDeck belongs to this Deck type
        if( $data['type'] != $this->type ) {
            return false;
        }
        
        $videos = array();
        // Update SlideDeck in the database
        if( isset( $data['video_entry'] ) )
            $videos = (array) $data['video_entry'];
        
        update_post_meta( $id, "{$this->namespace}_list_of_videos", implode( "\n", $videos ) );
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
     * Prints the footer scripts necessary for all the video services APIs
     */
    function slidedeck_footer_scripts( $html, $slidedeck ){
        if( $slidedeck['type'] == 'video' ){
            wp_enqueue_script( 'froogaloop' );
            if( is_ssl() ){
                wp_enqueue_script( 'youtube-api' );
                wp_enqueue_script( 'dailymotion-api' );
            }else{
                wp_enqueue_script( 'youtube-api' );
                wp_enqueue_script( 'dailymotion-api' );
            }
        }
        return $html;
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
            
            if( $source == 'listofvideos' ) {
                $options_model['Setup']['total_slides'] = array(
                    'type' => 'hidden',
                    'name' => 'total_slides',
                    'value' => 999
                );
            }
            
            $options_model['Content']['date-format']['type'] = "hidden";
            $options_model['Content']['date-format']['value'] = "none";
        }
        
        return $options_model;
    }
    
    /**
     * Prints some "footer scripts" for the iFrame Preview/Embed
     */
    function slidedeck_print_footer_scripts(){
        global $SlideDeckPlugin;
        
        // If the request is coming from wp-admin
        if( preg_match( '#/wp-admin/admin-ajax.php#i', $_SERVER['REQUEST_URI'] ) ){
            echo "\n" . '<script src="' . SLIDEDECK2_URLPATH . '/decks/' . $this->type . '/javascripts/froogaloop.min.js?v=' . SLIDEDECK2_VERSION . '" type="text/javascript"></script>' . "\n";
            if( is_ssl() ){
                echo "\n" . '<script src="https://www.youtube.com/player_api?v=' . SLIDEDECK2_VERSION . '" type="text/javascript"></script>' . "\n";
                echo "\n" . '<script src="https://api.dmcdn.net/all.js?v=' . SLIDEDECK2_VERSION . '" type="text/javascript"></script>' . "\n";
            }else{
                echo "\n" . '<script src="http://www.youtube.com/player_api?v=' . SLIDEDECK2_VERSION . '" type="text/javascript"></script>' . "\n";
                echo "\n" . '<script src="http://api.dmcdn.net/all.js?v=' . SLIDEDECK2_VERSION . '" type="text/javascript"></script>' . "\n";
            }
        }
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
        
        // Adding footer scripts for the preview.
        add_action( "slidedeck_print_footer_scripts", array( &$this, 'slidedeck_print_footer_scripts' ), 9 );
        
        // Slides associated with this SlideDeck
        $slides_nodes = $this->get_slides( $slidedeck );
        
        $slide_counter = 1;
        foreach( (array) $slides_nodes as $slide_nodes ) {
            $slide = array(
                'title' => $slide_nodes['meta']['title'],
                'styles' => "",
                'classes' => array(),
                'content' => "",
                'thumbnail' => (string) $slide_nodes['meta']['thumbnail']
            );
            
            // In-line styles to apply to the slide DD element
            $slide_styles = array();
            $slide_nodes['slide_counter'] = $slide_counter;
            $slide_nodes['deck_iteration'] = $deck_iteration;
            
            $slide['title'] = $slide_nodes['title'] = slidedeck2_stip_tags_and_truncate_text( $slide_nodes['meta']['title'], $slidedeck['options']['titleLength'] );
            $slide_nodes['permalink'] = $slide_nodes['meta']['permalink'];
            $slide_nodes['excerpt'] = slidedeck2_stip_tags_and_truncate_text( $slide_nodes['meta']['description'], $slidedeck['options']['descriptionLength'] );
            $slide_nodes['image'] = $slide_nodes['meta']['full_image'];
            
            // Build an in-line style tag if needed
            if( !empty( $slide_styles ) ) {
                foreach( $slide_styles as $property => $value ) {
                    $slide['styles'] .= "{$property}:{$value};";
                }
            }
            
			if( !empty( $slide['title'] ) ) {
				$slide['classes'][] = "has-title";
			} else {
				$slide['classes'][] = "no-title";
			}
			
			if( !empty( $slide_nodes['meta']['description'] ) ) {
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
        
        return $slides;
    }
}