<?php
namespace Sdk\ServiceRequirement\Model;

use Marmot\Core;
use Marmot\Interfaces\INull;

use Sdk\Common\Model\NullApplyAbleTrait;
use Sdk\Common\Model\NullModifyStatusAbleTrait;
use Sdk\Common\Model\NullOperatAbleTrait;

class NullServiceRequirement extends ServiceRequirement implements INull
{
    use NullApplyAbleTrait, NullModifyStatusAbleTrait, NullOperatAbleTrait;

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
