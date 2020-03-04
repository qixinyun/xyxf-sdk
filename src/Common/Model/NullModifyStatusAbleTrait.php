<?php
namespace Sdk\Common\Model;

trait NullModifyStatusAbleTrait
{
    public function revoke() : bool
    {
        return $this->resourceNotExist();
    }

    public function close() : bool
    {
        return $this->resourceNotExist();
    }

    public function deletes() : bool
    {
        return $this->resourceNotExist();
    }

    abstract protected function resourceNotExist() : bool;
}
