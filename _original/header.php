<!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

	<head profile="http://gmpg.org/xfn/11">

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >

		<title><?php wp_title('|', true, 'right'); ?></title>

		<?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>

		<?php wp_head(); ?>

		<?php if (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) { ?>
			<!-- Development only -->
    		<script src="//localhost:35729/livereload.js?snipver=1" type="text/javascript"></script>
		<?php } ?>

	</head>

	<body <?php body_class(); ?> style="background-color: <?php get_background_color(); ?>; background-image: <?php get_background_image(); ?>; ">

		<div class="offcanvas">

			<?php if ( has_nav_menu( 'primary' ) ) {

				wp_nav_menu( array(

					'container' => '',
					'items_wrap' => '%3$s',
					'theme_location' => 'primary',
					'walker' => new lingonberry_nav_walker

				) ); } else {

				wp_list_pages( array(

					'container' => '',
					'title_li' => ''

				));

			} ?>

		</div>

		<header class="header section">

			<div class="container header-inner">

				<?php if (get_header_image() != '') : ?>

					<a href="<?php echo esc_url( home_url() ); ?>/" title="<?php echo esc_attr( get_bloginfo( 'title' ) ); ?>  | <?php echo esc_attr( get_bloginfo( 'description' ) ); ?>" rel="home" class="logo">
						<?php if (is_page(1)) { echo 'Estas en la página de Brasil'; } ?>
						<img src="<?php header_image(); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
					</a>

				<?php else : ?>

					<a href="<?php echo esc_url( home_url() ); ?>/" title="<?php echo esc_attr( get_bloginfo( 'title' ) ); ?> &mdash; <?php echo esc_attr( get_bloginfo( 'description' ) ); ?>" rel="home" class="logo noimg"></a>

				<?php endif; ?>

				<h1 class="blog-title">
					<a href="<?php echo esc_url( home_url() ); ?>/" title="<?php echo esc_attr( get_bloginfo( 'title' ) ); ?> &mdash; <?php echo esc_attr( get_bloginfo( 'description' ) ); ?>" rel="home"><?php echo esc_attr( get_bloginfo( 'title' ) ); ?></a>
				</h1>

				<div class="nav-toggle">

					<div class="bar"></div>
					<div class="bar"></div>
					<div class="bar"></div>

					<div class="clear"></div>

				</div>

				 <div class="clear"></div>

			</div> <!-- /header section -->

		</header> <!-- /header-inner section-inner -->

		<main class="container section-inner">
