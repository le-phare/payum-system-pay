<?php

declare(strict_types=1);

namespace Yproximite\Payum\SystemPay\Request;

use Payum\Core\Model\ModelAggregateInterface;
use Payum\Core\Model\ModelAwareInterface;

interface GetNotifyInterface extends ModelAwareInterface, ModelAggregateInterface
{
    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @return void
     */
    public function markNew();

    /**
     * @return bool
     */
    public function isNew();

    /**
     * @return void
     */
    public function markCaptured();

    /**
     * @return bool
     */
    public function isCaptured();

    /**
     * @return bool
     */
    public function isAuthorized();

    /**
     * @return void
     */
    public function markAuthorized();

    /**
     * @return void
     */
    public function markPayedout();

    /**
     * @return bool
     */
    public function isPayedout();

    /**
     * @return bool
     */
    public function isRefunded();

    /**
     * @return void
     */
    public function markRefunded();

    /**
     * @return bool
     */
    public function isSuspended();

    /**
     * @return void
     */
    public function markSuspended();

    /**
     * @return bool
     */
    public function isExpired();

    /**
     * @return void
     */
    public function markExpired();

    /**
     * @return bool
     */
    public function isCanceled();

    /**
     * @return void
     */
    public function markCanceled();

    /**
     * @return bool
     */
    public function isPending();

    /**
     * @return void
     */
    public function markPending();

    /**
     * @return bool
     */
    public function isFailed();

    /**
     * @return void
     */
    public function markFailed();

    /**
     * @return bool
     */
    public function isUnknown();

    /**
     * @return void
     */
    public function markUnknown();
}
