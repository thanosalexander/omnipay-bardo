<?php

namespace Omnipay\Bardo;

use Omnipay\Common\AbstractGateway;

 

/**
 * Bardo Gateway
 *
 * @link https://bardo.com/docs/
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Bardo';
    }

    public function getDefaultParameters()
    {
        return array(
            'shopId' => 'BARDO_TEST',
            'testMode' => false,
        );
    }

    public function getShopId()
    {
        return $this->getParameter('shopId');
    }

    public function setShopId($value)
    {
        return $this->setParameter('shopId', $value);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Bardo\Message\PurchaseRequest', $parameters);
    }
	public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Bardo\Message\CompletePurchaseRequest', $parameters);
    }
}
