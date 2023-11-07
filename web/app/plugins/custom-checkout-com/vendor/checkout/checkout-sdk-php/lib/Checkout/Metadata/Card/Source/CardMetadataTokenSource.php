<?php

namespace MyCheckout\Metadata\Card\Source;

class CardMetadataTokenSource extends CardMetadataRequestSource
{
    /**
     * @var string
     */
    public $token;

    public function __construct()
    {
        parent::__construct(CardMetadataSourceType::$TOKEN);
    }
}
