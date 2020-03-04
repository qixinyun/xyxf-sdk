<?php
namespace Sdk\Common\Model;

trait NullResubmitAbleTrait
{
    public function resubmit() : bool
    {
        return $this->resourceNotExist();
    }

    abstract protected function resourceNotExist() : bool;
}
