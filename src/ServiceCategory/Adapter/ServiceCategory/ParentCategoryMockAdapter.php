<?php
namespace Sdk\ServiceCategory\Adapter\ServiceCategory;

use Sdk\Common\Adapter\OperatAbleMockAdapterTrait;

use Sdk\ServiceCategory\Model\ParentCategory;
use Sdk\ServiceCategory\Utils\MockFactory;

class ParentCategoryMockAdapter implements IParentCategoryAdapter
{
    use OperatAbleMockAdapterTrait;

    public function fetchOne($id)
    {
        return MockFactory::generateParentCategoryObject($id);
    }

    public function fetchList(array $ids) : array
    {
        $parentCategoryList = array();

        foreach ($ids as $id) {
            $parentCategoryList[] = MockFactory::generateParentCategoryObject($id);
        }

        return $parentCategoryList;
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
        return MockFactory::generateParentCategoryObject($id);
    }

    public function fetchListAsync(array $ids) : array
    {
        $parentCategoryList = array();

        foreach ($ids as $id) {
            $parentCategoryList[] = MockFactory::generateParentCategoryObject($id);
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
