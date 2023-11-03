<div class="services">
    <div class="title">Graming Services</div>
    <div class="content">
        <?php
        $service_list = get_field("services_list", "option");
        foreach ($service_list as $service):
            ?>
            <div class="servise_group">
                <div class="title">
                    <?php echo $service["list_name"] ?>
                </div>
                <div class="content">
                    <?php foreach ($service["product_list"] as $product_id):
                        $product = wc_get_product($product_id["product"]);
                        $product_name = $product->get_title();
                        $url = get_permalink($product_id["product"]);
                        ?>
                        <div class="btn-red">
                            <a href="<?php echo $url; ?>">
                                <?php echo $product_name; ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>