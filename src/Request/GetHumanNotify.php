<?php

declare(strict_types=1);

namespace Yproximite\Payum\SystemPay\Request;

class GetHumanNotify extends BaseGetNotify
{
    const STATUS_CAPTURED = 'captured';

    const STATUS_AUTHORIZED = 'authorized';

    const STATUS_PAYEDOUT = 'payedout';

    const STATUS_REFUNDED = 'refunded';

    const STATUS_UNKNOWN = 'unknown';

    const STATUS_FAILED = 'failed';

    const STATUS_SUSPENDED = 'suspended';

    const STATUS_EXPIRED = 'expired';

    const STATUS_PENDING = 'pending';

    const STATUS_CANCELED = 'canceled';

    const STATUS_NEW = 'new';

    public function markCaptured()
    {
        $this->status = static::STATUS_CAPTURED;
    }

    public function isCaptured()
    {
        return $this->isCurrentNotifyEqualTo(static::STATUS_CAPTURED);
    }

    public function markAuthorized()
    {
        $this->status = static::STATUS_AUTHORIZED;
    }

    public function isAuthorized()
    {
        return $this->isCurrentNotifyEqualTo(static::STATUS_AUTHORIZED);
    }

    public function markPayedout()
    {
        $this->status = static::STATUS_PAYEDOUT;
    }

    public function isPayedout()
    {
        return $this->isCurrentNotifyEqualTo(static::STATUS_PAYEDOUT);
    }

    public function markRefunded()
    {
        $this->status = static::STATUS_REFUNDED;
    }

    public function isRefunded()
    {
        return $this->isCurrentNotifyEqualTo(static::STATUS_REFUNDED);
    }

    public function markSuspended()
    {
        $this->status = static::STATUS_SUSPENDED;
    }

    public function isSuspended()
    {
        return $this->isCurrentNotifyEqualTo(static::STATUS_SUSPENDED);
    }

    public function markExpired()
    {
        $this->status = static::STATUS_EXPIRED;
    }

    public function isExpired()
    {
        return $this->isCurrentNotifyEqualTo(static::STATUS_EXPIRED);
    }

    public function markCanceled()
    {
        $this->status = static::STATUS_CANCELED;
    }

    public function isCanceled()
    {
        return $this->isCurrentNotifyEqualTo(static::STATUS_CANCELED);
    }

    public function markPending()
    {
        $this->status = static::STATUS_PENDING;
    }

    public function isPending()
    {
        return $this->isCurrentNotifyEqualTo(static::STATUS_PENDING);
    }

    public function markFailed()
    {
        $this->status = static::STATUS_FAILED;
    }

    public function isFailed()
    {
        return $this->isCurrentNotifyEqualTo(static::STATUS_FAILED);
    }

    public function markNew()
    {
        $this->status = static::STATUS_NEW;
    }

    public function isNew()
    {
        return $this->isCurrentNotifyEqualTo(static::STATUS_NEW);
    }

    public function markUnknown()
    {
        $this->status = static::STATUS_UNKNOWN;
    }

    public function isUnknown()
    {
        return $this->isCurrentNotifyEqualTo(static::STATUS_UNKNOWN);
    }

    /**
     * @param string $expectedNotify
     *
     * @return bool
     */
    protected function isCurrentNotifyEqualTo($expectedNotify)
    {
        return $this->getValue() === $expectedNotify;
    }
}
