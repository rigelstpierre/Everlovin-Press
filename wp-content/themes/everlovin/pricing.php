<?php
/*
Template Name: Pricing and FAQ
*/
?>
<?php get_header(); ?>
	<div id="main">
		<div class="pricing-faq">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="container">
				<?php
					wp_nav_menu( array( 'container' => 'nav', 'container_id' => 'services', 'theme_location' => 'hire' ) );
				?>
			</div>
			<section>
				<h3>let’s talk shop</h3>
				<h2>how do we price our services?</h2>
				<?php the_content(); ?>
				<h2>frequently asked quetsions</h2>
				<?php $the_query = new WP_Query( array('post_type' => array('faq'),'showposts' => '5' ));
		          while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		          <article>
		          	<h5><?php the_title(); ?></h5>
		          	<p><?php the_content(); ?></p>
		          </article>
		        <?php endwhile; wp_reset_postdata(); ?>
			</section>
		</div>
		<?php endwhile; endif; ?>
	</div><!-- end main -->
<?php get_footer(); ?>