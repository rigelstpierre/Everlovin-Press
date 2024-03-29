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
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo _e( "Insert your SlideDeck", $namespace ); ?></title>
        
        <link rel="stylesheet" type="text/css" href="<?php echo SLIDEDECK2_URLPATH; ?>/css/fancy-form.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo SLIDEDECK2_URLPATH; ?>/css/slidedeck-admin.css" media="all" />
        
        <script type="text/javascript" src="<?php echo $wp_scripts->registered['jquery']->src; ?>"></script>
        <script type="text/javascript" src="<?php echo $wp_scripts->registered['slidedeck-admin']->src; ?>"></script>
        <script type="text/javascript" src="<?php echo $wp_scripts->registered['fancy-form']->src; ?>"></script>
        
        <style type="text/css">
            body, html {
                position: relative;
                width: 100%;
                height: 100%;
                overflow: hidden;
                margin: 0;
                padding: 0;
                background-color: #f2f2f2;
            }
            #slidedeck-insert-iframe-form {
                position: absolute;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                overflow: hidden;
            }
            #slidedeck-insert-iframe-wrapper {
                position: absolute;
                top: 45px;
                right: 0;
                bottom: 60px;
                left: 0;
                overflow: auto;
                overflow-x: hidden;
                border-bottom: 1px solid #d1d1d1;
            }
        </style>
    </head>
    <body class="insert-iframe-modal">
        <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="GET" id="slidedeck-insert-iframe-form">
            <div id="slidedeck-insert-iframe-section-header" class="slidedeck-header">
                <h1><?php _e( "Choose a SlideDeck to insert:", $namespace ); ?></h1>
                
                <?php slidedeck2_html_input( 'orderby', $orderby, array( 'type' => 'select', 'label' => "Arrange by:", 'attr' => array( 'class' => 'fancy' ), 'values' => $order_options ) ); ?>
                
                <input type="hidden" name="action" value="<?php echo $namespace; ?>_insert_iframe_update" />
                <?php wp_nonce_field( "slidedeck-update-insert-iframe", "_wpnonce_insert_update", false ); ?>
                <?php wp_nonce_field( "slidedeck-insert" ); ?>
            </div>
            
            <div id="slidedeck-insert-iframe-wrapper">
                
                <fieldset id="slidedeck-insert-iframe-section-table">
                    
                    <div class="inner">
                        
                        <?php echo $insert_iframe_table; ?>
                        
                    </div>
                    
                </fieldset>
            
            </div>
            
            <p class="submit-row">
                <a href="#cancel" id="slidedeck-insert-iframe-cancel-link"><?php _e( "Cancel", $namespace ); ?></a>
                <input type="submit" class="slidedeck-button-primary" value="<?php _e( "Insert", $namespace ); ?>" />
            </p>
        </form>
    </body>
</html>