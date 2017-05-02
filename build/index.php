	<?php get_header(); ?>
		<div id="wrap-content" class="row">
			<section id="site-content" class="container-fluid">
					<?php if ( have_posts() ) {
						while ( have_posts() ) : the_post(); ?>
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
								<?= the_category(); ?>
								<a href="<?= the_permalink(); ?>"
									class="entry-link"
									rel="bookmark">
									<header class="entry-header">
										<h1 class="entry-title"><?= the_title(); ?></h1>
									</header>
									<div class="entry-content">
										<?= the_excerpt(); ?>
										<?php // wp_link_pages(); ?>
									</div>
								</a>
								<footer class="entry-footer">
									<?php printf( __( 'Posted <time datetime="%1$s">%2$s</time> by %3$s. ', 'voidx' ), get_post_time('c'), get_the_date(), get_the_author() ); ?>
									<?php _e( 'Categories: ', 'voidx' ); echo '. '; ?>
								</footer>
							</article>
						<?php endwhile;
					} else { ?>
						<article id="post-0" class="post no-results not-found">
							<header class="entry-header">
								<h1><?php _e( 'Not found', 'voidx' ); ?></h1>
							</header>
							<div class="entry-content">
								<p><?php _e( 'Sorry, but your request could not be completed.', 'voidx' ); ?></p>
								<?php get_search_form(); ?>
							</div>
						</article>
					<?php } ?>
					<?php voidx_post_navigation(); ?>
			</section>
		</div><!-- #wrap-content -->
	</main><!-- #main-content -->

	<div id="side-content" class="col-md-4">
		<?php get_sidebar(); ?>
	</div><!-- right-col -->

	</div><!-- .row -->
</div><!-- .container -->

<?php get_footer(); ?>
