<?php
/**
 * Images associated with this SlideDeck
 * 
 * Sortable list of thumbnails for images associated with a Media Library SlideDeck
 * 
 * @package SlideDeck
 */
?>
<?php foreach( (array) $media as $image ): ?>
    
    <div class="media-image">
        <a href="<?php echo wp_nonce_url( admin_url( 'admin-ajax.php?action=slidedeck_medialibrary_image_properties&id=' . $image['post']->ID ), 'slidedeck-medialibrary-image-properties' ); ?>" title="Image Properties" class="slidedeck-medialibrary-image-properties">
            <img width="<?php echo $image['src'][1]; ?>" height="<?php echo $image['src'][2]; ?>" src="<?php echo $image['src'][0]; ?>" alt="<?php echo esc_attr( $image['post']->post_title ); ?>" />
	        <span class="tip"><?php _e( "Click to Edit", $namespace ); ?></span>
        </a>
        <a href="#<?php echo $image['post']->ID; ?>" class="remove"><?php _e( "Remove", $namespace ); ?></a>
        <input type="hidden" name="options[medialibrary_ids][]" value="<?php echo $image['post']->ID; ?>" />
    </div>
    
<?php endforeach; ?>
