<?php
namespace Sdk\Common\Adapter;

use Sdk\Common\Model\IOnShelfAble;

interface IOnShelfAbleAdapter
{
    public function onShelf(IOnShelfAble $onShelfAbleObject) : bool;

    public function offStock(IOnShelfAble $onShelfAbleObject) : bool;
}
