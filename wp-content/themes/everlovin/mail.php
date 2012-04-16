<?php
error_reporting(E_ALL);
$worktype = $_POST['worktype'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['telephone'];
$message = $_POST['message'];
$formcontent=" Work Type: $worktype \n From: $name \n Phone: $phone \n Message: $message";
$recipient = "hithere@rigelwritescode.com";
$subject = "Custom Quote Contact Form";
$mailheader = "From: $email \r\n";
mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie ie6 no-js" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en"><!--<![endif]-->
<head>

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title>  Custom Quotes | Evelovin Press</title>

		<meta name="description" content="Fine Letterpress Stationer">	
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

		<link rel="stylesheet" type="text/css" media="all" href="/wp-content/themes/everlovin/css/style.css" />
		<link rel="stylesheet" href="/wp-content/themes/everlovin/css/print.css" media="print" />
		<link rel="shortcut icon" href="/wp-content/themes/everlovin/images/favicon.ico">
		<link rel="pingback" href="/xmlrpc.php" />
		
		<!-- Internet Explorer stylesheet. You can use .i6, .ie7, .ie8, .ie9 classes to target specific versions -->
		<!--[if IE ]><link rel="stylesheet" href="/wp-content/themes/everlovin/css/ie.css"><![endif]-->

		<script type="text/javascript" src="http://use.typekit.com/etd8abw.js"></script>
		<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
		
		<meta name='robots' content='noindex,nofollow' />
<link rel="alternate" type="application/rss+xml" title="Evelovin Press &raquo; Feed" href="/feed/" />
<link rel="alternate" type="application/rss+xml" title="Evelovin Press &raquo; Comments Feed" href="/comments/feed/" />
<link rel="alternate" type="application/rss+xml" title="Evelovin Press &raquo; Custom Quotes Comments Feed" href="/hire-the-press-man/custom-quotes/feed/" />
<script type='text/javascript' src='/wp-includes/js/comment-reply.js?ver=20090102'></script>
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js?ver=3.3.1'></script>
<script type='text/javascript' src='/wp-content/themes/everlovin/js/main.js?ver=1.0'></script>
<script type='text/javascript' src='/wp-content/themes/everlovin/js/jquery.tweet.js?ver=1.0'></script>
<script type='text/javascript' src='/wp-content/themes/everlovin/js/jquery.jribbble-1.0.0.ugly.js?ver=1.0'></script>
<script type='text/javascript' src='/wp-content/themes/everlovin/js/jquery.nivo.slider.pack.js?ver=1.0'></script>
<script type='text/javascript' src='/wp-content/themes/everlovin/js/modernizr-2.0.6.js?ver=1.0'></script>
<link rel='prev' title='Home' href='/' />
<link rel='next' title='Pricing Guidelines and FAQ' href='/hire-the-press-man/pricing-guidelines-and-faq/' />
<link rel='canonical' href='/hire-the-press-man/custom-quotes/' />

</head>
<body class="page page-id-33 page-parent page-child parent-pageid-8 page-template page-template-custom-php hire-the-press-man custom-quotes">

	<div class="wrapper">

		<header>
			<div class="container">
				<a href="/"><img src="/wp-content/themes/everlovin/images/logo.jpg" alt="logo" /></a>
				<nav id="primary" class="menu-primary-container"><ul id="menu-primary" class="menu"><li id="menu-item-14" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-14"><a href="/see-the-work/">See The Work</a></li>
<li id="menu-item-13" class="menu-item menu-item-type-post_type menu-item-object-page current-page-ancestor menu-item-13"><a href="/hire-the-press-man/">Hire The Press Man</a></li>
<li id="menu-item-12" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-12"><a href="/meet-greet/">Meet &#038; Greet</a></li>
</ul></nav>			</div>
		</header>	<div id="main">
		<div class="custom-quotes">
			<div class="container">
				<nav id="services" class="menu-hire-the-press-man-container"><ul id="menu-hire-the-press-man" class="menu"><li id="menu-item-83" class="custom menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-33 current_page_item menu-item-83"><a href="/hire-the-press-man/custom-quotes/">Custom Quotes</a></li>
<li id="menu-item-82" class="pricing menu-item menu-item-type-post_type menu-item-object-page menu-item-82"><a href="/hire-the-press-man/pricing-guidelines-and-faq/">Pricing &#038; FAQ</a></li>
<li id="menu-item-80" class="process menu-item menu-item-type-post_type menu-item-object-page menu-item-80"><a href="/hire-the-press-man/capabilities-and-process/">Capabilities &#038; Process</a></li>
<li id="menu-item-81" class="wholesale menu-item menu-item-type-post_type menu-item-object-page menu-item-81"><a href="/hire-the-press-man/wholesale-ordering/">Wholesale</a></li>
</ul></nav>				<section class="quote-form">
					<h3>quote request form</h3>
					<h4 style="text-align: center; padding-bottom: 50px;">Thanks We've Recieved Your Email and We'll Get back To You ASAP!</h4>
				</section>
			</div>
		</div>
	</div><!-- end main -->
	<footer>
		<div class="container">
			<div class="newsletter">
				<h4>newsletter signup</h4>
				<form>
					<input type="email" placeholder="email address here" />
					<input type="submit" value="submit" />
				</form>
			</div>
			<div class="lastword">
				<h4>one last word</h4>
				<p>BEING GOOD IS HARD WORK.</h4>
			</div>
			<span><p>Copyright &copy;2012 Evelovin Press. All rights reserved.</p></span>
		</div>
	</footer>
	
	<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
	
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
</body>
</html>