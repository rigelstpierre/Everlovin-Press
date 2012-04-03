<?php if( !empty( $slidedecks ) ): ?>
<div class="inner">
    <ul>
    <?php foreach( (array) $slidedecks as $slidedeck ): ?>
        <li class="slidedeck-row<?php if( $slidedeck == end( $slidedecks ) ) echo ' last '; ?>">
            <?php slidedeck2_icon( $slidedeck ); ?>
            <a href="<?php echo slidedeck2_action( "&action=edit&slidedeck={$slidedeck['id']}" ); ?>" class="slidedeck-title">
                <?php echo $slidedeck['title']; ?>
                <span class="slidedeck-modified">Modified <?php echo date( "m-d-Y", strtotime( $slidedeck['updated_at'] ) + ( get_option( 'gmt_offset' ) * 3600 ) ); ?></span>
            </a>
            <div class="slidedeck-actions">
                <div class="slidedeck-delete tooltip" title="<?php _e( "Delete", $namespace ); ?>">
                    <form action="" method="post" class="delete-slidedeck">
                        <?php wp_nonce_field( "{$namespace}-delete-slidedeck" ); ?>
                        <input type="hidden" name="slidedeck" value="<?php echo $slidedeck['id']; ?>" />
                        <input type="submit" value="Delete" class="delete-slidedeck" />
                    </form>
                </div>
                <div class="slidedeck-preview tooltip" title="<?php _e( "Preview", $namespace ); ?>">
                    <a class="slidedeck-preview-link" href="<?php echo $this->get_iframe_url( $slidedeck['id'] ); ?>" data-for="slidedeck-preview-<?php echo $slidedeck['id']; ?>">Preview</a>
                </div>
                <div class="slidedeck-getcode tooltip" title="<?php _e( "Use This SlideDeck", $namespace ); ?>">
                    <a class="slidedeck-getcode-link" href="<?php echo admin_url( "admin-ajax.php?action={$namespace}_getcode_dialog&slidedeck={$slidedeck['id']}" ); ?>">Get Code</a>
                </div>
                <span class="slidedeck-id">id: <?php echo $slidedeck['id']; ?></span>
            </div>
        </li>
        <div class="slidedeck-preview-wrapper">
            <iframe src="" frameborder="0" id="slidedeck-preview-<?php echo $slidedeck['id']; ?>"></iframe>
        </div>
    <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
<div id="no-decks-placeholder"<?php echo ( !empty( $slidedecks ) ) ? ' style="display:none;"' : ''; ?>>
    <h4><?php _e( "Currently, you have", $namespace ); ?></h4>
    <div id="zero-slidedecks-created"><img src="<?php echo SLIDEDECK2_URLPATH; ?>/images/zero-slidedecks-created.png" alt="<?php _e( "Zero SlideDecks Created", $namespace ); ?>" /></div>
    <h4 class="categories prompt"<?php echo ( $default_view == 'sources' ) ? ' style="display:none;"' : ''; ?>><?php _e( "Let's fix that. Choose a deck type from above to start.", $namespace ); ?></h4>
    <h4 class="sources prompt"<?php echo ( $default_view == 'decks' ) ? ' style="display:none;"' : ''; ?>><?php _e( "Let's fix that. Choose a content source from above to start.", $namespace ); ?></h4>
</div>