<?php
namespace Sdk\Label\Adapter\Label;

use Sdk\Common\Adapter\OperatAbleMockAdapterTrait;
use Sdk\Common\Adapter\EnableAbleMockAdapterTrait;

use Sdk\Label\Model\Label;
use Sdk\Label\Utils\MockFactory;

class LabelMockAdapter implements ILabelAdapter
{
    use OperatAbleMockAdapterTrait, EnableAbleMockAdapterTrait;

    public function fetchOne($id)
    {
        return MockFactory::generateLabelObject($id);
    }

    public function fetchList(array $ids) : array
    {
        $labelList = array();

        foreach ($ids as $id) {
            $labelList[] = MockFactory::generateLabelObject($id);
        }

        return $labelList;
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
        return MockFactory::generateLabelObject($id);
    }

    public function fetchListAsync(array $ids) : array
    {
        $parentCategoryList = array();

        foreach ($ids as $id) {
            $parentCategoryList[] = MockFactory::generateLabelObject($id);
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
