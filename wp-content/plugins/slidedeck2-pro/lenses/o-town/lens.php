<?php
class SlideDeckLens_OTown extends SlideDeckLens_Scaffold {
    var $options_model = array(
        'Appearance' => array(
            'accentColor' => array(
                'value' => "#ff00ff"
            ),
            'titleFont' => array(
                'value' => "oswald"
            ),
        ),
        'Interface' => array(
			'navigation-type' => array(
				'name' => 'navigation-type',
				'type' => 'select',
				'values' => array(
                    'nav-numbers' => 'Numbers',
                    'nav-dots' => 'Dots'
				),
				'value' => 'nav-dots',
				'label' => 'Navigation Type',
				'description' => "Note: Dots Navigation Type is limited to a max of 10. If you have more than 10 slides, Thumbnails is better for your users.",
				'weight' => 20
			),
            'show-author' => array(
                'type' => 'checkbox',
                'data' => 'boolean',
                'label' => "Show Author",
                'value' => true,
                'description' => "Show or hide the author of the content, when that info is available.",
                'weight' => 50
            ),
            'show-author-avatar' => array(
                'type' => 'checkbox',
                'data' => 'boolean',
                'label' => "Show Author Avatar",
                'value' => true,
                'description' => "Show the author's avatar image when available",
                'weight' => 60
            )
		),
        'Content' => array(
            'linkAuthorName' => array(
				'type' => 'hidden',
                'data' => "boolean",
                'value' => false
			),
			// Show Title here so it can be included in defaults overrides since it is being set only for some sources
			'show-title' => array()
        ),
        'Behavior' => array(
			'autoplay-indicator' => array(
                'name' => 'autoplay-indicator',
                'type' => 'select',
                'values' => array(
                    'autoplay-straight' => 'Straight',
                    'autoplay-snake' => 'Outline',
                    'autoplay-hide' => 'None'
                ),
                'value' => 'autoplay-straight',
                'label' => 'AutoPlay Indicator',
                'description' => "Choose the style of the animated timer when AutoPlay and Thumbnails are enabled",
                'weight' => 30
            ),
		)
    );
	
    function __construct(){
        parent::__construct();
        add_filter( "{$this->namespace}_get_slides", array( &$this, "slidedeck_get_slides" ), 11, 2 );
    }
    
    /**
     * Add appropriate classes for this Lens to the SlideDeck frame
     * 
     * @param array $slidedeck_classes Classes to be applied
     * @param array $slidedeck The SlideDeck object being rendered
     * 
     * @uses SlideDeckLens_Scaffold::is_valid()
     * 
     * @return array
     */
    function slidedeck_frame_classes( $slidedeck_classes, $slidedeck ) {
        if( $this->is_valid( $slidedeck['lens'] ) ) {
            $slidedeck_classes[] = $this->prefix . $slidedeck['options']['navigation-type'];
            $slidedeck_classes[] = $this->prefix . $slidedeck['options']['autoplay-indicator'];
        }
        
        return $slidedeck_classes;
    }
    /**
     * Making the SlideDeck process as a vertical deck
     * 
     * @param boolean $process_as_vertical default boolean - false
     * @param array $slidedeck The SlideDeck object being rendered
     * 
     * @uses SlideDeckLens_Scaffold::is_valid()
     * 
     * @return boolean
     */
    function slidedeck_process_as_vertical( $process_as_vertical, $slidedeck ){
        if( $this->is_valid( $slidedeck['lens'] ) ) {
            $process_as_vertical = true;
        }
        return $process_as_vertical;
    }
    
    
    /**
     * Removing the background-image inline style from the slide DD element
     * Background image is being used within the template on an internal element
     * Adding the accent-color class to the <a> tags if Twitter
     *
     * @param array $slides Array of Slides
     * @param array $slidedeck The SlideDeck object being rendered
     * 
     * @uses SlideDeckLens_Scaffold::is_valid()
     * 
     * @return array
     */
    function slidedeck_get_slides( $slides, $slidedeck ){
        if( $this->is_valid( $slidedeck['lens'] ) ){
            
            foreach( $slides as &$slide ){
                $slide['styles'] = preg_replace("#background-image:\s?url\([^\)]+\);\s?#", '', $slide['styles']);
                if( $slidedeck['source'] == 'twitter' ){
                    $slide['content'] = preg_replace( '/\<a /', '<a class="accent-color" ', $slide['content'] );
                }
            }
        }
        return $slides;
    }
    
    /**
     * Hook into modify the hide-excerpt option - setting it to true and hiding it for twitter decks
     * 
     * @param array $options_model Options Model array
     * @param arrat $slidedeck The SlideDeck object
     * 
     * @uses SlideDeckLens_Scaffold::is_valid()
     * 
     * @return array
     */
    function slidedeck_options_model( $options_model, $slidedeck ){
        if( $this->is_valid( $slidedeck['lens'] ) ) {
                
            $thumbnail_navigation = array( 'image', 'video' );

            if( in_array( $slidedeck['type'] , $thumbnail_navigation ) ){
                $options_model['Interface']['navigation-type']['values'] = array_merge(
                    $options_model['Interface']['navigation-type']['values'],
                    array(
                        'values' => array(
                            'nav-thumb' => "Thumbnails"
                        )
                    )
                );
                $options_model['Interface']['navigation-type']['type'] = 'hidden';
                $options_model['Interface']['navigation-type']['value'] = 'nav-thumb';
                
                $options_model['Behavior']['autoplay-indicator']['value'] = 'autoplay-snake';
                
                $options_model['Content']['show-title'] = array(
	                'type' => 'checkbox',
	                'data' => 'boolean',
	                'label' => "Show Title",
	                'value' => true,
	                'weight' => 3
                );
                
                $options_model['Playback']['slideTransition']['type'] = 'hidden';
                $options_model['Playback']['slideTransition']['value'] = 'slide';
                
                $options_model['Content']['date-format']['type'] = 'hidden';
                $options_model['Content']['date-format']['value'] = 'none';
                
                $options_model['Content']['show-excerpt']['type'] = 'hidden';
                $options_model['Content']['show-excerpt']['value'] = true;
                
                $options_model['Content']['excerptLengthWithImages']['type'] = 'hidden';
            }

            if( $slidedeck['source'] == "twitter" ) {
                $options_model['Appearance']['hyphenate']['value'] = true;
            }
        }
            
        return $options_model;
    }
}
