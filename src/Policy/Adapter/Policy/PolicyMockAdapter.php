<?php
namespace Sdk\Policy\Adapter\Policy;

use Sdk\Common\Adapter\OperatAbleMockAdapterTrait;
use Sdk\Common\Adapter\OnShelfAbleMockAdapterTrait;

use Sdk\Policy\Model\Policy;
use Sdk\Policy\Utils\MockFactory;

class PolicyMockAdapter implements IPolicyAdapter
{
    use OperatAbleMockAdapterTrait, OnShelfAbleMockAdapterTrait;

    public function fetchOne($id)
    {
        return MockFactory::generatePolicyObject($id);
    }

    public function fetchList(array $ids) : array
    {
        $policyList = array();

        foreach ($ids as $id) {
            $policyList[] = MockFactory::generatePolicyObject($id);
        }

        return $policyList;
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
        return MockFactory::generatePolicyObject($id);
    }

    public function fetchListAsync(array $ids) : array
    {
        $parentCategoryList = array();

        foreach ($ids as $id) {
            $parentCategoryList[] = MockFactory::generatePolicyObject($id);
        }

        return $parentCategoryList;
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
