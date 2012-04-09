<?php
/*
Template Name: See The Work
*/
?>
<?php get_header(); ?>
	<div id="main">
		<div class="container">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<section class="see-work-top">
				<p><?php the_content(); ?></p>
				<?php
					wp_nav_menu( array( 'container' => 'nav', 'container_id' => 'work', 'theme_location' => 'work' ) );
				?>
			</section>
			<?php endwhile; endif; ?>
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
					<a class="texture-1" href="<? the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
		        <?php endwhile; wp_reset_postdata(); ?>
			</section>
			
		</div><!-- end container -->
	</div><!-- end main -->
<?php get_footer(); ?>