<?php
namespace Sdk\DispatchDepartment\Adapter\DispatchDepartment;

use Sdk\Common\Adapter\OperatAbleMockAdapterTrait;
use Sdk\Common\Adapter\EnableAbleMockAdapterTrait;

use Sdk\DispatchDepartment\Model\DispatchDepartment;
use Sdk\DispatchDepartment\Utils\MockFactory;

class DispatchDepartmentMockAdapter implements IDispatchDepartmentAdapter
{
    use OperatAbleMockAdapterTrait, EnableAbleMockAdapterTrait;

    public function fetchOne($id)
    {
        return MockFactory::generateDispatchDepartmentObject($id);
    }

    public function fetchList(array $ids) : array
    {
        $dispatchDepartmentList = array();

        foreach ($ids as $id) {
            $dispatchDepartmentList[] = MockFactory::generateDispatchDepartmentObject($id);
        }

        return $dispatchDepartmentList;
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
        return MockFactory::generateDispatchDepartmentObject($id);
    }

    public function fetchListAsync(array $ids) : array
    {
        $parentCategoryList = array();

        foreach ($ids as $id) {
            $parentCategoryList[] = MockFactory::generateDispatchDepartmentObject($id);
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
