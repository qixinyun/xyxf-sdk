<?php
namespace Sdk\ServiceCategory\Model;

use Marmot\Core;
use Marmot\Interfaces\INull;

use Sdk\Common\Model\NullOperatAbleTrait;
use Sdk\Common\Model\NullEnableAbleTrait;

class NullServiceCategory extends ServiceCategory implements INull
{
    use NullOperatAbleTrait, NullEnableAbleTrait;
    
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
}
