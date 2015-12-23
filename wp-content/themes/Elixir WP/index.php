<?php get_header('multipage'); ?>
<section class="container blog">
	<div class="row">
		<div class="col-sm-9">
			<?php if ( have_posts() ) : while  ( have_posts() ) : the_post(); ?>
				<article <?php post_class('post'); ?>>				
					<a href="<?php the_permalink(); ?>">
						<span class="date">
							<?php echo get_the_date('d') ?>
							<br>
							<small><?php echo get_the_date('M') ?></small>
						</span>
					</a>
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
							<?php the_excerpt(); ?>
							<?php wp_link_pages(); ?>
						</div>
						<div class="post-meta">
							<h6>
							<?php _e("by",'jellythemes'); ?> <?php the_author_posts_link(); ?> /
							<?php _e("in",'jellythemes'); ?> <?php the_category(', '); ?> /
							<?php comments_popup_link(); ?>
							<a href="<?php the_permalink(); ?>" class="more"><?php _e('Read more', 'jellythemes') ?></a>
							</h6>
						</div>
						<?php if (has_tag()): ?>
							<div class="tags">
								<?php the_tags('',' ',''); ?>
							</div>
						<?php endif; ?>
					</div>
				</article>
			<?php endwhile; ?>
				<nav class="pagination">
					<?php posts_nav_link(); ?>
				</nav>
			<?php else: ?>
				<article class="post">				
					<div class="inner-spacer-right-lrg">
						<div class="post-title">
							<h2><?php _e('No posts founds', 'jellythemes'); ?></h2>
						</div>
					</div>
				</article>
			<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</section>

<?php get_footer(); ?>
