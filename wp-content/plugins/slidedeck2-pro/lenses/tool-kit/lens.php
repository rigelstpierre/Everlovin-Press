<?php
class SlideDeckLens_ToolKit extends SlideDeckLens_Scaffold {
	var $options_model = array(
		'Setup' => array(
			'navigation-position' => array(
				'name' => 'navigation-position',
				'type' => 'select',
				'attr' => array(
					'class' => "fancy"
				),
				'values' => array(
					'nav-pos-top' => 'Top',
					'nav-pos-bottom' => 'Bottom'
				),
				'value' => 'nav-pos-bottom',
				'label' => 'Navigation Position',
				'description' => "Choose where the navigation panel resides"
            )
		),
        'Appearance' => array(
            'accentColor' => array(
                'value' => "#3ea0c1"
            ),
			'frame' => array(
				'name' => 'frame',
				'type' => 'select',
				'value' => 'frame',
				'values' => array(
					'frame' => 'Thick',
					'hairline' => 'Hairline'
				),
				'label' => 'Frame Style',
				'description' => "Choose the thickness of the frame around your SlideDeck",
				'weight' => 40
			),
			'text-position' => array(
				'name' => 'text-position',
				'type' => 'select',
				'values' => array(
					'title-pos-top' => 'Top',
					'title-pos-bottom' => 'Bottom',
					'title-pos-left' => 'Left',
                    'title-pos-right' => 'Right',
                    'title-pos-fill' => 'Fill Slide'
                    				),
				'value' => 'title-pos-top',
				'label' => 'Caption Position',
				'description' => "Choose where to place the caption text on the slide",
				'weight' => 50
			),
			'text-color' => array(
				'name' => 'text-color',
				'type' => 'select',
				'values' => array(
					'title-dark' => 'Dark',
					'title-light' => 'Light'
				),
				'value' => 'title-dark',
				'label' => 'Text Color Variation',
				'weight' => 60
			),
        ),
        'Content' => array(
            'show-excerpt' => array(
                'type' => 'checkbox',
                'data' => 'boolean',
                'label' => "Show Excerpt",
                'value' => true
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
            'date-format' => array(
                'type' => 'select',
                'data' => 'string',
                'label' => "Date Format",
                'value' => "timeago",
                'description' => "Adjust how the date is shown",
                'weight' => 40
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
        'Interface' => array(
			'navigation-type' => array(
				'name' => 'navigation-type',
				'type' => 'select',
				'values' => array(
					'nav-dots' => 'Dots',
					'nav-thumb' => 'Thumbnails',
					'no-nav' => 'Turn Navigation Off'
				),
				'value' => 'nav-dots',
				'label' => 'Navigation Type',
				'description' => "Note: Dots Navigation Type is limited to a max of 10. If you have more than 10 slides, Thumbnails is better for your users.",
				'weight' => 20
			),
			'navigation-style' => array(
				'name' => 'navigation-style',
				'type' => 'select',
				'values' => array(
					'nav-default' => 'Inside slide area',
					'nav-bar' => 'In its own bar',
					'nav-hanging' => 'Hanging outside'
				),
				'value' => 'nav-default',
				'label' => 'Navigation Style',
				'description' => "Change the location of the SlideDeck's navigation elements",
				'weight' => 30
			),
			'arrow-style' => array(
				'name' => 'arrow-style',
				'type' => 'select',
				'values' => array(
					'arrowstyle-1' => 'Default',
					'arrowstyle-2' => 'Pointer Arrow',
					'arrowstyle-3' => 'Hairline Arrow',
					'arrowstyle-4' => 'Short Small Arrow',
					'arrowstyle-5' => 'Circle Hairline Button Arrow',
					'arrowstyle-6' => 'Circle Play Button Arrow',
					'arrowstyle-7' => 'Circle Pointer Button Arrow',
					'arrowstyle-8' => 'Circle Play Arrow',
					'arrowstyle-9' => 'Circle Pointer Arrow'
				),
				'value' => 'arrowstyle-1',
				'label' => 'Arrow Style',
				'description' => "Pick an arrow style that best matches your website's design.",
				'weight' => 40,
				'interface' => array(
				    'type' => 'thumbnails',
				    'values' => array(
				        'arrowstyle-1' => '/lenses/tool-kit/images/arrowstyle_1.thumb.png',
				        'arrowstyle-2' => '/lenses/tool-kit/images/arrowstyle_2.thumb.png',
				        'arrowstyle-3' => '/lenses/tool-kit/images/arrowstyle_3.thumb.png',
				        'arrowstyle-4' => '/lenses/tool-kit/images/arrowstyle_4.thumb.png',
				        'arrowstyle-5' => '/lenses/tool-kit/images/arrowstyle_5.thumb.png',
				        'arrowstyle-6' => '/lenses/tool-kit/images/arrowstyle_6.thumb.png',
				        'arrowstyle-7' => '/lenses/tool-kit/images/arrowstyle_7.thumb.png',
				        'arrowstyle-8' => '/lenses/tool-kit/images/arrowstyle_8.thumb.png',
				        'arrowstyle-9' => '/lenses/tool-kit/images/arrowstyle_9.thumb.png',
                    )
                )
			),
            'nav-arrow-style' => array(
                'name' => 'nav-arrow-style',
				'type' => 'select',
				'values' => array(
					'nav-arrow-style-1' => 'Button',
					'nav-arrow-style-2' => 'Arrow'
				),
				'value' => 'nav-arrow-style-1',
				'label' => 'Thumbnail Arrow Style',
				'weight' => 50,
				'description' => "Pick an arrow style for the Thumbnail Navigation"
			),
		)
    );
    
    function __construct(){
        parent::__construct();
        add_filter( "{$this->namespace}_get_slides", array( &$this, "slidedeck_get_slides" ), 11, 2 );
		
		add_action( "{$this->namespace}_setup_options_bottom", array( &$this, 'slidedeck_setup_options_bottom' ) );
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
    
    function slidedeck_render_slidedeck_before($html, $slidedeck){
		if( $this->is_valid( $slidedeck['lens'] ) ) {
			$html .= '<div class="sd-tool-kit-wrapper">';
		}
		return $html;
	}
	
	function slidedeck_render_slidedeck_after($html, $slidedeck){
		if( $this->is_valid( $slidedeck['lens'] ) ) {
			$html .= '</div>';
		}
		return $html;
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
        if( $this->is_valid( $slidedeck['lens'] ) ) {
        
	        $slidedeck_classes[] = $this->prefix . $slidedeck['options']['navigation-type'];
	        $slidedeck_classes[] = $this->prefix . $slidedeck['options']['frame'];
	        $slidedeck_classes[] = $this->prefix . $slidedeck['options']['navigation-style'];
	        $slidedeck_classes[] = $this->prefix . $slidedeck['options']['navigation-position'];
	        $slidedeck_classes[] = $this->prefix . $slidedeck['options']['text-position'];
	        $slidedeck_classes[] = $this->prefix . $slidedeck['options']['text-color'];
	        $slidedeck_classes[] = $this->prefix . $slidedeck['options']['show-title'];
	        $slidedeck_classes[] = $this->prefix . $slidedeck['options']['nav-arrow-style'];
	        $slidedeck_classes[] = $this->prefix . $slidedeck['options']['arrow-style'];
        }
        
        return $slidedeck_classes;
    }
    
    function slidedeck_dimensions( $width, $height, $outer_width, $outer_height, $slidedeck ) {
    	global $SlideDeckPlugin;
    	if( $this->is_valid( $slidedeck['lens'] ) ) {
    			
    		$og_w = $width;
			$og_h = $height;
			$og_ow = $outer_width;
			$og_oh = $outer_height;
			
			$size = $SlideDeckPlugin->SlideDeck->get_closest_size($slidedeck);
    	
    		if( $slidedeck['options']['frame'] == 'frame' ) {
    			$width = $og_w - 24;
    			$height = $og_h - 24;
                if( $slidedeck['options']['navigation-type'] != 'no-nav' ) {
        			if( $slidedeck['options']['navigation-style'] == 'nav-hanging' ) {
        				if( $slidedeck['options']['navigation-type'] == 'nav-thumb' ) {
    	    				if( $size == 'large' || $size == 'medium' ) {
    							$height = $og_h - 94;
    						}
    	    				if( $size == 'small' ) {
    							$height = $og_h - 70;
    						}
    					}
    					if( $slidedeck['options']['navigation-type'] == 'nav-dots' ) {
    						if( $size == 'large' || $size == 'medium' ) {
    							$height = $og_h - 57;
    						}
    	    				if( $size == 'small' ) {
    							$height = $og_h - 47;
    						}
    	    				if( $slidedeck['options']['navigation-position'] == 'nav-pos-top' ) {
    	    					$height = $og_h - 55;
    	    				}
        				}
        			}
        			if( $slidedeck['options']['navigation-style'] == 'nav-bar' ) {
        				$height = $og_h - 46;
        				if( $size == 'large' ) {
    						$height = $og_h - 66;
    					}
        				if( $slidedeck['options']['navigation-type'] == 'nav-thumb' ) {
        					$height = $og_h - 85;
        					if( $size == 'small' ) {
        						$height = $og_h - 71;
        					}
    	    			}
    	    			if( $slidedeck['options']['navigation-position'] == 'nav-pos-top' ) {
    	    				if( $slidedeck['options']['navigation-type'] == 'nav-dots' ) {
    		    				$height = $og_h - 44;
    		    				if( $size == 'large' ) {
    		    					$height = $og_h - 65;
    		    				}
    	    				}
    	    				if( $slidedeck['options']['navigation-type'] == 'nav-thumb' ) {
    		    				if( $size == 'small' ) {
    		    					$height = $og_h - 68;
    		    				}
    	    				}
    	    			}
        			}
                }
    		}else if( $slidedeck['options']['frame'] == 'hairline' ) {
    			$width = $og_w - 2;
    			$height = $og_h - 2;
                if( $slidedeck['options']['navigation-type'] != 'no-nav' ) {
        			if( $slidedeck['options']['navigation-style'] == 'nav-bar' ) {
        				if($slidedeck['options']['navigation-type'] == 'nav-dots'  ) {
        				    if($slidedeck['options']['navigation-position'] == 'nav-pos-top'  ) {
        	    				if( $size == 'small' || $size == 'medium' ){
        	    					$height = $og_h - 2;
                                }
        	    				if( $size == 'large' ){
        	    					$height = $og_h - 32;
        	    				}
                            }else{
                                $height = $og_h - 34;
                            }
        				}
        				if( $slidedeck['options']['navigation-type'] == 'nav-thumb'  ) {
    	    				if( $size == 'large' ) {
    	    					$height = $og_h - 71;
        					}
    	    				if( $size == 'medium' ) {
    	    					$height = $og_h - 74;
        					}
        					if( $size == 'small' ){
        						$height = $og_h - 60;
        					}
        				}
        			}
    				if( $slidedeck['options']['navigation-style'] == 'nav-hanging' ) {
    					if( $slidedeck['options']['navigation-type'] == 'nav-thumb' ) {
    						if( $size == 'large' || $size == 'medium' ) {
    	    					$height = $og_h - 72;
    						}
    						if( $size == 'small' ){
    							$height = $og_h - 66;
    						}
    					}
    					if( $slidedeck['options']['navigation-type'] == 'nav-dots' ) {
    						if($slidedeck['options']['navigation-position'] == 'nav-pos-top'  ) {
        						if( $size == 'large' || $size == 'medium' ) {
        	    					$height = $og_h - 36;
        						}
        						if( $size == 'small' ){
        							$height = $og_h - 54;
                                    $outer_height = $og_h - 26;
        						}
    						}else{
        						if( $size == 'large' || $size == 'medium' ) {
        	    					$height = $og_h - 36;
        						}
        						if( $size == 'small' ){
        							$height = $og_h - 34;
        						}
    						}    
    					}
    				}
                }
    		}
    	}
    }

    /**
     * Hook into modify the hide-excerpt option - setting it to true and hiding it for video decks
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
            
            /**
             * Remove the navigation that covers the content if
             * the deck type is any of the following:
             */
            $remove_navigation_container = array('video');
            if( in_array( $slidedeck['type'] , $remove_navigation_container ) ){
                // Set "Bar" as the default and remove the inside option.
                $options_model['Interface']['navigation-style'] = array_merge( 
                    $options_model['Interface']['navigation-style'],
                    array(
                        'values' => array(
                            'nav-bar' => 'In its own bar',
                            'nav-hanging' => 'Hanging outside'
                        ),
                        'value' => 'nav-bar'
                    )
                );
                // Set title as the left side, visible
                $options_model['Content']['show-title']['value'] = true;
				
                $options_model['Appearance']['text-position']['value'] = 'title-pos-left';
                
                // Set Thumbnails as the default.
                $options_model['Interface']['navigation-type']['value'] = 'nav-thumb';
            }
            
            /**
             * Set the excerpt and title info to visible if the
             * deck type is any of the following:
             */
            $text_on_by_default = array( 'feeds', 'social' );
            if( in_array( $slidedeck['type'] , $text_on_by_default ) ){
                $options_model['Content']['show-title']['value'] = true;
            }

            /**
             * Set the default options for image decks
             */
            $image_decks = array( 'image' );
            if( in_array( $slidedeck['type'] , $image_decks ) ){
                $options_model['Interface']['navigation-type']['value'] = 'nav-thumb';
                $options_model['Interface']['navigation-style']['value'] = 'nav-hanging';
                
                // Default for Instagram
                if( $slidedeck['source'] == 'instagram' ){
                    $options_model['Setup']['size']['value'] = 'custom';
                    $options_model['Setup']['width']['value'] = 400;
                    $options_model['Setup']['height']['value'] = 459;
                }
                
                // Default for Dribbble
                if( $slidedeck['source'] == 'dribbble' ){
                    $options_model['Setup']['size']['value'] = 'custom';
                    $options_model['Setup']['width']['value'] = 400;
                    $options_model['Setup']['height']['value'] = 359;
                }
                
                if( $slidedeck['source'] != 'medialibrary' ) {
                    $options_model['Content']['excerptLengthWithImages']['type'] = "hidden";
                    $options_model['Content']['show-excerpt']['type'] = "hidden";
                    $options_model['Content']['show-excerpt']['value'] = false;
                }
            }

            /**
             * Turn text position to fill when the source is Twitter
             */
            if( $slidedeck['source'] == 'twitter' ){
                $options_model['Appearance']['text-position']['value'] = 'title-pos-fill';
                $options_model['Appearance']['titleFont']['label'] = "Tweet Font";
                $options_model['Appearance']['bodyFont']['type'] = "hidden";
                $options_model['Appearance']['hyphenate']['value'] = true;
            }
            

        } // End: $this->is_valid( $slidedeck['lens'] )
            
        return $options_model;
    }
	
    /**
     * SlideDeck Default Options hook-in
     * 
     * Hook for slidedeck_default_options filter to add additional options for this deck type.
     * Merges the array of existing options with the new, additional options.
	 * 
     * @param array $options The SlideDeck Options
     * @param string $type The SlideDeck Type
     * @param string $lens The SlideDeck Lens
     * @param string $source The SlideDeck source
	 * 
     * @return array
     */
	function slidedeck_default_options( $options, $type, $lens, $source ) {
		if( $this->is_valid( $lens ) ) {
			
            /**
             * Remove the navigation that covers the content if
             * the deck type is any of the following:
             */
            $remove_navigation_container = array( 'video' );
            if( in_array( $type, $remove_navigation_container ) ){
                // Set "Bar" as the default and remove the inside option.
                $options['navigation-style'] = 'nav-bar';
                
                // Set Thumbnails as the default.
                $options['navigation-type'] = 'nav-thumb';
                
                // Show title by default.
                $options['show-title'] = true;
                
                // Text on the left by default.
                $options['text-position'] = 'title-pos-left';

            }
            
            /**
             * Set the default options for image decks
             */
            $image_decks = array( 'image' );
            if( in_array( $type, $image_decks ) ){
                $options['navigation-type'] = 'nav-thumb';
                $options['navigation-style'] = 'nav-hanging';
                if( $source == 'instagram' ){
                    $options['size'] = 'custom';
                    $options['width'] = 500;
                    $options['height'] = 559;
                }
                if( $source == 'dribbble' ){
                    $options['size'] = 'custom';
                    $options['width'] = 400;
                    $options['height'] = 359;
                }
            }
            
            /**
             * Set the excerpt and title info to visible if the
             * deck type is any of the following:
             */
            $text_on_by_default = array( 'feeds', 'social' );
            if( in_array( $type, $text_on_by_default ) ){
                $options['show-title'] = true;
            }

            /**
             * Turn text position to fill when the source is Twitter
             */
            if( $source == 'twitter' ) {
                $options['text-position'] = 'title-pos-fill';
            }
            
		}
		
		return $options;
	}

	/**
	 * Append options to bottom of the setup list
	 * 
	 * @param array $slidedeck
	 */
	function slidedeck_setup_options_bottom( $slidedeck ) {
		if( $this->is_valid( $slidedeck['lens'] ) ) {
			echo '<li>' . slidedeck2_html_input( "options[navigation-position]", $slidedeck['options']['navigation-position'], $this->options_model['Setup']['navigation-position'], false ) . '</li>';
		}
	}
}
