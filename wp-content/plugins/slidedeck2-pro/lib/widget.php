<?php
class SlideDeck2Widget extends WP_Widget {
    var $namespace = "slidedeck2";
    
    /**
     * Constructor function for Class
     * 
     * @uses WP_Widget()
     */
    function SlideDeck2Widget() {
        $widget_options = array(
            'classname' => $this->namespace . '_widget',
            'description' => 'Add SlideDeck 2 SlideDecks to your widget areas'
        );
        $this->WP_Widget( $this->namespace . '_widget', 'SlideDeck 2 Widget', $widget_options );
    }
    
    /**
     * Initialization function to register widget
     * 
     * @uses register_widget()
     */
    function init() {
        register_widget( "SlideDeck2Widget" );
    }
    
    /**
     * Form function for the widget control panel
     * 
     * @param object $instance Option data for this widget instance
     * 
     * @uses slidedeck_load()
     * @uses slidedeck_dir()
     */
    function form( $instance ) {
        global $SlideDeckPlugin;
        
        $instance = wp_parse_args( (array) $instance, array(
            'slidedeck_id' => "",
            $this->namespace . '_deploy_as_iframe' => false
        ) );
        
        $slidedeck_id = strip_tags( $instance['slidedeck_id'] );
        $deploy_as_iframe = $instance[$this->namespace . '_deploy_as_iframe'];
        
        $namespace = $this->namespace;
        $slidedecks = $SlideDeckPlugin->SlideDeck->get( null, 'post_title', 'ASC', 'publish' );
        
        include( SLIDEDECK2_DIRNAME . '/views/elements/_widget-form.php' );
    }
    
    /**
     * Update processing function for saving widget instance settings
     * 
     * @param object $new_instance Option data submitted for this widget instance
     * @param object $old_instance Existing option data for this widget instance
     * 
     * @return object $instance Updated option data
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        
        $instance['slidedeck_id'] = $new_instance['slidedeck_id'];
        $instance[$this->namespace . '_deploy_as_iframe'] = isset( $new_instance[$this->namespace . '_deploy_as_iframe'] );
        
        return $instance;
    }
    
    /**
     * Widget output function
     * 
     * Loads a SlideDeck instance based off the widget settings specified by the user
     * 
     * @param object $args Extra arguments provided for this widget output see documentation at
     *                     http://codex.wordpress.org/Function_Reference/the_widget
     * @param object $instance Option data for this widget instance
     * 
     * @uses slidedeck()
     */
    function widget( $args, $instance ) {
        global $slidedeck_footer_scripts;
        
        extract( $args, EXTR_SKIP );
        
        echo $before_widget;
        
        $shortcode = "[SlideDeck2 id={$instance['slidedeck_id']}";
        if( $instance[$this->namespace . '_deploy_as_iframe'] ) $shortcode.= " iframe=1";
        $shortcode.= "]";
        
        echo do_shortcode( $shortcode );
        
        echo $after_widget;
    }
}
add_action( 'widgets_init', array( 'SlideDeck2Widget', 'init' ) );
