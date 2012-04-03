<?php if ( !is_taxonomy_hierarchical( $taxonomy ) ): ?>
<div id="tagsdiv-<?php echo $taxonomy_object->name; ?>" class="postbox tagsdiv taxonomy <?php echo $taxonomy_object->name; ?>">
    <h3 class="widget-top"><?php echo $taxonomy_object->label; ?></h3>
	<div class="inside">
		<?php slidedeck2_post_tags_meta_box( null, array(
			'id' => 'tagsdiv-'.$taxonomy,
			'title' => $taxonomy_object->label,
			'callback' => 'post_tags_meta_box',
			'args' => array(
				'taxonomy' => $taxonomy,
				'tags' => implode( ',', $filtered )
			) ) );
		?>
	</div>
</div>
<?php else: ?>
<div id="categorydiv-<?php echo $taxonomy_object->name; ?>" class="postbox taxonomy <?php echo $taxonomy_object->name; ?>">
    <h3 class="widget-top"><?php echo $taxonomy_object->label; ?></h3>
	<div class="inside">
		<?php slidedeck2_post_categories_meta_box( null, array(
			'id' => $taxonomy.'div',
			'title' => $taxonomy_object->label,
			'callback' => 'post_categories_meta_box',
			'args' => array(
				'taxonomy' => $taxonomy,
				'selected_cats' => $filtered
			) ) );
	    ?>
	</div>
</div>
<?php endif; ?>
