<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="posts">
			<div class="vertical-guide">

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<?php get_template_part( 'content', get_post_format() ); ?>

					<?php @include('components/post-archive-nav.php'); ?>

			   	<?php endwhile; else: ?>

					<p><?php _e("We couldn't find any posts that matched your query. Please try again.", "lingonberry"); ?></p>

				<?php endif; ?>

				</div> <!-- /vertical-guide -->
			</div> <!-- /post -->

	</div> <!-- /posts -->

<?php get_footer(); ?>
