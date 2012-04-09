<?php
/*
Template Name: Hire the Press Man
*/
?>
<?php get_header(); ?>
	<div id="main">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="container hirethepressman">
			<p><?php the_field('top_text'); ?></p>
			<section class="services">
				<h2>old-fashioned service with can-do spirit!</h2>
				<a href="<?php bloginfo('url'); ?>/hire-the-press-man/custom-quotes"><div class="blue">
					<h3>Custom<br />quotes</h3>
				</div></a>
				<a href="<?php bloginfo('url'); ?>/hire-the-press-man/pricing-guidelines-and-faq/"><div class="orange">
					<h3>pricing<br/>guidelines<br />&amp; FAQ</h3>
				</div></a>
				<a href="<?php bloginfo('url'); ?>/hire-the-press-man/wholesale-ordering/"><div class="white"> 
					<h3>wholesale<br />ordering</h3>
				</div></a>
				<a href="<?php bloginfo('url'); ?>/hire-the-press-man/capabilities-and-process/"><div class="black">
					<h3>capabilities<br />&amp;<br />process</h3>
				</div></a>
			</section>
			<section class="products-services">
				<h2>products &amp; services</h2>
				<ul>
					<li>Business Cards</li>
					<li>Stationery</li>
					<li>Invitations</li>
					<li>Posters</li>
					<li>Limited Edition Prints</li>
				</ul>
				<ul>
					<li>Print Design</li>
					<li>Typesetting</li>
					<li>Illustration</li>
					<li>Greeting Cards</li>
					<li>Speciality Books</li>
				</ul>
				<ul>
					<li>Specialty Die Cuts</li>
					<li>Perforations</li>
					<li>Folding & Assembly</li>
					<li>Foil Stamping</li>
					<li>Engraving Loreom</li>
				</ul>
			</section>
			<section class="unusual">
				<h2>Have an unusual job?</h2>
				<p><?php the_content(); ?></p>
			</section>
		</div>
		<?php endwhile; endif; ?>
	</div><!-- end main -->
<?php get_footer(); ?>