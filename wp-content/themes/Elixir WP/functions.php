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


/////////////////
// EVENTS
/////////////////
add_action('init', 'events');
function events() {
  register_post_type('events', array(
      'labels' => array(
        'name' => 'Events',
        'singular_name' => 'Event',
        'add_new_item' => 'Add New Event',
        'edit_item' => 'Edit Event',
        'search_items' => 'Search Events',
        'not_found' => 'No Events found'
      ),
      'show_ui' => true,
      'menu_position' => 55,
      'menu_icon' => 'dashicons-calendar-alt',
      'supports' => array('title', 'editor', 'thumbnail')
  ));
}

add_filter('enter_title_here', 'events_title');
function events_title($input) {
  if (get_post_type() === 'events') return "Enter event name here";
  return $input;
}

add_filter('wp_insert_post_data', 'events_custom_permalink');
function events_custom_permalink($data) {
  if ($data['post_type'] == 'events') {
    $data['post_name'] = sanitize_title($data['post_title']);
  }
  return $data;
}

// Place fields after the title
add_action('edit_form_after_title', 'events_after_title');
function events_after_title($post) {
  if (get_post_type() == 'events') {
    ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
      jQuery(document).ready(function(){
        jQuery('#date_start, #date_end').flatpickr({
          altInput: true, altFormat: "n/j/y h:i K", dateFormat: "Y-m-d H:i",
          enableTime: true, defaultHour: "0"
        });
      });
    </script>

    <input type="text" name="event_date_start" value="<?php if ($post->event_date_start != "") echo date("Y-m-d H:i", $post->event_date_start); ?>" id="date_start" placeholder="Start Date/Time">
    <input type="text" name="event_date_end" value="<?php if ($post->event_date_end != "") echo date("Y-m-d H:i", $post->event_date_end); ?>" id="date_end" placeholder="End Date/Time">
    <br>
    If the event is just one day with no end time, leave End Date/Time blank.<br>
    If it is an all-day event, leave the time to the default "12:00 AM".<br>
    <br>

    <?php
    echo '<input type="text" name="events_url" placeholder="URL (optional)" value="';
    if ($post->events_url != "") echo $post->events_url;
    echo '" id="events_url"><br><br>';
  }
}

add_action('admin_head', 'events_css');
function events_css() {
  if (get_post_type() == 'events') {
    echo '<style>
      .flatpickr-input, #events_url { padding: 3px 8px; font-size: 1.5em; line-height: 100%; height: 1.7em; width: 100%; outline: 0; }
      .flatpickr-input { margin-top: 1em; background: #FFFFFF !important; width: auto; }
      .wp-list-table #title { width: 60%; }
      .wp-list-table #event_date_start { width: 30%; }
    </style>';
  }
}

function events_required_fields() {
  if (get_post_type() != 'events') return;

  if (empty($_POST['event_date_start'])) {
    wp_die('The Start Date/Time is REQUIRED. Click the back button on your browser and set it.'); 
  } 
}
add_action('pre_post_update', 'events_required_fields');

add_action('save_post', 'events_save');
function events_save($post_id) {
  if (get_post_type() != 'events') return;

  if (!empty($_POST['event_date_start'])) {
    update_post_meta($post_id, 'event_date_start', strtotime($_POST['event_date_start']));
  } else {
    delete_post_meta($post_id, 'event_date_start');
  }

  if (!empty($_POST['event_date_end'])) {
    update_post_meta($post_id, 'event_date_end', strtotime($_POST['event_date_end']));
  } else {
    delete_post_meta($post_id, 'event_date_end');
  }

  if (!empty($_POST['events_url'])) {
    update_post_meta($post_id, 'events_url', $_POST['events_url']);
  } else {
    delete_post_meta($post_id, 'events_url');
  }
}


add_filter('manage_events_posts_columns', 'set_custom_edit_events_columns');
function set_custom_edit_events_columns($columns) {
  unset($columns['date']);

  $columns['event_date_start'] = "Event Date";

  return $columns;
}

add_action('manage_events_posts_custom_column', 'custom_events_column', 10, 2);
function custom_events_column($column, $post_id) {
  switch ($column) {
    case 'event_date_start':
      if (get_post_meta($post_id, 'event_date_start', true) != "")
        echo date("n/j/y", get_post_meta($post_id, 'event_date_start', true));

      if (get_post_meta($post_id, 'event_date_end', true) != "" && date("n/j/y", get_post_meta($post_id, 'event_date_start', true)) != date("n/j/y", get_post_meta($post_id, 'event_date_end', true)))
        echo " - ".date("n/j/y", get_post_meta($post_id, 'event_date_end', true));

      if (get_post_meta($post_id, 'event_date_start', true) != "" && date("g:i A", get_post_meta($post_id, 'event_date_start', true)) != "12:00 AM") {
        echo "<br>".date("g:i A", get_post_meta($post_id, 'event_date_start', true));

        if (get_post_meta($post_id, 'event_date_end', true) != "" && date("g:i A", get_post_meta($post_id, 'event_date_start', true)) != date("g:i A", get_post_meta($post_id, 'event_date_end', true)))
        echo " - ".date("g:i A", get_post_meta($post_id, 'event_date_end', true));
      }

      break;
  }
}

add_filter('manage_edit-events_sortable_columns', 'set_custom_events_sortable_columns');
function set_custom_events_sortable_columns($columns) {
  $columns['event_date_start'] = 'event_date_start';
  return $columns;
}

add_action('pre_get_posts', 'events_custom_orderby', 4);
function events_custom_orderby($query) {
  if (!$query->is_main_query() || 'events' != $query->get('post_type')) return;

  $orderby = $query->get('orderby');

  if ($orderby == '' || $orderby == 'event_date_start') {
    $query->set('meta_key', 'event_date_start');
    $query->set('orderby', 'meta_value_num');
  }
}


// Creates post duplicate as a draft and redirects then to the edit post screen
function duplicate_event(){
  global $wpdb;
  if (!(isset( $_GET['post']) || isset( $_POST['post']) || (isset($_REQUEST['action']) && 'duplicate_event' == $_REQUEST['action']))) wp_die('No post to duplicate has been supplied!');

  if (!isset($_GET['duplicate_nonce']) || !wp_verify_nonce($_GET['duplicate_nonce'], basename( __FILE__ )))
    return;
 
  // Get original post ID
  $post_id = (isset($_GET['post']) ? absint( $_GET['post']) : absint($_POST['post']));

  // and all the original post data
  $post = get_post($post_id);

  $current_user = wp_get_current_user();
  $new_post_author = $current_user->ID;
 
  // if post data exists, create the post duplicate
  if (isset( $post ) && $post != null) {
    $args = array(
      'comment_status' => $post->comment_status,
      'ping_status'    => $post->ping_status,
      'post_author'    => $new_post_author,
      'post_content'   => $post->post_content,
      'post_excerpt'   => $post->post_excerpt,
      'post_name'      => $post->post_name,
      'post_parent'    => $post->post_parent,
      'post_password'  => $post->post_password,
      'post_status'    => 'draft',
      'post_title'     => $post->post_title,
      'post_type'      => $post->post_type,
      'to_ping'        => $post->to_ping,
      'menu_order'     => $post->menu_order
    );

    $new_post_id = wp_insert_post($args);

    $taxonomies = get_object_taxonomies($post->post_type);
    foreach ($taxonomies as $taxonomy) {
      $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
      wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
    }

    $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");

    if (count($post_meta_infos) != 0) {
      $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";

      foreach ($post_meta_infos as $meta_info) {
        $meta_key = $meta_info->meta_key;
        if ($meta_key == '_wp_old_slug') continue;
        $meta_value = addslashes($meta_info->meta_value);
        $sql_query_sel[] = "SELECT $new_post_id, '$meta_key', '$meta_value'";
      }

      $sql_query .= implode(" UNION ALL ", $sql_query_sel);
      $wpdb->query($sql_query);
    }

    wp_redirect(admin_url('post.php?action=edit&post=' . $new_post_id));

    exit;
  } else {
    wp_die('Post creation failed, could not find original post: ' . $post_id);
  }
}
add_action('admin_action_duplicate_event', 'duplicate_event');
 
// Add the duplicate link to action list for post_row_actions
function duplicate_event_link( $actions, $post ) {
  if (current_user_can('edit_posts') && $post->post_type=='events')
    $actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=duplicate_event&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce') . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
  
  return $actions;
}
add_filter( 'post_row_actions', 'duplicate_event_link', 10, 2 );


function events_home_shortcode() {
  $output = '
    <style>
      #events { margin-bottom: 0; padding: 0; }
      #events H2.heading { padding-top: 66px; letter-spacing: 0.05em; }
      .events-home-cols { display: flex; justify-content: space-between; }
      .event-home { width: 28%; }
      .event-home H2, .event-home H3, .event-home H4 { font-family: Oswald; }
      .event-home H4 { font-size: 2.2em; line-height: 1.2em; margin-bottom: 0.25em; }
      .events-home .button.menu { margin: 30px auto 66px; }
      .events-home .button.menu:before, .events-home .button.menu:after { content: ""; }

      @media only screen and (max-width: 1000px) {
        .event-home H4 { font-size: 3vw; line-height: 1.2em; }
      }

      @media only screen and (max-width: 800px) {
        .events-home-cols { flex-direction: column; }
        .event-home { width: 100%; padding: 15px 0; text-align: center; }
        .event-home H4 { font-size: 2.2em; line-height: 1.2em; }
      }
    </style>
  ';

  $output .= '<div class="events-home">';

    $rightnow = strtotime("Today");

    $args = array (
      'post_type' => 'events',
      'orderby'   => 'meta_value_num',
      'order'     => 'ASC',
      'showposts' => 3,
      'meta_query' => array(
          'relation'=>'OR',
           array(
              'key' => 'event_date_start',
              'value' => $rightnow,
              'compare' => '>=',
              'type' => 'NUMERIC'
           ),
           array(
              'key' => 'event_date_end',
              'value' => $rightnow,
              'compare' => '>=',
              'type' => 'NUMERIC'
           ),
           array('key' => 'event_date_start', 'compare' => 'NOT EXISTS')
       )
    );

    $events = new WP_Query($args);
    
    if ($events->have_posts()) {
      $output .= '<h2 class="heading">Events</h2>';

      $output .= '<div class="events-home-cols">';

        while ($events->have_posts() ) : $events->the_post();
          $output .= '<div class="event-home">';
            $output .= "<h2>" . date("F j", get_post_meta(get_the_ID(), 'event_date_start', true));

            if ($post->event_date_end != "") {
              if (date("F j", get_post_meta(get_the_ID(), 'event_date_start', true)) != date("F j", get_post_meta(get_the_ID(), 'event_date_end', true))) {
                $output .= " - ";

                if (date("M", get_post_meta(get_the_ID(), 'event_date_start', true)) != date("M", get_post_meta(get_the_ID(), 'event_date_end', true)))
                  $output .= date("F ", get_post_meta(get_the_ID(), 'event_date_end', true));

                $output .= date("j", get_post_meta(get_the_ID(), 'event_date_end', true));
              }
            }

            $output .= "</h2>";

            if (date("H:i", get_post_meta(get_the_ID(), 'event_date_start', true)) != "00:00") {
              $output .= "<h3>".date("g:i A", get_post_meta(get_the_ID(), 'event_date_start', true));

              if (date("H:i", get_post_meta(get_the_ID(), 'event_date_end', true)) != "00:00" && date("H:i", get_post_meta(get_the_ID(), 'event_date_start', true)) != date("H:i", get_post_meta(get_the_ID(), 'event_date_end', true)))
                $output .= " - ".date("g:i A", get_post_meta(get_the_ID(), 'event_date_end', true));

              $output .= "</h3>";
            }

            $output .= "<h4>".get_the_title()."</h4>";

            $output .= wp_trim_words(get_the_excerpt(), 30, '...<br><a href="'.home_url().'/events/">Read More</a>');

          $output .= "</div>\n";
        endwhile;

      $output .= '</div>';

      $output .= '<a href="'.home_url().'/events/" class="button menu center">View All Events</a>';
    }
  
  $output .= '</div>';

  return $output;
}
add_shortcode('events-home', 'events_home_shortcode');


function fg_jellythemes_map($atts, $content = null) {
  $return = '
  <style>
  #location { margin-bottom: 0; }
  #maps IFRAME { position: absolute; top: 0; left: 0; height: 100%; width: 100%; }
  </style>
  <div id="maps">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1451.9342164115335!2d-87.98978744262682!3d43.296076868708674!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8804e56bbf91c04d%3A0x43853b2c4434e4a!2sMorton&#39;s+Wisconsinn!5e0!3m2!1sen!2sus!4v1549488290380" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
  </div>';
  
  return $return;
}
add_shortcode('fg_jellythemes_map', 'fg_jellythemes_map');
?>