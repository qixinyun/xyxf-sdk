<?php
namespace Sdk\DeliveryAddress\Repository;

use Sdk\Common\Repository\FetchRepositoryTrait;
use Sdk\Common\Repository\OperatAbleRepositoryTrait;
use Sdk\Common\Repository\ModifyStatusAbleRepositoryTrait;
use Sdk\Common\Repository\ErrorRepositoryTrait;

use Sdk\DeliveryAddress\Adapter\DeliveryAddress\IDeliveryAddressAdapter;
use Sdk\DeliveryAddress\Adapter\DeliveryAddress\DeliveryAddressMockAdapter;
use Sdk\DeliveryAddress\Adapter\DeliveryAddress\DeliveryAddressRestfulAdapter;

use Marmot\Core;
use Marmot\Framework\Classes\Repository;

use Sdk\DeliveryAddress\Model\DeliveryAddress;

class DeliveryAddressRepository extends Repository implements IDeliveryAddressAdapter
{
    use FetchRepositoryTrait,
        OperatAbleRepositoryTrait,
        ModifyStatusAbleRepositoryTrait,
        ErrorRepositoryTrait;

    private $adapter;

    const LIST_MODEL_UN = 'DELIVERY_ADDRESS_LIST';
    const FETCH_ONE_MODEL_UN = 'DELIVERY_ADDRESS_FETCH_ONE';

    public function __construct()
    {
        $this->adapter = new DeliveryAddressRestfulAdapter(
            Core::$container->has('sdk.url') ? Core::$container->get('sdk.url') : '',
            Core::$container->has('sdk.authKey') ? Core::$container->get('sdk.authKey') : []
        );
    }

    public function getActualAdapter() : IDeliveryAddressAdapter
    {
        return $this->adapter;
    }

    public function getMockAdapter() : IDeliveryAddressAdapter
    {
        return new DeliveryAddressMockAdapter();
    }

    public function scenario($scenario)
    {
        $this->getAdapter()->scenario($scenario);
        return $this;
    }

    public function setDefault(DeliveryAddress $deliveryAddress) : bool
    {
        return $this->getAdapter()->setDefault($deliveryAddress);
    }
}
