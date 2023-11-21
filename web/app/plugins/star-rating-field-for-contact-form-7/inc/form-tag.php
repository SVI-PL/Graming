<?php
add_action( 'wpcf7_init', 'srffcf7_add_form_tag_button', 10, 0 );

  function srffcf7_add_form_tag_button() {
	wpcf7_add_form_tag(  array('star_rating','star_rating*'), 'srffcf7_button_form_tag_handler',array(
        'name-attr' => true,
        ) );
    }
	function srffcf7_button_form_tag_handler( $tag ) {
        if ( empty( $tag->name ) ) {
        	return '';
     	}

 	    $validation_error = wpcf7_get_validation_error( $tag->name );

        $class = wpcf7_form_controls_class( $tag->type );

        $atts = array();

        $atts['name'] = $tag->name;
        $atts['class'] = $tag->get_class_option( $class );
        $atts['id'] = $tag->get_id_option();
        $atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );
        $atts['max'] = $tag->get_option( 'max', 'signed_int', true );
        $disable_cancel = $tag->has_option( 'disable_cancel' ) ? ' cancel-btn="1" ' : ' cancel-btn="0" ';

    
        $atts['max'] = $tag->get_option( 'max', 'signed_int', true );
        if($atts['max'] =='')
        {
            $max_size = 5;
        }
        else{
            $max_size = $atts['max'];
        }
    

        $html = '' ;

        $html .= '<div target_pos="'.$tag->name.'" max_size="'.$max_size.'" class="star_rating_class" '.$disable_cancel.' ></div>';  
        $html .= '<span  class="wpcf7-form-control-wrap '.sanitize_html_class($tag->name).'">';  
        $html .= '<input type="hidden" name="'.$tag->name.'" class="custom_radio_class '.$tag->name.'" value=""/>';
        $html .= $validation_error;
        $html .= '</span>';  
    
      return $html;
  }