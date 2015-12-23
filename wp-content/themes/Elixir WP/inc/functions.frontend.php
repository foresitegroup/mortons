<?php
    // Define content width
    if ( ! isset( $content_width ) ) $content_width = 1180;
	// Load scripts and styles files
    function jellythemes_scripts_and_styles() {
        global $jellythemes;
        if (!is_admin()) {
            $protocol = is_ssl() ? 'https' : 'http';
            wp_enqueue_style( 'fonts', "$protocol://fonts.googleapis.com/css?family=Yellowtail%7cCabin:400,500,600,700,400italic,700italic%7cLibre+Baskerville:400italic%7cGreat+Vibes%7cOswald:400,300,700%7COpen+Sans:300italic,400italic,600italic,700italic,400,300,600,700" );
            wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
            wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
            wp_enqueue_style( 'elixir', get_template_directory_uri() . '/css/elixir-' . $jellythemes['style'] . '.css' );
            wp_enqueue_style( 'carousel', get_template_directory_uri() . '/js/owl-carousel/owl.carousel.css' );
            wp_enqueue_style( 'carousel-theme', get_template_directory_uri() . '/js/owl-carousel/owl.theme.css' );
            wp_enqueue_style( 'carousel-transitions', get_template_directory_uri() . '/js/owl-carousel/owl.transitions.css' );
            wp_enqueue_style( 'YTPlayer', get_template_directory_uri() . '/css/YTPlayer.css' );
            wp_enqueue_style( 'Swipebox', get_template_directory_uri() . '/css/swipebox.css' );
            wp_enqueue_style( 'theme-style', get_stylesheet_uri() );
            if (!empty($jellythemes['color'])) {wp_enqueue_style( $jellythemes['color'], get_template_directory_uri() . '/css/color/' . $jellythemes['color'] . '.css' );}

            wp_enqueue_script('jquery');
            wp_enqueue_script(
                'modernizr',
                get_template_directory_uri() . '/js/modernizr.custom.js',
                false,false,true );
            wp_enqueue_script(
                'classie',
                get_template_directory_uri() . '/js/classie.js',
                array('jquery'),false,true );
            wp_enqueue_script(
                'pathLoader',
                get_template_directory_uri() . '/js/pathLoader.js',
                array('jquery'),false,true );
            wp_enqueue_script(
                'carousel',
                get_template_directory_uri() . '/js/owl-carousel/owl.carousel.min.js',
                array('jquery'),false,true );
            wp_enqueue_script(
                'inview',
                get_template_directory_uri() . '/js/jquery.inview.js',
                array('jquery'),false,true );
            wp_enqueue_script(
                'nav',
                get_template_directory_uri() . '/js/jquery.nav.js',
                array('jquery'),false,true );
            wp_enqueue_script(
                'YTPlayer',
                get_template_directory_uri() . '/js/jquery.mb.YTPlayer.js',
                array('jquery'),false,true );
            wp_enqueue_script(
                'form',
                get_template_directory_uri() . '/js/jquery.form.js',
                array('jquery'),false,true );
            wp_enqueue_script(
                'validate',
                get_template_directory_uri() . '/js/jquery.validate.js',
                array('jquery'),false,true );

            wp_enqueue_script(
                'bootstrap',
                get_template_directory_uri() . '/js/bootstrap.min.js',
                array('jquery'),false,true );
            wp_enqueue_script(
                'default',
                get_template_directory_uri() . '/js/default.js',
                array('jquery'),false,true );
            /*wp_enqueue_script(
                'plugins',
                get_template_directory_uri() . '/js/plugins.js',
                array('jquery'),false,true );*)*/
            wp_enqueue_script(
                'isotope',
                get_template_directory_uri() . '/js/jquery.isotope.min.js',
                array('jquery'),false,true );
            wp_enqueue_script(
                'prettyphoto',
                get_template_directory_uri() . '/js/jquery.prettyPhoto.js',
                array('jquery'),false,true );
            wp_enqueue_script(
                'swipebox',
                get_template_directory_uri() . '/js/jquery.swipebox.js',
                array('jquery'),false,true );
            $theme_opts = array( 'theme_path' => get_template_directory_uri(), 
                                'color' => $jellythemes['color'],
                                'style' => $jellythemes['style']);
            wp_localize_script( 'default', 'jellythemes', $theme_opts );
            wp_localize_script( 'plugins', 'jellythemes', $theme_opts );
        }
    }
    add_action('wp_enqueue_scripts', 'jellythemes_scripts_and_styles');

    // Define walker nav menu to display custom html output
    class jellythemes_walker_nav_menu extends Walker_Nav_Menu {

        function start_el( &$output, $item, $depth = 0, $args = array(), $curr = 0 ) {
            global $wp_query;
            $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

            $depth_classes = array(
                ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
                ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
                ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
                'menu-item-depth-' . $depth
            );
            $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
            $class_names = str_replace('current_page_item', 'current', $class_names);
            if (strpos($item->url, '#')) {
                $class_names = str_replace('current-menu-item', '', $class_names);
                $class_names = str_replace('current', '', $class_names);
            }
            $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="page-scroll ' . $depth_class_names . ' ' . $class_names . '">';

            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
            $item_output = '';
            if (is_object($args)) :
            $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
                $args->before,
                $attributes,
                $args->link_before,
                apply_filters( 'the_title', $item->title, $item->ID ),
                $args->link_after,
                $args->after
            );
            endif;
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args, 0 );
        }
    }

    //Return array of section's IDs in Main menu
    function jellythemes_get_sections(){
        if(!has_nav_menu( 'main' )) {
            return;
        }
        if ( ( $locations = get_nav_menu_locations() ) && $locations['main']  ) {
            $menu = wp_get_nav_menu_object( $locations['main'] );
            $items  = wp_get_nav_menu_items($menu->term_id);
            $sections = array();
            foreach((array) $items as $menu_items){
                if ($menu_items->object == 'page-sections') {
                    $sections[] = $menu_items->object_id;
                }
            }
        }
        return $sections;
    }

    //Comment format and Walker
    function jellythemes_comments_format($comment, $args, $depth) {
            $id = $comment->comment_ID;
    ?>
            <li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php echo $id ?>">

            <!--comment body-->
            <div class="row-fluid comment-body" id="div-comment-<?php echo esc_attr($id); ?>">
                <div class="span1 comment-author vcard">
                    <?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, 43); ?>
                </div>

                <div class="span11">
                    <?php if ($comment->comment_approved == '0') : ?>
                    <span class="comment-awaiting-moderation"><?php echo __('Your comment is awaiting moderation.','Pixelentity Theme/Plugin') ?></span>
                    <br/>
                    <?php endif; ?>


                    <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>','Pixelentity Theme/Plugin'), get_comment_author_link()); ?>
                    <div class="comment-meta commentmetadata">
                    <a href="<?php echo htmlspecialchars(get_comment_link()); ?>">
                        <?php printf( __('%1$s at %2$s','Pixelentity Theme/Plugin'), get_comment_date(),  get_comment_time()); ?>
                    </a>
                    <?php edit_comment_link(__('(Edit)','Pixelentity Theme/Plugin'),'&nbsp;&nbsp;',''); ?>
                    </div>
                    <div class="pe-wp-default">
                        <?php comment_text(); ?>
                    </div>
                    <div class="reply pull-right">
                        <?php comment_reply_link(array_merge( $args, array('add_below' => "div-comment", 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                    </div>
                </div>
            </div>
    <?php
    }

    //Format title
    function jellythemes_wp_title( $title, $sep ) {
        global $jellythemes;

        $title = str_replace($sep, '', $title);
        // Add the site name.
        $title .= (empty($title) ? '' : ' ' .  $sep . ' ') . strip_tags($jellythemes['blogname']);

        return $title;
    }
    add_filter( 'wp_title', 'jellythemes_wp_title', 10, 2 );
    // Theme supports
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( "post-thumbnails" )
?>
