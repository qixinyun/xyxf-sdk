<?php
namespace Sdk\Service\Adapter\Service;

use Sdk\Common\Adapter\ApplyAbleMockAdapterTrait;
use Sdk\Common\Adapter\OperatAbleMockAdapterTrait;
use Sdk\Common\Adapter\ModifyStatusMockAdapterTrait;
use Sdk\Common\Adapter\ResubmitAbleMockAdapterTrait;

use Sdk\Service\Model\Service;
use Sdk\Service\Utils\MockFactory;

class ServiceMockAdapter implements IServiceAdapter
{
    use OperatAbleMockAdapterTrait,
        ApplyAbleMockAdapterTrait,
        ServiceMockAdapterTrait,
        ModifyStatusMockAdapterTrait,
        ResubmitAbleMockAdapterTrait;

    public function fetchOne($id)
    {
        return MockFactory::generateServiceObject($id);
    }

    public function fetchList(array $ids): array
    {
        $serviceList = array();

        foreach ($ids as $id) {
            $serviceList[] = MockFactory::generateServiceObject($id);
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
        return MockFactory::generateServiceObject($id);
    }

    public function fetchListAsync(array $ids): array
    {
        $serviceList = array();

        foreach ($ids as $id) {
            $serviceList[] = MockFactory::generateServiceObject($id);
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
