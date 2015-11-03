<?php

namespace Omnipay\Bardo\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Bardo Complete Purchase Request
 */
class CompletePurchaseRequest extends AbstractRequest
{
    public function getData()
    {
		
        
		$shop = $this->httpRequest->query->all();
		$shopnumber = $shop['SHOP_NUMBER'];
        
		
		$data = $this->httpClient->post('https://pay.bardo-gateway.com/trm/TransactionHandler.ashx')
		->setPostField('UserName', 'your_given_username')
		->setPostField('Password', 'your_given_password')
		->setPostField('SHOP_NUMBER', $shopnumber)
		->send();
		
		return $data;
		
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data->json());
    }

    public function getEndpoint()
    {
        return $this->endpoint;
    }
}
