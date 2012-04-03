<div class="slidedeck-cover slidedeck-cover-back">
    
    <div class="slidedeck-cover-wrapper">
        
	    <div class="slidedeck-cover-binding"><span class="slidedeck-cover-binding-highlight"></span><span class="slidedeck-cover-color" style="background-color:<?php echo $accent_color; ?>"></span></div>
	    
        <div class="slidedeck-cover-copy">
            <div class="slidedeck-cover-outer">
                <div class="slidedeck-cover-middle">
                    <div class="slidedeck-cover-inner">
                        <span class="slidedeck-cover-title" style="font-family:<?php echo $title_font['stack']; ?>;<?php if( isset( $title_font['weight'] ) ) echo 'font-weight:' . $title_font['weight'] . ';'; ?>"><?php echo nl2br( $back_title ); ?></span>
                        
                        <a href="<?php echo esc_attr( $button_url ); ?>" class="slidedeck-cover-button slidedeck-cover-cta" target="_blank">
                            <span class="slidedeck-cover-color" style="background-color:<?php echo $accent_color; ?>;"></span>
                            <span class="text"><?php echo $button_label; ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <a href="#restart" class="slidedeck-cover-nav-button slidedeck-cover-restart" title="Restart">
            <span class="slidedeck-cover-button">Restart</span>
            <span class="slidedeck-cover-color" style="background-color:<?php echo $accent_color; ?>;"></span>
            <span class="slidedeck-cover-semicircle"></span>
        </a>
        
        <span class="slidedeck-cover-wrapper-back" style="border-left-color:<?php echo $accent_color; ?>;"><span class="slidedeck-cover-wrapper-back-inner"></span></span>
        <span class="slidedeck-cover-wrapper-nub"></span>
    </div>
    
    <div class="slidedeck-cover-mask"></div>
    
</div>
