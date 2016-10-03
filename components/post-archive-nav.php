<div class="post-nav">

	<?php
	$next_post = get_next_post();
	if (!empty( $next_post )): ?>

		<a class="btn btn-info btn-lg post-nav-newer" title="<?php _e('Next post:', 'lingonberry'); echo ' ' . esc_attr(get_the_title($next_post)); ?>" href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo get_the_title($next_post); ?> &raquo;</a>

	<?php endif; ?>

	<?php
	$prev_post = get_previous_post();
	if (!empty( $prev_post )): ?>

		<a class="btn btn-info btn-lg post-nav-older" title="<?php _e('Previous post:', 'lingonberry'); echo ' ' . esc_attr(get_the_title($prev_post)); ?>" href="<?php echo get_permalink( $prev_post->ID ); ?>">&laquo; <?php echo get_the_title($prev_post); ?></a>

	<?php endif; ?>

</div> <!-- /post-nav -->

<?php comments_template( '', true ); ?>
