<?php
	function lps_load_scripts() {

		if ( !is_admin() ) {

			// Basic .js file for your sitewide JavaScript
			wp_enqueue_script('basic', get_bloginfo('template_directory').'/js/main.js', array('jquery'), '1.0');

			// Twitter Jquery Widget
			wp_enqueue_script('twitter', get_bloginfo('template_directory').'/js/jquery.tweet.js', array('jquery'), '1.0');

			// Dribbble Jquery Widget
			wp_enqueue_script('dribbble', get_bloginfo('template_directory').'/js/jquery.jribbble-1.0.0.ugly.js', array('jquery'), '1.0');

			// Slider
			wp_enqueue_script('slider', get_bloginfo('template_directory').'/js/jquery.flexslider-min.js', array('jquery'), '1.0');
		
			// Modernizr
			wp_enqueue_script('modernizr', get_bloginfo('template_directory').'/js/modernizr-2.0.6.js', array('jquery'), '1.0');

			// Load jQuery from Google
			if ( !is_admin() ) {
				wp_deregister_script('jquery');
				wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"), false);
				wp_enqueue_script('jquery');
				}

			// For comment reply form
			if ( is_singular() && get_option( 'thread_comments' ) && comments_open() )
				wp_enqueue_script( 'comment-reply' );	
		}

	}
?>