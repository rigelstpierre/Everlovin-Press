<?php
/**
 * Image Properties Modal
 * 
 * @package SlideDeck
 */
?>
<div class="slidedeck-header">
    <h1>Image Properties</h1>
</div>

<form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post" id="slidedeck-medialibrary-image-properties-form">
    
    <fieldset>
        
        <input type="hidden" name="action" value="slidedeck_medialibrary_image_properties" />
        <input type="hidden" name="ID" value="<?php echo $media['post']->ID; ?>" />
        <?php wp_nonce_field( 'slidedeck-medialibrary-image-properties' ); ?>
        
        <p><?php slidedeck2_html_input( "title", $media['post']->post_title, array( 'label' => "Title" ) ); ?></p>
        <p><?php slidedeck2_html_input( "caption", $media['post']->post_excerpt, array( 'label' => "Caption" ) ); ?></p>
        <p><?php slidedeck2_html_input( "media_link", $media['media_link'], array( 'label' => "Link" ) ); ?></p>
        
    </fieldset>
    
    <p class="submit-row">
        <a href="#close" class="close-modal">Cancel</a>
        <input type="submit" value="Save Changes" class="button button-primary" />
    </p>
    
</form>
