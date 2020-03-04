<?php
namespace Sdk\Common\Model;

trait NullOnShelfAbleTrait
{
    public function onShelf() : bool
    {
        return $this->resourceNotExist();
    }

    public function offStock() : bool
    {
        return $this->resourceNotExist();
    }

    public function isOnShelf() : bool
    {
        return $this->resourceNotExist();
    }

    public function isOffStock() : bool
    {
        return $this->resourceNotExist();
    }

    abstract protected function resourceNotExist() : bool;
}
