<?php

namespace MyCheckout\Issuing\Cardholders;

use MyCheckout\Common\DocumentType;

class CardholderDocument
{
    /**
     * @var string value of DocumentType
     */
    public $type;

    /**
     * @var string
     */
    public $front_document_id;

    /**
     * @var string
     */
    public $back_document_id;

}
