<?php
namespace Sdk\PolicyInterpretation\Adapter\PolicyInterpretation;

use Sdk\Common\Adapter\OperatAbleMockAdapterTrait;
use Sdk\Common\Adapter\OnShelfAbleMockAdapterTrait;

use Sdk\PolicyInterpretation\Model\PolicyInterpretation;
use Sdk\PolicyInterpretation\Util\MockFactory;

class PolicyInterpretationMockAdapter implements IPolicyInterpretationAdapter
{
    use OperatAbleMockAdapterTrait, OnShelfAbleMockAdapterTrait;
    
    public function fetchOne($id)
    {
        return MockFactory::generatePolicyInterpretationObject($id);
    }

    public function fetchList(array $ids) : array
    {
        $policyInterpretationList = array();

        foreach ($ids as $id) {
            $policyInterpretationList[] = MockFactory::generatePolicyInterpretationObject($id);
        }

        return $policyInterpretationList;
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
        return MockFactory::generatePolicyInterpretationObject($id);
    }

    public function fetchListAsync(array $ids) : array
    {
        $parentCategoryList = array();

        foreach ($ids as $id) {
            $parentCategoryList[] = MockFactory::generatePolicyInterpretationObject($id);
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
