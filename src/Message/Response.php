<?php

namespace Omnipay\Bardo\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Migs Purchase Response
 */
class Response extends AbstractResponse implements RedirectResponseInterface
{
    protected $redirectUrl;

    public function __construct(RequestInterface $request, $data, $redirectUrl)
    {
        parent::__construct($request, $data);
        $this->redirectUrl = $redirectUrl;
    }

    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        return $this->getData();
    }
	 public function getTransactionReference()
    {
        return isset($this->data['SHOP_NUMBER']) ? $this->data['SHOP_NUMBER'] : null;
    }
	 public function getMessage()
    {
        return isset($this->data['redirect_msg']) ? $this->data['redirect_msg'] : null;
    }
}
