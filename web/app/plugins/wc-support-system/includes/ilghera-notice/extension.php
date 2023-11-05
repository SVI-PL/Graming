<?php
/**
 * ilGhera Notice class extension
 *
 * @author ilGhera
 * @package ilghera-notice/ 
 * @since 1.0.1
 */

/* The extension */
class WSS_Notice extends Ilghera_Notice {

    /**
     * The construct
     */
    public function __construct() {

        $this->products[] = array(
            'name'   => 'WC Support System - Premium',
            'slug'   => 'woocommerce-support-system-premium',
            'sign'   => 'wss',
            'domain' => 'wc-support-system',
        );

        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

        $this->check_license();

    }

}
new WSS_Notice();

