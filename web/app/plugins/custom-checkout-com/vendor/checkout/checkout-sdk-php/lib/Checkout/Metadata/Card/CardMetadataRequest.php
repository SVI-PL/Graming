<?php

namespace MyCheckout\Metadata\Card;

use MyCheckout\Metadata\Card\Source\CardMetadataRequestSource;

class CardMetadataRequest
{
    /**
     * @var CardMetadataRequestSource
     */
    public $source;
    /**
     * @var string value of CardMetadataFormatType
     */
    public $format;
}
