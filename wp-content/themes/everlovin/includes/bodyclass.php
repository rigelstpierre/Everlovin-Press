<?php

function expand_body_classes($classes, $class='') {
	global $wp_query;	
	$post_id = $wp_query->post->ID;
	if(is_page($post_id )){
		$page = get_page($post_id);
		//check for parent
		if($page->post_parent>0){
			$parent = get_page($page->post_parent);
			$classes[] = sanitize_title($parent->post_title);
		}
		$classes[] = sanitize_title($page->post_title);
	}
	return $classes;// return the $classes array
}

?>