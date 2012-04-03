<?php
/**
 * SlideDeck Editor Form
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
<?php do_action( "{$namespace}_before_form", $slidedeck, $form_action ); ?>

<div class="wrap" id="slidedeck_form">
    
    <?php slidedeck2_flash(); ?>
    
    <p><a href="<?php echo slidedeck2_action(); ?>" id="back-to-manage"><?php _e( "Back to Manage Screen", $namespace ); ?></a></p>
    
    <form action="" method="post" id="slidedeck-update-form" class="slidedeck-form">
        <fieldset id="slidedeck-section-header" class="slidedeck-form-section slidedeck-header">
            <img class="source-icon" src="<?php echo SLIDEDECK2_URLPATH . $source['icon']; ?>" alt="<?php echo $source['label']; ?>" />
            <a class="configure-source" href="#configure">Configure</a>
            <div id="slidedeck-content-source" class="<?php echo ( $_REQUEST['action'] == 'create' ) ? '' : 'hidden'; ?>">
                <h4><?php printf( __( "Configure your %s source", $this->namespace ), $source['label'] ); ?></h4>
                <?php do_action( "{$namespace}_form_content_source", $slidedeck, $form_action ); ?>
            </div>
            
            <?php wp_nonce_field( "{$namespace}-{$form_action}-slidedeck" ); ?>
            <input type="hidden" name="action" value="<?php echo $form_action; ?>" id="form_action" />
            <input type="hidden" name="id" value="<?php echo $slidedeck['id']; ?>" id="slidedeck_id" />
            <?php wp_nonce_field( "{$namespace}-preview-iframe-update", "_wpnonce_preview", false ); ?>
            <?php wp_nonce_field( "{$namespace}-lens-update", "_wpnonce_lens_update", false ); ?>
            
            <div id="slidedeck-title-wrapper">
                <div id="slidedeck-title-wrapper-edit-view"<?php if( $form_action == "create" ) echo ' style="display:none;"'; ?>>
                    <h1><span><?php echo $slidedeck['title']; ?></span> <a href="#edit">Edit</a></h1>
                </div>
                <input type="text" name="title" size="60" value="<?php echo $slidedeck['title']; ?>" id="slidedeck_title" class="input-large<?php if( $form_action == 'create' ) echo ' auto-replace empty'; ?>"<?php if( $form_action == "edit" ) echo ' style="display:none;"'; ?> />
            </div>
        </fieldset>
        
        <div id="slidedeck-form-body">
            
            <?php do_action( "{$namespace}_form_top", $slidedeck, $form_action ); ?>
            
            <fieldset id="slidedeck-section-lenses" class="slidedeck-form-section collapsible clearfix">
                <h3 class="hndl"><span class="indicator"></span><?php _e( "Lenses", $namespace ); ?></h3>
                
                <div class="inner clearfix">
                    <?php foreach( $lenses as &$lens ): ?>
                        <label class="lens<?php if( $lens['slug'] == $slidedeck['lens'] ) echo ' selected'; ?>">
                            <span class="thumbnail"><img src="<?php echo $lens['thumbnail']; ?>" alt="<?php echo $lens['meta']['name']; ?>" /></span>
                            <span class="title"><?php echo $lens['meta']['name']; ?></span>
                            <input type="radio" name="lens" value="<?php echo $lens['slug']; ?>"<?php if( $lens['slug'] == $slidedeck['lens'] ) echo ' checked="checked"'; ?> />
                        </label >
                    <?php endforeach; ?>
                    
                </div>
                
            </fieldset>
            
            <fieldset id="slidedeck-section-preview" class="slidedeck-form-section collapsible clearfix">
                <h3 class="hndl"><span class="indicator"></span><?php _e( "Preview", $namespace ); ?></h3>
                
                <div class="inner <?php if( !empty( $the_stage_background ) ) echo 'texture-' . $the_stage_background; ?>">
                
                    <iframe id="slidedeck-preview" frameborder="0" allowtransparency="yes"  src="<?php echo $iframe_url; ?>" style="width:<?php echo $dimensions['outer_width'] + 2; ?>px;height:<?php echo $dimensions['outer_height'] + 2; ?>px;"></iframe>
                    
                </div>
                
                <ul id="preview-textures">
                    <?php foreach( $stage_backgrounds as $stage_background => $label ): ?>
    	                <li id="texture-<?php echo $stage_background; ?>"<?php if( $stage_background == $the_stage_background ) echo ' class="active"'; ?>><a href="<?php echo wp_nonce_url( admin_url( 'admin-ajax.php?action=' . $namespace . '_stage_background&slidedeck=' . $slidedeck['id'] . '&background=' . $stage_background ), "{$namespace}-stage-background" ); ?>"><?php echo $label; ?></a></li>
                    <?php endforeach; ?>
            	</ul>
                
            </fieldset>
            
            <fieldset id="slidedeck-section-options" class="slidedeck-form-section collapsible clearfix">
                <h3 class="hndl"><span class="indicator"></span><?php _e( "Options", $namespace ); ?></h3>
                
                <div class="inner clearfix">
                    
                    <?php include( SLIDEDECK2_DIRNAME . '/views/elements/_options.php' ); ?>
                    
                </div>
            </fieldset>
            
            <?php do_action( "{$namespace}_form_bottom", $slidedeck, $form_action ); ?>
            
            <input id="save-slidedeck-button" type="submit" class="button button-primary" value="Save SlideDeck" />            
            
        </div>
    </form>
</div>

<script type="text/javascript">
    var SlideDeckFonts = <?php echo json_encode( $fonts ); ?>;
    var __hasSavedCovers = <?php echo var_export( $has_saved_covers, true ); ?>;
</script>

<?php if( isset( $_GET['firstsave'] ) ): ?>
    <?php global $wp_scripts; ?>
    <script type="text/javascript" src="<?php echo $wp_scripts->registered['zeroclipboard']->src; ?>"></script>
    <script type="text/javascript">
        ZeroClipboard.setMoviePath('<?php echo SLIDEDECK2_URLPATH; ?>/js/zeroclipboard/ZeroClipboard10.swf');
        jQuery(document).ready(function(){SlideDeckPlugin.FirstSaveDialog.open(<?php echo $slidedeck['id']; ?>);});
    </script>
<?php endif; ?>


<?php do_action( "{$namespace}_after_form", $slidedeck, $form_action ); ?>