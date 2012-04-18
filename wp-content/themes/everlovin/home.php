<?php
/*
Template Name: Home
*/
?>
<?php get_header(); ?>
	<section class="slider">
		<div class="flexslider">
		  <ul class="slides">
		    <?php $the_query = new WP_Query( array('post_type' => array('slideshow'), 'showposts' => '5' ));
	          while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
	        	<li>
	        		<? the_post_thumbnail(); ?>
	        		<div class="slide">
	        			<h1><? the_title(); ?></h1>
	        			<h3><?php the_content(); ?></h3>
	        		</div>
	        	</li>
	        <?php endwhile; wp_reset_postdata(); ?>
		  </ul>
		</div>
	</section>
	<div id="main">
		<div class="container">
			<section class="featured-content">
				<?php $the_query = new WP_Query( array('post_type' => array('customwork'),'showposts' => '1' ));
		          while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		        	<div class="smallbox blue">
						<? the_post_thumbnail(); ?>
					</div>
					<a class="texture-1" href="<? the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
		        <?php endwhile; wp_reset_postdata(); ?>
				
				<?php $the_query = new WP_Query( array('post_type' => array('customwork'),'showposts' => '1', 'offset' => '1' ));
		          while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		            <div class="smallbox orange">
						<?php the_post_thumbnail(); ?>
					</div>
					<a class="texture-2" href="<? the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
		        <?php endwhile; wp_reset_postdata(); ?>
				
				<?php $the_query = new WP_Query( array('post_type' => array('customwork'),'showposts' => '1', 'offset' => '2' ));
		          while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		            <a class="largebox orange" href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
		        <?php endwhile; wp_reset_postdata(); ?>
		       
		        <?php $the_query = new WP_Query( array('post_type' => array('customwork'),'showposts' => '1', 'offset' => '3' ));
		          while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		            <div class="smallbox white" >
						<? the_post_thumbnail(); ?>
					</div>
					<a class="texture-3" href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
		        <?php endwhile; wp_reset_postdata(); ?>
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