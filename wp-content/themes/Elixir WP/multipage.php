<?php /* Template Name: Parent Page */ ?>
<?php get_header('multipage'); ?>
    <?php while ( have_posts() ) : the_post(); ?>
        <?php $back = $post //backup post data?>
        <?php $child_sections = new WP_Query(array('post_type' => 'page', 'post_parent' => $post->ID, 'orderby' => 'menu_order', 'order' =>'ASC', 'posts_per_page' => -1)); ?>
        <?php while ($child_sections->have_posts() ) : $child_sections->the_post(); ?>
            <?php $bg = rwmb_meta( '_jellythemes_section_bg', 'type=image', get_the_ID() );  foreach ($bg as $bg_image) : $bg_url = $bg_image['full_url']; endforeach; ?>
                <section id="<?php echo esc_attr($post->post_name); ?>" class="section <?php echo get_post_meta( $post->ID, '_jellythemes_section_type', true ); ?> <?php echo get_post_meta( $post->ID, '_jellythemes_section_color', true ); ?>" style="background-color:<?php echo get_post_meta( $post->ID, '_jellythemes_bg_color', true ); ?>; <?php echo (!empty($bg_url) ? 'background-image: url(' . $bg_url . ')' : ''); ?>">
                    <div class="<?php echo get_post_meta( $post->ID, '_jellythemes_section_width', true ); ?>">
                        <?php the_content(); ?> 
                    </div>
                </section>
            <?php $bg_url=''; ?>
        <?php endwhile; ?>
        <?php $post = $back //restore post data?>
    <?php endwhile; ?>
<?php get_footer(); ?>