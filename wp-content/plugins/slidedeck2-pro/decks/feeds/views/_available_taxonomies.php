<?php if( !empty( $taxonomies ) ): ?>
	<ul>
	<?php foreach( $taxonomies as &$taxonomy ): ?>
	    <?php if( !empty( $taxonomy->terms ) ): ?>
	        <li class="taxonomy">
	        	<?php slidedeck2_html_input( "options[taxonomies][{$taxonomy->name}]", $slidedeck['options']['taxonomies'][$taxonomy->name], array( 'type' => 'checkbox', 'label' => $taxonomy->label . ' <span class="count">(' . count( $taxonomy->terms ) . ')</span>', 'attr' => array( 'class' => 'fancy' ) ) ); ?>
	    	</li>
	    <?php endif; ?>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>