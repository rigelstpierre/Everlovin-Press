<div class="slidedeck-header">
    <h1><?php _e( "Configure Covers", $namespace ); ?></h1>
</div>

<div id="slidedeck-covers-swap">
    <span class="label"><?php _e( "Select Cover", $namespace ); ?></span>
    <span class="toggles">
        <a href="#front" class="toggle toggle-front selected"><?php _e( "Front", $namespace ); ?></a><a href="#back" class="toggle toggle-back"><?php _e( "Back", $namespace ); ?></a>
    </span>
</div>

<form action="" method="post">
    
    <div id="slidedeck-covers-preview-wrapper" style="width:<?php echo intval( $dimensions['outer_width'] * $scaleRatio ); ?>px;height:<?php echo intval( $dimensions['outer_height'] * $scaleRatio ); ?>px">
        <span class="mask"></span>
        <div id="slidedeck-covers-preview" class="slidedeck-frame slidedeck-cover-easing-back slidedeck-cover-style-<?php echo $cover['cover_style']; ?><?php if( !empty( $cover['variation'] ) ) echo ' slidedeck-cover-' . $cover['variation']; ?><?php if( $cover['peek'] ) echo ' slidedeck-cover-peek'; ?> sd2-<?php echo $size_class; ?>" style="width:<?php echo $dimensions['outer_width']; ?>px;height:<?php echo $dimensions['outer_height']; ?>px;-webkit-transform: scale(<?php echo $scaleRatio; ?>);-webkit-transform-origin: 0 0;-moz-transform: scale(<?php echo $scaleRatio; ?>);-moz-transform-origin: 0 0;-o-transform: scale(<?php echo $scaleRatio; ?>);-o-transform-origin: 0 0;-ms-transform: scale(<?php echo $scaleRatio; ?>);-ms-transform-origin: 0 0;transform: scale(<?php echo $scaleRatio; ?>);transform-origin: 0 0;">
            <?php echo $this->Cover->render( $slidedeck_id, 'front' ); ?>
            <?php echo $this->Cover->render( $slidedeck_id, 'back' ); ?>
            <?php echo do_shortcode( "[SlideDeck2 id=$slidedeck_id iframe=1 nocovers=1]" ); ?>
        </div>
    </div>
    
    <fieldset>
        
        <div class="inner clearfix">
            
            <ul class="options-list front-options">
                <?php foreach( $front_options as $option ): ?>
                    <li><span class="inner"><?php slidedeck2_html_input( $option, $cover[$option], $cover_options_model[$option] ); ?></span></li>
                <?php endforeach; ?>
            </ul>
            
            <ul class="options-list back-options" style="height:0;">
                <?php foreach( $back_options as $option ): ?>
                    <li><span class="inner"><?php slidedeck2_html_input( $option, $cover[$option], $cover_options_model[$option] ); ?></span></li>
                <?php endforeach; ?>
            </ul>
            
        </div>
        
    </fieldset>
    
    <fieldset>
        
        <?php wp_nonce_field( "{$this->namespace}-cover-update" ); ?>
        <input type="hidden" name="slidedeck" value="<?php echo $slidedeck_id; ?>" />
        
        <div class="inner clearfix">
            
            <ul class="options-list global-options">
                <?php foreach( $global_options as $option ): ?>
                    <li<?php if( $option == "variation" && empty( $variations[$cover['cover_style']] ) ) echo ' style="display:none;"'; ?>><span class="inner"><?php slidedeck2_html_input( $option, $cover[$option], $cover_options_model[$option] ); ?></span></li>
                <?php endforeach; ?>
            </ul>
            
        </div>
    
    </fieldset>
    
    <p class="submit-row">
        <a href="#cancel" class="cancel-modal">Cancel</a>
        <input type="submit" class="button button-primary" value="Save Changes" />
    </p>
    
    <script type="text/javascript">
        SlideDeckPlugin.CoversEditor.fonts = <?php echo json_encode( $slidedeck_fonts ); ?>;
        SlideDeckPlugin.CoversEditor.variations = <?php echo json_encode( $variations ); ?>;
    </script>
    
</form>
