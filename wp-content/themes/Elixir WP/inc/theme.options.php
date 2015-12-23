<?php


if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/ReduxFramework/ReduxCore/framework.php' ) ) {
	require_once( dirname( __FILE__ ) . '/ReduxFramework/ReduxCore/framework.php' );
}

if (!function_exists('redux_init')) :
	function redux_init() {
	
	$args = array();


	// For use with a tab example below
	$tabs = array();

	ob_start();

	$ct = wp_get_theme();
	$theme_data = $ct;
	$item_name = $theme_data->get('Name');
	$tags = $ct->Tags;
	$screenshot = $ct->get_screenshot();
	$class = $screenshot ? 'has-screenshot' : '';

	$customize_title = sprintf( __( 'Customize &#8220;%s&#8221;','redux-framework-demo' ), $ct->display('Name') );

	?>
	<div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
		<?php if ( $screenshot ) : ?>
			<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
			<a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr( $customize_title ); ?>">
				<img src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
			</a>
			<?php endif; ?>
			<img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
		<?php endif; ?>

		<h4>
			<?php echo $ct->display('Name'); ?>
		</h4>

		<div>
			<ul class="theme-info">
				<li><?php printf( __('By %s','redux-framework-demo'), $ct->display('Author') ); ?></li>
				<li><?php printf( __('Version %s','redux-framework-demo'), $ct->display('Version') ); ?></li>
				<li><?php echo '<strong>'.__('Tags', 'redux-framework-demo').':</strong> '; ?><?php printf( $ct->display('Tags') ); ?></li>
			</ul>
			<p class="theme-description"><?php echo $ct->display('Description'); ?></p>
			<?php if ( $ct->parent() ) {
				printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.' ) . '</p>',
					__( 'http://codex.wordpress.org/Child_Themes','redux-framework-demo' ),
					$ct->parent()->display( 'Name' ) );
			} ?>

		</div>

	</div>

	<?php
	$item_info = ob_get_contents();

	ob_end_clean();

	$sampleHTML = '';
	if( file_exists( dirname(__FILE__).'/info-html.html' )) {
		/** @global WP_Filesystem_Direct $wp_filesystem  */
		global $wp_filesystem;
		if (empty($wp_filesystem)) {
			require_once(ABSPATH .'/wp-admin/includes/file.php');
			WP_Filesystem();
		}
		$sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__).'/info-html.html');
	}

	// BEGIN Sample Config

	// Setting dev mode to true allows you to view the class settings/info in the panel.
	// Default: true
	$args['dev_mode'] = false;

	// Set the icon for the dev mode tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: info-sign
	//$args['dev_mode_icon'] = 'info-sign';

	// Set the class for the dev mode tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	$args['dev_mode_icon_class'] = 'icon-large';

	// Set a custom option name. Don't forget to replace spaces with underscores!
	$args['opt_name'] = 'jellythemes';

	// Setting system info to true allows you to view info useful for debugging.
	// Default: false
	//$args['system_info'] = true;


	// Set the icon for the system info tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: info-sign
	//$args['system_info_icon'] = 'info-sign';

	// Set the class for the system info tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	//$args['system_info_icon_class'] = 'icon-large';

	$theme = wp_get_theme();

	$args['display_name'] = $theme->get('Name');
	//$args['database'] = "theme_mods_expanded";
	$args['display_version'] = $theme->get('Version');


	// Define the starting tab for the option panel.
	// Default: '0';
	//$args['last_tab'] = '0';

	// Define the option panel stylesheet. Options are 'standard', 'custom', and 'none'
	// If only minor tweaks are needed, set to 'custom' and override the necessary styles through the included custom.css stylesheet.
	// If replacing the stylesheet, set to 'none' and don't forget to enqueue another stylesheet!
	// Default: 'standard'
	//$args['admin_stylesheet'] = 'standard';

	// Setup custom links in the footer for share icons
	$args['share_icons']['twitter'] = array(
	    'link' => 'http://twitter.com/jellythemes',
	    'title' => 'Follow me on Twitter',
	    'img' => ReduxFramework::$_url . 'assets/img/twitter.png'
	);
	$args['share_icons']['facebook'] = array(
	    'link' => 'http://facebook.com/jellythemes',
	    'title' => 'Follow me on Facebook',
	    'img' => ReduxFramework::$_url . 'assets/img/facebook.png'
	);

	// Enable the import/export feature.
	// Default: true
	//$args['show_import_export'] = false;

	// Set the icon for the import/export tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: refresh
	//$args['import_icon'] = 'refresh';

	// Set the class for the import/export tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	$args['import_icon_class'] = 'icon-large';

	/**
	 * Set default icon class for all sections and tabs
	 * @since 3.0.9
	 */
	$args['default_icon_class'] = 'icon-large';
	$args['google_api_key'] = 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII';

	// Set a custom menu icon.
	//$args['menu_icon'] = '';

	// Set a custom title for the options page.
	// Default: Options
	$args['menu_title'] = __('Elixir Options', 'redux-framework-demo');

	// Set a custom page title for the options page.
	// Default: Options
	$args['page_title'] = __('Elixir Options', 'redux-framework-demo');

	// Set a custom page slug for options page (wp-admin/themes.php?page=***).
	// Default: redux_options
	$args['page_slug'] = 'elixir_options';

	$args['default_show'] = true;
	$args['default_mark'] = '*';

	// Set a custom page capability.
	// Default: manage_options
	//$args['page_cap'] = 'manage_options';

	// Set the menu type. Set to "menu" for a top level menu, or "submenu" to add below an existing item.
	// Default: menu
	//$args['page_type'] = 'submenu';

	// Set the parent menu.
	// Default: themes.php
	// A list of available parent menus is available at http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	//$args['page_parent'] = 'options-general.php';

	// Set a custom page location. This allows you to place your menu where you want in the menu order.
	// Must be unique or it will override other items!
	// Default: null
	//$args['page_position'] = null;

	// Set a custom page icon class (used to override the page icon next to heading)
	//$args['page_icon'] = 'icon-themes';

	// Set the icon type. Set to "iconfont" for Elusive Icon, or "image" for traditional.
	// Redux no longer ships with standard icons!
	// Default: iconfont
	//$args['icon_type'] = 'image';

	// Disable the panel sections showing as submenu items.
	// Default: true
	//$args['allow_sub_menu'] = false;

	// Set ANY custom page help tabs, displayed using the new help tab API. Tabs are shown in order of definition.
	$args['help_tabs'][] = array(
	    'id' => 'redux-opts-1',
	    'title' => __('Theme Information 1', 'redux-framework-demo'),
	    'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
	);
	$args['help_tabs'][] = array(
	    'id' => 'redux-opts-2',
	    'title' => __('Theme Information 2', 'redux-framework-demo'),
	    'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
	);

	// Set the help sidebar for the options page.
	$args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo');

	$social_icons = array('fa-adjust' => 'adjust', 
								'fa-adn' => 'adn', 
								'fa-align-center' => 'align-center', 
								'fa-align-justify' => 'align-justify', 
								'fa-align-left' => 'align-left', 
								'fa-align-right' => 'align-right', 
								'fa-ambulance' => 'ambulance', 
								'fa-anchor' => 'anchor', 
								'fa-android' => 'android', 
								'fa-angle-double-down' => 'angle-double-down', 
								'fa-angle-double-left' => 'angle-double-left', 
								'fa-angle-double-right' => 'angle-double-right', 
								'fa-angle-double-up' => 'angle-double-up', 
								'fa-angle-down' => 'angle-down', 
								'fa-angle-left' => 'angle-left', 
								'fa-angle-right' => 'angle-right', 
								'fa-angle-up' => 'angle-up', 
								'fa-apple' => 'apple', 
								'fa-archive' => 'archive', 
								'fa-arrow-circle-down' => 'arrow-circle-down', 
								'fa-arrow-circle-left' => 'arrow-circle-left', 
								'fa-arrow-circle-o-down' => 'arrow-circle-o-down', 
								'fa-arrow-circle-o-left' => 'arrow-circle-o-left', 
								'fa-arrow-circle-o-right' => 'arrow-circle-o-right', 
								'fa-arrow-circle-o-up' => 'arrow-circle-o-up', 
								'fa-arrow-circle-right' => 'arrow-circle-right', 
								'fa-arrow-circle-up' => 'arrow-circle-up', 
								'fa-arrow-down' => 'arrow-down', 
								'fa-arrow-left' => 'arrow-left', 
								'fa-arrow-right' => 'arrow-right', 
								'fa-arrow-up' => 'arrow-up', 
								'fa-arrows' => 'arrows', 
								'fa-arrows-alt' => 'arrows-alt', 
								'fa-arrows-h' => 'arrows-h', 
								'fa-arrows-v' => 'arrows-v', 
								'fa-asterisk' => 'asterisk', 
								'fa-automobile' => 'automobile', 
								'fa-backward' => 'backward', 
								'fa-ban' => 'ban', 
								'fa-bank' => 'bank', 
								'fa-bar-chart-o' => 'bar-chart-o', 
								'fa-barcode' => 'barcode', 
								'fa-bars' => 'bars', 
								'fa-beer' => 'beer', 
								'fa-behance' => 'behance', 
								'fa-behance-square' => 'behance-square', 
								'fa-bell' => 'bell', 
								'fa-bell-o' => 'bell-o', 
								'fa-bitbucket' => 'bitbucket', 
								'fa-bitbucket-square' => 'bitbucket-square', 
								'fa-bitcoin' => 'bitcoin', 
								'fa-bold' => 'bold', 
								'fa-bolt' => 'bolt', 
								'fa-bomb' => 'bomb', 
								'fa-book' => 'book', 
								'fa-bookmark' => 'bookmark', 
								'fa-bookmark-o' => 'bookmark-o', 
								'fa-briefcase' => 'briefcase', 
								'fa-btc' => 'btc', 
								'fa-bug' => 'bug', 
								'fa-building' => 'building', 
								'fa-building-o' => 'building-o', 
								'fa-bullhorn' => 'bullhorn', 
								'fa-bullseye' => 'bullseye', 
								'fa-cab' => 'cab', 
								'fa-calendar' => 'calendar', 
								'fa-calendar-o' => 'calendar-o', 
								'fa-camera' => 'camera', 
								'fa-camera-retro' => 'camera-retro', 
								'fa-car' => 'car', 
								'fa-caret-down' => 'caret-down', 
								'fa-caret-left' => 'caret-left', 
								'fa-caret-right' => 'caret-right', 
								'fa-caret-square-o-down' => 'caret-square-o-down', 
								'fa-caret-square-o-left' => 'caret-square-o-left', 
								'fa-caret-square-o-right' => 'caret-square-o-right', 
								'fa-caret-square-o-up' => 'caret-square-o-up', 
								'fa-caret-up' => 'caret-up', 
								'fa-certificate' => 'certificate', 
								'fa-chain' => 'chain', 
								'fa-chain-broken' => 'chain-broken', 
								'fa-check' => 'check', 
								'fa-check-circle' => 'check-circle', 
								'fa-check-circle-o' => 'check-circle-o', 
								'fa-check-square' => 'check-square', 
								'fa-check-square-o' => 'check-square-o', 
								'fa-chevron-circle-down' => 'chevron-circle-down', 
								'fa-chevron-circle-left' => 'chevron-circle-left', 
								'fa-chevron-circle-right' => 'chevron-circle-right', 
								'fa-chevron-circle-up' => 'chevron-circle-up', 
								'fa-chevron-down' => 'chevron-down', 
								'fa-chevron-left' => 'chevron-left', 
								'fa-chevron-right' => 'chevron-right', 
								'fa-chevron-up' => 'chevron-up', 
								'fa-child' => 'child', 
								'fa-circle' => 'circle', 
								'fa-circle-o' => 'circle-o', 
								'fa-circle-o-notch' => 'circle-o-notch', 
								'fa-circle-thin' => 'circle-thin', 
								'fa-clipboard' => 'clipboard', 
								'fa-clock-o' => 'clock-o', 
								'fa-cloud' => 'cloud', 
								'fa-cloud-download' => 'cloud-download', 
								'fa-cloud-upload' => 'cloud-upload', 
								'fa-cny' => 'cny', 
								'fa-code' => 'code', 
								'fa-code-fork' => 'code-fork', 
								'fa-codepen' => 'codepen', 
								'fa-coffee' => 'coffee', 
								'fa-cog' => 'cog', 
								'fa-cogs' => 'cogs', 
								'fa-columns' => 'columns', 
								'fa-comment' => 'comment', 
								'fa-comment-o' => 'comment-o', 
								'fa-comments' => 'comments', 
								'fa-comments-o' => 'comments-o', 
								'fa-compass' => 'compass', 
								'fa-compress' => 'compress', 
								'fa-copy' => 'copy', 
								'fa-credit-card' => 'credit-card', 
								'fa-crop' => 'crop', 
								'fa-crosshairs' => 'crosshairs', 
								'fa-css3' => 'css3', 
								'fa-cube' => 'cube', 
								'fa-cubes' => 'cubes', 
								'fa-cut' => 'cut', 
								'fa-cutlery' => 'cutlery', 
								'fa-dashboard' => 'dashboard', 
								'fa-database' => 'database', 
								'fa-dedent' => 'dedent', 
								'fa-delicious' => 'delicious', 
								'fa-desktop' => 'desktop', 
								'fa-deviantart' => 'deviantart', 
								'fa-digg' => 'digg', 
								'fa-dollar' => 'dollar', 
								'fa-dot-circle-o' => 'dot-circle-o', 
								'fa-download' => 'download', 
								'fa-dribbble' => 'dribbble', 
								'fa-dropbox' => 'dropbox', 
								'fa-drupal' => 'drupal', 
								'fa-edit' => 'edit', 
								'fa-eject' => 'eject', 
								'fa-ellipsis-h' => 'ellipsis-h', 
								'fa-ellipsis-v' => 'ellipsis-v', 
								'fa-empire' => 'empire', 
								'fa-envelope' => 'envelope', 
								'fa-envelope-o' => 'envelope-o', 
								'fa-envelope-square' => 'envelope-square', 
								'fa-eraser' => 'eraser', 
								'fa-eur' => 'eur', 
								'fa-euro' => 'euro', 
								'fa-exchange' => 'exchange', 
								'fa-exclamation' => 'exclamation', 
								'fa-exclamation-circle' => 'exclamation-circle', 
								'fa-exclamation-triangle' => 'exclamation-triangle', 
								'fa-expand' => 'expand', 
								'fa-external-link' => 'external-link', 
								'fa-external-link-square' => 'external-link-square', 
								'fa-eye' => 'eye', 
								'fa-eye-slash' => 'eye-slash', 
								'fa-facebook' => 'facebook', 
								'fa-facebook-square' => 'facebook-square', 
								'fa-fast-backward' => 'fast-backward', 
								'fa-fast-forward' => 'fast-forward', 
								'fa-fax' => 'fax', 
								'fa-female' => 'female', 
								'fa-fighter-jet' => 'fighter-jet', 
								'fa-file' => 'file', 
								'fa-file-archive-o' => 'file-archive-o', 
								'fa-file-audio-o' => 'file-audio-o', 
								'fa-file-code-o' => 'file-code-o', 
								'fa-file-excel-o' => 'file-excel-o', 
								'fa-file-image-o' => 'file-image-o', 
								'fa-file-movie-o' => 'file-movie-o', 
								'fa-file-o' => 'file-o', 
								'fa-file-pdf-o' => 'file-pdf-o', 
								'fa-file-photo-o' => 'file-photo-o', 
								'fa-file-picture-o' => 'file-picture-o', 
								'fa-file-powerpoint-o' => 'file-powerpoint-o', 
								'fa-file-sound-o' => 'file-sound-o', 
								'fa-file-text' => 'file-text', 
								'fa-file-text-o' => 'file-text-o', 
								'fa-file-video-o' => 'file-video-o', 
								'fa-file-word-o' => 'file-word-o', 
								'fa-file-zip-o' => 'file-zip-o', 
								'fa-files-o' => 'files-o', 
								'fa-film' => 'film', 
								'fa-filter' => 'filter', 
								'fa-fire' => 'fire', 
								'fa-fire-extinguisher' => 'fire-extinguisher', 
								'fa-flag' => 'flag', 
								'fa-flag-checkered' => 'flag-checkered', 
								'fa-flag-o' => 'flag-o', 
								'fa-flash' => 'flash', 
								'fa-flask' => 'flask', 
								'fa-flickr' => 'flickr', 
								'fa-floppy-o' => 'floppy-o', 
								'fa-folder' => 'folder', 
								'fa-folder-o' => 'folder-o', 
								'fa-folder-open' => 'folder-open', 
								'fa-folder-open-o' => 'folder-open-o', 
								'fa-font' => 'font', 
								'fa-forward' => 'forward', 
								'fa-foursquare' => 'foursquare', 
								'fa-frown-o' => 'frown-o', 
								'fa-gamepad' => 'gamepad', 
								'fa-gavel' => 'gavel', 
								'fa-gbp' => 'gbp', 
								'fa-ge' => 'ge', 
								'fa-gear' => 'gear', 
								'fa-gears' => 'gears', 
								'fa-gift' => 'gift', 
								'fa-git' => 'git', 
								'fa-git-square' => 'git-square', 
								'fa-github' => 'github', 
								'fa-github-alt' => 'github-alt', 
								'fa-github-square' => 'github-square', 
								'fa-gittip' => 'gittip', 
								'fa-glass' => 'glass', 
								'fa-globe' => 'globe', 
								'fa-google' => 'google', 
								'fa-google-plus' => 'google-plus', 
								'fa-google-plus-square' => 'google-plus-square', 
								'fa-graduation-cap' => 'graduation-cap', 
								'fa-group' => 'group', 
								'fa-h-square' => 'h-square', 
								'fa-hacker-news' => 'hacker-news', 
								'fa-hand-o-down' => 'hand-o-down', 
								'fa-hand-o-left' => 'hand-o-left', 
								'fa-hand-o-right' => 'hand-o-right', 
								'fa-hand-o-up' => 'hand-o-up', 
								'fa-hdd-o' => 'hdd-o', 
								'fa-header' => 'header', 
								'fa-headphones' => 'headphones', 
								'fa-heart' => 'heart', 
								'fa-heart-o' => 'heart-o', 
								'fa-history' => 'history', 
								'fa-home' => 'home', 
								'fa-hospital-o' => 'hospital-o', 
								'fa-html5' => 'html5', 
								'fa-image' => 'image', 
								'fa-inbox' => 'inbox', 
								'fa-indent' => 'indent', 
								'fa-info' => 'info', 
								'fa-info-circle' => 'info-circle', 
								'fa-inr' => 'inr', 
								'fa-instagram' => 'instagram', 
								'fa-institution' => 'institution', 
								'fa-italic' => 'italic', 
								'fa-joomla' => 'joomla', 
								'fa-jpy' => 'jpy', 
								'fa-jsfiddle' => 'jsfiddle', 
								'fa-key' => 'key', 
								'fa-keyboard-o' => 'keyboard-o', 
								'fa-krw' => 'krw', 
								'fa-language' => 'language', 
								'fa-laptop' => 'laptop', 
								'fa-leaf' => 'leaf', 
								'fa-legal' => 'legal', 
								'fa-lemon-o' => 'lemon-o', 
								'fa-level-down' => 'level-down', 
								'fa-level-up' => 'level-up', 
								'fa-life-bouy' => 'life-bouy', 
								'fa-life-ring' => 'life-ring', 
								'fa-life-saver' => 'life-saver', 
								'fa-lightbulb-o' => 'lightbulb-o', 
								'fa-link' => 'link', 
								'fa-linkedin' => 'linkedin', 
								'fa-linkedin-square' => 'linkedin-square', 
								'fa-linux' => 'linux', 
								'fa-list' => 'list', 
								'fa-list-alt' => 'list-alt', 
								'fa-list-ol' => 'list-ol', 
								'fa-list-ul' => 'list-ul', 
								'fa-location-arrow' => 'location-arrow', 
								'fa-lock' => 'lock', 
								'fa-long-arrow-down' => 'long-arrow-down', 
								'fa-long-arrow-left' => 'long-arrow-left', 
								'fa-long-arrow-right' => 'long-arrow-right', 
								'fa-long-arrow-up' => 'long-arrow-up', 
								'fa-magic' => 'magic', 
								'fa-magnet' => 'magnet', 
								'fa-mail-forward' => 'mail-forward', 
								'fa-mail-reply' => 'mail-reply', 
								'fa-mail-reply-all' => 'mail-reply-all', 
								'fa-male' => 'male', 
								'fa-map-marker' => 'map-marker', 
								'fa-maxcdn' => 'maxcdn', 
								'fa-medkit' => 'medkit', 
								'fa-meh-o' => 'meh-o', 
								'fa-microphone' => 'microphone', 
								'fa-microphone-slash' => 'microphone-slash', 
								'fa-minus' => 'minus', 
								'fa-minus-circle' => 'minus-circle', 
								'fa-minus-square' => 'minus-square', 
								'fa-minus-square-o' => 'minus-square-o', 
								'fa-mobile' => 'mobile', 
								'fa-mobile-phone' => 'mobile-phone', 
								'fa-money' => 'money', 
								'fa-moon-o' => 'moon-o', 
								'fa-mortar-board' => 'mortar-board', 
								'fa-music' => 'music', 
								'fa-navicon' => 'navicon', 
								'fa-openid' => 'openid', 
								'fa-outdent' => 'outdent', 
								'fa-pagelines' => 'pagelines', 
								'fa-paper-plane' => 'paper-plane', 
								'fa-paper-plane-o' => 'paper-plane-o', 
								'fa-paperclip' => 'paperclip', 
								'fa-paragraph' => 'paragraph', 
								'fa-paste' => 'paste', 
								'fa-pause' => 'pause', 
								'fa-paw' => 'paw', 
								'fa-pencil' => 'pencil', 
								'fa-pencil-square' => 'pencil-square', 
								'fa-pencil-square-o' => 'pencil-square-o', 
								'fa-phone' => 'phone', 
								'fa-phone-square' => 'phone-square', 
								'fa-photo' => 'photo', 
								'fa-picture-o' => 'picture-o', 
								'fa-pied-piper' => 'pied-piper', 
								'fa-pied-piper-alt' => 'pied-piper-alt', 
								'fa-pied-piper-square' => 'pied-piper-square', 
								'fa-pinterest' => 'pinterest', 
								'fa-pinterest-square' => 'pinterest-square', 
								'fa-plane' => 'plane', 
								'fa-play' => 'play', 
								'fa-play-circle' => 'play-circle', 
								'fa-play-circle-o' => 'play-circle-o', 
								'fa-plus' => 'plus', 
								'fa-plus-circle' => 'plus-circle', 
								'fa-plus-square' => 'plus-square', 
								'fa-plus-square-o' => 'plus-square-o', 
								'fa-power-off' => 'power-off', 
								'fa-print' => 'print', 
								'fa-puzzle-piece' => 'puzzle-piece', 
								'fa-qq' => 'qq', 
								'fa-qrcode' => 'qrcode', 
								'fa-question' => 'question', 
								'fa-question-circle' => 'question-circle', 
								'fa-quote-left' => 'quote-left', 
								'fa-quote-right' => 'quote-right', 
								'fa-ra' => 'ra', 
								'fa-random' => 'random', 
								'fa-rebel' => 'rebel', 
								'fa-recycle' => 'recycle', 
								'fa-reddit' => 'reddit', 
								'fa-reddit-square' => 'reddit-square', 
								'fa-refresh' => 'refresh', 
								'fa-renren' => 'renren', 
								'fa-reorder' => 'reorder', 
								'fa-repeat' => 'repeat', 
								'fa-reply' => 'reply', 
								'fa-reply-all' => 'reply-all', 
								'fa-retweet' => 'retweet', 
								'fa-rmb' => 'rmb', 
								'fa-road' => 'road', 
								'fa-rocket' => 'rocket', 
								'fa-rotate-left' => 'rotate-left', 
								'fa-rotate-right' => 'rotate-right', 
								'fa-rouble' => 'rouble', 
								'fa-rss' => 'rss', 
								'fa-rss-square' => 'rss-square', 
								'fa-rub' => 'rub', 
								'fa-ruble' => 'ruble', 
								'fa-rupee' => 'rupee', 
								'fa-save' => 'save', 
								'fa-scissors' => 'scissors', 
								'fa-search' => 'search', 
								'fa-search-minus' => 'search-minus', 
								'fa-search-plus' => 'search-plus', 
								'fa-send' => 'send', 
								'fa-send-o' => 'send-o', 
								'fa-share' => 'share', 
								'fa-share-alt' => 'share-alt', 
								'fa-share-alt-square' => 'share-alt-square', 
								'fa-share-square' => 'share-square', 
								'fa-share-square-o' => 'share-square-o', 
								'fa-shield' => 'shield', 
								'fa-shopping-cart' => 'shopping-cart', 
								'fa-sign-in' => 'sign-in', 
								'fa-sign-out' => 'sign-out', 
								'fa-signal' => 'signal', 
								'fa-sitemap' => 'sitemap', 
								'fa-skype' => 'skype', 
								'fa-slack' => 'slack', 
								'fa-sliders' => 'sliders', 
								'fa-smile-o' => 'smile-o', 
								'fa-sort' => 'sort', 
								'fa-sort-alpha-asc' => 'sort-alpha-asc', 
								'fa-sort-alpha-desc' => 'sort-alpha-desc', 
								'fa-sort-amount-asc' => 'sort-amount-asc', 
								'fa-sort-amount-desc' => 'sort-amount-desc', 
								'fa-sort-asc' => 'sort-asc', 
								'fa-sort-desc' => 'sort-desc', 
								'fa-sort-down' => 'sort-down', 
								'fa-sort-numeric-asc' => 'sort-numeric-asc', 
								'fa-sort-numeric-desc' => 'sort-numeric-desc', 
								'fa-sort-up' => 'sort-up', 
								'fa-soundcloud' => 'soundcloud', 
								'fa-space-shuttle' => 'space-shuttle', 
								'fa-spinner' => 'spinner', 
								'fa-spoon' => 'spoon', 
								'fa-spotify' => 'spotify', 
								'fa-square' => 'square', 
								'fa-square-o' => 'square-o', 
								'fa-stack-exchange' => 'stack-exchange', 
								'fa-stack-overflow' => 'stack-overflow', 
								'fa-star' => 'star', 
								'fa-star-half' => 'star-half', 
								'fa-star-half-empty' => 'star-half-empty', 
								'fa-star-half-full' => 'star-half-full', 
								'fa-star-half-o' => 'star-half-o', 
								'fa-star-o' => 'star-o', 
								'fa-steam' => 'steam', 
								'fa-steam-square' => 'steam-square', 
								'fa-step-backward' => 'step-backward', 
								'fa-step-forward' => 'step-forward', 
								'fa-stethoscope' => 'stethoscope', 
								'fa-stop' => 'stop', 
								'fa-strikethrough' => 'strikethrough', 
								'fa-stumbleupon' => 'stumbleupon', 
								'fa-stumbleupon-circle' => 'stumbleupon-circle', 
								'fa-subscript' => 'subscript', 
								'fa-suitcase' => 'suitcase', 
								'fa-sun-o' => 'sun-o', 
								'fa-superscript' => 'superscript', 
								'fa-support' => 'support', 
								'fa-table' => 'table', 
								'fa-tablet' => 'tablet', 
								'fa-tachometer' => 'tachometer', 
								'fa-tag' => 'tag', 
								'fa-tags' => 'tags', 
								'fa-tasks' => 'tasks', 
								'fa-taxi' => 'taxi', 
								'fa-tencent-weibo' => 'tencent-weibo', 
								'fa-terminal' => 'terminal', 
								'fa-text-height' => 'text-height', 
								'fa-text-width' => 'text-width', 
								'fa-th' => 'th', 
								'fa-th-large' => 'th-large', 
								'fa-th-list' => 'th-list', 
								'fa-thumb-tack' => 'thumb-tack', 
								'fa-thumbs-down' => 'thumbs-down', 
								'fa-thumbs-o-down' => 'thumbs-o-down', 
								'fa-thumbs-o-up' => 'thumbs-o-up', 
								'fa-thumbs-up' => 'thumbs-up', 
								'fa-ticket' => 'ticket', 
								'fa-times' => 'times', 
								'fa-times-circle' => 'times-circle', 
								'fa-times-circle-o' => 'times-circle-o', 
								'fa-tint' => 'tint', 
								'fa-toggle-down' => 'toggle-down', 
								'fa-toggle-left' => 'toggle-left', 
								'fa-toggle-right' => 'toggle-right', 
								'fa-toggle-up' => 'toggle-up', 
								'fa-trash-o' => 'trash-o', 
								'fa-tree' => 'tree', 
								'fa-trello' => 'trello', 
								'fa-trophy' => 'trophy', 
								'fa-truck' => 'truck', 
								'fa-try' => 'try', 
								'fa-tumblr' => 'tumblr', 
								'fa-tumblr-square' => 'tumblr-square', 
								'fa-turkish-lira' => 'turkish-lira', 
								'fa-twitter' => 'twitter', 
								'fa-twitter-square' => 'twitter-square', 
								'fa-umbrella' => 'umbrella', 
								'fa-underline' => 'underline', 
								'fa-undo' => 'undo', 
								'fa-university' => 'university', 
								'fa-unlink' => 'unlink', 
								'fa-unlock' => 'unlock', 
								'fa-unlock-alt' => 'unlock-alt', 
								'fa-unsorted' => 'unsorted', 
								'fa-upload' => 'upload', 
								'fa-usd' => 'usd', 
								'fa-user' => 'user', 
								'fa-user-md' => 'user-md', 
								'fa-users' => 'users', 
								'fa-video-camera' => 'video-camera', 
								'fa-vimeo-square' => 'vimeo-square', 
								'fa-vine' => 'vine', 
								'fa-vk' => 'vk', 
								'fa-volume-down' => 'volume-down', 
								'fa-volume-off' => 'volume-off', 
								'fa-volume-up' => 'volume-up', 
								'fa-warning' => 'warning', 
								'fa-wechat' => 'wechat', 
								'fa-weibo' => 'weibo', 
								'fa-weixin' => 'weixin', 
								'fa-wheelchair' => 'wheelchair', 
								'fa-windows' => 'windows', 
								'fa-won' => 'won', 
								'fa-wordpress' => 'wordpress', 
								'fa-wrench' => 'wrench', 
								'fa-xing' => 'xing', 
								'fa-xing-square' => 'xing-square', 
								'fa-yahoo' => 'yahoo', 
								'fa-yen' => 'yen', 
								'fa-youtube' => 'youtube', 
								'fa-youtube-play' => 'youtube-play', 
								'fa-youtube-square' => 'youtube-square');
	$sections = array();

	//Background Patterns Reader
	$sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
	$sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
	$sample_patterns      = array();

	if ( is_dir( $sample_patterns_path ) ) :

	  if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
	  	$sample_patterns = array();

	    while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

	      if( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
	      	$name = explode(".", $sample_patterns_file);
	      	$name = str_replace('.'.end($name), '', $sample_patterns_file);
	      	$sample_patterns[] = array( 'alt'=>$name,'img' => $sample_patterns_url . $sample_patterns_file );
	      }
	    }
	  endif;
	endif;

	$sections[] = array(
				'title' => __('General settings', 'nhp-opts'),
				'desc' => __('<p class="description">General theme settings</p>', 'nhp-opts'),
				'icon' => 'el-icon-cogs',
				//Lets leave this as a blank section, no options just some intro text set above.
				'fields' => array(
					array(
						'id' => 'blogname',
						'type' => 'text',
						'title' => __('Site name', 'nhp-opts'),
						'default' => 'Elixir by Jellythemes',
						),
					array(
				        'id'       => 'logo',
				        'type'     => 'media',
				        'url'      => true,
				        'title'    => __('Logo image', 'jellythemes'),
				        'desc'     => __('Aprox. 132x35px', 'jellythemes'),
				        'default'  => array('url'=> get_stylesheet_directory_uri() . '/images/logo_elixir.png')
				        ),
				    array(
				        'id'       => 'favicon',
				        'type'     => 'media',
				        'url'      => true,
				        'title'    => __('Favicon image', 'jellythemes'),
				        'default'  => array(
				            'url'=> get_stylesheet_directory_uri() . '/favicon.ico'
				        )
				        ),
					array(
						'id'=>'color',
						'type' => 'select',
						'title' => __('Theme color scheme', 'jellythemes'),
						'subtitle' => __('Select your themes alternative color scheme.', 'jellythemes'),
						'options' => array(
											'' => 'Default',
											'red'=>'Red',
											'wine'=>'Wine',
											'gold'=>'Gold',
											'bluegray'=>'Bluegray',
											'orange'=>'Orange',
											'black'=>'Black',
											'yellow'=>'Yellow',
											'green'=>'Green',
									),
						'default' => 'gold',
					),
					array(
						'id'=>'style',
						'type' => 'select',
						'title' => __('Theme style', 'jellythemes'),
						'subtitle' => __('Select your theme style.', 'jellythemes'),
						'options' => array('elegant'=>'Elegant',
											'asian'=>'Asian',
											'american'=>'American',
											'italian'=>'Italian',
									),
						'default' => 'elegant',
					)
				)
					

				);

$sections[] = array(
				'icon' => 'el-icon-bullhorn',
				'title' => __('Contact/Footer info', 'nhp-opts'),
				'desc' => __('<p class="description">Complete contact info</p>', 'nhp-opts'),
				'fields' => array(
					array(
						'id' => 'facebook',
						'type' => 'text',
						'title' => __('Facebook url', 'nhp-opts'),
						'validate' => 'url'
						),
					array(
						'id' => 'facebook_icon',
						'type' => 'select',
						'title' => __('Choose icon', 'nhp-opts'),
						'default' => 'fa-facebook',
						'options' => $social_icons,
						),
					array(
						'id' => 'twitter',
						'type' => 'text',
						'title' => __('Twitter url', 'nhp-opts'),
						'validate' => 'url'
						),
					array(
						'id' => 'twitter_icon',
						'type' => 'select',
						'title' => __('Choose icon', 'nhp-opts'),
						'default' => 'fa-twitter',
						'options' => $social_icons,
						),
					array(
						'id' => 'gplus',
						'type' => 'text',
						'title' => __('Google Plus url', 'nhp-opts'),
						'validate' => 'url'
						),
					array(
						'id' => 'gplus_icon',
						'type' => 'select',
						'title' => __('Choose icon', 'nhp-opts'),
						'default' => 'fa-google-plus',
						'options' => $social_icons,
						),
					array(
						'id' => 'pinterest',
						'type' => 'text',
						'title' => __('Pinterest url', 'nhp-opts'),
						'validate' => 'url'
						),
					array(
						'id' => 'pinterest_icon',
						'type' => 'select',
						'title' => __('Choose icon', 'nhp-opts'),
						'default' => 'fa-pinterest',
						'options' => $social_icons,
						),
					array(
						'id' => 'contact_email',
						'type' => 'text',
						'title' => __('Email for contact form', 'nhp-opts'),
						'validate' => 'email',
						'default' => get_option('admin_email')
						),
					)
				);



	$sections[] = array(
		'type' => 'divide',
	);

	$sections[] = array(
		'icon' => 'el-icon-info-sign',
		'title' => __('Theme Information', 'redux-framework-demo'),
		'desc' => __('<p class="description">This is the Description. Again HTML is allowed</p>', 'redux-framework-demo'),
		'fields' => array(
			array(
				'id'=>'raw_new_info',
				'type' => 'raw',
				'content' => $item_info,
				)
			),
		);


	if(file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
	    $tabs['docs'] = array(
			'icon' => 'el-icon-book',
			'icon_class' => 'icon-large',
	        'title' => __('Documentation', 'redux-framework-demo'),
	        'content' => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
	    );
	}

	global $ReduxFramework;
	$ReduxFramework = new ReduxFramework($sections, $args, $tabs);

	// END Sample Config
	}
	add_action('init', 'redux_init');
endif;

/**

	Remove all things related to the Redux Demo mode.

**/
if ( !function_exists( 'redux_remove_demo_options' ) ):
	function redux_remove_demo_options() {

		// Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
		remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );

		// Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
		if ( class_exists('ReduxFrameworkPlugin') ) {
			remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2 );
		}
	}
	//add_action('init', 'redux_remove_demo_options');
endif;



