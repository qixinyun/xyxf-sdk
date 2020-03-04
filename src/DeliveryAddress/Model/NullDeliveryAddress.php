<?php
namespace Sdk\DeliveryAddress\Model;

use Marmot\Core;
use Marmot\Interfaces\INull;

use Sdk\Common\Model\NullOperatAbleTrait;

class NullDeliveryAddress extends DeliveryAddress implements INull
{
    use NullOperatAbleTrait;

    private static $instance;

    public static function &getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function resourceNotExist() : bool
    {
        Core::setLastError(RESOURCE_NOT_EXIST);
        return false;
    }

    public function setDefault() : bool
    {
        return $this->resourceNotExist();
    }

    public function deletes() : bool
    {
        return $this->resourceNotExist();
    }
}
