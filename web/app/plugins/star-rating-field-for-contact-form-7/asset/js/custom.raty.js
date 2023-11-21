jQuery( document ).ready(function() {
    // console.log( "star ready!" );
    
    jQuery('.star_rating_class').each(function(index, value) {

        if(jQuery(this).attr('cancel-btn')=='0') {    
            jQuery(jQuery(this)).raty({
                targetType:   'score',
                cancelButton:  true,
                cancelOff:   'cancel-off.png',
                cancelOn:    'cancel-on.png',
                starOff:     'star-off.png',
                starOn:     'star-on.png',
                path: student_ajax.ajax_urla+'/asset/jquery.rating/images',
                target: '.'+jQuery(this).attr("target_pos"),
                number: jQuery(this).attr("max_size"),
                targetKeep:   true,
            });
        }else{
            jQuery(jQuery(this)).raty({
                targetType:   'score',
                starOff:     'star-off.png',
                starOn:      'star-on.png',
                path: student_ajax.ajax_urla+'/asset/jquery.rating/images',
                target: '.'+jQuery(this).attr("target_pos"),
                number: jQuery(this).attr("max_size"),
                targetKeep:   true,
            });
        }

      });

});