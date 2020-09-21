<?php

declare(strict_types=1);

namespace Yproximite\Payum\SystemPay\Request;

use Payum\Core\Request\Notify as Request;
use Yproximite\Payum\SystemPay\Api;

class RequestNotifyApplier
{
    /** @var array<string, callable<Request>> */
    protected $appliers = [];

    /** @var \ArrayAccess|null */
    protected $model;

    public function __construct()
    {
        $this->appliers[Api::STATUS_ABANDONED]                         = function (Request $request) { $request->markCanceled(); };
        $this->appliers[Api::STATUS_AUTHORISED]                        = function (Request $request) { $this->checkPaymentAuthorized($request); };
        $this->appliers[Api::STATUS_AUTHORISED_TO_VALIDATE]            = function (Request $request) { $request->markPending(); };
        $this->appliers[Api::STATUS_CANCELLED]                         = function (Request $request) { $request->markCanceled(); };
        $this->appliers[Api::STATUS_CAPTURED]                          = function (Request $request) { $request->markCaptured(); };
        $this->appliers[Api::STATUS_CAPTURE_FAILED]                    = function (Request $request) { $request->markFailed(); };
        $this->appliers[Api::STATUS_EXPIRED]                           = function (Request $request) { $request->markExpired(); };
        $this->appliers[Api::STATUS_INITIAL]                           = function (Request $request) { $request->markNew(); };
        $this->appliers[Api::STATUS_NOT_CREATED]                       = function (Request $request) { $request->markUnknown(); };
        $this->appliers[Api::STATUS_REFUSED]                           = function (Request $request) { $request->markCanceled(); };
        $this->appliers[Api::STATUS_SUSPENDED]                         = function (Request $request) { $request->markSuspended(); };
        $this->appliers[Api::STATUS_UNDER_VERIFICATION]                = function (Request $request) { $request->markPending(); };
        $this->appliers[Api::STATUS_WAITING_AUTHORISATION]             = function (Request $request) { $request->markPending(); };
        $this->appliers[Api::STATUS_WAITING_AUTHORISATION_TO_VALIDATE] = function (Request $request) { $request->markPending(); };
    }

    public function apply(?string $status, Request $request, ?\ArrayAccess $model): void
    {
        if (null === $status) {
            $request->markNew();

            return;
        }

        if (!array_key_exists($status, $this->appliers)) {
            $request->markUnknown();

            return;
        }

        $this->model = $model;

        $this->appliers[$status]($request);
    }

    private function checkPaymentAuthorized(Request $request): void
    {
        if ($this->model && '00' === $this->model[Api::FIELD_VADS_RESULT]) {
            $request->markCaptured();
        } else {
            $request->markAuthorized();
        }
    }
}
