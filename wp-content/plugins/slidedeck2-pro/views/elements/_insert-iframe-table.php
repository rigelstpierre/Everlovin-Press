<table cellpadding="0" cellspacing="0" class="slidedeck-row">
    <tbody>
        
        <?php foreach( $slidedecks as &$slidedeck ): ?>
            <tr class="<?php if( in_array( $slidedeck['id'], $selected ) ) echo ' selected'; ?><?php if( $slidedeck == end( $slidedecks ) ) echo ' last'; ?>">
                <td class="col-1 col-slidedeck-type">
                    <?php slidedeck2_icon( $slidedeck ); ?>
                </td>
                <td class="col-2 col-slidedeck-title">
                    <span class="slidedeck-title">
                        <input type="checkbox" name="slidedecks[]" class="slidedecks-insert" value="<?php echo $slidedeck['id']; ?>"<?php if( in_array( $slidedeck['id'], $selected ) ) echo ' checked="checked"'; ?> />
                        <?php echo $slidedeck['title']; ?>
                        <span class="slidedeck-id">(<?php echo $slidedeck['id']; ?>)</span>
                    </span>
                </td>
                <td class="col-3 col-slidedeck-created">
                    <span class="slidedeck-created">Created <?php echo date( "M d, Y", strtotime( $slidedeck['created_at'] ) + ( get_option( 'gmt_offset' ) * 3600 ) ); ?></span>
                </td>
            </tr>
        <?php endforeach; ?>
        
    </tbody>
</table>