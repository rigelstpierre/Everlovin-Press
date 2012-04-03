	<?php if ( ! have_posts() ) : ?>
		<article id="post-0" class="post error404 not-found">
			<h2 class="entry-title"><?php _e( 'Not Found', 'lps' ); ?></h2>
			<p>Sorry, there don't seem to be any posts.</p>
		</article><!-- #post-0 -->
	<?php endif; ?>

	<?php while ( have_posts() ) : the_post(); ?>
		
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header>
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'lps' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					<?php post_meta(); ?>
				</header>
		<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>
				<article class="entry-summary">
					<?php custom_excerpt(45, "More Info"); ?>
				</article><!-- .entry-summary -->
		<?php else : ?>
				<article class="entry-content">
					<?php custom_excerpt(100, "More Info"); ?>
				</article><!-- .entry-content -->
		<?php endif; ?>

			</article><!-- #post-## -->

			<?php comments_template( '', true ); ?>

	<?php endwhile;?>

	<?php if (  $wp_query->max_num_pages > 1 ) : ?>
					<nav id="nav-below" class="navigation">
						<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 0 ) ); ?></div>
						<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 0 ) ); ?></div>
					</nav><!-- #nav-below -->
	<?php endif; ?>