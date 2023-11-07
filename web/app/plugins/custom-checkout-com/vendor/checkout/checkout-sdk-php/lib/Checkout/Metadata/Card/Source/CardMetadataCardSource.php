<?php

namespace MyCheckout\Metadata\Card\Source;

class CardMetadataCardSource extends CardMetadataRequestSource
{
    /**
     * @var string
     */
    public $number;

    public function __construct()
    {
        parent::__construct(CardMetadataSourceType::$CARD);
    }
}
