<?php
$return='';
define('WP_USE_THEMES', false);
require_once('../../../../wp-load.php');
$projects = new WP_Query(array('meta_key' => '_jellythemes_project_exclude', 'meta_value' => '0', 'post_type'=>'works', 'posts_per_page' => $_GET['perpage'], 'paged' => $_GET['paged']));
    while ($projects->have_posts()) : $projects->the_post();
        $term_list = wp_get_post_terms(get_the_ID(), 'type', array("fields" => "names"));
        $return .= '<div class="folio-item isotope-item ' . implode(' ', get_post_class('element')) . '" style="height:' . $_GET['height'] . 'px;">
                    <div class="portfolio-thumb">
                        <a class="folio-project" href="' . get_permalink() .'" onClick="return false;">
                            ' .  wp_get_attachment_image( get_post_thumbnail_id(get_the_ID()), 'project_thumb', false, array('class' => 'img-responsive')).'
                            <div class="portfolio-dark-overlay"></div>
                            <div class="portfolio-inner">
                                <div class="portfolio-inner-ctr">
                                    <span class="zoom"></span>
                                    <h4>' . get_the_title() . '</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>';
    endwhile;
    echo $return;
?>