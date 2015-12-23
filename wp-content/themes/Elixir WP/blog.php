<?php /* Template Name: Blog */ ?>
<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
	<!-- BEGIN HOME SLIDER SECTION -->
    <section id="home-slider">
        <div class="overlay"></div>
        <!-- SLIDER IMAGES -->
        <div id="owl-main" class="owl-carousel">
            <?php $images = rwmb_meta('_jellythemes_slider_images', 'type=image', $post->ID ); ?>
            <?php foreach ($images as $image) : ?>
                <div class="item"><img src="<?php echo esc_url($image['full_url']); ?>" alt=""></div>
            <?php endforeach; ?>
        </div>
        <!-- SLIDER CONTENT -->
        <div class="slide-content">
            <div class="voffset100"></div>
           	<?php $logos = rwmb_meta('_jellythemes_slider_logo', 'type=image', $post->ID ); ?>
            <?php foreach ($logos as $logo) : ?>
                <span class="logointro"><img src="<?php echo esc_url($logo['full_url']); ?>" alt="<?php echo get_post_meta( $post->ID, '_jellythemes_slider_content', true ); ?>"/></span>
            <?php endforeach; ?>
            <?php $texts =  get_post_meta( $post->ID, '_jellythemes_slider_text', true ); ?>
            <div id="owl-main-text" class="owl-carousel">
                <?php foreach ($texts as $i => $text) : ?>
                    <div class="item"><h2><?php echo $text ?></h2></div>
                <?php endforeach; ?>
            </div>
            <div class="slide-sep"></div>
            <p><?php echo get_post_meta( $post->ID, '_jellythemes_slider_content', true ); ?></p>
        </div>
        <!-- BOTTOM ANIMATED ARROW -->
        <a href="<?php echo get_post_meta( $post->ID, '_jellythemes_slider_link', true ); ?>" class="page-scroll menu-item"><div class="mouse"><span></span></div></a>
    </section>
    <!-- END HOME SLIDER SECTION -->
    <?php $content = get_the_content(); ?>
    <?php if (!empty($content)) :?>
    <section id="<?php echo esc_attr($post->post_name); ?>" class="section <?php echo get_post_meta( $post->ID, '_jellythemes_section_type', true ); ?>" style="background-color:<?php echo get_post_meta( $post->ID, '_jellythemes_bg_color', true ); ?>; <?php echo (!empty($bg_url) ? 'background-image: url(' . $bg_url . ')' : ''); ?>">
        <div class="container">
            <?php the_content(); ?> 
        </div>
    </section>
	<?php endif; ?>
	<div class="jt_row-fluid  row">
		<div class="col-md-12 jt_col column_container">
	        <div class="voffset100"></div>
	        <h2 class="section-title">Our blog</h2>
	    </div>
	</div>
<?php endwhile; ?>
<section class="container blog">
	<div class="row">
		<div class="col-sm-9">
			<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$blog = new WP_Query(array('post_type'=>'post', 'paged' => $paged));?>
			<?php if ( $blog->have_posts() ) : while  ( $blog->have_posts() ) : $blog->the_post(); ?>
				<article <?php post_class(); ?>>				
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
					<?php
						global $wp_query;
						$temp_wp_query = $wp_query;
						$wp_query = null;
						$wp_query = $blog;
					?>
					<?php posts_nav_link(); ?>
				</nav>
			<?php else: ?>
			<!-- no posts found -->
			<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</section>

<?php get_footer(); ?>