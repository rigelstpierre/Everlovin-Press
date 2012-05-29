<?php get_header(); ?>
	<div id="main">
			<div class="container">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<section class="single">
					<aside>
						<span class="prev"><?php next_post('%', 'Next', 'no'); ?></span>
						<div><?php echo get_post_type( $post->ID ); ?></div>
						<span class="next"><?php previous_post('%','Previous', 'no'); ?></span>
						<h3><?php the_title(); ?></h3>
						<h2>the low-down</h2>
						<p><?php the_field('low_down'); ?></p>
						<h2><?php the_field('optional_title'); ?></h2>
						<p><?php the_field('optional_content'); ?></p>
						<h2>be generous</h2>
						<div id="tweet-button">
						  <a href="https://twitter.com/share?url=<?php the_permalink(); ?>" target="_blank">Tweet</a>
						</div>
						<a href="<?php the_permalink(); ?>" id="facebook-button"></a>
						<a href="<?php the_permalink(); ?>" class="pin-it-button" count-layout="none"></a>
					</aside>
					<?php the_content(); ?>
				</section>
				<section class="work">
				<?php $the_query = new WP_Query( array('post_type' => array('customwork'),'showposts' => '1' ));
		          while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		        	<div class="smallbox blue">
						<? the_post_thumbnail(); ?>
					</div>
					<a class="texture-1" href="<? the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
		        <?php endwhile; wp_reset_postdata(); ?>
				
				<?php $the_query = new WP_Query( array('post_type' => array('customwork'),'showposts' => '1', 'offset' => '1' ));
		          while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					<div class="smallbox white">
						<? the_post_thumbnail(); ?>
					</div>
					<a class="texture-3" href="<? the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
		        <?php endwhile; wp_reset_postdata(); ?>
				
				<?php $the_query = new WP_Query( array('post_type' => array('customwork'),'showposts' => '1', 'offset' => '2' ));
		          while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		            <div class="smallbox orange">
						<?php the_post_thumbnail(); ?>
					</div>
					<a class="texture-2" href="<? the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
		        <?php endwhile; wp_reset_postdata(); ?>
		       
		        <?php $the_query = new WP_Query( array('post_type' => array('customwork'),'showposts' => '1', 'offset' => '3' ));
		          while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		           	<div class="smallbox blue">
						<? the_post_thumbnail(); ?>
					</div>
					<a class="texture-4" href="<? the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
		        <?php endwhile; wp_reset_postdata(); ?>
			</section>
				<?php endwhile; endif; ?>
			</div><!-- end container -->
		</div><!-- end main -->
<?php get_footer(); ?>

