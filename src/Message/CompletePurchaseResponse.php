<?php

namespace Omnipay\Bardo\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Migs Purchase Response
 */
class CompletePurchaseResponse extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        if (!is_array($data)) {
            parse_str($data, $data);
        }

        parent::__construct($request, $data);
    }

    public function isSuccessful()
    {
        return isset($this->data['TRANSAC_STATUS']) && "M0" === $this->data['TRANSAC_STATUS'] || "00" === $this->data['TRANSAC_STATUS'] || "M2" === $this->data['TRANSAC_STATUS'] ;
    }

    public function getTransactionReference()
    {
        return isset($this->data['SHOP_NUMBER']) ? $this->data['SHOP_NUMBER'] : null;
    }

    public function getMessage()
    {
        return isset($this->data['bard_Message']) ? $this->data['bard_Message'] : null;
    }
}
