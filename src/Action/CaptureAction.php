<?php

declare(strict_types=1);

namespace Yproximite\Payum\SystemPay\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Request\Capture;
use Payum\Core\Security\GenericTokenFactoryAwareInterface;
use Payum\Core\Security\GenericTokenFactoryAwareTrait;
use Payum\Core\Security\TokenInterface;
use Yproximite\Payum\SystemPay\Action\Api\BaseApiAwareAction;
use Yproximite\Payum\SystemPay\Api;

class CaptureAction extends BaseApiAwareAction implements ActionInterface, GatewayAwareInterface, GenericTokenFactoryAwareInterface
{
    use GatewayAwareTrait;
    use GenericTokenFactoryAwareTrait;

    /**
     * {@inheritdoc}
     *
     * @param Capture $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $details = ArrayObject::ensureArrayObject($request->getModel());

        // don't execute CaptureAction (avoid doPayment call) if request contains SytemPay populated result field data
        if (null !== $details[Api::FIELD_VADS_RESULT] || '00' === $details[Api::FIELD_VADS_RESULT]) {
            return;
        }

        if ($request->getToken() instanceof TokenInterface) {
            $notifyToken = $this->tokenFactory->createNotifyToken(
                $request->getToken()->getGatewayName(),
                $request->getToken()->getDetails()
            );
        }

        // populate this by your own "notify" route
        if ($this->api && null !== $this->api->getOption($details->toUnsafeArray(), Api::FIELD_VADS_URL_CHECK)) {
            $details[Api::FIELD_VADS_URL_CHECK] = $this->api->getOption($details->toUnsafeArray(), Api::FIELD_VADS_URL_CHECK).$notifyToken->getHash();
        } elseif (null === $details[Api::FIELD_VADS_URL_CHECK]) {
            // you need to override the parameter "payum.notify_path" in your payum.yml "parameters" definition
            // by your own notify route to get it working
            $details[Api::FIELD_VADS_URL_CHECK] = $notifyToken->getTargetUrl();
        }

        // populate this by your own "done" route.
        // setting "vads_url_return" unique route replace 4 other routes:
        // "vads_url_cancel", "vads_url_error", "vads_url_refused" and "vads_url_success"
        if ($this->api && null !== $this->api->getOption($details->toUnsafeArray(), Api::FIELD_VADS_URL_RETURN)) {
            $details[Api::FIELD_VADS_URL_RETURN] = $this->api->getOption($details->toUnsafeArray(), Api::FIELD_VADS_URL_RETURN).$notifyToken->getHash();
        } else {
            $details[Api::FIELD_VADS_URL_RETURN] = $request->getToken()->getAfterUrl();
        }

        $this->api->doPayment((array) $details);
    }

    /**
     * {@inheritdoc}
     */
    public function supports($request)
    {
        return
            $request instanceof Capture &&
            $request->getModel() instanceof \ArrayAccess;
    }
}
