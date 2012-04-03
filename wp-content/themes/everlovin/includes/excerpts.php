<?php
	function excerpt($limit) {
	      $excerpt = explode(' ', get_the_content(), $limit);
	      if (count($excerpt)>=$limit) {
	        array_pop($excerpt);
	        $excerpt = implode(" ",$excerpt).'...';
	      } else {
	        $excerpt = implode(" ",$excerpt);
	      } 
	      $excerpt = preg_replace('`\[[^\]]*]`','',$excerpt);
	      $excerpt = preg_replace("/<img(.*?)>/si", "", $excerpt);
	      $excerpt = preg_replace("/<em(.*?)>/si", "", $excerpt);
	  	  return $excerpt;preg_replace('`\[[^\]]*]`','',$excerpt);

	}

	function custom_excerpt($length='',$more_txt='Read More') {
		$default_length = 30;
		if (empty($length)) {
				$excerpt_length = $default_length;
			} else {
				$excerpt_length = $length;
			}
		$excerpt = excerpt($excerpt_length);
		$link = '<a href="'.get_permalink($post->ID).'" class="more_link">'.$more_txt.'</a>';
		$output = "$excerpt $link";
		echo wpautop($output, true);
	}
?>