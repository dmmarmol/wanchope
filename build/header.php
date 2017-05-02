<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?php wp_title( '-', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">

		<nav id="site-navigation" class="navbar navbar-primary navbar-fixed-top">
			<div class="container Pos(rel)">
				<?= render_menu('main', ['sandwich' => ['show_brand' => true]]); ?>
				<?php /*
					<button id="responsive-menu-toggle" class="btn">
						<?= render_sandwich('Toggle Menu') ?>
					</button>
				*/ ?>
			</div>
		</nav>

		<div id="wrap-main" class="container-fluid">
			<div class="row">
				<div class="container">
					<div class="row">
						<main id="main-content" class="col-md-8">
							<div id="wrap-header" class="row" style="background-color: #<?= get_header_textcolor(); ?>;">
								<header id="masthead" class="site-header">
									<div class="site-branding">
										<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
										<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
									</div>
								</header>
							</div>

