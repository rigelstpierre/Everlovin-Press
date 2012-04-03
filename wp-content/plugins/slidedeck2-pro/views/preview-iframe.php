<?php
/**
 * Preview SlideDeck iframe template
 * 
 * SlideDeck 2 Pro for WordPress 2.0.20120327
 * Copyright (c) 2012 digital-telepathy (http://www.dtelepathy.com)
 * 
 * BY USING THIS SOFTWARE, YOU AGREE TO THE TERMS OF THE SLIDEDECK 
 * LICENSE AGREEMENT FOUND AT http://www.slidedeck.com/license. 
 * IF YOU DO NOT AGREE TO THESE TERMS, DO NOT USE THE SOFTWARE.
 * 
 * More information on this project:
 * http://www.slidedeck.com/
 * 
 * Full Usage Documentation: http://www.slidedeck.com/usage-documentation 
 * 
 * @package SlideDeck
 * @subpackage SlideDeck 2 Pro for WordPress
 * @author dtelepathy
 */
?>
<!doctype html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $slidedeck['title']; ?></title>
        
        <script type="text/javascript">var SlideDeckLens={};</script>
        
        <?php
            foreach( $scripts as $script ) {
                $src = $wp_scripts->registered[$script]->src;
                if ( !preg_match( '|^https?://|', $src ) && !( $content_url && 0 === strpos( $src, $content_url ) ) ) {
                    $src = $base_url . $src;
                }
                
                echo '<script type="text/javascript" src="' . $src . '"></script>';
            }
        ?>
        
        <link rel="stylesheet" type="text/css" href="<?php echo $wp_styles->registered['slidedeck']->src; ?>" />
        
        <?php echo $this->Lens->get_css( $lens ); ?>
        
        <style type="text/css">
            body, html {
                margin: 0;
                padding: 0;
                overflow: hidden;
                width: 100%;
                height: 100%;
            }
            #mask {
                position: absolute;
                z-index: 1;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                background: #f2f2f2;
                -webkit-opacity: 0;
                -moz-opacity: 0;
                -o-opacity: 0;
                opacity: 0;
                filter: Alpha(opacity=0);
                -ms-filter: "Alpha(opacity=0)";
                -webkit-transition: opacity 0.35s;
                -moz-transition: opacity 0.35s;
                -o-transition: opacity 0.35s;
                transition: opacity 0.35s;
                font-size: 10px;
            }
            #mask.visible {
                z-index: 99999;
                left: 0;
                -webkit-opacity: 1;
                -moz-opacity: 1;
                -o-opacity: 1;
                opacity: 1;
                filter: Alpha(opacity=100);
                -ms-filter: "Alpha(opacity=100)";
            }
            #mask .mask-loading-wrapper {
            	position: absolute;
            	top: 0;
            	right: 0;
            	bottom: 0;
            	left: 0;
            	width: 100%;
            	height: 100%;
            }
            #mask .mask-loading-title {
            	position: absolute;
            	display: block;
            	top: 50%;
            	left: 0;
            	right: 0;
            	margin: -7.9em 0 0 0;
            	text-indent: -999em;
            	width: 100%;
            	line-height: 5.3em;
            	max-height: 53px;
            	font-size: 1em;
            	background: url('<?php echo SLIDEDECK2_URLPATH; ?>/images/loading-title.png') center center no-repeat;
            	background-size: contain;
            }
            #mask .mask-loading-copy {
				position: absolute;
				top: 50%;
				left: 50%;
				text-align: center;
				margin: 0 0 0 -8.675em;
				text-align: center;
				width: 17.35em;
				background: url('<?php echo SLIDEDECK2_URLPATH; ?>/images/border-loading.png') center 0 no-repeat;
				background-size: contain;
				padding: 1em 0 0;
				font: italic 2em/1.6em Georigia, serif;
				color: #aeaeae;
				text-shadow: 0 1px 1px #fff;
            }
            #mask .mask-loading-wrapper img {
            	position: absolute;
            	top: 50%;
            	left: 50%;
            	width: 3.1em;
            	height: 3.1em;
            	margin: 0;
            	max-width: 31px;
            	max-height: 31px;
            	margin: -1.55em 0 0 -1.55em;
            }
            .slidedeck-frame { z-index: 2; }
        </style>
        
        <script type="text/javascript">
        	(function($){
        		$(window).load(function(){
    				var $mask = $('#mask'),
    					$window = $(window);
					var $wrapper = $mask.find('.mask-loading-wrapper');
    				
        			$window.resize(function(){
				        var width = $window.width(),
				            height = $window.height();
				        
				        $wrapper.css('font-size', (Math.round(Math.min((width/347)*1000, 1139))/1000) + "em");
        			});
        			
        			$mask.removeClass('visible');
        		});
        	})(jQuery);
        </script>
    </head>
    <body>
        <div id="mask" class="visible">
        	<div class="mask-loading-wrapper" style="<?php if( isset( $preview_font_size ) ) echo 'font-size: ' . $preview_font_size . 'em'; ?>">
        		<img src="<?php echo SLIDEDECK2_URLPATH; ?>/images/loading.gif" alt="<?php _e( "Loading", $namespace ); ?>">
	        	<div class="mask-loading-title">Loading</div>
	        	<div class="mask-loading-copy"><?php _e( "We&rsquo;re decking out your content!", $namespace ); ?></div>
        	</div>
        </div>
        <?php echo do_shortcode( "[SlideDeck2 id={$slidedeck['id']}" . ( $preview ? ' preview=1' : '' ) . "]" ); ?>
        <?php $this->print_footer_scripts(); ?>
        <script type="text/javascript">
            (function($){
                $(document).ready(function(){
                    $('a').attr('target', '_blank');
                });
            })(jQuery);
        </script>
    </body>
</html>