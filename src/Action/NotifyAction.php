<?php

declare(strict_types=1);

namespace Yproximite\Payum\SystemPay\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Yproximite\Payum\SystemPay\Api;
use Yproximite\Payum\SystemPay\Request\GetNotifyInterface;

class NotifyAction implements ActionInterface
{
    /**
     * @param GetNotifyInterface $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $details = ArrayObject::ensureArrayObject($request->getFirstModel());
        $status = $details[Api::FIELD_VADS_TRANS_STATUS];

        switch ($status) {
            case Api::STATUS_AUTHORISED:
                if ($details && '00' === $details[Api::FIELD_VADS_RESULT]) {
                    $request->markCaptured();

                    break;
                }

                $request->markAuthorized();
                break;

            case null:
            case Api::STATUS_INITIAL:
                $request->markNew();
                break;

            case Api::STATUS_CANCELLED:
            case Api::STATUS_ABANDONED:
            case Api::STATUS_REFUSED:
                $request->markCanceled();
                break;

            case Api::STATUS_AUTHORISED_TO_VALIDATE:
            case Api::STATUS_UNDER_VERIFICATION:
            case Api::STATUS_WAITING_AUTHORISATION:
            case Api::STATUS_WAITING_AUTHORISATION_TO_VALIDATE:
                $request->markPending();
                break;

            case Api::STATUS_CAPTURED:
                $request->markCaptured();
                break;

            case Api::STATUS_CAPTURE_FAILED:
                $request->markFailed();
                break;

            case Api::STATUS_EXPIRED:
                $request->markExpired();
                break;

            case Api::STATUS_SUSPENDED:
                $request->markSuspended();
                break;

            case Api::STATUS_NOT_CREATED:
            default:
                $request->markUnknown();
                break;
        }

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($request)
    {
        return
            $request instanceof GetNotifyInterface &&
            $request->getModel() instanceof \ArrayAccess;
    }
}
