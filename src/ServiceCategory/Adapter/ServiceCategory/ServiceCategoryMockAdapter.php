<?php
namespace Sdk\ServiceCategory\Adapter\ServiceCategory;

use Sdk\Common\Adapter\OperatAbleMockAdapterTrait;
use Sdk\Common\Adapter\EnableAbleMockAdapterTrait;

use Sdk\ServiceCategory\Model\ServiceCategory;
use Sdk\ServiceCategory\Utils\MockFactory;

class ServiceCategoryMockAdapter implements IServiceCategoryAdapter
{
    use OperatAbleMockAdapterTrait, EnableAbleMockAdapterTrait;
    
    public function fetchOne($id)
    {
        return MockFactory::generateServiceCategoryObject($id);
    }

    public function fetchList(array $ids) : array
    {
        $serviceCategoryList = array();

        foreach ($ids as $id) {
            $serviceCategoryList[] = MockFactory::generateServiceCategoryObject($id);
        }

        return $serviceCategoryList;
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
        return MockFactory::generateServiceCategoryObject($id);
    }

    public function fetchListAsync(array $ids) : array
    {
        $parentCategoryList = array();

        foreach ($ids as $id) {
            $parentCategoryList[] = MockFactory::generateServiceCategoryObject($id);
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
