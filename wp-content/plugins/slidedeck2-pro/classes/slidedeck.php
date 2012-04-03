<?php
/**
 * SlideDeck Model
 * 
 * Model for handling CRUD and other basic functionality for SlideDeck management. Acts
 * as the parent class for all Deck types.
 * 
 * @author dtelepathy
 * @package SlideDeck
 */
class SlideDeck {
    var $namespace = "slidedeck";
    
    // The current type of SlideDeck being displayed (if any)
    var $current_type;
    
    // The current source of SlideDeck being displayed (if any)
    var $current_source;
    
    // Class prefix
    var $prefix = "sd2-";
    
    // SlideDeck options used by the JavaScript library for output as a JSON formatted object
    var $javascript_options = array(
        'speed' => 'integer',
        'start' => 'integer',
        'autoPlay' => 'boolean',
        'autoPlayInterval' => 'integer',
        'cycle' => 'boolean',
        'keys' => 'boolean',
        'scroll' => 'boolean',
        'continueScrolling' => 'boolean',
        'activeCorner' => 'boolean',
        'hideSpines' => 'boolean',
        'transition' => 'string',
        'slideTransition' => 'string',
        'touch' => 'boolean',
        'touchThreshold' => 'integer'
    );
    
    // Default SlideDeck options
    var $options_model = array(
        'Setup' => array(
            'total_slides' => array(
                'type' => 'text',
                'data' => "integer",
                'attr' => array(
                    'size' => 3,
                    'maxlength' => 2
                ),
                'value' => 5,
                'label' => "Number of Slides",
                'description' => "Set how many slides you want in your SlideDeck. Most Content Sources supply up to 10 at a time.",
                'interface' => array(
                    'type' => "slider",
                    'min' => 3,
                    'max' => 25,
                    'update' => array(
                        'option' => 'start',
                        'value' => 'max'
                    )
                )
            ),
            'size' => array(
                'type' => 'radio',
                'data' => "string",
                'values' => array(
                    'small',
                    'medium',
                    'large',
                    'custom'
                ),
                'value' => 'medium',
                'label' => "Size",
                'description' => "Set the dimensions of your SlideDeck. Choose from the predefined sizes or enter a custom size."
            ),
            'width' => array(
                'type' => 'text',
                'data' => "integer",
                'attr' => array(
                    'size' => 5,
                    'maxlength' => 4
                ),
                'value' => 500,
                'label' => "Width"
            ),
            'height' => array(
                'type' => 'text',
                'data' => "integer",
                'attr' => array(
                    'size' => 5,
                    'maxlength' => 4
                ),
                'value' => 500,
                'label' => "Height"
            ),
            'overlays' => array(
                'type' => 'select',
                'data' => "string",
                'value' => "hover",
                'label' => "Show Overlay",
                'values' => array(
                    'always' => "Always",
                    'hover' => "On Hover",
                    'never' => "Never"
                ),
                'description' => "Overlays allow your users to interact with your content from within the SlideDeck, depending on the Content Source."
            ),
            'show-front-cover' => array(
                'name' => 'show-front-cover',
                'type' => 'hidden',
                'data' => 'boolean',
                'value' => false,
                'label' => "Show Front Cover"
            ),
            'show-back-cover' => array(
                'name' => 'show-back-cover',
                'type' => 'hidden',
                'data' => 'boolean',
                'value' => false,
                'label' => "Show Back Cover"
            )
        ),
        'Appearance' => array(
            'accentColor' => array(
                'type' => "text",
                'data' => "string",
                'attr' => array(
                    'class' => "color-picker",
                    'size' => 7
                ),
                'value' => "#3ea0c1",
                'label' => "Accent Color",
                'description' => "Pick a color for the accent elements of your Lens, including links, buttons and titles.",
                'weight' => 1
            ),
            'titleFont' => array(
                'type' => "select",
                'data' => "string",
                'value' => "sans-serif",
                'values' => array(),
                'label' => "Title Font",
                'weight' => 10
            ),
            'bodyFont' => array(
                'type' => "select",
                'data' => "string",
                'value' => "sans-serif",
                'values' => array(),
                'label' => "Body Font",
                'weight' => 20
            ),
            'hyphenate' => array(
                'type' => "checkbox",
                'data' => "boolean",
                'value' => false,
                'label' => "Hyphenate Content",
                'description' => "Automatically hyphenate (on some browsers) and break title and excerpt if needed."
            ),
            'activeCorner' => array(
                'type' => 'hidden',
                'data' => "boolean",
                'value' => false,
                'label' => "Display Active Slide Indicator",
                'description' => "Visual indicator attached to the slide title bar of the current slide"
            ),
            'hideSpines' => array(
                'type' => 'hidden',
                'data' => "boolean",
                'value' => true,
                'label' => "Hide Slide Title Bars",
                'description' => "Not all lenses work well with slide title bars turned on"
            )
        ),
        'Interface' => array(
            'display-nav-arrows' => array(
                'type' => 'select',
                'data' => 'string',
                'label' => "Show Slide Controls",
                'value' => "hover",
                'values' => array(
                    'always' => "Always",
                    'hover' => "On Hover",
                    'never' => "Never"
                ),
                'description' => "Adjust when slide controls are shown to your visitors",
                'weight' => 1
            ),
        ),
        'Content' => array(
            'date-format' => array(
                'type' => 'select',
                'data' => 'string',
                'label' => "Date Format",
                'value' => "timeago",
                'description' => "Adjust how the date is shown",
                'weight' => 40
            )
		),
        'Behavior' => array(
            'keys' => array(
                'type' => 'checkbox',
                'data' => "boolean",
                'value' => true,
                'label' => "Keyboard Navigation",
                'description' => "Allow users to use the left and right arrow keys to navigate the SlideDeck",
                'weight' => 1
            ),
            'scroll' => array(
                'type' => 'checkbox',
                'data' => "boolean",
                'value' => false,
                'label' => "Mouse Wheel Navigation",
                'description' => "Allow users to use the mouse wheel to navigate the SlideDeck",
                'weight' => 2
            ),
            'touch' => array(
                'type' => 'checkbox',
                'data' => "boolean",
                'value' => false,
                'label' => "Touch Navigation",
                'description' => "Allow users to navigate the SlideDeck by swiping left and right on most touchscreen devices",
                'weight' => 3
            ),
            'continueScrolling' => array(
                'type' => 'hidden',
                'data' => "boolean",
                'value' => false,
                'label' => "Continue Scrolling",
                'description' => "Allow scrolling to the next horizontal slide after scrolling to the last vertical slide",
                'weight' => 10
            ),
            'touchThreshold' => array(
            	'type' => 'select',
            	'data' => 'integer',
            	'value' => 100,
            	'values' => array(
            		30 => "Tightest",
            		40 => "Tighter",
            		50 => "Average",
            		60 => "Looser",
            		70 => "Loosest"
				),
				'label' => "Touch Sensitivity",
				'description' => "Adjust how responsive the SlideDeck is to touchscreen gestures",
				'weight' => 20,
				'interface' => array(
				    'type' => 'slider',
				    'min' => 30,
				    'max' => 70,
				    'minLabel' => "Tightest",
				    'maxLabel' => "Loosest",
				    'step' => 10
				)
            )
        ),
        'Playback' => array( 
            'start' => array(
                'type' => 'text',
                'data' => "integer",
                'attr' => array(
                    'size' => 2,
                    'maxlength' => 2
                ),
                'value' => 1,
                'label' => "Starting Slide",
                'description' => "Choose which slide to display first",
                'weight' => 1,
                'interface' => array(
                    'type' => 'slider',
                    'min' => 1
                )
            ),
            'randomize' => array(
                'type' => 'checkbox',
                'data' => "boolean",
                'value' => false,
                'label' => "Randomize Slide Order",
                'weight' => 10
            ),
            'autoPlay' => array(
                'type' => 'checkbox',
                'data' => "boolean",
                'value' => false,
                'label' => "Autoplay SlideDeck",
                'description' => "Set the SlideDeck to begin playing automatically",
                'weight' => 20
            ),
            'autoPlayInterval' => array(
                'type' => 'text',
                'data' => "float",
                'attr' => array(
                    'size' => 2,
                    'maxlength' => 2
                ),
                'value' => 5,
                'label' => "Autoplay Interval",
                'description' => "Interval between each slide progression in seconds when autoplaying",
                'suffix' => "seconds",
                'weight' => 21,
                'interface' => array(
                    'type' => 'slider',
                    'min' => 1,
                    'max' => 10,
                    'minLabel' => "1sec",
                    'maxLabel' => "10secs"
                )
            ),
            'cycle' => array(
                'type' => 'checkbox',
                'data' => "boolean",
                'value' => true,
                'label' => "Loop Playback",
                'description' => "Restart the SlideDeck from the first slide when finished",
                'weight' => 30
            ),
            'slideTransition' => array(
                'type' => 'select',
                'data' => "string",
                'values' => array(
                    'stack' => "Card Stack",
                    'fade' => "Cross-fade",
                    'flipHorizontal' => "Flip Horizontal",
                    'flip' => "Flip Vertical",
                    'slide' => "Slide"
                ),
                'value' => 'slide',
                'label' => "Slide Transition",
                'description' => "Choose an animation for transitioning between slides",
                'weight' => 40
            ),
            'speed' => array(
                'type' => "select",
                'data' => "integer",
                'value' => 750,
                'values' => array(
                	2000 => "Very Slow",
                	1000 => "Slow",
                	750 => "Moderate",
                	500 => "Fast",
                	250 => "Very Fast",
				),
                'label' => "Animation Speed",
                'description' => "Choose how fast the slide transition should animate",
                'weight' => 50,
                'interface' => array(
                    'type' => 'slider',
                    'min' => 250,
                    'max' => 2000,
                    'step' => 250,
                    'marks' => true,
                    'minLabel' => "250ms",
                    'maxLabel' => "2sec"
                )
            ),
            'transition' => array(
                'type' => "select",
                'data' => "string",
                'value' => 'swing',
                'values' => array(
                    'easeOutBounce' => "Bounce",
                    'easeOutElastic' => "Elastic",
                    'linear' => "Linear",
                    'swing' => "Swing",
                    'easeOutSine' => "Light Ease",
                    'easeOutCirc' => "Medium Ease",
                    'easeOutExpo' => "Heavy Ease"
                ),
                'label' => "Animation Easing",
                'description' => "Control the style of the animation",
                'weight' => 60
            ),
        )
    );
    
    // SlideDecks that are being rendered to the page (to prevent duplicate HTML tag IDs)
    var $rendered_slidedecks = array();
    
    function __construct() {
        add_action( 'admin_init', array( &$this, '_admin_init' ) );
        add_action( 'admin_print_scripts-toplevel_page_slidedeck2', array( &$this, '_admin_print_scripts' ), 11 );
        add_action( 'admin_print_styles-toplevel_page_slidedeck2', array( &$this, '_admin_print_styles' ), 11 );
        
        // Creation cleanup routine
        add_action( "{$this->namespace}_cleanup_create", array( &$this, 'cleanup_create' ) );
        
        // Modify the SlideDeck form title according to the type being edited
        add_filter( "{$this->namespace}_form_title", array( &$this, '_slidedeck_form_title' ), 10, 3 );
        
        add_filter( "{$this->namespace}_default_lens", array( &$this, '_slidedeck_default_lens' ), 10, 3 );
        if( method_exists( $this, 'slidedeck_default_lens' ) )
            add_filter( "{$this->namespace}_default_lens", array( &$this, 'slidedeck_default_lens' ), 11, 3 );
        
        // Filter lenses down to those available for the content type being viewed
        add_filter( "{$this->namespace}_get_lenses", array( &$this, '_slidedeck_get_lenses' ), 10, 2 );
        if( method_exists( $this, 'slidedeck_get_lenses' ) )
            add_filter( "{$this->namespace}_get_lenses", array( &$this, 'slidedeck_get_lenses' ), 11, 2 );
        
        // Filter lenses down to those available for the content type being viewed
        if( method_exists( $this, 'slidedeck_get_slides' ) )
            add_filter( "{$this->namespace}_get_slides", array( &$this, 'slidedeck_get_slides' ), 10, 2 );
        
        // Update options_model for default and for sub-classes
        add_filter( "{$this->namespace}_options_model", array( &$this, '_slidedeck_options_model' ), 10, 2 );
        if( method_exists( $this, 'slidedeck_options_model' ) )
            add_filter( "{$this->namespace}_options_model", array( &$this, 'slidedeck_options_model' ), 11, 2 );
            
        // Update the default options for sub-classes
        add_filter( "{$this->namespace}_default_options", array( &$this, '_slidedeck_default_options' ), 10, 4 );
        if( method_exists( $this, 'slidedeck_default_options' ) )
            add_filter( "{$this->namespace}_default_options", array( &$this, 'slidedeck_default_options' ), 11, 4 );
        
        // Frame classes
        add_filter( "{$this->namespace}_frame_classes", array( &$this, '_slidedeck_frame_classes' ), 10, 2 );
        
        if( method_exists( $this, 'add_hooks') )
            $this->add_hooks();
    }

    private function _sort_by_slidedeck_source_asc( $a, $b ) {
        return ( $a['source'] > $b['source'] );
    }
    
    private function _sort_by_slidedeck_source_desc( $a, $b ) {
        return ( $a['source'] < $b['source'] );
    }
    
    private function _type_fix( $val, $type ) {
        switch( $type ) {
            case "boolean":
                $val = (boolean) ( in_array( $val, array( "1", "true" ) ) ? true : false );
            break;
            
            case "float":
                $val = (float) floatval( $val );
            break;
            
            case "integer":
                $val = (integer) intval( $val );
            break;
            
            case "string":
            default:
                $val = (string) $val;
            break;
        }
        
        return $val;
    }
    
    /**
     * WordPress init action hook-in
     * 
     * @uses add_action()
     */
    function _admin_init() {
        global $SlideDeckPlugin;
        
        // Get the type based off the source in the URL
        if( isset( $_REQUEST['source'] ) ) {
            $this->current_type = $SlideDeckPlugin->get_type_by_source( $_REQUEST['source'] );
			$this->current_source = $_REQUEST['source'];
        } 
        // If that isn't present, try and look up the one associated with the SlideDeck
        elseif( isset( $_REQUEST['slidedeck'] ) ) {
            $slidedeck = $this->get( $_REQUEST['slidedeck'] );
            $this->current_type = $slidedeck['type'];
            $this->current_source = $slidedeck['source'];
        }
        
        $this->register_scripts();
        $this->register_styles();
    }
    
    /**
     * WordPress admin_print_scripts hook-in
     * 
     * @uses wp_enqueue_script()
     */
    function _admin_print_scripts() {
        if( isset( $this->type ) )
            if( $this->current_type == $this->type )
                wp_enqueue_script( "slidedeck-deck-{$this->type}-admin" );
    }
    
    /**
     * WordPress admin_print_styles hook-in
     * 
     * @uses wp_enqueue_style()
     */
    function _admin_print_styles() {
        if( isset( $this->type ) )
            if( $this->current_type == $this->type )
                wp_enqueue_style( "slidedeck-deck-{$this->type}-admin" );
    }
    
    /**
     * SlideDeck Default lens hook-in
     * 
     * Hook for slidedeck_default_lens filter to change the default, starting lens
     * 
     * @return string
     */
    function _slidedeck_default_lens( $lens, $type, $source ) {
        // Only process for sub-classes with a type
        if( !isset( $this->type ) )
            return $lens;
        
        // Make sure this is this SlideDeck type
        if( $type == $this->type ) {
            $default_lens = "tool-kit";
            
            if( isset( $this->sources[$source]['default_lens'] ) )
                $default_lens = $this->sources[$source]['default_lens'];
            
            $lens = $default_lens;
        }
        
        return $lens;
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
    function _slidedeck_default_options( $options, $type, $lens, $source ) {
        if( !isset( $this->type ) )
            return $options;
        
        // Make sure this is this SlideDeck type
        if( $type == $this->type ) {
            if( isset( $this->options_model ) ) {
                foreach( $this->options_model as $options_group ) {
                    foreach( $options_group as $name => $option ) {
                        if( isset( $option['value'] ) )
                            $options[$name] = $option['value'];
                    }
                }
            }
        
            if( isset( $this->default_options ) )
                $options = array_merge( $options, $this->default_options );
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
    function _slidedeck_frame_classes( $slidedeck_classes, $slidedeck ) {
        if( !isset( $this->type ) || $slidedeck['type'] == $this->type ) {
        	foreach( $this->options_model as $options_group => $options ) {
        		foreach( $options as $name => $properties ) {
	                if( preg_match( "/^(hide|show)/", $name ) ) {
	                    if( $slidedeck['options'][$name] == true )
	                        $slidedeck_classes[] = $this->prefix . $name;
	                }
        		}
        	}
        }
        
        $slidedeck_classes[] = "date-format-" . $slidedeck['options']['date-format'];
        
        if( $slidedeck['options']['hyphenate'] == true ) {
            $slidedeck_classes[] = $this->prefix . "hyphenate";
        }
        
        return $slidedeck_classes;
    }
    
    /**
     * Hook into slidedeck_form_title filter
     * 
     * Checks if the SlideDeck type being edited matches the sub-class type and updates
     * the form title to reflect the current type being edited.
     * 
     * @param string $form_title The form title
     * @param array $slidedeck The SlideDeck object
     * @param string $form_action The action being performed (create|edit)
     * 
     * @return string
     */
    function _slidedeck_form_title( $form_title, $slidedeck, $form_action ) {
        if( isset( $this->type ) && $this->type == $slidedeck['type'] ) {
            switch( $form_action ) {
                case "create":
                    $form_title = "Create {$this->name} SlideDeck";
                break;
                
                case "edit":
                    $form_title = "Edit {$this->name} SlideDeck";
                break;
            }
        }
        
        return $form_title;
    }
    
    /**
     * SlideDeck Lens lookup filter hook-in
     * 
     * Filters down list of lenses to only those of the particular type SlideDeck type being viewed.
     * If a user requested a specific lens, this just returns the $lenses array un-modified.
     * 
     * @param array $lenses The lenses loaded initially
     * @param string $slug A slug requested by the user (if any was requested)
     * 
     * @global $SlideDeckPlugin
     * 
     * @uses SlideDeckPlugin::is_plugin()
     */
	function _slidedeck_get_lenses( $lenses, $slug ) {
        global $SlideDeckPlugin;
        
        if( !empty( $slug ) || !$SlideDeckPlugin->is_plugin() ) {
            return $lenses;
        }
        
		if( isset( $this->sources ) && in_array( $this->current_source, array_keys( $this->sources ) ) ) {
	        // Array of filtered lenses
	        $filtered = array();
	        
            foreach( $lenses as $slug => &$lens ) {
            	if( in_array( $this->current_source, $lens['meta']['sources'] ) ) {
	                $filtered[$slug] = $lens;
            	}
            }
	        
	        $lenses = $filtered;
		}
        
        return $lenses;
    }
    
    /**
     * slidedeck_options_model hook-in
     * 
     * @param array $options_model The Options Model
     * @param string $slidedeck The SlideDeck object
     * 
     * @return array
     */
    function _slidedeck_options_model( $options_model, $slidedeck ) {
        global $slidedeck_fonts;
        
        foreach( (array) $slidedeck_fonts as $key => $font ) {
            $options_model['Appearance']['titleFont']['values'][$key] = $font['label'];
            $options_model['Appearance']['bodyFont']['values'][$key] = $font['label'];
        }
        
        $options_model['Playback']['start']['interface']['max'] = $slidedeck['options']['total_slides'];
        
        if( isset( $this->type ) && $this->type == $slidedeck['type'] ) {
            if( isset( $this->options_model ) && !empty( $this->options_model ) ) {
                foreach( $this->options_model as $options_group => $options ) {
                    foreach( $options as $option_key => $option_params ) {
                        // Only merge if this is an override of an existing property
                        if( isset( $options_model[$options_group][$option_key] ) )
                            $options_model[$options_group][$option_key] = array_merge( (array) $options_model[$options_group][$option_key], $option_params );
                        // Else declare the new option model
                        else
                            $options_model[$options_group][$option_key] = $option_params;
                    }
                }
            }
        }
        
        $options_model['Content']['date-format']['values'] = array(
            'none' => "Do not show",
            'timeago' => "2 Days Ago",
            'human-readable' => date( "F j, Y" ),
            'human-readable-abbreviated' => date( "M j, Y" ),
            'raw' => date( "m/d/Y" ),
            'raw-eu' => date( "Y/m/d" )
        );

        return $options_model;
    }
    
    /**
     * Clean up after create
     * 
     * Many SlideDeck types create an auto-draft upon click of the creation button. If the
     * user never saves the SlideDeck, it remains an auto-draft.
     * 
     * @param integer $slidedeck_id The ID of the SlideDeck to cleanup
     */
    function cleanup_create( $slidedeck_id ) {
        // Try to find this SlideDeck ID with an auto-draft status
        $slidedeck = $this->get( $slidedeck_id, '', '', 'auto-draft' );
        
        if( !empty( $slidedeck ) ) {
            $this->delete( $slidedeck_id );
        }
    }

    /**
     * Create a new SlideDeck
     * 
     * Create a new entry in the database for a SlideDeck and returns an array of the
     * SlideDeck object.
     * 
     * @param string $type The type of SlideDeck to be created
     * @param string $source The source for the SlideDeck
     * 
     * @uses wp_insert_post()
     * @uses apply_filters
     * @uses update_post_meta()
     * @uses SlideDeck::get()
     * @uses do_action()
     * 
     * @return array
     */ 
    final public function create( $type = "", $source = "" ) {
        // Fail silently if no type was passed and this was not a child class request
        if( empty( $type ) && !isset( $this->type ) ) {
            return false;
        }
        
        // Use the child class' type as the default type
        if( isset( $this->type ) ) {
            $type = $this->type;
        }
        
        // Fail silently if type could not be defined
        if( empty( $type ) ) {
            return false;
        }
        
        $form_action = "create";    // Set the form action ( referenced when saving the SlideDeck and for interface appearance )
        $default_slide_amount = 3;    // Set the default amount of slides to start with
        
        $post_status = apply_filters( "{$this->namespace}_default_create_status", "publish", $type );
        
        // Insert a new SlideDeck in the database
        $slidedeck_id = wp_insert_post( array(
            'post_content' => "",
            'post_title' => "My SlideDeck",
            'post_status' => $post_status,
            'comment_status' => "closed",
            'ping_status' => "closed",
            'post_type' => SLIDEDECK2_POST_TYPE
        ) );
        
        if( $post_status == 'auto-draft' ) {
            wp_schedule_single_event( time() + 30, "{$this->namespace}_cleanup_create", $slidedeck_id );
        }
        
        // Set SlideDeck type
        update_post_meta( $slidedeck_id, "{$this->namespace}_type", $type );
        // Set SlideDeck source
        update_post_meta( $slidedeck_id, "{$this->namespace}_source", $source );
        // Set default SlideDeck lens
        $lens = apply_filters( "{$this->namespace}_default_lens", SLIDEDECK2_DEFAULT_LENS, $type, $source );
        update_post_meta( $slidedeck_id, "{$this->namespace}_lens", $lens );
        
        // Set SlideDeck options
        $options = apply_filters( "{$this->namespace}_default_options", $this->default_options(), $type, $lens, $source );
        update_post_meta( $slidedeck_id, "{$this->namespace}_options", $options );
        
        $slidedeck = $this->get( $slidedeck_id, null, null, apply_filters( "{$this->namespace}_default_create_status", "publish", $type ) );
        
        do_action( "{$this->namespace}_after_create", $slidedeck_id, $slidedeck );
        
        return $slidedeck;
    }

    /**
     * Default options for a SlideDeck
     * 
     * Parses through the option model to create an array of default options in a structure
     * matching that needed for database storage.
     * 
     * @return array
     */
    function default_options() {
        global $SlideDeckPlugin;
        
        $default_options = array();
        
        foreach( array( $SlideDeckPlugin->SlideDeck->options_model, $this->options_model ) as $model ) {
            foreach( $model as $options_group => $options ) {
                foreach( $options as $key => $val ) {
                    // Process as a regular option
                    if( array_key_exists( 'type', $val ) ) {
                        $default_options[$key] = $val['value'];
                    } 
                    // Process as an option containing sub-options
                    else {
                        foreach( $val as $sub_key => $sub_val ) {
                            $default_options[$key][$sub_key] = $sub_val['value'];
                        }
                    }
                }
            }
        }
        
        return $default_options;
    }
    
    /**
     * Delete a SlideDeck
     * 
     * @param integer $id SlideDeck ID
     * 
     * @uses SlideDeck::get()
     * @uses wp_delete_post()
     * @uses do_action()
     */
    final public function delete( $id ) {
        $slidedeck = $this->get( $id );
        $type = $slidedeck['type'];
        
        // Delete the SlideDeck entry
        wp_delete_post( $id, true );
        
        do_action( "{$this->namespace}_after_delete", $id, $type );
    }
    
    /**
     * Convenience method for loading SlideDecks
     * 
     * Returns a SlideDeck object if a single SlideDeck was requested or an array of SlideDecks 
     * if no ID or an array of IDs were passed. If no SlideDecks are found, returns an empty
     * array.
     * 
     * @param int $id ID of the SlideDeck to retrieve
     * @param string $orderby The optional (defaults to "title") column to order by (directly correlates to the orderby option of WP_Query)
     * @param string $order The optional (defaults to "ASC") direction to order (directly correlates to the order option of WP_Query)
     * @param string $post_status The option status of the post
     * 
     * @uses WP_Query
     * @uses get_option()
     * @uses get_post_meta()
     * @uses get_the_title()
     * 
     * @return object
     */
    final public function get( $id = null, $orderby = 'post_title', $order = 'ASC', $post_status = 'any' ) {
        global $wpdb;
        
        $sql = $wpdb->prepare( "SELECT {$wpdb->posts}.* FROM $wpdb->posts WHERE 1=1 AND {$wpdb->posts}.post_type = %s", SLIDEDECK2_POST_TYPE );
        
        if( isset( $id ) ) {
            $sql.= " AND {$wpdb->posts}.ID";
            if( is_array( $id ) ) {
                // Make sure all IDs are numeric
                array_map( 'intval', $id );
                
                $sql.= " IN(" . join( ',', $id ) . ")"; 
            } else {
                $sql = $wpdb->prepare( $sql . " = %d", $id );
            }
        }
        
        if( !empty( $post_status ) ) {
            if( is_array( $post_status ) ) {
                foreach( $post_status AS &$post_stat )
                    $post_stat = "'" . addslashes( $post_stat ) . "'";
                
                $post_status = implode( ",", $post_status );
                
                // sprintf() used to combing SQL and values because wpdb::prepare() quotes %s values
                $sql = $wpdb->prepare( $sql . sprintf( " AND {$wpdb->posts}.post_status IN(%s)", $post_status ) );
            } else {
                // Allow querying without specifying post_status filtering
                if( $post_status != "any" )
                    $sql = $wpdb->prepare( $sql . " AND {$wpdb->posts}.post_status = %s", $post_status );
            }
        }
        
        if( isset( $orderby ) && !empty( $orderby ) && isset( $order ) && !empty( $order ) ) {
            if( $orderby != "slidedeck_source" ) {
                $sql.= " ORDER BY $orderby $order";
            }
        }
        
        $cache_key = md5( __METHOD__ . $sql );
        $slidedecks = wp_cache_get( $cache_key );
        
        if( $slidedecks == false ) {
            $query_posts = $wpdb->get_results( $sql );
            
            // Populate the $slidedecks array with SlideDeck entries
            $slidedecks = array();
            foreach( (array) $query_posts as $post ) {
                $post_id = $post->ID;
                
                $slidedeck = array(
                    'id' => $post_id,
                    'author' => $post->post_author,
                    'type' => get_post_meta( $post_id, "{$this->namespace}_type", true ),
                    'source' => get_post_meta( $post_id, "{$this->namespace}_source", true ),
                    'title' => get_the_title( $post_id ),
                    'lens' => get_post_meta( $post_id, "{$this->namespace}_lens", true ),
                    'created_at' => $post->post_date,
                    'updated_at' => $post->post_modified
                );
                $slidedeck['options'] = $this->get_options( $post_id, $slidedeck['type'], $slidedeck['lens'], $slidedeck['source'] );
                
                $slidedecks[] = $slidedeck;
            }
            
            wp_cache_set( $cache_key, $slidedecks );
        }

        if( $orderby == "slidedeck_source" ) {
            usort( $slidedecks, array( &$this, '_sort_by_slidedeck_source_' . strtolower( $order ) ) );
        }
        
        // If this was a request for a single SlideDeck, only return the requested ID
        if( isset( $id ) && !is_array( $id ) ) {
            foreach( (array) $slidedecks as $slidedeck ) {
                if( $slidedeck['id'] == $id ) {
                    return apply_filters( "{$this->namespace}_after_get", $slidedeck, $id, $orderby, $order, $post_status );
                }
            }
        }
        
        return $slidedecks;
    }

    /**
     * Get the closest SlideDeck class for custom dimensions
     * 
     * @uses apply_filters()
     * 
     * @return string
     */
    function get_closest_size( $slidedeck ) {
        global $SlideDeckPlugin;
        
		if( $slidedeck['options']['size'] != "custom" )
			return $slidedeck['options']['size'];
		
        $width = $slidedeck['options']['width'];
        $height = $slidedeck['options']['height'];
        
        $sizes = apply_filters( "slidedeck_sizes", $SlideDeckPlugin->sizes, $slidedeck );
        $previous_width_delta = 99999;
        foreach( $sizes as $size => $properties ) {
            // Ignore the "custom" size since this is what we're trying to accommodate for already
            if( $size == "custom" )
                continue;
            
            // Determine the delta between this "size" and the user specified width
            $width_delta = abs( $properties['width'] - $width );
            // The closest delta gets the size class
            if( $width_delta < $previous_width_delta ) {
                $previous_width_delta = $width_delta;
                $closest_size = $size;
            } 
        }
        
        return $closest_size;
    }
    
    /**
     * Get SlideDeck dimensions
     * 
     * @param array $slidedeck The SlideDeck object
     * @param integer $override_width Width override
     * @param integer $override_height Height override
     * 
     * @global $SlideDeckPlugin
     * 
     * @uses apply_filters()
     * @uses do_action_ref_array()
     * 
     * @return array
     */
    function get_dimensions( $slidedeck, $override_width = false, $override_height = false ) {
        global $SlideDeckPlugin;
        
        $sizes = apply_filters( "{$this->namespace}_sizes", $SlideDeckPlugin->sizes, $slidedeck );
        
        $width = ( $slidedeck['options']['size'] != "custom" ? $sizes[$slidedeck['options']['size']]['width'] : $slidedeck['options']['width'] );
        $height = ( $slidedeck['options']['size'] != "custom" ? $sizes[$slidedeck['options']['size']]['height'] : $slidedeck['options']['height'] );
        
        // Allow for override of dimensions from the $styles option
        if( $override_width )
            $width = $override_width;
        if( $override_height )
            $height = $override_height;
        
        $outer_width = $width;
        $outer_height = $height;
        
        do_action_ref_array( "{$this->namespace}_dimensions", array( &$width, &$height, &$outer_width, &$outer_height, &$slidedeck ) );
        
        $dimensions = array(
            'width' => $width,
            'height' => $height,
            'outer_width' => $outer_width,
            'outer_height' => $outer_height,
        );
        
        return $dimensions;
    }
    
    /**
     * Get a SlideDeck's parent ID
     * 
     * Returns the top-most parent of the SlideDeck ID requested. If the ID requested is the top-most
     * parent, it returns that ID, otherwise, it looks up the parent ID and returns that.
     * 
     * @param integer $slidedeck_id The SlideDeck ID
     * 
     * @global $wpdb
     * 
     * @uses wpdb::get_row()
     * @uses wpdb::prepare()
     * @uses wp_get_cache()
     * @uses wp_set_cache()
     * 
     * @return integer
     */
    function get_parent_id( $slidedeck_id ) {
        global $wpdb;
        
        $sql = $wpdb->prepare( "SELECT * FROM {$wpdb->posts} WHERE {$wpdb->posts}.ID = %d", $slidedeck_id );
        
        $cache_key = md5( $sql );
        
        $parent_id = wp_cache_get( $cache_key );
        
        if( $parent_id == false ) {
            $row = $wpdb->get_row( $sql );
            
            // Get the post_parent column by default
            $parent_id = $row->post_parent;
            
            // If the parent ID is 0, this is the top-most parent, return the ID instead
            if( $parent_id == 0 ) {
                $parent_id = $row->ID;
            }
            
            wp_cache_set( $cache_key, $parent_id );
        }
        
        return $parent_id;
    }

    /**
     * Get the title font-stack
     * 
     * Returns the CSS font-stack for the font-stack key passed in.
     * 
     * @param string $stack_key The key name for the font-stack to use
     * 
     * @uses SlideDeck::get_fonts()
     * 
     * @return string
     */
    function get_title_font( $slidedeck ) {
        $fonts = $this->get_fonts( $slidedeck );
        
        if( array_key_exists( $slidedeck['options']['titleFont'], $fonts ) )
            $font = $fonts[$slidedeck['options']['titleFont']];
        
        return $font;
    }
    
    /**
     * Generate a unique ID for a SlideDeck
     * 
     * Generates a unique ID string for a SlideDeck for use when being rendered
     * on a page.
     * 
     * @param intetger $slidedeck_id SlideDeck ID
     * 
     * @return string
     */
    function get_unique_id( $slidedeck_id ) {
        // The unique ID to identify the SlideDeck DL element by
        $slidedeck_unique_id = "SlideDeck-$slidedeck_id";
        if( isset( $this->rendered_slidedecks[$slidedeck_id] ) && $this->rendered_slidedecks[$slidedeck_id] > 1 ) {
            $slidedeck_unique_id .= "-" . $this->rendered_slidedecks[$slidedeck_id];
        }
        
        return $slidedeck_unique_id;
    }
    
    /**
     * Get the body font-stack
     * 
     * Returns the CSS font-stack for the font-stack key passed in.
     * 
     * @param string $stack_key The key name for the font-stack to use
     * 
     * @uses SlideDeck::get_fonts()
     * 
     * @return string
     */
    function get_body_font( $slidedeck ) {
        $fonts = $this->get_fonts( $slidedeck );
        
        if( array_key_exists( $slidedeck['options']['bodyFont'], $fonts ) )
            $font = $fonts[$slidedeck['options']['bodyFont']];
        
        return $font;
    }
    
    /**
     * Get all fonts available for use
     * 
     * Returns a combined array of fonts from the Lens and SlideDeck core
     * 
     * @param array $slidedeck The SlideDeck object
     * 
     * @return array
     */
    function get_fonts( $slidedeck ) {
        global $slidedeck_fonts;
        
        $fonts = apply_filters( "{$this->namespace}_get_font", $slidedeck_fonts, $slidedeck );
        
		uksort( $fonts, 'strnatcasecmp' );
		
        return $fonts;
    }
    
    /**
     * Get the options for the SlideDeck
     * 
     * Gets the options using the default options to fill in the blanks and allows per-deck type
     * overrides via a filter. Returns a keyed array of options for the SlideDeck.
     * 
     * @param integer $id The SlideDeck's ID
     * @param string $type The type of SlideDeck
     * @param string $lens The SlideDeck's lens
     * @param string $source The SlideDeck's source
     * 
     * @uses get_post_meta()
     * @uses apply_filters()
     * 
     * @return array
     */
    function get_options( $id, $type, $lens, $source ) {
        $cache_key = md5( serialize( func_get_args() ) );
        
        $options = wp_cache_get( $cache_key );
        
        if( $options == false ) {
            $stored_options = (array) get_post_meta( $id, "{$this->namespace}_options", true );
            
            $default_options = apply_filters( "{$this->namespace}_default_options", $this->default_options(), $type, $lens, $source );
            
            $options = array_merge( (array) $default_options, $stored_options );
            
            wp_cache_set( $cache_key, $options );
        }
        
        return $options;
    }
    
    /**
     * Register scripts used by Decks
     * 
     * @uses wp_register_script()
     */
    function register_scripts() {
        // Fail silently if this is not a sub-class instance
        if( !isset( $this->type ) ) {
            return false;
        }
        
        $filename = '/decks/' . $this->type . '/deck.js';
        
        if( file_exists( SLIDEDECK2_DIRNAME . $filename ) ) {
            wp_register_script( "slidedeck-deck-{$this->type}-admin", SLIDEDECK2_URLPATH . $filename, array( 'jquery', 'slidedeck-admin' ), SLIDEDECK2_VERSION, true );
        }
    }
    
    /**
     * Register styles used by Decks
     * 
     * @uses wp_register_style()
     */
    function register_styles() {
        // Fail silently if this is not a sub-class instance
        if( !isset( $this->type ) ) {
            return false;
        }
        
        $filename = '/decks/' . $this->type . '/deck.css';
        
        if( file_exists( SLIDEDECK2_DIRNAME . $filename ) ) {
            wp_register_style( "slidedeck-deck-{$this->type}-admin", SLIDEDECK2_URLPATH . $filename, array( 'slidedeck-admin' ), SLIDEDECK2_VERSION, 'screen' );
        }
    }

    /**
     * Render a SlideDeck
     * 
     * Builds HTML markup to render a SlideDeck, including supporting lens file assets unless
     * specifically requested to be excluded.
     * 
     * @param integer $id The ID of the SlideDeck to render
     * @param array $styles Optional array of styles to apply to the SlideDeck element
     * @param boolean $include_lens_files Optional argument to include lens file output with the SlideDeck HTML
     * @param boolean $preview Is this a preview?
     * 
     * @global $SlideDeckPlugin
     * 
     * @uses SlideDeck::get()
     * @uses apply_filters()
     * @uses SlideDeckLens::get()
     * @uses do_action()
     * 
     * @return string
     */
    final public function render( $id, $styles = array(), $include_lens_files = true, $preview = false ) {
        global $SlideDeckPlugin;
        
        $license_key = $SlideDeckPlugin->get_license_key();
        if( empty( $license_key ) && !$preview ) {
            return "";
        }
        
        $slidedeck = $this->get( $id );
        
        // Return an empty string if no SlideDeck was found by the requested ID
        if( empty( $slidedeck ) ) {
            return "";
        }
        
        // Increment the use count for a specific SlideDeck
        if( array_key_exists( $id, $this->rendered_slidedecks ) ) {
            $this->rendered_slidedecks[$id]++;
        } else {
            $this->rendered_slidedecks[$id] = 1;
        }
        
        // Classes for the SlideDeck's frame element
        $frame_classes = array(
            'slidedeck-frame',
            'slidedeck_frame'
        );
        $frame_classes[] = "lens-{$slidedeck['lens']}";
        $frame_classes[] = "show-overlay-{$slidedeck['options']['overlays']}";
        $frame_classes[] = "display-nav-{$slidedeck['options']['display-nav-arrows']}";
		
		$source_primary_taxonomy = $SlideDeckPlugin->get_source_primary_taxonomy( $slidedeck['source'] );
        $frame_classes[] = "source-type-{$source_primary_taxonomy}";
        $frame_classes[] = "content-source-{$slidedeck['source']}";
		
        // Add IE classes
        if( preg_match( "/msie ([\d]+)\./", strtolower( $_SERVER['HTTP_USER_AGENT'] ), $msie_matches ) ) {
            $frame_classes[] = "msie";
            $frame_classes[] = "msie-" . $msie_matches[1];
        }
        
        $frame_classes = apply_filters( "{$this->namespace}_frame_classes", $frame_classes, $slidedeck );
        
		// Uniquify classes for the frame 
		$frame_classes = array_unique( $frame_classes );
		
        $override_width = isset( $styles['width'] ) ? $styles['width'] : false;
        $override_height = isset( $styles['height'] ) ? $styles['height'] : false;
        $slidedeck_dimensions = $this->get_dimensions( $slidedeck, $override_width, $override_height );
        extract( $slidedeck_dimensions );
        
        // In-line styles to apply to the SlideDeck's frame element
        $frame_styles_arr = array();
        $frame_styles_arr['width'] = $outer_width . "px";
        $frame_styles_arr['height'] = $outer_height . "px";
        $frame_styles_arr = apply_filters( "{$this->namespace}_frame_styles_arr", $frame_styles_arr, $slidedeck );
        $frame_styles_str = "";
        foreach( $frame_styles_arr as $property => $value ) {
            $frame_styles_str .= "$property:$value;";
        }
        
        $slidedeck_unique_id = $this->get_unique_id( $slidedeck['id'] );
        
        // Classes for the SlideDeck's DL element
        $slidedeck_classes = array(
            'slidedeck'
        );
        $slidedeck_classes[] = "slidedeck-{$slidedeck['id']}";
        $slidedeck_classes = apply_filters( "{$this->namespace}_classes", $slidedeck_classes, $slidedeck );
        
		// Uniquify classes for the frame 
		$slidedeck_classes = array_unique( $slidedeck_classes );
		
        $lens = $SlideDeckPlugin->Lens->get( $slidedeck['lens'] );
        
        $slidedeck_styles_arr = array_merge( $styles, array( 'width' => $width . "px", 'height' => $height . "px" ) );
        $slidedeck_styles_arr = apply_filters( "{$this->namespace}_styles_arr", $slidedeck_styles_arr, $slidedeck, $lens );
        
        $slidedeck_styles_str = "";
        foreach( (array) $slidedeck_styles_arr as $property => $value ) {
            $slidedeck_styles_str.= "$property:$value;";
        }
        
        $html = '<div id="' . $slidedeck_unique_id . '-frame" class="' . implode( " ", $frame_classes ) . '" style="' . $frame_styles_str . '">';
        
        $html.= apply_filters( "{$this->namespace}_render_slidedeck_before", "", $slidedeck );
        
        $html.= '<dl id="' . $slidedeck_unique_id . '" class="' . implode( " ", $slidedeck_classes ) . '" style="' . $slidedeck_styles_str . '">';
        
        // Hook in for any SlideDeck type to control the slide output
        $slides = apply_filters( "{$this->namespace}_get_slides", array(), $slidedeck );
        
        if( $slidedeck['options']['randomize'] == true )
            shuffle( $slides );
        
		$preview_scale_ratio = $outer_width / 650;
		$preview_font_size = intval( min( $preview_scale_ratio * 1000, 1139 ) ) / 1000;
		
		// Check for empty content and render a No Content Found image instead
		if( empty( $slides ) && $preview ) {
			ob_start();
				$namespace = $this->namespace;
				include( SLIDEDECK2_DIRNAME . '/views/elements/_no-content-found.php' );
				$html = ob_get_contents();
			ob_end_clean();
			
			return $html;
		}
		
		// boolean(true) to change orientation of SlideDeck to vertical
		$process_as_vertical = apply_filters( "{$this->namespace}_process_as_vertical", false, $slidedeck );
		
		if( $process_as_vertical )
			$slides = array( array( 'vertical_slides' => $slides ) );
		
        foreach( $slides as $slide ) {
            $slide_model = array(
                'title' => "",
                'styles' => "",
                'classes' => array(),
                'vertical_slides' => array(),
                'thumbnail' => ""
            );
            $slide = array_merge( $slide_model, $slide );
            
            $html .= "<dt>{$slide['title']}</dt>";
            $html .= '<dd style="' . $slide['styles'] . '" class="' . implode( " ", $slide['classes'] ) . '" data-thumbnail-src="' . $slide['thumbnail'] . '">';
			
            // Vertical Slides
            if( !empty( $slide['vertical_slides'] ) ) {
                $html .= '<dl class="slidesVertical">';
                foreach( $slide['vertical_slides'] as $vertical_slide ) {
                    $vertical_slide = array_merge( $slide_model, $vertical_slide );
                    
                    $html .= "<dt>{$vertical_slide['title']}</dt>";
                    $html .= '<dd style="' . $vertical_slide['styles'] . '" class="' . implode( " ", $vertical_slide['classes'] ) . '" data-thumbnail-src="' . $vertical_slide['thumbnail'] . '">' . $vertical_slide['content'] . '</dd>';
                }
                $html .= '</dl>';
            }
            // Horizontal Slides
            else {
                $html .= $slide['content'];
            }
            $html .= "</dd>";
        }
        
        $html.= '</dl>';
        
        $html.= $this->render_overlays( $slidedeck, $slidedeck_unique_id );
        
        // Default navigation
        $html .= '<a class="deck-navigation horizontal prev" href="#prev-horizontal"><span>Previous</span></a>';
        $html .= '<a class="deck-navigation horizontal next" href="#next-horizontal"><span>Next</span></a>';
        $html .= '<a class="deck-navigation vertical prev" href="#prev-vertical"><span>Previous</span></a>';
        $html .= '<a class="deck-navigation vertical next" href="#next-vertical"><span>Next</span></a>';
        
        $html.= apply_filters( "{$this->namespace}_render_slidedeck_after", "", $slidedeck );
        //$html.= '<a href="http://www.slidedeck.com/r" rel="external" class="slidedeck-2-bug">SlideDeck 2 Beta</a>';
        $html.= '</div>';
        
        // Additional JavaScript for rendering vertical slides
        $vertical_properties = array(
            'speed' => $slidedeck['options']['speed'],
            'scroll' => $slidedeck['options']['scroll'],
            'continueScrolling' => $slidedeck['options']['continueScrolling']
        );
        $vertical_properties = apply_filters( "{$this->namespace}_vertical_properties", $vertical_properties, $slidedeck );
        
        $vertical_scripts = '.vertical(' . json_encode( $vertical_properties ) . ')';
        
        // Filter the JavaScript options into an array for JSON output
        $javascript_options = array();
        foreach( $slidedeck['options'] as $key => &$val ) {
            if( in_array( $key, array_keys( $this->javascript_options ) ) ) {
                // Make sure that the response is of the appropriate object type
                if( is_string( $val ) ) {
                    $val = $this->_type_fix( $val, $this->javascript_options[$key] );
                } elseif( is_array( $val ) ) {
                    foreach( $val as $_key => &$_val ) {
                        $_val = $this->_type_fix( $_val, $this->javascript_options[$key][$_key] );
                    }
                }
                $javascript_options[$key] = $val;
            }
        }
		
		$javascript_options['touchThreshold'] = array(
            'x' => round( ( $javascript_options['touchThreshold'] / 100 ) * $width ),
            'y' => round( ( $javascript_options['touchThreshold'] / 100 ) * $height )
		);
		
		// Multiple autoPlayInterval by 1000 since it is stored as seconds and the JavaScript library expects milliseconds
		$javascript_options['autoPlayInterval'] = $javascript_options['autoPlayInterval'] * 1000;
        
        // Add the JavaScript commands to render the SlideDeck to the footer_scripts variable for rendering in the footer of the page
        $SlideDeckPlugin->footer_scripts .= '<script type="text/javascript">jQuery("#' . $slidedeck_unique_id . '").slidedeck( ' . json_encode( $javascript_options ) . ' )' . $vertical_scripts . ';</script>';
        
        // Add overrides for fonts and accent colors
        $title_font = $this->get_title_font( $slidedeck );
        $body_font = $this->get_body_font( $slidedeck );
        
        $SlideDeckPlugin->footer_styles .= '#' . $slidedeck_unique_id . ' {font-family:' . $body_font['stack'] . ';}';
        $SlideDeckPlugin->footer_styles .= '#' . $slidedeck_unique_id . ' .slide-title{font-family:' . $title_font['stack'] . ( isset( $title_font['weight'] ) ? ';font-weight:' . $title_font['weight'] : "" ) . ';}';
        $SlideDeckPlugin->footer_styles .= '#' . $slidedeck_unique_id . '-frame .accent-color{color:' . $slidedeck['options']['accentColor'] . '}';
        $SlideDeckPlugin->footer_styles .= '#' . $slidedeck_unique_id . '-frame .accent-color-background{background-color:' . $slidedeck['options']['accentColor'] . '}';
        
        $SlideDeckPlugin->footer_scripts .= apply_filters( "{$this->namespace}_footer_scripts", "", $slidedeck );
        $SlideDeckPlugin->footer_styles .= apply_filters( "{$this->namespace}_footer_styles", "", $slidedeck );
        
        // Process the SlideDeck's lens assets 
        if( !isset( $SlideDeckPlugin->lenses_included[$lens['slug']] ) && $include_lens_files === true ) {
            $SlideDeckPlugin->lenses_included[$lens['slug']] = true;

            $lens_css_tags = $SlideDeckPlugin->Lens->get_css( $lens );
            $html = $lens_css_tags . $html;
            
            if ( isset( $lens['script_url'] ) && !empty( $lens['script_url'] ) ) {
                $SlideDeckPlugin->footer_scripts .= '<script type="text/javascript" src="' . $lens['script_url'] .'"></script>';
            }
        }
        
        return $html;
    }

    /**
     * Generate Overlay HTML
     * 
     * @param array $slidedeck The SlideDeck object
     * @param string $slidedeck_unique_id Unique SlideDeck ID in the DOM
     * 
     * @global $SlideDeckPlugin
     * 
     * @return string
     */
    function render_overlays( $slidedeck, $slidedeck_unique_id ) {
        global $SlideDeckPlugin, $post;
        
        $html = '<div class="slidedeck-overlays" data-for="' . $slidedeck_unique_id . '">';
        $html.= '<a href="#slidedeck-overlays" class="slidedeck-overlays-showhide">Overlays<span class="open-icon"></span><span class="close-icon"></span></a>';
        
        $permalink = "";
        if( isset( $post->ID ) )
            $permalink = get_permalink( $post->ID );
        
        $permalink .= "#$slidedeck_unique_id";
        
        $overlays = array(
            'facebook' => array(
                'label' => "Share",
                'link' => "http://www.facebook.com/sharer.php?u=" . esc_url( $permalink ) . "&t=" . urlencode( $slidedeck['title'] ),
                'data' => array(
                    'popup-width' => 659,
                    'popup-height' => 592
                )
            ),
            'twitter' => array(
                'label' => "Tweet",
                'link' => "https://twitter.com/intent/tweet",
                'url_params' => array(
                    'url' => esc_url( $permalink ),
                    'hashtags' => "slidedeck",
                    'related' => "slidedeck",
                    'text' => "Check out my " . $slidedeck['title'] . " SlideDeck!"
                ),
                'data' => array(
                    'popup-width' => 466,
                    'popup-height' => 484
                )
            )
        );
        
        // Get the configured Twitter User
        $twitter_user = $SlideDeckPlugin->get_option( 'twitter_user' );
        
        // Add the Twitter User as the via argument if it is set
        if( !empty( $twitter_user ) )
            $overlays['twitter']['url_params']['via'] = $twitter_user;
        
        // Build the full Twitter intent link
        $overlays['twitter']['link'] .= "?" . http_build_query( $overlays['twitter']['url_params'] );
        
        $overlays = apply_filters( "{$this->namespace}_overlays", $overlays, $slidedeck );
        
        $html.= '<span class="slidedeck-overlays-wrapper">';
        
        $i = 0;
        foreach( $overlays as $overlay => $overlay_args ) {
            $i++;
            
            // Additional data parameters for this overlay
            $datas = "";
            // Define data array if it doesn't exist yet
            if( !isset( $overlay_args['data'] ) )
                $overlay_args['data'] = array();
            
            // Define at least a type data key
            $overlay_args['data']['type'] = $overlay;
            
            // Loop through additional data properties to build a string to append to the A tag
            foreach( $overlay_args['data'] as $data => $val )
                $datas.= ' data-' . $data . '="' . $val . '"';
            
            $html.= '<a href="' . $overlay_args['link'] . '" target="_blank" class="slidedeck-overlay slidedeck-overlay-type-' . $overlay . ' slidedeck-overlay-' . $i . '"' . $datas . '><span class="slidedeck-overlay-logo"></span><span class="slidedeck-overlay-label">' . $overlay_args['label'] . '</span></a>';
        }
        
        $html.= '</span>';
        
        $html.= '</div>';
        
        return $html;
    }

    /**
     * Processor to save SlideDeck data
     * 
     * @param object $id The ID of the SlideDeck to save
     * @param object $params The SlideDeck parameters to save, if none are passed, returns false
     * 
     * @uses wp_verify_nonce()
     * @uses SlideDeckPlugin::sanitize()
     * @uses wp_insert_post()
     * @uses SlideDeckPlugin::load()
     * @uses SlideDeckPlugin::load_slides()
     * @uses update_post_meta()
     * 
     * @return object $slidedeck Updated SlideDeck object
     */
    final public function save( $id = null, $params = array() ) {
        // Fail silently if not parameters were passed in
        if( !isset( $id ) || empty( $params ) ) {
            return false;
        }
        
        // Clean the data for safe storage
        $data = slidedeck2_sanitize( $params );
        
        // What type of SlideDeck is this
        $type = $data['type'];
        // What lens is this SlideDeck using
        $lens = $data['lens'];
        
        do_action( "{$this->namespace}_before_save", $id, $data, $type );
        
        $options_model = apply_filters( "{$this->namespace}_options_model", $this->options_model, $data );
        
        // Loop through boolean options and set as false if the value was not passed in
        foreach( $options_model as $options_group => $options ) {
            foreach( $options as $key => $properties ) {
                if( !isset( $properties['data'] ) ) $properties['data'] = "string";
                if( !isset( $data['options'][$key] ) && $properties['data'] == "boolean" ) {
                    $data['options'][$key] = false;
                }
            }
        }
        
        // Properly store the data as the expected option type
        foreach( $data['options'] as $key => &$val ) {
            foreach( $options_model as $options_group => $options ) {
                if( in_array( $key, array_keys( $options ) ) ) {
                    // Make sure that the response is of the appropriate object type
                    if( is_string( $val ) ) {
	                    $data_type = isset( $options[$key]['data'] ) ? $options[$key]['data'] : "string";
                        $val = $this->_type_fix( $val, $data_type );
                    } elseif( is_array( $val ) ) {
                        foreach( $val as $_key => &$_val ) {
		                    $data_type = isset( $options[$key][$_key]['data'] ) ? $options[$key][$_key]['data'] : "string";
                            $_val = $this->_type_fix( $_val, $data_type );
                        }
                    }
                }
            }
        }

        // Allow filter hook-in to override values based on Deck type
        $data['options'] = apply_filters( "{$this->namespace}_options", $data['options'], $type );
        
        $post_args = array(
            'ID' => $id,
            'post_status' => "publish",
            'post_content' => "",
            'post_title' => $data['title']
        );
        
        if( isset( $data['post_status'] ) && !empty( $data['post_status'] ) )
            $post_args['post_status'] = $data['post_status'];
        
        if( isset( $data['post_parent'] ) && !empty( $data['post_parent'] ) )
            $post_args['post_parent'] = $data['post_parent'];
        
        // Save the primary SlideDeck post
        wp_update_post( $post_args );
        
        // Save the type of SlideDeck
        update_post_meta( $id, "{$this->namespace}_type", $data['type'] );
        // Save the content source of the SlideDeck
        update_post_meta( $id, "{$this->namespace}_source", $data['source'] );
        // Save the lens used by this SlideDeck
        update_post_meta( $id, "{$this->namespace}_lens", $data['lens'] );
        // Save the options for this SlideDeck
        update_post_meta( $id, "{$this->namespace}_options", $data['options'] );
        
        do_action( "{$this->namespace}_after_save", $id, $data, $type );
        
        // Return the newly saved SlideDeck
        $slidedeck = $this->get( $id );
        
        return $slidedeck;
    }

    /**
     * Save a preview auto-draft
     * 
     * Saves all passed in data for a SlideDeck in a duplicate auto-draft entry
     * that is used for the preview. If an auto-draft entry already exists for this
     * SlideDeck, it will be updated otherwise a new auto-draft entry is created.
     * Returns the auto-draft SlideDeck object.
     * 
     * @param integer $slidedeck_id Parent SlideDeck ID
     * @param array $params Parameters for the SlideDeck (usually $_REQUEST or $_POST)
     * 
     * @uses SlideDeck::get()
     * @uses WP_Query()
     * @uses wp_insert_post()
     * @uses SlideDeck::save()
     * 
     * @return array
     */
    final public function save_preview( $slidedeck_id, $params ) {
        $slidedeck = $this->get( $slidedeck_id );
        
        // Get the ID of any existing auto-draft SlideDeck for this SlideDeck and use that for our preview
        $query_args = array(
            'post_status' => "auto-draft",
            'post_parent' => $slidedeck_id,
            'post_type' => SLIDEDECK2_POST_TYPE
        );
        $query = new WP_Query( $query_args );
        
        // Get the auto-draft ID from the query
        if( !empty( $query->posts ) ) {
            $slidedeck_preview_id = $query->post->ID;
        } 
        // Create a new auto-draft to save previews for
        else {
            $post_args = array(
                'post_status' => "auto-draft",
                'post_parent' => $slidedeck_id,
                'post_type' => SLIDEDECK2_POST_TYPE,
                'post_title' => $slidedeck['title'] . " Preview"
            );
            $slidedeck_preview_id = wp_insert_post( $post_args );
        }
        
        $params['post_status'] = "auto-draft";
        $params['post_parent'] = $slidedeck_id;
        
        $slidedeck_preview = $this->save( $slidedeck_preview_id, $params );
        
        return $slidedeck_preview;
    }
}
