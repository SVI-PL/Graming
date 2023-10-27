<?php $customer_orders = wc_get_orders(
    array(
        'customer' => get_current_user_id(),
        'orderby' => 'date',
        'order' => 'DESC',
    )
); ?>
<?php if ($customer_orders): ?>
    <div class="buy_now_acc">
        <div class="btn-red"><a href="/service/usd/">Deposit Now</a></div>
    </div>
    <div class="account-orders">
        <div class="acc_title">Deposit History</div>
        <div class="orders_list">
            <?php
            foreach ($customer_orders as $customer_order):
                $order = wc_get_order($customer_order); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
                $item_count = $order->get_item_count() - $order->get_item_count_refunded();
                ?>
                <?php
                $items = $customer_order->get_items();
                $product_id = "";

                if (!empty($items)) {
                    foreach ($items as $item) {
                        $product_id = $item["product_id"];
                        break;
                    }
                } 
                
                if($product_id == 75):
                ?>
                <div class="order_item">
                    <div class="order_left">
                        <div class="left_top">
                            <div class="order_title">
                                <?php $items = $customer_order->get_items();
                                if (!empty($items)) {
                                    foreach ($items as $item) {
                                        $product_name = $item->get_name();
                                        break;
                                    }
                                    echo $product_name;
                                } ?>
                            </div>
                        </div>
                        <div class="order_bottom">
                            <div class="order_status <?php echo esc_html(wc_get_order_status_name($order->get_status())); ?>">
                                <?php echo esc_html(wc_get_order_status_name($order->get_status())); ?>
                            </div>
                            <div class="order_num">
                                <?php echo esc_html(_x('№', 'hash before order number', 'woocommerce') . $order->get_order_number()); ?>
                            </div>
                            <div class="order_date">
                                <time datetime="<?php echo esc_attr($order->get_date_created()->date('c')); ?>">
                                    <?php echo esc_html(wc_format_datetime($order->get_date_created())); ?>
                                </time>
                            </div>
                            <div class="order_total">
                                <?php echo $order->get_formatted_order_total(); ?>
                            </div>
                        </div>
                    </div>
                    <a class="order_view" href="<?php echo esc_url($order->get_view_order_url()); ?>"></a>
                </div>
                <?php endif;?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>