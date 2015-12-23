<?php /* Template Name: Single Section */ ?>
<?php get_header('multipage'); ?>
    <?php while (have_posts() ) : the_post(); ?>
        <?php $bg = rwmb_meta( '_jellythemes_section_bg', 'type=image', get_the_ID() );  foreach ($bg as $bg_image) : $bg_url = $bg_image['full_url']; endforeach; ?>
            <section id="<?php echo esc_attr($post->post_name); ?>" class="section <?php echo get_post_meta( $post->ID, '_jellythemes_section_type', true ); ?> <?php echo get_post_meta( $post->ID, '_jellythemes_section_color', true ); ?>" style="background-color:<?php echo get_post_meta( $post->ID, '_jellythemes_bg_color', true ); ?>; <?php echo (!empty($bg_url) ? 'background-image: url(' . $bg_url . ')' : ''); ?>">
                <div class="<?php echo get_post_meta( $post->ID, '_jellythemes_section_width', true ); ?>">
                    <?php the_content(); ?> 
                </div>
            </section>
        <?php $bg_url=''; ?>
    <?php endwhile; ?>
<?php get_footer(); ?>