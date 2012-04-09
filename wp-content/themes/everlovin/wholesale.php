<?php
/*
Template Name: Wholesale Ordering
*/
?>
<?php get_header(); ?>
	<div id="main">
		<div class="wholesale-ordering">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="container">
				<?php
					wp_nav_menu( array( 'container' => 'nav', 'container_id' => 'services-white', 'theme_location' => 'hire' ) );
				?>
			</div>
			<section>
				<h3>calling all retailers<br />of finely-crafted goods</h3>
				<h2>We’d love to talk</h2>
				<img src="<?php the_field('top_image'); ?>" alt="" />
				<?php the_content(); ?>
				<h2>our partners</h2>
				<ul class="canada">
					<li>Canada</li>
					<li><a href="#">Aenean leo ligula</a></li>
					<li><a href="#">Fend ac, enim. Aliquam</a></li> 
					<li><a href="#">Aenean leo ligula</a></li>
					<li><a href="#">Porttitor eu, consequat</a></li>
					<li><a href="#">Vitae, elei</a></li>
					<li><a href="#">Aenean leo ligula</a></li>
					<li><a href="#">Porttitor eu, consequat</a></li>
				</ul>
				<ul>
					<li>USA</li>
					<li><a href="#">Aenean leo ligula</a></li>
					<li><a href="#">Aenean leo ligula lorem portiotr</a></li> 
					<br />
					<li>Worldwide</li>
					<li><a href="#">Aenean leo ligula</a></li>
					<li><a href="#">Aenean leo ligula</a></li>
					<li><a href="#">lorem portiotr</a></li>

				</ul>
				<div style="clear: both;"></div>
			</section>
		</div>
		<?php endwhile; endif; ?>
	</div><!-- end main -->
<?php get_footer(); ?>