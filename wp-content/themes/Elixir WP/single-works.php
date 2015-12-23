<div class="project-single ">
			<div class="project-info container">
				<h6><?php echo get_post_meta( $post->ID, '_jellythemes_project_subtitle', true ); ?></h6>
				<h4><?php the_title(); ?></h4>
				<?php echo get_post_meta( $post->ID, '_jellythemes_project_description', true ); ?>
			<?php
                $url = get_post_meta( $post->ID, '_jellythemes_project_url', true );
                if (!empty($url)) :
            ?>
            	<a href="<?php echo esc_url($url); ?>" class="btn2"><?php _e('View project', 'jellythemes'); ?></a>
            <?php endif; ?>
				<a href="#" class="close top">Next project</a>
			</div>
			<div class="project-slide carousel-wrapper container with_pagination with_buttons">
				<div id="owl-project-single" class="owl-carousel generic-carousel">
					<?php $video = get_post_meta( $post->ID, '_jellythemes_project_video', true ); ?>
                    <?php if (!empty($video)) : ?><div class="item"><?php echo wp_oembed_get($video, array('width' => 1180)) ?></div><?php endif; ?>
                    <?php $images = rwmb_meta( '_jellythemes_project_images', 'type=plupload_image', get_the_ID() ); ?>
                    <?php  foreach($images as $image) : ?>
                    <div class="item"><?php echo  wp_get_attachment_image( $image['ID'], 'project_image', false, array('class' => 'img-responsive')); ?></div>
                    <?php endforeach; ?>
					
				</div>
			</div>
		</div>