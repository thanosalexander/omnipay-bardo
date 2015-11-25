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
		$username = $this->getParameter('username');
		$password = $this->getParameter('password');

		if (is_null($username) or is_null($password)) {
			throw new \Exception("Missing username or password", 1);
		}

		$data = $this->httpClient->post('https://pay.bardo-gateway.com/trm/TransactionHandler.ashx')
		->setPostField('UserName', $username)
		->setPostField('Password', $password)
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
