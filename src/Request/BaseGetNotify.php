<?php

declare(strict_types=1);

namespace Yproximite\Payum\SystemPay\Request;

use Payum\Core\Request\Generic;

abstract class BaseGetNotify extends Generic implements GetNotifyInterface
{
    /**
     * @var int
     */
    protected $status;

    public function __construct($model)
    {
        parent::__construct($model);

        $this->markUnknown();
    }

    public function getValue()
    {
        return $this->status;
    }
}
