<?php

namespace Checkout\Common\Four;

class Product
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $quantity;

    /**
     * @var int
     */
    public $unit_price;

    /**
     * @var string
     */
    public $reference;

    /**
     * @var string
     */
    public $image_url;

    /**
     * @var string
     */
    public $url;

    /**
     * @var int
     */
    public $total_amount;

    /**
     * @var int
     */
    public $tax_amount;

    /**
     * @var int
     */
    public $discount_amount;

    /**
     * @var string
     */
    public $sku;

    /**
     * @var string
     */
    public $goods_id;

    /**
     * @var string
     */
    public $wxpay_goods_id;
}
