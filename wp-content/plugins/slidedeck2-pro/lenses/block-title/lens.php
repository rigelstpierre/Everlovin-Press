<?php
class SlideDeckLens_BlockTitle extends SlideDeckLens_Scaffold {
    var $options_model = array(
        'Appearance' => array(
            'accentColor' => array(
                'value' => "#ffffff"
            ),
            'titleFont' => array(
                'value' => "oswald"
            )
        ),
        'Content' => array(
            'verticalTitleLength' => array(
                'type' => 'hidden',
                'data' => "integer",
                'value' => 25,
                'label' => "Vertical Title Length",
                'description' => "Measured in characters"
            ),
            'linkAuthorName' => array(
				'type' => 'hidden',
                'data' => "boolean",
                'value' => false
			)
        ),
        'Interface' => array(
        	'show-author' => array(
				'type' => 'hidden',
				'data' => 'boolean',
				'value' => true
			),
			'show-author-avatar' => array(
				'type' => 'hidden',
				'data' => 'boolean',
				'value' => false
			)
		)
    );
	
	/**
     * Modify Slide title to wrap in spans for stlying
     * 
     * @param array $nodes $nodes Various information nodes available to use in the template file
     * 
     * @return array
     */
	function slidedeck_slide_nodes( $nodes, $slidedeck ){
		if( $this->is_valid( $slidedeck['lens'] ) ) {
			$temp_title = $nodes['title'];
			$title_parts = explode( " ", $temp_title );
			$new_title = "";
			foreach( $title_parts as $title_part ){
				$new_title .= '<span class="accent-color-background">'. $title_part .'</span> ';
			}
			$nodes['title'] = $new_title;
		}
		
		return $nodes;
	}
    
    /**
     * Options Model Overrides
     * 
     * @param array $options_model The options model array
     * @param array $slidedeck The SlideDeck object
     * 
     * @uses SlideDeckLens_Scaffold::is_valid()
     * 
     * @return array
     */
    function slidedeck_options_model( $options_model, $slidedeck ) {
        if( $this->is_valid( $slidedeck['lens'] ) ) {
            if( $slidedeck['source'] == "twitter" ) {
                $options_model['Appearance']['hyphenate']['value'] = true;
            }
        }
        
        return $options_model;
    }
}
