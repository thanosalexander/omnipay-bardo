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
		$shopnumber = $this->getParameter('transactionId');
		$username = $this->getParameter('username');
		$password = $this->getParameter('password');
		$clientid = $this->getParameter('clientid');

		if (is_null($username) or is_null($password)) {
			throw new \Exception("Missing username or password", 1);
		}
		if (is_null($clientid)) {
			throw new \Exception("Missing clientid", 1);
		}

		$data = $this->httpClient->post('https://pay.bardo-gateway.com/trm/TransactionHandler.ashx')
		->setPostField('UserName', $username)
		->setPostField('Password', $password)
		->setPostField('SHOP_NUMBER', $shopnumber)
		->setPostField('ClientId', $clientid)
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

	public function setUsername($value)
	{
		$this->setParameter('username', $value);
	}

	public function getUsername()
	{
		$this->getParameter('username');
	}

	public function setPassword($value)
	{
		$this->setParameter('password', $value);
	}

	public function getPassword()
	{
		$this->getParameter('password');
	}
	public function setClientId($value)
	{
		$this->setParameter('clientid', $value);
	}
	public function getClientId()
	{
		$this->getParameter('clientid');
	}
}
