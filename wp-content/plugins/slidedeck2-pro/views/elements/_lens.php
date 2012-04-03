<?php
/**
 * SlideDeck Lens Management Page Lens Entry
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
<div class="lens">
    
    <div class="inner">
	    
	    <?php if( !$lens['is_protected'] ): ?>
	        <a href="<?php echo slidedeck2_action( "/lenses&action=edit&slidedeck-lens={$lens['slug']}" ); ?>" class="thumbnail">
	    <?php else: ?>
	        <span class="thumbnail">
	    <?php endif; ?>
	    
	        <span class="thumbnail-inner" style="background-image:url(<?php echo $lens['thumbnail-large']; ?>);"></span>
	        
	    <?php if( !$lens['is_protected'] ): ?>
	        </a>
	    <?php else: ?>
	        </span>
	    <?php endif; ?>
	    
	    <h4><?php echo $lens['meta']['name']; ?></h4>
	    
	    <p class="author">
	    	<?php echo get_avatar( $lens['meta']['author'], 15 ); ?>
	        <?php if( !empty( $lens['meta']['author_uri'] ) ): ?>
	            <a href="<?php echo $lens['meta']['author_uri']; ?>" target="_blank">
	        <?php endif; ?>
	        <?php echo $lens['meta']['author']; ?>
	        <?php if( !empty( $lens['meta']['author_uri'] ) ): ?>
	            </a>
	        <?php endif; ?>
	    </p>
	    
	    <div class="content-sources"><strong>Content Source(s):</strong>
	    	<?php foreach( $lens['meta']['sources'] as $source ): ?>
	    		<img src="<?php echo SLIDEDECK2_URLPATH . $sources[$source]['chicklet']; ?>" class="source" alt="<?php echo $sources[$source]['label']; ?>" />
			<?php endforeach; ?>
	    </div>
	    
	    <?php if( !empty( $lens['meta']['variations'] ) ): ?>
	        <p class="variations"><strong>Variations:</strong>
	            <?php
	                $sep = "";
	                foreach( $lens['meta']['variations'] as $variation ):
	            ?>
	                <?php
	                    echo $sep . '<span class="variation">' . ucwords( str_replace( "-", " ", $variation ) ) . '</span>';
	                    $sep = ", ";
	                ?>
	            <?php endforeach; ?>
	        </p>
	    <?php endif; ?>
    
    </div>
        
    <div class="actions<?php if( $is_writable->valid !== true ) echo ' disabled' ?>">
        <form action="" method="post">
            <a href="<?php echo slidedeck2_action( "/lenses" ); ?>&action=copy&lens=<?php echo $lens['slug']; ?>" class="copy-lens"><?php _e( "Copy", $namespace ); ?></a>
            
            <?php if( !$lens['is_protected'] ): ?>
                
                <a href="<?php echo slidedeck2_action( "/lenses&action=edit&slidedeck-lens={$lens['slug']}" ); ?>" class="edit-lens"><?php _e( "Edit", $namespace ); ?></a>
            
            	<?php wp_nonce_field( "{$namespace}-delete-lens" ); ?>
            	<input type="hidden" name="lens" value="<?php echo $lens['slug']; ?>" />
            	<input type="submit" value="<?php _e( 'Delete', $namespace ); ?>" class="delete-lens" />
            
            <?php endif; ?>
        </form>
    </div>
           
</div>