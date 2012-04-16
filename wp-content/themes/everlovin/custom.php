<?php
/*
Template Name: Custom Quotes
*/
?>
<?php get_header(); ?>
	<div id="main">
		<div class="custom-quotes">
			<div class="container">
				<?php
					wp_nav_menu( array( 'container' => 'nav', 'container_id' => 'services', 'theme_location' => 'hire' ) );
				?>
				<section class="quote-form">
					<h3>quote request form</h3>
					<form action="<?php bloginfo('template_directory'); ?>/mail.php" method="POST">
						<h4>What are you looking for?</h4>
						<input type="radio" name="worktype" value="Custom Design" class="radio" /><label for="customdesign">Custom Design</label>
						<input type="radio" name="worktype" value="Letterpress" class="radio" /><label for="letterpress">Letterpress Printing</label>
						<input type="radio" name="worktype" value="Wholesale" class="radio" /><label for="wholesale">Wholesale Info</label>
						<h4>how can we contact you?</h4>
						<input type="text" id="name" name="name" placeholder="Your Name" />
						<input type="email" id="email" name="email" placeholder="Email Address" />
						<input type="text" id="telephone" name="telephone" placeholder="Telephone" />
						<h4>what can we do for you?</h4>
						<textarea name="message"></textarea>
						<input type="submit" value="Submit" />
					</form>
				</section>
			</div>
		</div>
	</div><!-- end main -->
<?php get_footer(); ?>