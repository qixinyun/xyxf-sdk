<?php
namespace Sdk\Crew\Model;

use Marmot\Interfaces\INull;

use Sdk\Common\Model\NullEnableAbleTrait;
use Sdk\Common\Model\NullOperatAbleTrait;

class NullCrew extends Crew implements INull
{
    use NullEnableAbleTrait, NullOperatAbleTrait;

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
