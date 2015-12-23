<?php
$return='';
define('WP_USE_THEMES', false);
require_once('../../../../wp-load.php');
$members = new WP_Query(array('post_type'=>'team_members', 'posts_per_page' => $_GET['perpage'], 'paged' => $_GET['paged']));
    while ($members->have_posts()) : $members->the_post();
        $image = get_post_meta( $post->ID, '_jellythemes_member_photo', true );
        $image_hover = get_post_meta( $post->ID, '_jellythemes_member_photo_hover', true );
        $return .= '<div class="team-member">
                            ' . wp_get_attachment_image($image, 'member_photo', false, array('class' => 'main')) .'
                            <div class="hover">
                                <div class="blur">' . wp_get_attachment_image($image_hover, 'member_photo') .'</div>
                                <div class="hover-border"></div>
                                <h2 class="name">' . get_post_meta( $post->ID, '_jellythemes_member_name', true ). '</h2>
                                <h3 class="position">' . get_post_meta( $post->ID, '_jellythemes_member_position', true ). '</h3>
                                <div class="social">';
                                    $return .= !get_post_meta( $post->ID, '_jellythemes_member_facebook', true ) ? '' : '<a class="icon fb" href="' . get_post_meta( $post->ID, '_jellythemes_member_facebook', true ). '">Facebook</a>';
                                    $return .= !get_post_meta( $post->ID, '_jellythemes_member_twitter', true ) ? '' : '<a class="icon tw" href="' . get_post_meta( $post->ID, '_jellythemes_member_twitter', true ). '">Twitter</a>';
                                    $return .= !get_post_meta( $post->ID, '_jellythemes_member_tumblr', true ) ? '' : '<a class="icon di" href="' . get_post_meta( $post->ID, '_jellythemes_member_dribbble', true ). '">Dribbble</a>';
        $return .= '            </div>
                            </div>
                        </div>';
    endwhile;
    echo $return;
?>