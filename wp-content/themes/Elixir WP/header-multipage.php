<?php global $jellythemes; global $class; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo esc_url($jellythemes['favicon']['url']) ?>">
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php wp_title(); ?></title>
    <?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>
    <!--[if lt IE 9]>
        <script src="./js/html5shiv.js"></script>
        <script src="./js/respond.js"></script>
    <![endif]-->
    <?php wp_head(); ?>
</head>
<body <?php body_class($jellythemes['color'] . ' single-section'); ?>>
    <div id="mask">
        <div class="loader">
          <img src="<?php echo get_template_directory_uri(); ?>/svg-loaders/tail-spin-<?php echo $jellythemes['style']; ?>.svg" alt='loading'>
        </div>
    </div>

    <!-- BEGIN HEADER -->
    <header id="header" role="banner">
        <div class="jt_row container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                    </button>
                <a class="navbar-brand normal logo" href="<?php echo site_url(); ?>"><img src="<?php echo esc_url($jellythemes['logo']['url']); ?>" alt="<?php wp_title(); ?>"></a>
                <a class="navbar-brand mini" href="<?php echo site_url(); ?>"><img src="<?php echo esc_url($jellythemes['logo']['url']); ?> " alt="<?php echo strip_tags($jellythemes['blogname']); ?>"></a>
                    <a class="navbar-brand mini darker" href="<?php echo site_url(); ?>"><img src="<?php echo esc_url($jellythemes['logo']['url']); ?> " alt="<?php echo strip_tags($jellythemes['blogname']); ?>"></a>
            </div>

            <!-- BEGIN NAVIGATION MENU-->
            <?php $pid = !empty($post) ? get_post_meta($post->ID, '_jellythemes_menu_name', true) : 0; ?>
            <?php wp_nav_menu(array('container' => 'nav', 'menu_class' => 'nav navbar-nav navigation','menu_id' => 'nav', 'container_class' => 'collapse navbar-collapse navbar-right navbar-main-collapse', 'theme_location' => 'main', 'menu' => $pid, 'walker' => new jellythemes_walker_nav_menu)); ?>
            <!-- EN NAVIGATION MENU -->

        </div>
    </header>
    <!-- END HEADER -->