<?php

namespace MyCheckout\Workflows\Conditions;

class EntityWorkflowConditionRequest extends WorkflowConditionRequest
{
    /**
     * @var array
     */
    public $entities;

    public function __construct()
    {
        parent::__construct(WorkflowConditionType::$entity);
    }
}
