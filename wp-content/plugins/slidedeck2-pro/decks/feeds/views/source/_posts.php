<?php
/**
 * SlideDeck Posts Content Source
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

<div id="content-source-posts">
    <input type="hidden" name="source" value="<?php echo $slidedeck['source']; ?>" />
    <input type="hidden" name="type" value="<?php echo $this->type; ?>" />
    <div class="inner">
    	<div class="left">
	        <ul class="content-source-fields">
	            <li>
	                <?php slidedeck2_html_input( 'options[post_type]', $slidedeck['options']['post_type'], array( 'type' => 'select', 'label' => __( "Post Type", $this->namespace ), 'attr' => array( 'class' => 'fancy' ), 'values' => $post_types ) ); ?>
	            </li>
	            <li>
	                <?php slidedeck2_html_input( 'options[post_type_sort]', $slidedeck['options']['post_type_sort'], array( 'type' => 'radio', 'label' => __( "Which Posts?", $this->namespace ), 'attr' => array( 'class' => 'fancy' ), 'values' => $post_type_sorts ) ); ?>
	            </li>
	            <li>
	                <?php slidedeck2_html_input( 'options[filter_by_tax]', $slidedeck['options']['filter_by_tax'], array( 'type' => 'checkbox', 'label' => __( "Filter by Taxonomy?", $this->namespace ), 'attr' => array( 'class' => 'fancy' ) ) ); ?>
	            </li>
	        </ul>
	        <div class="slidedeck-ajax-loading" style="display:none;"><?php _e( "Loading your taxonomies...", $this->namespace ); ?></div>
	        <div id="slidedeck-filters"><?php echo $this->available_filters( $slidedeck['options']['post_type'], $slidedeck ); ?></div>
    	</div>
        <div class="right" style="<?php echo ( $slidedeck['options']['filter_by_tax'] == '1' ) ? '' : 'display:none'; ?>">
            <div class="trailblazer" style="display:none;">
                <p><?php _e( "Toggle one or more taxonomies in the left column to see the selection boxes appear here.", $this->namespace ); ?></p>
            </div>
            <div id="any-or-all-taxonomies" style="display:none;"><?php slidedeck2_html_input( "options[query_any_all]", $slidedeck['options']['query_any_all'], $this->options_model['Setup']['query_any_all'] ); ?></div>
	        <div id="poststuff">
		        <div id="slidedeck-terms">
		        	<?php 
		        		// Loop through the selected taxonomies and output the current terms.
		        		foreach( (array) $slidedeck['options']['taxonomies'] as $taxonomy => $value ){
				        	echo $this->available_terms( $slidedeck['options']['post_type'], $slidedeck, $taxonomy );
		        		}
		        	?>
		    	</div>
	        </div>
            <div class="slidedeck-ajax-loading" style="display:none;"><?php _e( "Loading terms chooser...", $this->namespace ); ?></div>
        </div>
    </div>
    <?php include( SLIDEDECK2_DIRNAME . '/views/elements/_flyout-action-row.php' ); ?>
</div>


