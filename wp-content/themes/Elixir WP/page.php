<?php get_header('multipage'); ?>
<section class="container blog">
	<div class="row">
		<div class="col-sm-9">
			<?php if ( have_posts() ) : while  ( have_posts() ) : the_post(); ?>
				<article <?php post_class(); ?>>				
					<div class="inner-spacer-right-lrg">
						<div class="post-media clearfix">
							<?php if (has_post_thumbnail()): ?>
								<?php the_post_thumbnail('full') ?>
							<?php endif; ?>
						</div>

						<div class="post-title">
							<h2><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2>
						</div>

						<div class="post-body pe-wp-default">
							<?php the_content(); ?>
							<?php wp_link_pages(); ?>
						</div>
						<div class="post-meta">
							<h6>
							<?php _e("by",'jellythemes'); ?> <?php the_author_posts_link(); ?> /
							<?php comments_popup_link(); ?>
							<a href="<?php the_permalink(); ?>" class="more"><?php _e('Read more', 'jellythemes') ?></a>
							</h6>
						</div>
					</div>
				</article>
				<?php comments_template(); ?>
			<?php endwhile; ?>
			<?php else: ?>
			<!-- no posts found -->
			<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</section>

<?php get_footer(); ?>
