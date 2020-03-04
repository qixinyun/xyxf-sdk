<?php
namespace Sdk\Common\Repository;

trait FetchRepositoryTrait
{
    public function fetchOne($id)
    {
        return $this->getAdapter()->fetchOne($id);
    }

    public function fetchList(array $ids) : array
    {
        return $this->getAdapter()->fetchList($ids);
    }

    public function search(
        array $filter = array(),
        array $sort = array(),
        int $number = 0,
        int $size = 20
    ) : array {
        return $this->getAdapter()->search($filter, $sort, $number, $size);
    }
}
