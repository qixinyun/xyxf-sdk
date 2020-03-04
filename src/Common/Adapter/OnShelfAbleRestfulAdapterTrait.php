<?php
namespace Sdk\Common\Adapter;

use Sdk\Common\Model\IOnShelfAble;

trait OnShelfAbleRestfulAdapterTrait
{
    abstract protected function getResource() : string;

    public function onShelf(IOnShelfAble $onShelfAbleObject) : bool
    {
        return $this->onShelfAction($onShelfAbleObject);
    }

    protected function onShelfAction(IOnShelfAble $onShelfAbleObject) : bool
    {
        $this->patch(
            $this->getResource().'/'.$onShelfAbleObject->getId().'/onShelf'
        );
        if ($this->isSuccess()) {
            $this->translateToObject($onShelfAbleObject);
            return true;
        }
        return false;
    }

    public function offStock(IOnShelfAble $onShelfAbleObject) : bool
    {
        return $this->offStockAction($onShelfAbleObject);
    }

    protected function offStockAction(IOnShelfAble $onShelfAbleObject) : bool
    {
        $this->patch(
            $this->getResource().'/'.$onShelfAbleObject->getId().'/offStock'
        );

        if ($this->isSuccess()) {
            $this->translateToObject($onShelfAbleObject);
            return true;
        }
        return false;
    }
}
