<?php

namespace Omnipay\Bardo\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Migs Complete Purchase Request
 */
class CompletePurchaseRequest extends AbstractRequest
{
	public function getData()
	{
		
		$data = $this->httpRequest->query->all();

		return $data;
	}

	public function sendData($data)
	{
		return $this->response = new CompletePurchaseResponse($this, $data);
	}

	public function getEndpoint()
	{
		return $this->endpoint;
	}
}
