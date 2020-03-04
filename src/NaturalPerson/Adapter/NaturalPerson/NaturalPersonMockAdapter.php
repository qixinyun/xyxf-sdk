<?php
namespace Sdk\NaturalPerson\Adapter\NaturalPerson;

use Sdk\Common\Adapter\OperatAbleMockAdapterTrait;
use Sdk\Common\Adapter\ApplyAbleMockAdapterTrait;

use Sdk\NaturalPerson\Model\NaturalPerson;
use Sdk\NaturalPerson\Util\MockFactory;

class NaturalPersonMockAdapter implements INaturalPersonAdapter
{
    use OperatAbleMockAdapterTrait, ApplyAbleMockAdapterTrait;

    public function fetchOne($id)
    {
        return MockFactory::generateNaturalPersonObject($id);
    }

    public function fetchList(array $ids) : array
    {
        $naturalPersonList = array();

        foreach ($ids as $id) {
            $naturalPersonList[] = MockFactory::generateNaturalPersonObject($id);
        }

        return $naturalPersonList;
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
        return MockFactory::generateNaturalPersonObject($id);
    }

    public function fetchListAsync(array $ids) : array
    {
        $parentCategoryList = array();

        foreach ($ids as $id) {
            $parentCategoryList[] = MockFactory::generateNaturalPersonObject($id);
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
