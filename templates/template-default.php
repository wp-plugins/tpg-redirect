<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<script>(function(){document.documentElement.className='js'})();</script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>


<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
<style>
body {
	color:#0099ff;
	font-family:Verdana, Geneva, sans-serif;
	font-size:large;
}
.page-header {
	width:30%;
	margin-left: auto;
	margin-right: auto;
}
.page-header h1 {
	color:#009999;
	text-align:center;
}
.page-content{
	margin: auto auto;
}
.page-footer {
	width: 20%;
	font-size: small;
	margin: 0 auto;
	text-align:center;
}
.msg-box {
	width: 40%;
	margin: 10em auto;
	padding: 2em 2em;
	border:#009999 thin double;
	text-align:center;
}
</style>
<header id="masthead" class="page-header" role="banner">
	<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
				
</header><!-- .site-header -->


<div id="content" class="site-content">
	<div class="page-content">
		<div class="msg-box">
			<p><?php _e( $this->rd_opts['rd-msg'], 'tpg_redirect' ); ?></p>
		</div><!-- .msg-box -->
	</div><!-- .page-content -->


</div><!-- .site-content -->

	<footer id="footer" class="page-footer" role="contentinfo">
		<a href="<?php echo esc_url( __( 'http://www.tpginc.net/blog/wordpress-plugins/plugin-tpg-redirect/', 'tpg_redirect' ) ); ?>"><?php printf( __( 'TPG Redirect %s', 'tpg_redirect' ), 'Plugin' ); ?></a>
	</footer><!-- .site-footer -->

</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>
