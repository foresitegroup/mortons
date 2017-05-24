<?php
    /* INCLUDE OPTIONS FRAMEWORKN */
    require_once dirname( __FILE__ ) . '/inc/theme.options.php';
    /* INCLUDE TGM PLUGIN ACTIVATION */
    require_once dirname( __FILE__ ) . '/inc/class-tgm-plugin-activation.php';
	/* FRONTEND FUNCTIONS */
    include get_template_directory() . '/inc/functions.frontend.php';
    /* ADMIN PANEL FUNCTIONS */
    include get_template_directory() . '/inc/functions.admin.php';
    /* POSTS TYPES DEFINITION FUNCTIONS */
    include get_template_directory() . '/inc/functions.posts_types.php';
	/* SHORTCODES DEFINITION */
    include get_template_directory() . '/inc/functions.shortcodes.php';
    /* METABOXES FRAMEWORK LOAD */
    define( 'RWMB_URL', trailingslashit( get_template_directory_uri() . '/inc/meta-box' ) );
    define( 'RWMB_DIR', trailingslashit( get_template_directory() . '/inc/meta-box' ) );
    require_once get_template_directory() . '/inc/meta-box/meta-box.php';
    include get_template_directory() . '/inc/functions.meta-boxes.php';
    /* VISUAL SHORTCODE LOAD */

// Wrap video embed code in DIV for responsive goodness
add_filter( 'embed_oembed_html', 'my_oembed_filter', 10, 4 ) ;
function my_oembed_filter($html, $url, $attr, $post_ID) {
  $return = '<div class="video">'.$html.'</div>';
  return $return;
}
?>