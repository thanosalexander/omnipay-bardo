<?php

namespace Omnipay\Bardo;

use Omnipay\Common\AbstractGateway;
use Omnipay\Bardo\Message\PurchaseRequest;

/**
 * Bardo Gateway
 *
 * @link https://pin.net.au/docs/api
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
            'SHOP_ID' => '',
            'testMode' => false,
        );
    }

    public function getShopId()
    {
        return $this->getParameter('SHOP_ID');
    }

    public function setShopId($value)
    {
        return $this->setParameter('SHOP_ID', $value);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Bardo\Message\PurchaseRequest', $parameters);
    }
}
