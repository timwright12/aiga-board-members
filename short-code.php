<?php

/*
    Insert a board member
    Example: [board_member name="Tim Wright"]
*/

  function get_the_content_with_formatting ($more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
  	$content = get_the_content($more_link_text, $stripteaser, $more_file);
  	$content = apply_filters('the_content', $content);
  	$content = str_replace(']]>', ']]&gt;', $content);
  	return $content;
  }

  function insert_board_member($attr = '') {

    $output = '';
    if( $attr ) {

      $members  = ( isset($attr['name']) ? $attr['name'] : '');
      $clean_members = str_replace(', ', ',', $members);
      $memberArray = explode(',', $clean_members);

      $output .= '<div class="board-member-listing">';

      foreach( $memberArray as $member ) {
        
        $member_slug = str_replace( ' ', '-', strtolower( $member ) );
        
        $args = array(
          'post_type' => 'board_member',
          'name' => $member_slug,
          'tax_query' => array(
            array(
              'taxonomy' => 'members',
              'field'    => 'slug',
              'terms'    => 'former',
              'operator'  => 'NOT IN'
            ),
          ),
        );
        
        $query = new WP_Query( $args );
        
        if ( $query->have_posts() ) {

          $output .= '<div class="board-member">';
          
          while ( $query->have_posts() ) {
            $query->the_post();
            
            $name = get_the_title();
            $content = get_the_content_with_formatting();
            $twitter = get_field('twitter');
            $linkedin = get_field('linkedin');
            $headshot = get_field('headshot');
            $title = get_field('title');
            $email = get_field('email');
            
            // name
            if($name) {
              $output .= '<h4 class="board-member-title">'. esc_attr( $name ) .', '. esc_attr( $title ) .'</h4>';
            }
            
            // headshot
            if( !empty($headshot) ) {
              $output .= '<img src="'. esc_url( $headshot['url'] ) .'" alt="'. esc_attr( $headshot['alt'] ) .'" class="board-member-image">';
            }
            
            // email
            if($email) {
              $output .= '<p>E-mail: <a href="mailto: '. esc_attr( $email ) .'">'. $email .'</a></p>';
            }
            
            // content
            if($content) {
              $output .= $content;
            }

            if( !empty($twitter) || !empty($linkedin) ) {
              
              $output .= '<div class="board-social-bar">';
              
              // twitter
              if( !empty($twitter) ) {
                $output .= '<a href="http://twitter.com/'. esc_attr( $twitter ) .'">Twitter</a> ';
              }
              
              // linkedin
              if( !empty($linkedin) ) {
                $output .= '<a href="'. esc_url( $linkedin ) .'">LinkedIn</a>';
              }
              
              $output .= '</div>';
              
            } // if there are social links

          } // while
          
          $output .= '</div><!--/.board-member-->';
          
        } // if has posts

      }

      $output .= '</div><!--/.board-member-listing-->';

      return $output;

    }

  } // insert_board_member
  
  $css_URL = plugins_url('layout.css', __FILE__);
  
  add_shortcode( 'board_member', 'insert_board_member' );
  wp_register_style( 'aiga_board_css', $css_URL );
  wp_enqueue_style( 'aiga_board_css');
  
  
  
?>