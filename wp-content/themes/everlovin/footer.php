	<footer>
		<div class="container">
			<div class="newsletter">
				<h4>newsletter signup</h4>
				<form>
					<input type="email" placeholder="email address here" />
					<input type="submit" value="submit" />
				</form>
				<p>update subscription preferences</p>
			</div>
			<div class="lastword">
				<h4>one last word</h4>
				<p>BEING GOOD IS HARD WORK.</h4>
			</div>
			<span><p>Copyright &copy;<?php echo date("Y"); ?> <?php bloginfo('name'); ?>. All rights reserved.</p></span>
		</div>
	</footer>
	
	<script src="javascripts/plugins.js"></script>
	<script src="javascripts/script.js"></script>
	
	<!--[if lt IE 7 ]>
		<script src="/javascripts/libs/dd_belatedpng.js"></script>
		<script> DD_belatedPNG.fix('img, .png_bg'); </script>
	<![endif]-->


	<!-- change the UA-XXXXX-X to be your site's ID -->
	<script>
		var _gaq = [['_setAccount', 'UA-XXXXX-X'], ['_trackPageview']];
	 	(function(d, t) {
			var g = d.createElement(t),
				s = d.getElementsByTagName(t)[0];
			g.async = true;
			g.src = ('https:' == location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			s.parentNode.insertBefore(g, s);
		})(document, 'script');
	</script>
<?php wp_footer(); ?>
</body>
</html>