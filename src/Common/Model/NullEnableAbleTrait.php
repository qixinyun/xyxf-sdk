<?php
namespace Sdk\Common\Model;

trait NullEnableAbleTrait
{
    public function enable() : bool
    {
        return $this->resourceNotExist();
    }

    public function disable() : bool
    {
        return $this->resourceNotExist();
    }

    public function isEnabled() : bool
    {
        return $this->resourceNotExist();
    }

    public function isDisabled() : bool
    {
        return $this->resourceNotExist();
    }

    abstract protected function resourceNotExist() : bool;
}
