<?php
namespace Sdk\Common\Model;

trait NullOperatAbleTrait
{
    public function add() : bool
    {
        return $this->resourceNotExist();
    }

    public function edit() : bool
    {
        return $this->resourceNotExist();
    }

    abstract protected function resourceNotExist() : bool;
}
