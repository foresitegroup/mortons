<?php
	//[jellythemes_photos] display latest works width filter menu
		add_shortcode( 'jellythemes_photos', 'jellythemes_photos_list' );
		function jellythemes_photos_list($atts, $content=null) {
		    extract( shortcode_atts( array(
		        'limit' => 8,
		        ), $atts ) );

		    $return  = '
		        <nav class="primary"><ul>
	                          <li><a class="selected" href="#" data-filter="*"><span>' . __('All photos', 'jellythemes') .'</span></a></li>';

		    $types = get_terms('type', array('hide_empty'=>0));

		    if ( $types && ! is_wp_error( $types ) ) :
		        foreach ( $types as $type ) {
		        	$return .= '<li><a href="#" data-filter=".'. esc_js($type->slug)  . '"><span>' . $type->name . '</span></a></li>';
		        }
		    endif;
		    $return .= '</ul></nav>
                        <div class="portfolio">';
		                $photos = new WP_Query(array('post_type'=>'photo', 'posts_per_page' => esc_attr($limit)));
		                while ($photos->have_posts()) : $photos->the_post();
		                    $term_list = wp_get_post_terms(get_the_ID(), 'type', array("fields" => "names"));
				           	$images = rwmb_meta( '_jellythemes_project_images', 'type=plupload_image', get_the_ID() );
                    		foreach($images as $image) :
                    			$img = wp_get_attachment_image( $image['ID'], 'full', false, array('class' => 'img-responsive'));
                    			$src = wp_get_attachment_image_src( $image['ID'], 'full');
                    		endforeach;
                            $return .= '<article class="' . implode(' ', get_post_class('entry')) . '">
			                                <a class="swipebox" href="'.$src[0].'">
			                                '.$img.'
			                                <span class="magnifier"></span>
			                                </a>
			                            </article>';
		                endwhile;
		    $return .=  '</div>';
		    return $return;
		}


	// Image title
	function jellythemes_ball($atts) {
		extract( shortcode_atts( array(
	        'image' => '',
	        'title' => 'About us'
		), $atts ) );
		$img = wp_get_attachment_image_src($image, 'member_photo');
	   	return '<div class="ball"><img src="' . $img[0] . '" alt="' . esc_attr($title) . '"></div>';
	}
	add_shortcode( 'jellythemes_ball', 'jellythemes_ball' );

	// Titles shortcode
	function jellythemes_title( $atts, $content = null ) {
		extract( shortcode_atts( array(
	        'type' => 'section-title',
		), $atts ) );
		if ($type=='deco') {
			return '<h2 class="section-title"><span class="timetable-decorator"></span><span class="opening-hours">' . $content . '</span><span class="timetable-decorator2"></span></h2>';
		} elseif ($type=='menu') {
			return '<h3>' . $content . '</h3>';
		} elseif ($type=='reservation') {
			return '<h3 class="reservation-phone">' . $content . '</h3>';
		} elseif ($type=='reservation2') {
			return '<h4><span>' . $content . '</span></h4>';
		} elseif ($type=='reservation3') {
			return '<h4><span class="above">' . $content . '</span></h4>';
		} elseif ($type=='testimonial') {
			return '<h2>' . $content . '<span>”</span></h2>';
		} elseif ($type=='single') {
			return '<h2 class="title">' . $content . '</h2>';
		} elseif ($type=='single-first') {
			return '<h2 class="title first">' . $content . '</h2>';
		} else {
			return '<h2 class="' . esc_attr($type) . '">' . $content . '</h2>';
		}
	}
	add_shortcode( 'jellythemes_title', 'jellythemes_title' );


	function jellythemes_separator( $atts, $content = null ) {
	   return '<div class="ornament"></div>';
	}
	add_shortcode( 'jellythemes_separator', 'jellythemes_separator' );

	function jellythemes_voffset( $atts, $content = null ) {
		extract( shortcode_atts( array(
	        'height' => '',
		), $atts ) );
	   return '<div class="voffset' . esc_attr($height) . '"></div>';
	}
	add_shortcode( 'jellythemes_voffset', 'jellythemes_voffset' );

	function jellythemes_button( $atts, $content = null ) {
		extract( shortcode_atts( array(
	        'type' => '',
	        'link' => '#'
		), $atts ) );
	   return '<a href="' . esc_attr($link) . '" class="button ' . esc_attr($type) . '">' . wp_strip_all_tags($content) . '</a>';
	}
	add_shortcode( 'jellythemes_button', 'jellythemes_button' );

	//[jellythemes_featured] displays featureds works carousel
	function jellythemes_featured($atts, $content=null) {
	    extract( shortcode_atts( array(
	        'limit' => 5,
	        'portfolio_link' => '#',
	        'portfolio_button' => 'Go portfolio'
	        ), $atts ) );
	    global $post;
	    $back=$post; //Backup post data
	    $return = '<div class="carousel-wrapper full with_buttons with_pagination round_inner">
                        <div id="owl-featured-works" class="owl-carousel generic-carousel">';
		$projects = new WP_Query(array('meta_key' => '_jellythemes_project_featured', 'meta_value' => '1', 'post_type'=>'works', 'posts_per_page' => esc_attr($limit)));
        while ($projects->have_posts()) : $projects->the_post();
            $images = rwmb_meta( '_jellythemes_project_bg_featured', 'type=plupload_image', get_the_ID() );
            foreach($images as $img) :
            	$large = wp_get_attachment_image_src( $img['ID'], 'full');
            	break;
            endforeach;
            $return .= '<div class="project">
                                <img class="bg" src="' .  $large[0] .'" alt="">
                                <div class="col-md-6 jt_col featured-info text-right">
                                    <div class="voffset150"></div>
                                    <h2 class="title invert-2">' . get_post_meta( $post->ID, '_jellythemes_work_featured_title', true ). '</h2>
                                    <h3 class="subtitle mini">' . get_post_meta( $post->ID, '_jellythemes_work_featured_type', true ). '</h3>
                                    <div class="voffset100"></div>
                                    <a href="' . get_post_meta( $post->ID, '_jellythemes_project_url', true ) . '" class="button inverse next">'. __("Go Website", 'jellythemes') . '</a>
                                </div>
                            </div>';
        endwhile;
        $post=$back; //restore post object
        $return .= '</div></div>';
	    return $return;
	}
	add_shortcode( 'jellythemes_featured', 'jellythemes_featured' );

	function jellythemes_content( $atts, $content = null ) {
		extract( shortcode_atts( array(
	        'class' => 'section-subtitle'
		), $atts ) );
		$content = preg_replace('#^<\/p>|<p>$#', '', $content);
	   return '<div class="' . esc_attr($class) . '">' . $content . '</div>';
	}
	add_shortcode( 'jellythemes_content', 'jellythemes_content' );

	function jellythemes_content2( $atts, $content = null ) {
		extract( shortcode_atts( array(
	        'class' => 'section-subtitle'
		), $atts ) );
		$content = preg_replace('#^<\/p>|<p>$#', '', $content);
	   return '<div class="' . esc_attr($class) . '">' . $content . '</div>';
	}
	add_shortcode( 'jellythemes_content2', 'jellythemes_content2' );

	function jellythemes_images_carousel( $atts, $content = null ) {
		extract( shortcode_atts( array(
	        'images' => array(),
	        'type' => '',
	        'pagination' => 'generic-carousel ',
	        'buttons' => '',
		), $atts ) );
		$return = '';
		$images_ids = explode(',',$images);

		$return = '<div class="carousel-wrap ' . esc_attr($type) . esc_attr($pagination) . '">
            <div class="jelly-carousel">';
            	foreach ($images_ids as $id) {
		        	$return .=  '<div class="item">' . wp_get_attachment_image($id, 'full')  .  '</div>';
		        }
        $return .= '</div>
        </div>';

        return $return;
	}
	add_shortcode( 'jellythemes_images_carousel', 'jellythemes_images_carousel' );

	//[jellythemes_team] displays featureds works carousel
	function jellythemes_team($atts, $content=null) {
	    extract( shortcode_atts( array(
	        'limit' => 5
	        ), $atts ) );
	    global $post;
	    $back=$post; //Backup post data
	    $return = '<div class="team-wrapper clearfix">';
		$membmers = new WP_Query(array('post_type'=>'team_members', 'posts_per_page' => esc_attr($limit)));
        while ($membmers->have_posts()) : $membmers->the_post();
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
                                        $return .= !get_post_meta( $post->ID, '_jellythemes_member_dribbble', true ) ? '' : '<a class="icon di" href="' . get_post_meta( $post->ID, '_jellythemes_member_dribbble', true ). '">Dribbble</a>';
            $return .= '            </div>
                                </div>
                            </div>';
        endwhile;
        $post=$back; //restore post object
        $return .= '</div>';
         if ($membmers->max_num_pages) {$return .= '<a data-perpage="' . esc_js($limit) . '" data-total="' . $membmers->found_posts . '" href="' . get_template_directory_uri() . '/inc/more.php" class="pag-more team">' . __('View more', 'jellythemes') . '</a>';}
	    return $return;
	}
	add_shortcode( 'jellythemes_team', 'jellythemes_team' );

	//[jellythemes_services] displays services
	function jellythemes_services_list($atts, $content=null) {
	    extract( shortcode_atts( array(
	        'limit' => 5
	        ), $atts ) );
	    global $post;
	    $back=$post; //Backup post data
	    $return = '<div class="carousel-wrapper full with_pagination">
                            <div id="owl-services" class="owl-carousel generic-carousel">';
		$services = new WP_Query(array('post_type'=>'services', 'posts_per_page' => esc_attr($limit)));
        while ($services->have_posts()) : $services->the_post();
            $icon = get_post_meta( $post->ID, '_jellythemes_service_icon', true );
            $text = get_post_meta( $post->ID, '_jellythemes_service_text', true );
            if ($services->current_post==0 || $services->current_post%6==0) {
            	$return .= '<ul class="ulitem clearfix">';
            }
            $return .= '<li>
                       	<i class="icon"><i class="fa ' . esc_attr($icon) . '"></i></i>
                        <h3>' . get_the_title() . '</h3>
                        <div class="service-text">' . $text . '</div></li>';
            if ($services->current_post==$services->found_posts || (($services->current_post+1)%6==0 && $services->current_post>0)) {
            	$return .= '</ul>';
            }
        endwhile;
        $post=$back; //restore post object
        $return .= '</div></div>';
	    return $return;
	}

	add_shortcode( 'jellythemes_services', 'jellythemes_services_list' );

	//Counters shortcode
	function jellythemes_map( $atts, $content = null ) {
		extract( shortcode_atts( array(
	        'latitude' => '40.780762',
	        'longitude' => '-73.987291',
	        'marker_name' => 'My Company'
		), $atts ) );
		$return = '
		<div id="maps" data-lat="' . esc_js($latitude) . '" data-lon="' . esc_js($longitude) . '" data-marker="' . esc_attr($marker_name) . '">
            <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
            <div class="map-content">
                <div class="wpgmappity_container inner-map" id="wpgmappitymap"></div>
            </div>
        </div>';
        return $return;
	}
	add_shortcode( 'jellythemes_map', 'jellythemes_map' );

	// Skills bar shortcode
	function jellythemes_skills( $atts, $content = null ) {
		extract( shortcode_atts( array(
	        'counter' => '100',
	        'skill' => 'Web development'
		), $atts ) );
		$return = '<div class="skill-content">
	                    <div class="progress-bar skill-2">
	                      <div class="skill-in" title="' . esc_attr($counter) . '"><div class="info-skills">' . esc_attr($skill) . ' <span>- ' . esc_attr($counter) . '%</span></div></div>
	                    </div>
	                </div>';

        return $return;
	}
	add_shortcode( 'jellythemes_skills', 'jellythemes_skills' );


	//[jellythemes_services] displays services
	function jellythemes_testimonials_list($atts, $content=null) {
	    extract( shortcode_atts( array(
	        'limit' => 5
	        ), $atts ) );
	    global $post;
	    $back=$post; //Backup post data
	    $return = '<div class="testimonials carousel-wrapper  with_pagination">
                            <div class="owl-carousel generic-carousel">';
		$testimonials = new WP_Query(array('post_type'=>'testimonials', 'posts_per_page' => esc_attr($limit)));
        while ($testimonials->have_posts()) : $testimonials->the_post();
            $return .= '<div class="item">
                            <p>' . strip_tags(get_post_meta( $post->ID, '_jellythemes_testimonial', true )). '</p>
                            <span class="author">' . get_post_meta( $post->ID, '_jellythemes_author_name', true ). '</span>
                        </div>';
        endwhile;
        $post=$back; //restore post object
		$return .=  '</div>
                </div>';
	    return $return;
	}

	add_shortcode( 'jellythemes_testimonials', 'jellythemes_testimonials_list' );

	// Carousel logos shortcode
	function jellythemes_logos_carousel( $atts, $content = null ) {
		extract( shortcode_atts( array(
	        'images' => array()
		), $atts ) );
		$return = '';
		$images_ids = explode(',',$images);
		$return = '<ul class="clients-list clearfix">';
        foreach ($images_ids as $id) {
        	$return .=  '<li>' . wp_get_attachment_image($id, 'full')  .  '</li>';
        }
        $return .= '</ul>';
        return $return;
	}
	add_shortcode( 'jellythemes_logos_carousel', 'jellythemes_logos_carousel' );

	//Image separator shortcode
	function jellythemes_image( $atts, $content = null ) {
		extract( shortcode_atts( array(
	        'image' => '',
	        'class' => '',
		), $atts ) );
		$return = 	wp_get_attachment_image($image, 'full', false, array('class' => esc_attr($class)));
        return $return;
	}
	add_shortcode( 'jellythemes_image', 'jellythemes_image' );

	//contact info shortcode
	function jellythemes_contact_info( $atts, $content = null ) {

		global $jellythemes;
	   return '<form action="' . get_template_directory_uri() . '/inc/mail.php" method="post" id="contactform" class="contact-form">
                <div class="col-md-6 jt_col column_container">
                	<input name="emailto" type="hidden" value="' . $jellythemes['contact_email'] . '">
                    <input type="text" id="name" name="name" class="name required" placeholder="' . __('Name', 'jellythemes') . '" >
                    <input type="email" id="email" name="email" class="email required" placeholder="' . __('Email', 'jellythemes') . '" >
                    <input type="text" id="subject" name="subject" placeholder="' . __('Subject', 'jellythemes') . '" >
                </div>

                <div class="col-md-6 jt_col column_container">
                     <textarea id="message" name="message" class="text area required" placeholder="' . __('Message', 'jellythemes') . '" rows="10"></textarea>
                </div>

                <div class="col-md-4 col-md-offset-4 jt_col column_container">
                <div class="formSent">' . __('<strong>Your Message Has Been Sent!</strong> Thank you for contacting us.', 'jellythemes') . '</div>
                <input type="submit" class="button contact center" value="' . __('Submit', 'jellythemes') . '" >
                </div>

            </form>
            <div class="voffset100"></div>';
	}
	add_shortcode( 'jellythemes_contact_info', 'jellythemes_contact_info' );


	//reservation form shortcode
	function jellythemes_reservation_form( $atts, $content = null ) {
		extract( shortcode_atts( array(
		), $atts ) );
		global $jellythemes;
	   	return '<form action="' . get_template_directory_uri() . '/inc/reservation.php" method="post" id="reservationform" class="contact-form">
                            <div class="col-md-5 col-md-offset-1 jt_col column_container">
                                <p>Book a table</p>
                                <input name="emailto" type="hidden" value="' . $jellythemes['contact_email'] . '">
                                <input type="date" onfocus="(this.type=\'date\')" id="date" name="date" placeholder="' . __('Date', 'jellythemes') . '" class="text date required" >
                                <input type="time" onfocus="(this.type=\'date\')" id="time" name="time" placeholder="' . __('Time', 'jellythemes') . '" class="text time required" >
                                <input type="text" id="party" name="party" placeholder="' . __('Party', 'jellythemes') . '" class="text party required" >
                            </div>

                            <div class="col-md-5 jt_col column_container">
                                <p>Contact Details</p>
                                <input type="text" id="reservation_name" name="reservation_name" placeholder="' . __('Name', 'jellythemes') . '" class="text reservation_name required" >
                                <input type="email" id="reservation_email" name="reservation_email" class="tex email required" placeholder="' . __('Email', 'jellythemes') . '" >
                                <input type="text" id="reservation_phone" name="reservation_phone" placeholder="' . __('Phone', 'jellythemes') . '" class="text reservation_phone required">
                            </div>

                            <div class="col-md-10 col-md-offset-1 jt_col column_container">
                                <textarea id="reservation_message" name="reservation_message" class="text area required" placeholder="' . __('Message', 'jellythemes') . '" rows="6"></textarea>
                            </div>
                            <div class="col-md-4 col-md-offset-4 jt_col column_container">
                            <div class="formSent">' . __('<strong>Your Message Has Been Sent!</strong> Thank you for contacting us.', 'jellythemes') . '</div>
                                <input type="submit" class="button center" value="' . __('Make reservation', 'jellythemes') . '" >
                            </div>
                        </form>
                        <div class="col-md-12 jt_col column_container">
                        <div class="voffset60"></div>
                            <div class="ornament"></div>
                        </div>';
	}
	add_shortcode( 'jellythemes_reservation_form', 'jellythemes_reservation_form' );


	//[jellythemes_menuitem] displays menu item
	function jellythemes_menuitem($atts, $content=null) {
	    extract( shortcode_atts( array(
	        'position' => '',
	        'detail' => '',
	        'price' => '',
	        'title' => ''
 	        ), $atts ) );
	    $return = '';
	    if ($position=='first') { $return = '<ul>'; }
	    if ($position=='first-single') { $return = '<ul class="menu">'; }
	    $return .= 	'<li>
	                	' . esc_attr($title) . '
	                	<div class="detail">' . esc_attr($detail) . '<span class="price">' . esc_attr($price) . '</span></div>
	            	</li>';
        if ($position=='last') { $return .= '</ul>'; }
	    return $return;
	}

	add_shortcode( 'jellythemes_menuitem', 'jellythemes_menuitem' );
	if (function_exists('vc_remove_element')) {
		vc_map( array(
		   "name" => __("Menu item", 'jellythemes'),
		   "base" => "jellythemes_menuitem",
		   "class" => "",
		   "icon" => "jelly-icon",
		   "category" => __('Elixir Theme', 'jellythemes'),
		   "params" => array(
		      array(
		         "type" => "textfield",
		         "holder" => "div",
		         "class" => "",
		         "heading" => __("Dish name",'jellythemes'),
		         "param_name" => "title",
		         "value" => __("Dish name", 'jellythemes'),
		         "description" => __("Enter the dish name.", 'jellythemes')
		      ),
		      array(
		         "type" => "textfield",
		         "holder" => "div",
		         "class" => "",
		         "heading" => __("Detail",'jellythemes'),
		         "param_name" => "detail",
		         "value" => __("Ingredients/Explanation", 'jellythemes'),
		      ),
		      array(
		         "type" => "textfield",
		         "holder" => "div",
		         "class" => "",
		         "heading" => __("Price",'jellythemes'),
		         "param_name" => "price",
		         "value" => __("$22.00", 'jellythemes'),
		      ),
		      array(
			      "type" => "dropdown",
			      "heading" => __('Position', 'jellythemes'),
			      "param_name" => "position",
			      "value" => array(
			                        __("Normal", 'jellythemes') => '',
			                        __("First element", 'jellythemes') => 'first',
			                         __("First element (single section)", 'jellythemes') => 'first-single',
			                        __("Last element", 'jellythemes') => 'last',
			                      ),
			    )
		   )
		));

		vc_map( array(
		   "name" => __("Title", 'jellythemes'),
		   "base" => "jellythemes_title",
		   "class" => "",
		   "icon" => "jelly-icon",
		   "category" => __('Elixir Theme', 'jellythemes'),
		   "params" => array(
		      array(
		         "type" => "textfield",
		         "holder" => "div",
		         "class" => "",
		         "heading" => __("Content",'jellythemes'),
		         "param_name" => "content",
		         "value" => __("Your title", 'jellythemes'),
		         "description" => __("Enter your title.", 'jellythemes')
		      ),
		      array(
			      "type" => "dropdown",
			      "heading" => __('Type', 'jellythemes'),
			      "param_name" => "type",
			      "value" => array(
			                        __("Normal", 'jellythemes') => 'section-title',
			                        __("Normal (single section)", 'jellythemes') => 'single',
			                        __("Normal First (single section)", 'jellythemes') => 'single-first',
									__("Heading", 'jellythemes') => 'heading font-smoothing',
									__("With decoration", 'jellythemes') => 'deco',
									__("Menu/reservation sec. Title", 'jellythemes') => 'menu',
									__("Reservation number (reservation sec.)", 'jellythemes') => 'reservation',
									__("Testimonial sec. Title", 'jellythemes') => 'testimonial',
									__("Pre title (reservation sec.)", 'jellythemes') => 'reservation3',
									__("Post title (reservation sec.)", 'jellythemes') => 'reservation2',
			                      ),
			    )
		   )
		));


		vc_map( array(
		   "name" => __("Vertical spacer", 'jellythemes'),
		   "base" => "jellythemes_voffset",
		   "class" => "",
		   "icon" => "jelly-icon",
		   "category" => __('Elixir Theme', 'jellythemes'),
		   "params" => array(
		      array(
			      "type" => "dropdown",
			      "heading" => __('Offset height', 'jellythemes'),
			      "param_name" => "height",
			      "value" => array(
			                        __("10px", 'jellythemes') => '10',
			                        __("20px", 'jellythemes') => '20',
			                        __("30px", 'jellythemes') => '30',
			                        __("40px", 'jellythemes') => '40',
			                        __("50px", 'jellythemes') => '50',
			                        __("60px", 'jellythemes') => '60',
			                        __("70px", 'jellythemes') => '70',
			                        __("80px", 'jellythemes') => '80',
			                        __("90px", 'jellythemes') => '90',
			                        __("100px", 'jellythemes') => '100',
			                        __("150px", 'jellythemes') => '150',
			                        __("200px", 'jellythemes') => '200',
			                      ),
			      "description" => __("Height will be adjust on responsive", 'jellythemes')
			    )
		   )
		));

		vc_map( array(
		   "name" => __("Button", 'jellythemes'),
		   "base" => "jellythemes_button",
		   "class" => "",
		   "icon" => "jelly-icon",
		   "category" => __('Elixir Theme', 'jellythemes'),
		   "params" => array(
		      array(
		         "type" => "textfield",
		         "holder" => "div",
		         "class" => "",
		         "heading" => __("Text",'jellythemes'),
		         "param_name" => "content",
		         "value" => __("Button text", 'jellythemes'),
		      ),
		      array(
		         "type" => "textfield",
		         "holder" => "div",
		         "class" => "",
		         "heading" => __("Link",'jellythemes'),
		         "param_name" => "link",
		         "value" => __("#", 'jellythemes'),
		      ),
		      array(
			      "type" => "dropdown",
			      "heading" => __('Type', 'jellythemes'),
			      "param_name" => "type",
			      "value" => array(
						__("Normal", 'jellythemes') => '', 
                        __("Big button (menu)", 'jellythemes') => 'menu center ',
                      ),
			    )
		   )
		));

		vc_map( array(
		   "name" => __("Content separator (decoration)", 'jellythemes'),
		   "base" => "jellythemes_separator",
		   "class" => "",
		   'show_settings_on_create' => false,
		   "icon" => "jelly-icon",
		   "category" => __('Elixir Theme', 'jellythemes'),
		   "params" => array()
		));

		vc_map( array(
		   "name" => __("Reservation Form", 'jellythemes'),
		   "base" => "jellythemes_reservation_form",
		   "class" => "",
		   'show_settings_on_create' => false,
		   "icon" => "jelly-icon",
		   "category" => __('Elixir Theme', 'jellythemes'),
		   "params" => array()
		));


		vc_map( array(
		   "name" => __("Section content", 'jellythemes'),
		   "base" => "jellythemes_content",
		   "class" => "",
		   "icon" => "jelly-icon",
		   "category" => __('Elixir Theme', 'jellythemes'),
		   "params" => array(
		      array(
		         "type" => "textarea_html",
		         "holder" => "div",
		         "class" => "",
		         "heading" => __("Content",'jellythemes'),
		         "param_name" => "content",
		         "value" => __("Your content", 'jellythemes'),
		         "description" => __("<p>Enter text.</p>", 'jellythemes')
		      ),
		      array(
			      "type" => "dropdown",
			      "heading" => __('Type of content', 'jellythemes'),
			      "param_name" => "class",
			      "value" => array(
			                        __("Subtitle", 'jellythemes') => 'section-subtitle',
			                        __("Subtitle (single section)", 'jellythemes') => 'subtitle',
			                        __("Normal", 'jellythemes') => 'text',
			                        __("Reservation number", 'jellythemes') => 'number',
			                      ),
			      "description" => __("Type of content", "jellythemes"),
			    )
		   )
		));

		vc_map( array(
		   "name" => __("Schedule (days and hours)", 'jellythemes'),
		   "base" => "jellythemes_content2",
		   "class" => "",
		   "icon" => "jelly-icon",
		   "category" => __('Elixir Theme', 'jellythemes'),
		   "params" => array(
		      array(
		         "type" => "textarea_html",
		         "holder" => "div",
		         "class" => "",
		         "heading" => __("Content",'jellythemes'),
		         "param_name" => "content",
		         "value" => __("Your content", 'jellythemes'),
		         "description" => __("<p>Enter text.</p>", 'jellythemes')
		      ),
		      array(
			      "type" => "dropdown",
			      "heading" => __('Type of content', 'jellythemes'),
			      "param_name" => "class",
			      "value" => array(
			                        __("None", 'jellythemes') => 'section-subtitle',
			                        __("Days", 'jellythemes') => 'section-subtitle days',
			                        __("Hours", 'jellythemes') => 'section-subtitle hours',
			                        __("Subtitle (single section)", 'jellythemes') => 'subtitle',
			                      ),
			      "description" => __("Type of content", "jellythemes"),
			    )
		   )
		));


		vc_map( array(
		    "name" => __("Image Carousel", "jellythemes"),
		    "base" => "jellythemes_images_carousel",
		    "icon" => "icon-wpb-images-carousel",
		    "category" => __('Elixir Theme', 'jellythemes'),
		    "description" => __('Animated carousel with images', 'jellythemes'),
		    "params" => array(
			        array(
			            "type" => "attach_images",
			            "heading" => __("Images", "jellythemes"),
			            "param_name" => "images",
			            "value" => "",
			            "description" => __("Select images from media library.", "jellythemes")
			        ),
			        array(
					      "type" => "dropdown",
					      "heading" => __('Layout', 'jellythemes'),
					      "param_name" => "type",
					      "value" => array(
					                        __("Normal", 'jellythemes') => ' ',
					                        __("Full width", 'jellythemes') => 'full ',
					                      ),
					    ),
				    array(
					      "type" => "dropdown",
					      "heading" => __('Pagination', 'jellythemes'),
					      "param_name" => "pagination",
					      "value" => array(
					                        __("No pagination", 'jellythemes') => 'generic-carousel ',
					                        __("With pagination and next/prev buttons", 'jellythemes') => 'with_pagination with_buttons ',
					                      ),
					    )
			    ),

		) );



		vc_map( array(
		    "name" => __("Map", "jellythemes"),
		    "base" => "jellythemes_map",
		    "icon" => "jelly-icon",
		    "category" => __('Elixir Theme', 'jellythemes'),
		    "description" => __('Insert Google Maps', 'jellythemes'),
		    "params" => array(
			        array(
				         "type" => "textfield",
				         "holder" => "div",
				         "class" => "",
				         "heading" => __("Latitude", 'jellythemes'),
				         "param_name" => "latitude",
				         "value" => __("40.780762", 'jellythemes'),
				    ),
				    array(
				         "type" => "textfield",
				         "holder" => "div",
				         "class" => "",
				         "heading" => __("Longitude", 'jellythemes'),
				         "param_name" => "longitude",
				         "value" => __("-73.987291", 'jellythemes'),
				    ),
				    array(
				         "type" => "textfield",
				         "holder" => "div",
				         "class" => "",
				         "heading" => __("Marker name", 'jellythemes'),
				         "param_name" => "marker_name",
				         "value" => __("My Company", 'jellythemes'),
				    )
			    )
		) );


		vc_map( array(
		   "name" => __("Testimonials", 'jellythemes'),
		   "description" => __("Testimonials carousel", 'jellythemes'),
		   "base" => "jellythemes_testimonials",
		   "class" => "",
		   "icon" => "jelly-icon",
		   "category" => __('Elixir Theme', 'jellythemes'),
		   "params" => array(
		      array(
			      "type" => "dropdown",
			      "heading" => __('Number of services to show', 'jellythemes'),
			      "param_name" => "limit",
			      "value" => array(
			                        __("Unlimited", 'jellythemes') => '-1',
			                        __("1", 'jellythemes') => '1',
			                        __('2', 'jellythemes') => '2',
			                        __('3', 'jellythemes') => '3',
									__('3', 'jellythemes') => '3',
									__('4', 'jellythemes') => '4',
									__('5', 'jellythemes') => '5',
									__("6", 'jellythemes') => '6',
			                        __('7', 'jellythemes') => '7',
			                        __('8', 'jellythemes') => '8',
									__('9', 'jellythemes') => '9',
									__('10', 'jellythemes') => '10',
									__('11', 'jellythemes') => '11',
									__('12', 'jellythemes') => '12',
			                      ),
			      "description" => __("Select the number of services you want to show", "jellythemes"),
			    )
		   )
		));

		vc_map( array(
		   "name" => __("Gallery", 'jellythemes'),
		   "description" => __("Photo gallery with filter", 'jellythemes'),
		   "base" => "jellythemes_photos",
		   "class" => "",
		   "icon" => "jelly-icon",
		   "category" => __('Elixir Theme', 'jellythemes'),
		   "params" => array(
		      array(
			      "type" => "dropdown",
			      "heading" => __('Number of photos to show', 'jellythemes'),
			      "param_name" => "limit",
			      "value" => array(
			                        __("Unlimited", 'jellythemes') => '-1',
			                        __("1", 'jellythemes') => '1',
			                        __('2', 'jellythemes') => '2',
			                        __('3', 'jellythemes') => '3',
									__('3', 'jellythemes') => '3',
									__('4', 'jellythemes') => '4',
									__('5', 'jellythemes') => '5',
									__("6", 'jellythemes') => '6',
			                        __('7', 'jellythemes') => '7',
			                        __('8', 'jellythemes') => '8',
									__('9', 'jellythemes') => '9',
									__('10', 'jellythemes') => '10',
									__('11', 'jellythemes') => '11',
									__('12', 'jellythemes') => '12',
			                      ),
			      "description" => __("Select the number of photos you want to show", "jellythemes"),
			    )
		   )
		));


		vc_map( array(
		    "name" => __("Single Image", "jellythemes"),
		    "base" => "jellythemes_image",
		    "icon" => "jelly-icon",
		    "category" => __('Elixir Theme', 'jellythemes'),
		    "description" => __('Inserty singles image (full size)', 'jellythemes'),
		    "params" => array(
			        array(
			            "type" => "attach_image",
			            "heading" => __("Image", "jellythemes"),
			            "param_name" => "image",
			            "value" => "",
			            "description" => __("Select image from media library. Shows full size", "jellythemes")
			        ),
			        array(
				         "type" => "textfield",
				         "holder" => "div",
				         "class" => "",
				         "heading" => __("Class name", 'jellythemes'),
				         "param_name" => "class",
				         "description" => __("Add CSS classes separated by spaces", 'jellythemes')
				      ),
			    )
		) );



		vc_map( array(
		   "name" => __("Contact form", 'jellythemes'),
		   "base" => "jellythemes_contact_info",
		   "class" => "",
		   "icon" => "jelly-icon",
		   "category" => __('Elixir Theme', 'jellythemes'),
		   'show_settings_on_create' => false,
		   "description" => __('Contact form', 'jellythemes'),
		   "params" => array()
		));
	}
	function custom_css_classes_for_vc_row_and_vc_column($class_string, $tag) {
          if ($tag=='vc_row' || $tag=='vc_row_inner') {
            $class_string = str_replace('vc_row-fluid', 'jt_row-fluid', $class_string);
            $class_string = str_replace('vc_row', 'row', $class_string);
          }
          if ($tag=='vc_column' || $tag=='vc_column_inner') {
            $class_string = preg_replace('/vc_col-sm-(\d{1,2})/', 'col-md-$1', $class_string);
            $class_string = str_replace('wpb_column', 'jt_col', $class_string);

          }
          $class_string = str_replace('wpb_row', 'jt_row', $class_string);
          return $class_string;
        }
    // Filter to Replace default css class for vc_row shortcode and vc_column
    add_filter('vc_shortcodes_css_class', 'custom_css_classes_for_vc_row_and_vc_column', 10, 2);
?>
