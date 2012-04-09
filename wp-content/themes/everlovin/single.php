<?php get_header(); ?>
	<div id="main">
			<div class="container">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<section class="single">
					<aside>
						<div>
							<?php echo get_post_type( $post->ID ); ?>
						</div>
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
				<?php endwhile; endif; ?>
			</div><!-- end container -->
		</div><!-- end main -->
<?php get_footer(); ?>

