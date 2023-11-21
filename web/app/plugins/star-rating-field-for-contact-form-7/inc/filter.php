<?php

add_filter( 'wpcf7_validate_star_rating' , 'srffcf7_star_rating_validation_filter' , 10, 2 );
    add_filter( 'wpcf7_validate_star_rating*' , 'srffcf7_star_rating_validation_filter' , 10, 2 );	
    function srffcf7_star_rating_validation_filter( $result, $tag ) {
    
        $dscf7data_image = sanitize_text_field($_POST[$tag->name]);

        $value = isset( $_POST[$tag->name] )	? sanitize_text_field(trim( strtr( (string) $dscf7data_image, "\n", " " ) )) : '';
        if ( 'star_rating' == $tag->basetype ) {
            if ( $tag->is_required() and '' === $value ) {
                
                $result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
            }
        }
        return $result;
    }
?>