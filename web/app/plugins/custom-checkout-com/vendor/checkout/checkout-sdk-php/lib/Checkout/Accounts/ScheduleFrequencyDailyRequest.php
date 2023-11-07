<?php

namespace MyCheckout\Accounts;

class ScheduleFrequencyDailyRequest extends ScheduleRequest
{
    public function __construct()
    {
        parent::__construct(ScheduleFrequency::$DAILY);
    }
}
