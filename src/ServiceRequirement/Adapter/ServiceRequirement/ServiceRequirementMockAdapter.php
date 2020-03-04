<?php
namespace Sdk\ServiceRequirement\Adapter\ServiceRequirement;

use Sdk\Common\Adapter\OperatAbleMockAdapterTrait;
use Sdk\Common\Adapter\ApplyAbleMockAdapterTrait;
use Sdk\Common\Adapter\ModifyStatusAbleMockAdapterTrait;

use Sdk\ServiceRequirement\Model\ServiceRequirement;
use Sdk\ServiceRequirement\Utils\MockFactory;

class ServiceRequirementMockAdapter implements IServiceRequirementAdapter
{
    use OperatAbleMockAdapterTrait, ApplyAbleMockAdapterTrait, ModifyStatusAbleMockAdapterTrait;

    public function fetchOne($id)
    {
        return MockFactory::generateRequirementObject($id);
    }

    public function fetchList(array $ids) : array
    {
        $requirementList = array();

        foreach ($ids as $id) {
            $requirementList[] = MockFactory::generateRequirementObject($id);
        }

        return $requirementList;
    }

    public function search(
        array $filter = array(),
        array $sort = array(),
        int $offset = 0,
        int $size = 20
    ) :array {
        unset($filter);
        unset($sort);

        $ids = [];

        for ($offset; $offset<$size; $offset++) {
            $ids[] = $offset;
        }

        $count = sizeof($ids);
        return array($this->fetchList($ids), $count);
    }

    public function fetchOneAsync(int $id)
    {
        return MockFactory::generateRequirementObject($id);
    }

    public function fetchListAsync(array $ids) : array
    {
        $requirementList = array();

        foreach ($ids as $id) {
            $requirementList[] = MockFactory::generateRequirementObject($id);
        }

        return $requirementList;
    }

    public function searchAsync(
        array $filter = array(),
        array $sort = array(),
        int $offset = 0,
        int $size = 20
    ) :array {
        unset($filter);
        unset($sort);

        $ids = [];

        for ($offset; $offset<$size; $offset++) {
            $ids[] = $offset;
        }

        $count = sizeof($ids);
        return array($this->fetchList($ids), $count);
    }
}
