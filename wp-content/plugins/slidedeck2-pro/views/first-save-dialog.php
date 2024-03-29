<div class="slidedeck-header">
    <h1><?php _e( "Three Simple Ways to Publish Your SlideDeck", $namespace ); ?></h1>
</div>
<div class="wrapper">
    <div class="inner">
        
        <div id="slidedeck-publish-method-insert" class="publish-method">
            <h3>Method 1</h3>
            <p><?php _e( "Insert into existing pages or posts just like you would an image", $namespace ); ?></p>
            <div class="action">
                <img src="<?php echo SLIDEDECK2_URLPATH; ?>/images/upload-insert-screenshot.png" alt="<?php _e( "Insert SlideDeck into pages or posts", $namespace ); ?>" />
            </div>
        </div>
        
        <div id="slidedeck-publish-method-launch-new-post" class="publish-method">
            <h3>Method 2</h3>
            <p><?php _e( "Click to launch a new page or post with your new SlideDeck", $namespace ); ?></p>
            
            <div class="action">
                <a class="slidedeck-button-primary" href="<?php echo admin_url( 'admin-ajax.php?action=slidedeck_create_new_with_slidedeck&post_type=page&slidedeck=' . $slidedeck_id ); ?>"><?php _e( "New Page", $namespace ); ?></a>
                <span><?php _e( "or", $namespace ); ?></span>
                <a class="slidedeck-button-primary" href="<?php echo admin_url( 'admin-ajax.php?action=slidedeck_create_new_with_slidedeck&post_type=post&slidedeck=' . $slidedeck_id ); ?>"><?php _e( "New Post", $namespace ); ?></a>
            </div>
        </div>
        
        <div id="slidedeck-publish-method-copy-paste" class="publish-method">
            <h3>Method 3</h3>
            <p><?php _e( "Copy &amp; Paste this shortcode into your post or page", $namespace ); ?></p>
            
            <div class="action">
                <input type="text" value="[SlideDeck2 id=<?php echo $slidedeck_id; ?>]" readonly="readonly" />
                <a href="#" class="slidedeck-copy-to-clipboard"><?php _e( "Copy Shortcode to Clipboard", $namespace ); ?> <img src="<?php echo SLIDEDECK2_URLPATH; ?>/images/icon-clipboard.png" alt=""></a>
                <span class="complete-message" style="display:none;"><?php _e( "Copied Successfully!", $namespace ); ?></span>
            </div>
        </div>
        
    </div>
    
    <div id="first-save-do-not-show-again" class="inner">
        <label><input type="checkbox" value="1" />
            <?php _e( "Don't show this notification again", $namespace ); ?>
        </label>
        <a class="close" href="#close"><?php _e( "Close", $namespace ); ?></a>
    </div>
</div>