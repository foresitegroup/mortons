<?php
/* Template Name: Events */

get_header();

$rightnow = strtotime("Today");

$args = array (
  'post_type' => 'events',
  'orderby'   => 'meta_value_num',
  'order'     => 'ASC',
  'showposts' => -1,
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
?>

<style>
.event {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  border-top: 3px solid rgba(0,0,0,0.3);
  padding: 50px 0;
}

.event:first-of-type { border-top: 0; padding-top: 30px; }

.event:last-of-type { padding-bottom: 80px; }

.event .text { width: 60%; }

.event .text H4 { font-size: 2em; line-height: 1.2em; }

.event .text P { margin: 0.75em 0 0; }

.event .image {
  width: 33%;
  background-repeat: no-repeat;
  background-position: center center;
  background-size: cover;
}

.event .image:before {
  content: "";
  display: block;
  padding-top: 100%;
}

@media only screen and (max-width: 800px) {
  .event { flex-direction: column; }
  .event .text, .event .image { width: 100%; }
  .event .image { margin-top: 2em; }
}

@media only screen and (max-width: 480px) {
  .event .text H2 { font-size: 5.4vw; }
  .event .text H3 { font-size: 4.4vw; }
  .event .text H4 { font-size: 7.5vw; line-height: 1.2em; }
}
</style>

<section class="container blog">
  <div class="post-title">
    <h2><?php the_title() ?></h2>
  </div>

  <div class="row">
    <div class="col-sm-12">
      <?php
      if ($events->have_posts()) {
        while ($events->have_posts() ) : $events->the_post();
          echo '<div class="event">';
            echo '<div class="text">';
              echo "<h2>" . date("l, F j", $post->event_date_start);

              if ($post->event_date_end != "") {
                if (date("F j", $post->event_date_start) != date("F j", $post->event_date_end)) {
                  echo " - ";

                  if (date("M", $post->event_date_start) != date("M", $post->event_date_end))
                    echo date("l, F ", $post->event_date_end);

                  echo date("j", $post->event_date_end);
                }
              }

              echo "</h2>";

              if (date("H:i", $post->event_date_start) != "00:00") {
                echo "<h3>".date("g:i A", $post->event_date_start);

                if (date("H:i", $post->event_date_end) != "00:00" && date("H:i", $post->event_date_start) != date("H:i", $post->event_date_end))
                  echo " - ".date("g:i A", $post->event_date_end);

                echo "</h3>";
              }

              the_title("<h4>","</h4>");

              if ($post->events_url != "") echo '<a href="'.$post->events_url.'" target="new">'.$post->events_url.'</a>';

              the_content();
            echo "</div>\n";

            echo '<div class="image"';
            if (has_post_thumbnail()) echo ' style="background-image: url('.get_the_post_thumbnail_url().');"';
            echo '></div>';
          echo "</div>\n";
        endwhile;
      } else {
        echo "<h2>Sorry, there are no upcoming events. Check back later.</h2>";
      }
      ?>
    </div>
  </div>
</section>

<?php
wp_reset_postdata();

get_footer();
?>