<?php

	/* Functions for processing custom fields */
	function format_custom_field($field, $format = '', $date_format = 'F j, Y')
	{

		$fetch = get_post_custom_values($field);
		$fetch = $fetch[0];
		
		// Test if anything was fetched or return false.
		if (!$fetch) {
			return false;	
		}
		
		switch ($format) {
			case 'date':
				return date($date_format, $fetch);
				break;
			case 'text_block':
				return wpautop($fetch);
				break;
			case 'link':
				return '<a href="'.$fetch.'" class="custom_link">'.$fetch.'</a>';
				break;
			case 'html':
				return html_entity_decode($fetch);
				break;
			case 'google_map':
				return display_google_map($fetch);
				break;
			default:
				// If you're not processing(formatting) the var at all
				// why even use this function? Just use the WP custom field funcs.
				return $fetch;
				
		}
	}

	// Get custom field data
	function get_custom_field($field, $format = '', $date_format = 'F j, Y')
	{
		return format_custom_field($field, $format, $date_format);
	}
	
	// Echo custom field data
	function custom_field($field, $format = '', $date_format = 'F j, Y')
	{
		echo format_custom_field($field, $format, $date_format);
	}
	
	
	// Formatting for Google Maps
	function display_google_map($code)
	{
		$code = html_entity_decode($code);
		// Remove the info bubble. Usually desirable, but use the html format if unwanted.
		$code = str_replace("output=embed", "output=embed&iwloc=near", $code);
		return $code;
	}

?>