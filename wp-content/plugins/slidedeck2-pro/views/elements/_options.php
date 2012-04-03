<div id="slidedeck-options-groups">
    <dl class="slidedeck">
        <dd>
            <dl class="slidesVertical clerafix">
            	
            	<dt><?php _e( "Setup", $namespace ); ?></dt>
            	<dd class="clearfix options-group-setup">

                    <ul class="options-list">
                        
                        <li id="slidedeck-sizes">
                            <span class="label"><?php _e( $options_model['Setup']['size']['label'], $namespace ); ?> <span class="tooltip" title="<?php _e( $options_model['Setup']['size']['description'], $namespace ); ?>"></span></span>
							<?php
							    $custom_size = $sizes['custom'];
							    unset( $sizes['custom'] );
							    $sizes['custom'] = $custom_size;
							    $inc = 1;
							    
							    foreach( $sizes as $value => $size ):
							?>
							    <label<?php if( $inc++ == ( count( $sizes ) - 1 ) ) echo ' class="last-fixed-size"'; ?>>
							        <input type="radio" name="options[size]" value="<?php echo $value; ?>" class="fancy"<?php if( $slidedeck['options']['size'] == $value ) echo ' checked="checked"'; ?> />
							        <?php echo $size['label']; ?>
							        <?php if( $value != "custom" ): ?><em><?php echo "{$size['width']}x{$size['height']}"; ?></em><?php endif; ?>
							    </label>
							<?php endforeach; ?>
							
							<span id="slidedeck-custom-dimensions"<?php if( $slidedeck['options']['size'] == "custom" ) echo ' class="selected"'; ?>>
							    <label><input type="text" name="options[width]" value="<?php echo $slidedeck['options']['width']; ?>" size="5" /> px</label> x 
							    <label><input type="text" name="options[height]" value="<?php echo $slidedeck['options']['height']; ?>" size="5" /> px</label>
							</span>
                        </li>
                        <li<?php if( $options_model['Setup']['total_slides']['type'] == "hidden" ) echo ' style="display:none;"'; ?>>
                            <?php slidedeck2_html_input( "options[total_slides]", $slidedeck['options']['total_slides'], $options_model['Setup']['total_slides'] ); ?>
                        </li>
                        <li id="slidedeck-covers">
                            <label class="label"><?php _e( "Covers", $namespace ); ?> <span class="tooltip" title="<?php _e( "Covers let you add a title slide to your SlideDeck, and add a call-to-action to the last slide.", $namespace ); ?>"></span></label>
                            <?php _e( "Front Cover:", $namespace ); ?> 
                            <input type="checkbox" name="options[show-front-cover]" class="fancy" value="1"<?php if( $slidedeck['options']['show-front-cover'] ) echo ' checked="checked"'; ?>" />
                            <?php _e( "Back Cover:", $namespace ); ?> 
                            <input type="checkbox" name="options[show-back-cover]" class="fancy" value="1"<?php if( $slidedeck['options']['show-back-cover'] ) echo ' checked="checked"'; ?>" />
                            <a href="<?php echo admin_url( wp_nonce_url( 'admin-ajax.php?action=slidedeck_covers_modal&slidedeck=' . $slidedeck['id'], 'slidedeck-cover-modal' ) ); ?>" id="slidedeck-covers-modal-link" class="button"><?php _e( "Edit", $namespace ); ?></a>
                        </li>
                        <li>
                            <?php
                                $overlay = $this->SlideDeck->options_model['Setup']['overlays'];
                                $overlay['attr']['class'] = "fancy";
                                slidedeck2_html_input( 'options[overlays]', $slidedeck['options']['overlays'], $overlay );
                            ?>
                        </li>
                        
                        <?php do_action( "{$namespace}_setup_options_bottom", $slidedeck ); ?>
                        
                    </ul>
            		
            	</dd>
            	
                <?php
                	$hidden_options = "";
                	for( $i = 0; $i < count( $options_groups ); $i++ ):
            	?>
                    
                    <?php
                		$all_options_hidden = true;
                    	foreach( $options_model[$options_groups[$i]] as $name => $option ) {
                    		if( array_key_exists( 'type', $option ) ) {
                    			if( $option['type'] != 'hidden' )
									$all_options_hidden = false;
                    		} else {
                    			foreach( $option as $sub_name => $sub_option ) {
	                    			if( $sub_option['type'] != 'hidden' )
										$all_options_hidden = false;
                    			}
                    		}
                    	}
					?>
                    
                    <?php if( !$all_options_hidden ): ?>
	                    <dt><?php echo $options_groups[$i]; ?></dt>
	                    <dd class="clearfix">
	                        
	                        <ul class="options-list">
                	<?php endif; ?>
            	
                        <?php
                            foreach( $options_model[$options_groups[$i]] as $name => $option ) {
                                $is_hidden = false;
                                if( array_key_exists( 'type', $option ) )
                                    if( $option['type'] == "hidden" )
                                        $is_hidden = true;
                                
                                $html = "";
                                
                                if( $is_hidden !== true )
                                    $html .= "<li>";
								
								$input_html = "";
								
                                if( array_key_exists( 'type', $option ) ) {
                                    if( !isset( $option['interface'] ) || empty( $option['interface'] ) ) {
                                        // Create attr property if it doesn't exist
                                        if( !isset( $option['attr'] ) ) $option['attr'] = array( 'class' => "" );
                                        // Create class attribute if it doesn't exist
                                        if( !isset( $option['attr']['class'] ) ) $option['attr']['class'] = "";
                                        $option['attr']['class'].= " fancy";
                                    }
                                    $input_html.= slidedeck2_html_input( "options[$name]", $slidedeck['options'][$name], $option, false );
                                } else {
                                    foreach( $option as $sub_name => $sub_option ) {
                                        if( !isset( $sub_option['interface'] ) || empty( $sub_option['interface'] ) ) {
                                            // Create attr property if it doesn't exist
                                            if( !isset( $sub_option['attr'] ) ) $sub_option['attr'] = array( 'class' => "" );
                                            // Create class attribute if it doesn't exist
                                            if( !isset( $sub_option['attr']['class'] ) ) $sub_option['attr']['class'] = "";
                                            $sub_option['attr']['class'].= " fancy";
                                        }
                                        $input_html.= slidedeck2_html_input( 'options[' . $name . '][' . $sub_name . ']', $slidedeck['options'][$name][$sub_name], $sub_option, false );
                                    }
                                }
								
								if( array_key_exists( 'type', $option ) && $option['type'] == 'hidden' )
									$hidden_options .= $input_html;
								else
									$html .= $input_html; 
								
                                if( $is_hidden !== true )
                                    $html .= "</li>";
                                
                            	echo $html;
                            }
                        ?>
                        
                    <?php if( !$all_options_hidden ): ?>
	                        </ul>
	                        
	                    </dd>
                    <?php endif; ?>
                        
                <?php endfor; ?>
            </dl>
        </dd>
    </dl>
    <?php echo $hidden_options; ?>
</div>
