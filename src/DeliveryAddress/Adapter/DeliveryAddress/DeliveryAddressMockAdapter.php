<?php
namespace Sdk\DeliveryAddress\Adapter\DeliveryAddress;

use Sdk\Common\Adapter\OperatAbleMockAdapterTrait;
use Sdk\Common\Adapter\ModifyStatusAbleMockAdapterTrait;

use Sdk\DeliveryAddress\Model\DeliveryAddress;
use Sdk\DeliveryAddress\Utils\MockFactory;

class DeliveryAddressMockAdapter implements IDeliveryAddressAdapter
{
    use OperatAbleMockAdapterTrait, ModifyStatusAbleMockAdapterTrait;

    public function fetchOne($id)
    {
        return MockFactory::generateDeliveryAddressObject($id);
    }

    public function fetchList(array $ids): array
    {
        $serviceList = array();

        foreach ($ids as $id) {
            $serviceList[] = MockFactory::generateDeliveryAddressObject($id);
        }

        return $serviceList;
    }

    public function search(
        array $filter = array(),
        array $sort = array(),
        int $offset = 0,
        int $size = 20
    ): array {
        unset($filter);
        unset($sort);

        $ids = [];

        for ($offset; $offset < $size; $offset++) {
            $ids[] = $offset;
        }

        $count = sizeof($ids);

        return array($this->fetchList($ids), $count);
    }

    public function fetchOneAsync(int $id)
    {
        return MockFactory::generateDeliveryAddressObject($id);
    }

    public function fetchListAsync(array $ids): array
    {
        $serviceList = array();

        foreach ($ids as $id) {
            $serviceList[] = MockFactory::generateDeliveryAddressObject($id);
        }

        return $serviceList;
    }

    public function searchAsync(
        array $filter = array(),
        array $sort = array(),
        int $offset = 0,
        int $size = 20
    ): array {
        unset($filter);
        unset($sort);

        $ids = [];

        for ($offset; $offset < $size; $offset++) {
            $ids[] = $offset;
        }

        $count = sizeof($ids);

        return array($this->fetchList($ids), $count);
    }
}
