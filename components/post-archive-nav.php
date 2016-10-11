<?php
$next_post = get_next_post();
$prev_post = get_previous_post();
if (!empty($next_post) || !empty($prev_post)) { ?>

	<div class="post-nav">

		<?php if (!empty( $next_post )): ?>

			<div class="col-sm-6">
				<a class="btn btn-lg post-nav-newer" title="<?php _e('Next post:', 'lingonberry'); echo ' ' . esc_attr(get_the_title($next_post)); ?>" href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo get_the_title($next_post); ?> &raquo;</a>
			</div>

		<?php endif; ?>

		<?php if (!empty( $prev_post )): ?>

			<div class="col-sm-6">
				<a class="btn btn-lg post-nav-older" title="<?php _e('Previous post:', 'lingonberry'); echo ' ' . esc_attr(get_the_title($prev_post)); ?>" href="<?php echo get_permalink( $prev_post->ID ); ?>">&laquo; <?php echo get_the_title($prev_post); ?></a>
			</div>

		<?php endif; ?>

	</div> <!-- /post-nav -->

<?php } // endif; ?>
