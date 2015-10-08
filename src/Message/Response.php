<?php

namespace Omnipay\Bardo\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Pin Response
 */
class Response extends AbstractResponse
{
    public function isSuccessful()
    {
        return !isset($this->data['error']);
    }

    public function getTransactionReference()
    {
        if (isset($this->data['response']['SHOP_NUMBER'])) {
            return $this->data['response']['SHOP_NUMBER'];
        }
    }

    public function getMessage()
    {
        if ($this->isSuccessful()) {
            return $this->data['response']['TRANSAC_STATUS'];
        } else {
            return $this->data['etat'];
        }
    }
}
