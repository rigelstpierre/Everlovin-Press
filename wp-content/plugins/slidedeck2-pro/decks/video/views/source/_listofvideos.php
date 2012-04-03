<?php
/**
 * SlideDeck List of Videos Content Source
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

<div id="content-source-listofvideos">
    <input type="hidden" name="source" value="<?php echo $slidedeck['source']; ?>" />
    <input type="hidden" name="type" value="<?php echo $this->type; ?>" />
    <div class="inner">
        <div class="add-button-wrapper">
            <?php 
        	$tooltip = __( "You can add video urls from YouTube, Vimeo, and Dailymotion", $this->namespace );
            slidedeck2_html_input( 'add-video-field', '', array( 'label' => __( "Enter URL" . '<span class="tooltip" title="' . $tooltip . '"></span>', $this->namespace ), 'attr' => array( 'size' => 40, 'maxlength' => 255 ), 'required' => true ) ); ?>
            <a class="list-of-videos-add add-button" href="#add"><?php _e( "Add", $this->namespace ); ?></a>
        </div>
    </div>
    <ul id="videos-sortable"><?php echo $urls_html; ?></ul>
    <?php include( SLIDEDECK2_DIRNAME . '/views/elements/_flyout-action-row.php' ); ?>
</div>