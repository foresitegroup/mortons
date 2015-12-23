<?php get_header(); ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <section id="home-slider">
                <div class="overlay"></div>
                <div id="owl-main" class="owl-carousel">
                    <?php $images = rwmb_meta('_jellythemes_slider_images', 'type=image', $post->ID ); ?>
                    <?php foreach ($images as $image) : ?>
                        <div class="item"><img src="<?php echo esc_url($image['full_url']); ?>" alt=""></div>
                    <?php endforeach; ?>
                </div>
                <div class="slide-content">
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
                    <p><?php echo get_post_meta( $post->ID, '_jellythemes_slider_content', true ); ?></p>
                    <div class="slide-sep"></div>
                </div>
                <div class="mouse"><span></span></div>
            </section>
        <?php endwhile; ?>
        <?php $back = $post //backup post data?>
        <?php $child_sections = new WP_Query(array('post_type' => 'page', 'post_parent' => $post->ID, 'orderby' => 'menu_order', 'order' =>'ASC', 'posts_per_page' => -1)); ?>
        <?php while ($child_sections->have_posts() ) : $child_sections->the_post(); ?>
            <?php $bg = rwmb_meta( '_jellythemes_section_bg', 'type=image', get_the_ID() );  foreach ($bg as $bg_image) : $bg_url = $bg_image['full_url']; endforeach; ?>
            <?php $video = get_post_meta( $post->ID, '_jellythemes_parallax_video', true ); ?>
            <?php if (empty($video)): ?>
                <section id="<?php echo esc_attr($post->post_name); ?>" class="section <?php echo get_post_meta( $post->ID, '_jellythemes_section_type', true ); ?>" style="background-color:<?php echo get_post_meta( $post->ID, '_jellythemes_bg_color', true ); ?>; <?php echo (!empty($bg_url) ? 'background-image: url(' . $bg_url . ')' : ''); ?>">
                    <div class="container <?php echo get_post_meta( $post->ID, '_jellythemes_section_width', true ); ?>">
                        <?php the_content(); ?> 
                    </div>
                </section>
            <?php else: ?>
                <section id="<?php echo esc_attr($post->post_name); ?>" class="player section" data-property="{videoURL:'<?php echo esc_js($video); ?>',containment:'self',autoPlay:true, mute:true, startAt:0,opacity:1,ratio:'4/3', addRaster:true}">
                    <div class="overlay"></div>
                    <?php $logos = rwmb_meta('_jellythemes_bg_logo', 'type=image', $post->ID ); ?>
                    <?php foreach ($logos as $logo) : ?>
                    <img class="video-img" src="<?php echo esc_url($logo['full_url']); ?>" alt="video">
                    <?php endforeach; ?>
                </section>
            <?php endif ?>
            <?php $bg_url=''; ?>
        <?php endwhile; ?>
        <?php $post = $back //restore post data?>
<?php get_footer(); ?>