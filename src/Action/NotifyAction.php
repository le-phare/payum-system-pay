<?php

declare(strict_types=1);

namespace Yproximite\Payum\SystemPay\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Yproximite\Payum\SystemPay\Api;
use Yproximite\Payum\SystemPay\Request\GetNotifyInterface;
use Yproximite\Payum\SystemPay\Request\RequestNotifyApplier;

class NotifyAction implements ActionInterface
{
    /** @var RequestNotifyApplier */
    private $requestNotifyApplier;

    public function __construct(RequestNotifyApplier $requestNotifyApplier)
    {
        $this->requestNotifyApplier = $requestNotifyApplier;
    }

    /**
     * {@inheritdoc}
     *
     * @param GetNotifyInterface $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());

        $this->requestNotifyApplier->apply($model[Api::FIELD_VADS_TRANS_STATUS], $request, $model);
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
