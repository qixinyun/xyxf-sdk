<?php
namespace Sdk\Common\Model;

trait NullApplyAbleTrait
{
    public function approve() : bool
    {
        return $this->resourceNotExist();
    }

    public function reject() : bool
    {
        return $this->resourceNotExist();
    }

    abstract protected function resourceNotExist() : bool;
}
