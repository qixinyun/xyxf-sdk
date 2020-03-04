<?php
namespace Sdk\Common\Repository;

use Sdk\Common\Model\IOnShelfAble;

trait OnShelfAbleRepositoryTrait
{
    public function onShelf(IOnShelfAble $onShelfAbleObject) : bool
    {
        return $this->getAdapter()->onShelf($onShelfAbleObject);
    }

    public function offStock(IOnShelfAble $onShelfAbleObject) : bool
    {
        return $this->getAdapter()->offStock($onShelfAbleObject);
    }
}
