<?php
class SlideDeckLens_Proto extends SlideDeckLens_Scaffold {
    var $options_model = array(
        'Appearance' => array(
            'titleFont' => array(
                'value' => 'bitter'
            )
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
            )
        )
    );
    
    function __construct(){
        parent::__construct();
        add_filter( "{$this->namespace}_get_slides", array( &$this, "slidedeck_get_slides" ), 11, 2 );
    }
    
    /**
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
                if( $slidedeck['source'] == 'twitter' ){
                    $slide['content'] = preg_replace( '/\<a /', '<a class="accent-color" ', $slide['content'] );
                }
            }
        }
        return $slides;
    }
    
    function slidedeck_options_model( $options_model, $slidedeck ) {
        if( $this->is_valid( $slidedeck['lens'] ) ) {
            if( in_array( $slidedeck['type'], array( 'image', 'video' ) ) ) {
                $options_model['Appearance']['accentColor']['type'] = "hidden";
            }
            
            if( $slidedeck['source'] == "twitter" ) {
                $options_model['Content']['linkTitle']['type'] = "hidden";
                $options_model['Content']['showTitle']['type'] = "hidden";
                $options_model['Content']['showTitle']['value'] = true;
                $options_model['Content']['titleLengthWithImages']['type'] = "hidden";
                $options_model['Content']['titleLengthWithImages']['value'] = 140;
                $options_model['Appearance']['hyphenate']['value'] = true;
            }
        }
        
        return $options_model;
    }
}
