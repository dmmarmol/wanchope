<?php get_header(); ?>

<?php /*
	<div class="row" >
		<a href="<?php site_url(); ?>category/<?php echo get_cat_name(55).'/'.get_cat_name(117); ?>" title="Ahora viajando"
		   class="featured panel">¡Ahora viajando!</a>
	</div>
*/ ?>


<div class="row">

	<div class="col-md-3">
		<div class="panel">
			Sidebar
		</div>
	</div>

	<div class="col-md-9">
		<?php if (have_posts()) : ?>

			<div class="posts">
				<div class="vertical-guide">

				<?php
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$total_post_count = wp_count_posts();
				$published_post_count = $total_post_count->publish;
				$total_pages = ceil( $published_post_count / $posts_per_page );

				if ( "1" < $paged ) : ?>

					<div class="page-title">

						<h4><?php printf( __('Page %s of %s', 'lingonberry'), $paged, $wp_query->max_num_pages ); ?></h4>

					</div>

				<?php endif; ?>

			    	<?php while (have_posts()) : the_post(); ?>

						<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				    		<?php get_template_part( 'content', get_post_format() ); ?>

			    		</div> <!-- /post -->

			        <?php endwhile; ?>

				<?php if ( $wp_query->max_num_pages > 1 ) : ?>

					<div class="post-nav archive-nav">

						<?php echo get_next_posts_link( __('&laquo; Older<span> posts</span>', 'lingonberry')); ?>

						<?php echo get_previous_posts_link( __('Newer<span> posts</span> &raquo;', 'lingonberry')); ?>

					</div> <!-- /post-nav archive-nav -->

				<?php endif; ?>

				</div>
			</div> <!-- /posts -->

		<?php endif; ?>

	</div>

</div><!-- /row -->


<?php get_footer(); ?>
