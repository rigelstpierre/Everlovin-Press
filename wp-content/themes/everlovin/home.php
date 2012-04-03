<?php
/*
Template Name: Home
*/
?>
<?php get_header(); ?>
	<section class="slider">
		<div class="container">
			<img src="<?php bloginfo('template_directory'); ?>/images/slider-holder.png" />
		</div>
	</section>
	<div id="main">
		<div class="container">
			<section class="featured-content">
				<div class="smallbox blue">
					<img src="<?php bloginfo('template_directory'); ?>/images/featured-content/ken-jan.jpg" alt="" />
				</div>
				<a class="texture-1" href="#"><h2>amanda &amp; tom’s wedding invitations</h2></a>

				<div class="smallbox orange">
					<img src="<?php bloginfo('template_directory'); ?>/images/featured-content/everlovin.jpg" alt="" />
				</div>
				<a class="texture-2" href="#"><h2>Everlovin’ gets a new identity</h2></a>
				
				<a class="largebox orange" href="#"><h2>Everlovin’ gets a new identity</h2></a>

				<div class="smallbox white">
					<img src="<?php bloginfo('template_directory'); ?>/images/featured-content/exavier.jpg" alt="" />
				</div>
				<a class="texture-3" href="#"><h2>Xavier &amp; phillpe wedding invitations</h2></a>
				
			</section>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<section class="about">
				<h2>About Us</h2>
				<p><?php the_content(); ?></p>
			</section>
			<?php endwhile; endif; ?>
			<section class="contact">
				<p><strong>contact</strong> (613) 555-5555  <a href="mailto:vince@everlovinpress.ca">vince@everlovinpress.ca</a> 14 cataraqui street, kingston, ontario, canada  K0K OKO</p>
			</section>
			<section class="social">
				<h2>introverts are social too</h2>
				<div class="dribbble">
					<h3>dribbble</h3>
					<div id="dribbble"></div>
				</div>
				<div class="twitter-box">
					<h3>twitter</h3>
					<div id="twitter" class="tweet"></div>
				</div>
			</section>
			<section class="furthermore">
				<h2>and furthermore…</h2>
			</section>
		</div><!-- end container -->
	</div><!-- end main -->
<?php get_footer(); ?>