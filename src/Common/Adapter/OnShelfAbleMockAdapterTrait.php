<?php
namespace Sdk\Common\Adapter;

use Sdk\Common\Model\IOnShelfAble;

trait OnShelfAbleMockAdapterTrait
{
    public function onShelf(IOnShelfAble $onShelfAbleObject) : bool
    {
        unset($onShelfAbleObject);
        return true;
    }

    public function offStock(IOnShelfAble $onShelfAbleObject) : bool
    {
        unset($onShelfAbleObject);
        return true;
    }
}
