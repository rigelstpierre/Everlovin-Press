<?php get_header(); ?>

	<section id="main">
		<section id="main_content">
			
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<header>
					<h2><?php the_title(); ?></h2>
				</header>
				<div class="content"><?php the_content();?></div>
				<?php endwhile; endif; ?>
			</article>
		</section><!--  #main_content-->		

<?php get_sidebar(); ?>
<?php get_footer(); ?>
