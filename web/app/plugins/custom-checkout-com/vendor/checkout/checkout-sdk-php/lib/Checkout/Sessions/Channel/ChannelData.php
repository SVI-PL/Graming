<?php

namespace MyCheckout\Sessions\Channel;

abstract class ChannelData
{
    public function __construct($channel)
    {
        $this->channel = $channel;
    }

    /**
     * @var string value of ChannelType
     */
    public $channel;
}
