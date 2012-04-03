<label class="label" for="options-feedCacheDuration"><?php _e( "Cache Duration" . '<span class="tooltip" title="' . $tooltip . '"></span>', $this->namespace ); ?></label>
<div class="jqueryui-slider-wrapper">
	<div id="cache-duration-slider" class="cache-slider content-source-slider"></div>
	<span class="ui-slider-value cache-slider-value"></span>
</div>
<?php 
    if( !isset( $slidedeck['options']['feedCacheDuration'] ) ) {
        $slidedeck['options']['feedCacheDuration'] = 1800;
    }
    slidedeck2_html_input( 'options[feedCacheDuration]', $slidedeck['options']['feedCacheDuration'], array( 'type' => 'hidden', 'attr' => array( 'class' => 'feed-cache-duration', 'size' => 5, 'maxlength' => 5 ) ) ); 
?>
