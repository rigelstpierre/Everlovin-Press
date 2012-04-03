<?php
/*
Template Name: Meet & Greet
*/
?>
<?php get_header(); ?>
	<div id="main">
		<div class="container">
			<section class="meet-greet-welcome">
				<div><img src="<?php bloginfo('template_directory'); ?>/images/come-on-in.png" alt="" align="" /></div>
				<h2>OPEN</h2>
			</section>
			<section class="reach-us">
				<h2>How to reach us</h2>
				<div>
					<p>walk<span>14 Cataraqui Street<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kingston, Ontario, Canada</span></p>
					<p>TALK<span>(613) 876-5927</span></p>
				</div>
				<ul>
					<li>WRITE<a href="mailto:vince@everlovinpress.com">vince@everlovinpress.com</a></li>
					<li>tweet<a href="http://twitter.com/everlovinpress">@everlovinpress</a></li>
					<li>PEEk&nbsp;&nbsp;<a href="http://dribbble.com/everlovin">Dribbble</a></li>
				</ul>
			</section>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<section class="meet-the-press-man">
				<h2>Meet the press man</h2>
				<div>
					<img src="<?php bloginfo('template_directory'); ?>/images/vince.jpg" alt="" />
					<aside>
						<h3>Vincent Perez</h3>
						<h4>sole proprietor & pressman</h4>
						<p><?php the_content(); ?></p>
					</aside>
				</div>
			</section>
			<?php endwhile; endif; ?>
			<section class="peek">
				<h2>Peek inside the press shop</h2>
				<img src="<?php bloginfo('template_directory'); ?>/images/peek/first-impressions.jpg" alt="" style="border: 1px solid #000;" />
				<img src="<?php bloginfo('template_directory'); ?>/images/peek/first-proof.jpg" alt="" />
				<img src="<?php bloginfo('template_directory'); ?>/images/peek/sweating.jpg" alt="" />
			</section>
			<section class="friends">
				<h2>we love our friends</h2>
				<ul>
					<li><a href="#">Lowercase Reading Room</a></li>
					<li><a href="#">Lowercase Reading Room</a></li>
					<li><a href="#">Lowercase Reading Room</a></li>
					<li><a href="#">Old Faithful Shop</a></li>
					<li><a href="#">Old Faithful Shop</a></li>
					<li><a href="#">Old Faithful Shop</a></li>
					<li><a href="#">The Dawson Printshop</a></li>
					<li><a href="#">The Dawson Printshop</a></li>
					<li><a href="#">The Dawson Printshop</a></li>
					<li><a href="#">Lorem Ipsum Odit</a></li>
					<li><a href="#">Lorem Ipsum Odit</a></li>
					<li><a href="#">Lorem Ipsum Odit</a></li>
					<li><a href="#">Studio On Fire</a></li>
					<li><a href="#">Studio On Fire</a></li>
					<li><a href="#">Studio On Fire</a></li>
				</ul>
			</section>
		</div>
	</div><!-- end main -->
<?php get_footer(); ?>