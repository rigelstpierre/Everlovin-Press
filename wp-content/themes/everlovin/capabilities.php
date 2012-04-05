<?php
/*
Template Name: Capabilities
*/
?>
<?php get_header(); ?>
	<div id="main">
		<div class="capabilities">
			<div class="container">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php
					wp_nav_menu( array( 'container' => 'nav', 'container_id' => 'services', 'theme_location' => 'hire' ) );
				?>
				<section class="what-we-do">
					<h3>what we do <br />and how we do it</h3>
					<h2>our process: slow and steady</h2>
					<?php the_content(); ?>
					<section class="capabilities-list">
						<h2>capabilities</h2>
						<br />
						<br />
						<h4>letterpress</h4>
						<p><?php the_field('letterpress_content'); ?></p>
						<br />
						<h4>bindery</h4>
						<p><?php the_field('bindery_content'); ?></p>
						<br />
						<h4>Foil-stamping</h4>
						<p><?php the_field('foil-stamping_content'); ?></p>
						<br />
						<h4>embossing</h4>
						<p><?php the_field('embossing_content'); ?></p>
					</section>
				</section>
			</div>
		<?php endwhile; endif; ?>
		</div>
	</div><!-- end main -->
<?php get_footer(); ?>