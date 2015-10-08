<?php

namespace Omnipay\Bardo\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * Pin Purchase Request
 */
class PurchaseRequest extends AbstractRequest
{
    protected $liveEndpoint = 'https://gate.bardo-gateway.com/bardo/process.aspx?';
    protected $testEndpoint = 'https://gate.bardo-gateway.com/bardo/process.aspx?';

    public function getShopId()
    {
        return $this->getParameter('SHOP_ID');
    }

    public function setShopId($value)
    {
        return $this->setParameter('SHOP_ID', $value);
    }

    public function getData()
    {
        $this->validate('amount', 'card');

        $data = array();
        $data['TRANSAC_AMOUNT'] = $this->getAmountInteger();
        $data['CURRENCY_CODE'] = strtoupper ($this->getCurrency());
        $data['PRODUCT_NAME'] = $this->getDescription();
        $data['CUSTOMER_IP'] = $this->getClientIp();
        $data['CUSTOMER_EMAIL'] = $this->getCard()->getEmail();
		$data['LANGUAGE_CODE'] = 'ENG';
		$data['CUSTOMER_PHONE'] = $this->getShippingPhone(); 
		$data['SHOP_NUMBER'] = $this->getTransactionId(); 
		
        if ($this->getToken()) {
            $data['card_token'] = $this->getToken();
        } else {
            $this->getCard()->validate();

            $data['card']['CB_NUMBER'] = $this->getCard()->getNumber();
            $data['card']['CB_MONTH'] = $this->getCard()->getExpiryMonth();
            $data['card']['CB_YEAR'] = $this->getCard()->getExpiryYear();
            $data['card']['CB_CVC'] = $this->getCard()->getCvv();
			$data['card']['CB_TYPE'] = $this->getCard()->getType();
            $data['card']['CUSTOMER_FIRST_NAME'] = $this->getCard()->getFirstName();
			$data['card']['CUSTOMER_LAST_NAME'] = $this->getCard()->getLastName();
            $data['card']['CUSTOMER_ADDRESS'] = $this->getCard()->getAddress1();
            $data['card']['CUSTOMER_CITY'] = $this->getCard()->getCity();
            $data['card']['CUSTOMER_ZIP_CODE'] = $this->getCard()->getPostcode();
            $data['card']['CUSTOMER_STATE'] = $this->getCard()->getState();
            $data['card']['CUSTOMER_COUNTRY'] = $this->getCard()->getCountry();
        }

        return $data;
    }

    public function sendData($data)
    {
        // don't throw exceptions for 4xx errors
        $this->httpClient->getEventDispatcher()->addListener(
            'request.error',
            function ($event) {
                if ($event['response']->isClientError()) {
                    $event->stopPropagation();
                }
            }
        );

        $httpResponse = $this->httpClient->post($this->getEndpoint().'SHOP_ID=BARDO_TEST&', null, $data)
            ->setHeader('Authorization', 'Basic '.base64_encode($this->getSecretKey().':'))
            ->send();

        return $this->response = new Response($this, $httpResponse->json());
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
}
