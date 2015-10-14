<?php

namespace Omnipay\Bardo\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * Pin Purchase Request
 */
class PurchaseRequest extends AbstractRequest
{
    protected $liveEndpoint = 'http://localhost/bard/omni.php';
    protected $testEndpoint = 'http://localhost/bard/omni.php';

    public function getShopId()
    {
        return $this->getParameter('shopId');
    }

    public function setShopId($value)
    {
        return $this->setParameter('shopId', $value);
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
		$data['SHOP_NUMBER'] = $this->getTransactionId(); 
		$data['URL_RETURN'] = $this->getReturnUrl(); 
		$data['redirect_msg'] = 'Redirecting Now';
		//$data['SHOP_ID'] = $this->getShopId();
		
		
        if ($this->getToken()) {
            $data['card_token'] = $this->getToken();
        } else {
            //$this->getCard()->validate();

            $data['card']['CB_NUMBER'] = $this->getCard()->getNumber();
            $data['card']['CB_MONTH'] = $this->getCard()->getExpiryMonth();
            $data['card']['CB_YEAR'] = $this->getCard()->getExpiryYear();
            $data['card']['CB_CVC'] = $this->getCard()->getCvv();
			$data['card']['CB_TYPE'] = $this->getCard()->getBrand();
            $data['card']['CUSTOMER_FIRST_NAME'] = $this->getCard()->getFirstName();
			$data['card']['CUSTOMER_LAST_NAME'] = $this->getCard()->getLastName();
            $data['card']['CUSTOMER_ADDRESS'] = $this->getCard()->getAddress1();
            $data['card']['CUSTOMER_CITY'] = $this->getCard()->getCity();
            $data['card']['CUSTOMER_ZIP_CODE'] = $this->getCard()->getPostcode();
            $data['card']['CUSTOMER_STATE'] = $this->getCard()->getState();
            $data['card']['CUSTOMER_COUNTRY'] = $this->getCard()->getCountry();
			$data['card']['CUSTOMER_PHONE'] = $this->getCard()->getbillingPhone(); 
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
		$fname =  $data['card']['CUSTOMER_FIRST_NAME'];
		$lname =  $data['card']['CUSTOMER_LAST_NAME'];
		$amount =  $data['TRANSAC_AMOUNT'];
		$currency =  $data['CURRENCY_CODE'];
		$productname =  $data['PRODUCT_NAME'];
		$ip =  $data['CUSTOMER_IP'];
		$email =  $data['CUSTOMER_EMAIL'];
		$languagecode =  $data['LANGUAGE_CODE'];
		$address =  $data['card']['CUSTOMER_ADDRESS'];
		$transactionId =  $data['SHOP_NUMBER'];
		$cardnumber =  $data['card']['CB_NUMBER'];
		$expiryMonth =  $data['card']['CB_MONTH'];
		$expiryYear =  $data['card']['CB_YEAR'];
		$cvv =  $data['card']['CB_CVC'];
		$cardtype =  $data['card']['CB_TYPE'];
		$city =  $data['card']['CUSTOMER_CITY'];
		$zipcode =  $data['card']['CUSTOMER_ZIP_CODE'];
		$state =  $data['card']['CUSTOMER_STATE'];
		$country =  $data['card']['CUSTOMER_COUNTRY'];
		$phone =  $data['card']['CUSTOMER_PHONE'];
		//$shopId = $this->$data['SHOP_ID'];
		$returnUrl= $data['URL_RETURN'];
	
		$redirectUrl = $this->getEndpoint().'?'.'SHOP_ID=BARDO_TEST&SHOP_NUMBER='.$transactionId.'&CUSTOMER_FIRST_NAME='.$fname.'&CUSTOMER_LAST_NAME='.$lname.'&CUSTOMER_EMAIL='.$email.'&CUSTOMER_ADDRESS='.$address.'&CUSTOMER_CITY='.$city.'&CUSTOMER_COUNTRY=KE&CUSTOMER_PHONE='.$phone.'&CUSTOMER_ZIP_CODE='.$zipcode.'&CUSTOMER_STATE='.$state.'&LANGUAGE_CODE='.$languagecode.'&PRODUCT_NAME='.$productname.'&CUSTOMER_IP='.$ip.'&TRANSAC_AMOUNT='.$amount.'&CURRENCY_CODE='.$currency;
		
		return $this->response = new Response($this, $data, $redirectUrl);
		
	
		
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
	
}
