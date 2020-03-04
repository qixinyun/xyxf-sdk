<?php
namespace Sdk\Common\Repository;

use Marmot\Interfaces\IErrorAdapter;

trait ErrorRepositoryTrait
{
    public function lastErrorId() : int
    {
        $adapter = $this->getAdapter();
        return $adapter instanceof IErrorAdapter ? $adapter->lastErrorId() : 0;
    }

    public function lastErrorInfo() : array
    {
        $adapter = $this->getAdapter();
        return $adapter instanceof IErrorAdapter ? $adapter->lastErrorInfo() : [];
    }
}
