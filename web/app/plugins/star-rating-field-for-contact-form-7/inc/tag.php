<?php
 add_action( 'wpcf7_admin_init', 'srffcf7_add_tag_generator_button', 55, 0 );
  
  function srffcf7_add_tag_generator_button() {
      $tag_generator = WPCF7_TagGenerator::get_instance();
      $tag_generator->add( 'star_rating', __( 'star rating', 'contact-form-7' ),
          'srffcf7_tag_generator_button', array( 'nameless' => 1 ) );
  }
  
  function srffcf7_tag_generator_button( $contact_form, $args = '' ) {
      $args = wp_parse_args( $args, array() );
  
      $description = __( "Generate a form-tag for a button tag button. For more details, see %s.", 'contact-form-7' );
  
      $desc_link = wpcf7_link( __( 'https://contactform7.com/submit-button/', 'contact-form-7' ), __( 'Submit button', 'contact-form-7' ) );
  
      $type = 'star_rating';
  ?>
  <div class="control-box">
  <fieldset>
  <legend><?php echo sprintf( esc_html( $description ), $desc_link ); ?></legend>
  
  <table class="form-table">
  <tbody>
    <tr>
	<th scope="row"><?php echo esc_html( __( 'Field type', 'contact-form-7' ) ); ?></th>
	<td>
		<fieldset>
		<legend class="screen-reader-text"><?php echo esc_html( __( 'Field type', 'contact-form-7' ) ); ?></legend>
		<label><input type="checkbox" name="required" /> <?php echo esc_html( __( 'Required field', 'contact-form-7' ) ); ?></label>
		</fieldset>
	</td>
	</tr>
      <tr>
        <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'contact-form-7' ) ); ?></label>
        </th>
        <td>
          <input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" />
        </td>
      </tr>
      <tr>
        <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-id' ); ?>"><?php echo esc_html( __( 'Id attribute', 'contact-form-7' ) ); ?></label>
        </th>
        <td>
          <input type="text" name="id" class="idvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-id' ); ?>" />
        </td>
      </tr>
      <tr>
        <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-class' ); ?>"><?php echo esc_html( __( 'Class attribute', 'contact-form-7' ) ); ?></label></th>
        <td>
          <input type="text" name="class" class="classvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-class' ); ?>" />
        </td>
      </tr>
    	<tr>
      	<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-max' ); ?>"><?php echo esc_html( __( 'Max', 'contact-form-7' ) ); ?></label>
        </th>
      	<td>
          <input type="text" name="max" class="numeric oneline option" id="<?php echo esc_attr( $args['content'] . '-max' ); ?>" /><label for="<?php echo esc_attr( $args['content'] . '-disable_cancel' ); ?>"><?php echo esc_html( __( 'Give maximum number to add star', 'contact-form-7' ) ); ?></label>
        </td>
    	</tr>
      <tr>
      	<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-disable_cancel' ); ?>"><?php echo esc_html( __( 'Cancel button', 'contact-form-7' ) ); ?></label>
        </th>
      	<td>
          <label><input type="checkbox" name="disable_cancel" class="option" /> <?php echo esc_html( __( 'Disable cancel button', 'contact-form-7' ) ); ?></label>
        </td>
    	</tr>
      <tr>
        <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-button_place' ); ?>"><?php echo esc_html( __( 'Cancel button place', 'contact-form-7' ) ); ?></label>
        </th>
        <td>
          <label>
            <input type="radio" name="button_place" id="<?php echo esc_attr( $args['content'] . '-button_place' );?>" value="left" class="option" disabled><?php echo esc_html( __( 'Left', 'contact-form-7' ) ); ?>
            <input type="radio" name="button_place" id="<?php echo esc_attr( $args['content'] . '-button_place' );?>" value="right" class="option" disabled><?php echo esc_html( __( 'Right', 'contact-form-7' ) ); ?> 
          </label><br>
          <label class="fcpfw_comman_link"><?php echo __('This Option Available in ','contact-form-7');?> <a href="https://topsmodule.com/product/star-rating-field-for-contact-form-7/" target="_blank">Pro Version</a></label>
        </td>
      </tr> 
      <tr>
        <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-button_on' ); ?>"><?php echo esc_html( __( 'Star On', 'contact-form-7' ) ); ?></label>
        </th>
          <td><label><input type="radio" name="button_on" id="<?php echo esc_attr( $args['content'] . '-button_on' );?>" value="star-1.png" class="option" disabled><label for="label-1"><img src="<?php echo SRFFCF7_PLUGIN_DIR ;?>/asset/jquery.rating/images/star-1.png"></label>
          <input type="radio" name="button_on" id="<?php echo esc_attr( $args['content'] . '-button_on' );?>" value="star-2.png" class="option" disabled><label for="label-1"><img src="<?php echo SRFFCF7_PLUGIN_DIR ;?>/asset/jquery.rating/images/star-2.png"></label>
          <input type="radio" name="button_on" id="<?php echo esc_attr( $args['content'] . '-button_on' );?>" value="medal-on.png" class="option" disabled><label for="label-1"><img src="<?php echo SRFFCF7_PLUGIN_DIR ;?>/asset/jquery.rating/images/medal-on.png" disabled></label>
          <input type="radio" name="button_on" id="<?php echo esc_attr( $args['content'] . '-button_on' );?>" value="medal-off.png" class="option" disabled><label for="label-1"><img src="<?php echo SRFFCF7_PLUGIN_DIR ;?>/asset/jquery.rating/images/medal-off.png"></label>
          <input type="radio" name="button_on" id="<?php echo esc_attr( $args['content'] . '-button_on' );?>" value="star-on.png" class="option" disabled><label for="label-1"><img src="<?php echo SRFFCF7_PLUGIN_DIR ;?>/asset/jquery.rating/images/star-on.png"></label>
          <input type="radio" name="button_on" id="<?php echo esc_attr( $args['content'] . '-button_on' );?>" value="star-off.png" class="option" disabled><label for="label-1"><img src="<?php echo SRFFCF7_PLUGIN_DIR ;?>/asset/jquery.rating/images/star-off.png"></label>
          <input type="radio" name="button_on" id="<?php echo esc_attr( $args['content'] . '-button_on' );?>" value="face-on.png" class="option" disabled><label for="label-1"><img src="<?php echo SRFFCF7_PLUGIN_DIR ;?>/asset/jquery.rating/images/face-on.png"></label>
          <input type="radio" name="button_on" id="<?php echo esc_attr( $args['content'] . '-button_on' );?>" value="face-off.png" class="option" disabled><label for="label-1"><img src="<?php echo SRFFCF7_PLUGIN_DIR ;?>/asset/jquery.rating/images/face-off.png"></label>
        </td>
      </tr> 
      <tr>
        <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-button_off' ); ?>"><?php echo esc_html( __( 'Star Off', 'contact-form-7' ) ); ?></label></th>
        <td><label><input type="radio" name="button_off" id="<?php echo esc_attr( $args['content'] . '-button_off' );?>" value="star-1.png" class="option" disabled><label for="label-1"><img src="<?php echo SRFFCF7_PLUGIN_DIR ;?>/asset/jquery.rating/images/star-1.png"></label>
          <input type="radio" name="button_off" id="<?php echo esc_attr( $args['content'] . '-button_off' );?>" value="star-2.png" class="option" disabled><label for="label-1"><img src="<?php echo SRFFCF7_PLUGIN_DIR ;?>/asset/jquery.rating/images/star-2.png"></label>
          <input type="radio" name="button_off" id="<?php echo esc_attr( $args['content'] . '-button_off' );?>" value="medal-on.png" class="option" disabled><label for="label-1"><img src="<?php echo SRFFCF7_PLUGIN_DIR ;?>/asset/jquery.rating/images/medal-on.png"></label>
          <input type="radio" name="button_off" id="<?php echo esc_attr( $args['content'] . '-button_off' );?>" value="medal-off.png" class="option" disabled><label for="label-1"><img src="<?php echo SRFFCF7_PLUGIN_DIR ;?>/asset/jquery.rating/images/medal-off.png"></label>
          <input type="radio" name="button_off" id="<?php echo esc_attr( $args['content'] . '-button_off' );?>" value="star-on.png" class="option" disabled><label for="label-1"><img src="<?php echo SRFFCF7_PLUGIN_DIR ;?>/asset/jquery.rating/images/star-on.png"></label>
          <input type="radio" name="button_off" id="<?php echo esc_attr( $args['content'] . '-button_off' );?>" value="star-off.png" class="option" disabled><label for="label-1"><img src="<?php echo SRFFCF7_PLUGIN_DIR ;?>/asset/jquery.rating/images/star-off.png"></label>
          <input type="radio" name="button_off" id="<?php echo esc_attr( $args['content'] . '-button_off' );?>" value="face-on.png" class="option" disabled><label for="label-1"><img src="<?php echo SRFFCF7_PLUGIN_DIR ;?>/asset/jquery.rating/images/face-on.png"></label>
          <input type="radio" name="button_off" id="<?php echo esc_attr( $args['content'] . '-button_off' );?>" value="face-off.png" class="option" disabled><label for="label-1"><img src="<?php echo SRFFCF7_PLUGIN_DIR ;?>/asset/jquery.rating/images/face-off.png"></label><br>
          <label class="fcpfw_comman_link"><?php echo __('This Option Available in ','contact-form-7');?> <a href="https://topsmodule.com/product/star-rating-field-for-contact-form-7/" target="_blank">Pro Version</a></label></td>
          </tr>
        <tr>
          <th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-single_select_star' ); ?>"><?php echo esc_html( __( 'Single star selection', 'contact-form-7' ) ); ?></label>
          </th>
          <td><label><input type="checkbox" name="single_select_star" class="single option"  id="<?php echo esc_attr( $args['content'] . '-single_select_star' );?>" disabled/> <?php echo esc_html( __( 'Enable this option only the overed star will be turned on', 'contact-form-7' ) ); ?></label><br>
          <label class="fcpfw_comman_link"><?php echo __('This Option Available in ','contact-form-7');?> <a href="https://topsmodule.com/product/star-rating-field-for-contact-form-7/" target="_blank">Pro Version</a></label>
          </td>
        </tr>
  </tbody>
  </table>
  </fieldset>
  </div>
  <div class="insert-box">
      <input type="text" name="<?php echo $type; ?>" class="tag code" readonly="readonly" onfocus="this.select()" />
      
      <div class="submitbox">
      <input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>" />
      </div>
  </div>
  <?php
  }
?>