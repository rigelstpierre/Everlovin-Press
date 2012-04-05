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
				<section class="featured-content">
					<div class="smallbox blue">
						<img src="<?php bloginfo('template_directory'); ?>/images/featured-content/ken-jan.jpg" alt="" />
					</div>
					<a class="texture-1" href="#"><h2>amanda &amp; tom’s wedding invitations</h2></a>

					<div class="smallbox white">
						<img src="<?php bloginfo('template_directory'); ?>/images/featured-content/everlovin.jpg" alt="" />
					</div>
					<a class="texture-3" href="#"><h2>Everlovin’ gets a new identity</h2></a>
					
					<a class="largebox orange" href="#"><h2>Everlovin’ gets a new identity</h2></a>

					<div class="smallbox white">
						<img src="<?php bloginfo('template_directory'); ?>/images/featured-content/exavier.jpg" alt="" />
					</div>
					<a class="texture-3" href="#"><h2>Xavier &amp; phillpe wedding invitations</h2></a>
				</section>
				
			</div><!-- end container -->
		</div><!-- end main -->
<?php get_footer(); ?>

