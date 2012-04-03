<?php
/**
 * Overview list of SlideDecks
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
<div class="slidedeck-wrapper">
    <div class="wrap" id="slidedeck-overview">
        <?php if( isset( $_GET['msg_deleted'] ) ): ?>
            <div id="slidedeck-flash-message" class="updated" style="max-width:964px;"><p><?php _e( "SlideDeck successfully deleted!", $namespace ); ?></p></div>
            <script type="text/javascript">(function($){if(typeof($)!="undefined"){$(document).ready(function(){setTimeout(function(){$("#slidedeck-flash-message").fadeOut("slow");},5000);});}})(jQuery);</script>
        <?php endif; ?>
        
        <div class="slidedeck-header">
            <h1><?php _e( "Manage SlideDecks", $namespace ); ?></h1>
        </div>
    	
    	<div id="slidedeck-types">
        	<h3><?php _e( "Create a new SlideDeck", $namespace ); ?></h3>
        	
		    <span class="toggles">
		        <a href="#decks" class="toggle toggle-decks<?php if( $default_view == 'decks' ) echo ' selected'; ?>"><?php _e( "Decks", $namespace ); ?></a><a href="#sources" class="toggle toggle-sources<?php if( $default_view == 'sources' ) echo ' selected'; ?>"><?php _e( "Sources", $namespace ); ?></a>
		    </span>
        	
        	<dl class="slidedeck" id="create-buttons-slidedeck">
        	    <dt>Deck Types</dt>
        	    <dd>
                	<?php if( !empty( $decks ) ): ?>
                	    
                	    <div class="decks">
                    	    
                    	    <?php foreach( (array) $sources_by_taxonomies as $taxonomy => $sources ): ?>
                    	        
                    	        <?php
                    	            if( count( $sources ) == 1 ) {
                    	                $create_url = slidedeck2_action( "&action=create&source=" . reset( array_keys( $sources ) ) );
                    	            } else {
                                        $create_url = wp_nonce_url( admin_url( "admin-ajax.php?action=slidedeck_source_modal&taxonomy={$taxonomy}" ), 'slidedeck-source-modal' );
                    	            }
                    	        ?>
                                <span id="deck-type-<?php echo $taxonomy; ?>" class="deck">
                                    <a href="<?php echo $create_url; ?>"<?php if( strpos( $create_url, 'admin-ajax.php' ) !== false ) echo ' class="slidedeck-source-modal"'; ?>>
                                        <span class="icon"><img src="<?php echo SLIDEDECK2_URLPATH . $taxonomies[$taxonomy]['thumbnail']; ?>" alt="<?php echo $taxonomies[$taxonomy]['label']; ?>" /></span>
                                        <span class="shadow"></span>
                                        <span class="label"><?php echo $taxonomies[$taxonomy]['label']; ?></span>
                                        <span class="glow"></span>
                                    </a>
                                </span>
                    	        
                	        <?php endforeach; ?>
                    	        
                	    </div>
                	    
            	    <?php endif; ?>
        	    </dd>
        	    
        	    <dt>Sources</dt>
        	    <dd>
                    <?php if( !empty( $sources ) ): ?>
                        
                        <div class="sources clearfix">
                            
                            <?php $count = 0; ?>
                            <?php foreach( $all_sources as $source): ?>
                                
                                <?php if( $count%4 == 0 ) echo '<div>'; ?>
                                
                                <a href="<?php echo slidedeck2_action( "&action=create&source=" . $source['name'] ); ?>" class="source">
                                    <img src="<?php echo SLIDEDECK2_URLPATH . $source['icon']; ?>" alt="<?php echo $source['label']; ?>" />
                                    <span class="label"><?php echo $source['label']; ?></span>
                                </a>
                                
                                <?php if( $count%4 == 3 ) echo '</div>'; $count++; ?>
                                
                            <?php endforeach; ?>
                            
                        </div>
                        
                    <?php endif; ?>
        	    </dd>
        	</dl>
        	
    	</div>
	    
	    <div id="slidedeck-table">
	        <?php if( !empty( $slidedecks ) ): ?>
    	        <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" id="slidedeck-table-sort">
    	            <fieldset>
        	            <input type="hidden" value="<?php echo $namespace; ?>_sort_manage_table" name="action" />
        	            <?php wp_nonce_field( "slidedeck-sort-manage-table" ); ?>
        	            
        	            <label for="slidedeck-table-sort-select"><?php _e( "Sort By:", $namespace ); ?></label> 
        	            <select name="orderby" id="slidedeck-table-sort-select" class="fancy">
        	                <?php foreach( $order_options as $value => $label ): ?>
        	                    <option value="<?php echo $value; ?>"<?php if( $value == $orderby ) echo ' selected="selected"'; ?>><?php _e( $label, $namespace ); ?></option>
                            <?php endforeach; ?>
        	            </select>
    	            </fieldset>
    	        </form>
	        <?php endif; ?>
	        
	        <div class="float-wrapper">
    	        <div class="left">
                	<?php include( SLIDEDECK2_DIRNAME . '/views/elements/_manage-table.php' ); ?>
    	        </div>
    	        <div class="right">
    	            <div class="right-inner">
        	            <div id="manage-iab" class="iab">
        	                <iframe height="100%" frameborder="0" scrolling="no" width="100%" allowtransparency="true" src="//www.slidedeck.com/wordpress-plugin-iab/"></iframe>
        	            </div>
        	            <div class="right-column-module">
            	            <h4><?php _e( "Have questions?", $this->namespace ); ?></h4>
            	            <p><?php _e( "See if there are any solutions in our support section.", $this->namespace ); ?></p>
            	            <a href="<?php admin_url( 'admin.php' ); ?>?page=slidedeck2.php/feedback" class="button slidedeck-noisy-button" target="_blank"><span><?php _e( "Get Support" , $this->namespace ); ?></span></a>
        	            </div>
    	            </div>
    	        </div>
	        </div>
	    </div>
	    
	    <div id="slidedeck-manage-footer">
	        <div class="float-wrapper">
	            <div class="left">
	                <?php // TODO: Remove width: 100%; ?>
	                <div class="leftLeft" style="width: 100%;">
                        <div class="module news">
                            <h3><?php _e( "News and Updates", $this->namespace ); ?></h3>
                            <div id="slidedeck-blog-rss-feed">
                                <span class="loading"><?php _e( "Fetching RSS Feeds...", $this->namespace ) ?></span>
                            </div>
                        </div>
	                </div>
	                <?php // TODO: Remove display:none; ?>
	                <div class="leftRight" style="display:none;">
                        <div class="module resources">
                            <h3><?php _e( "Resource Center", $this->namespace ); ?></h3>
                            <ul>
                                <li>
                                    <div class="icon screencast"></div>
                                    <a href="#">Create an image gallery with Instagram</a>
                                </li>
                                <li>
                                    <div class="icon document"></div>
                                    <a href="#">How to change your background color using CSS</a>
                                </li>
                                <li>
                                    <div class="icon screencast"></div>
                                    <a href="#">Create a video slider from a YouTube playlist</a>
                                </li>
                            </ul>
                        </div>
	                </div>
	            </div>
	            <div class="right">
	                <div class="module slidedeck tweets">
	                    <h3><?php _e( "Latest Tweets", $this->namespace ); ?></h3>
	                    <div id="slidedeck-latest-tweets">
                            <span class="loading"><?php _e( "Fetching Latest Tweets...", $this->namespace ) ?></span>
	                    </div>
	                </div>
	            </div>
	        </div>
	        <div id="dt-footer-logo">
                <span id="a-product-of"><?php _e( "A product of", $this->namespace ); ?></span>
                <a href="http://www.dtelepathy.com" target="_blank"><img border="0" class="logo" src="<?php echo SLIDEDECK2_URLPATH; ?>/images/dt-logo.png" alt="<?php _e( "digital-telepathy", $this->namespace ); ?>" /></a>
                <p>
                    <a href="http://www.dtelepathy.com" target="_blank"><span id="orange-tag"><?php _e( "UX Design Studio", $this->namespace ); ?></span></a>
                </p>
	        </div>
	    </div>
    	
    </div>
</div>
<script type="text/javascript">
    ZeroClipboard.setMoviePath('<?php echo SLIDEDECK2_URLPATH; ?>/js/zeroclipboard/ZeroClipboard10.swf');
</script>