<?php
namespace Sdk\Common\Repository;

use Marmot\Interfaces\IAsyncAdapter;

trait AsyncRepositoryTrait
{
    public function fetchOneAsync(int $id)
    {
        $adapter = $this->getAdapter();
        return $adapter instanceof IAsyncAdapter ? $adapter->fetchOneAsync($id) : '';
    }

    public function fetchListAsync(array $id)
    {
        $adapter = $this->getAdapter();
        return $adapter instanceof IAsyncAdapter ? $adapter->fetchListAsync($id) : array();
    }

    public function searchAsync(
        array $filter = array(),
        array $sort = array(),
        int $offset = 0,
        int $size = 20
    ) {
        $adapter = $this->getAdapter();
        return $adapter instanceof IAsyncAdapter
            ? $adapter->searchAsync($filter, $sort, $offset, $size)
            : array();
    }
}
