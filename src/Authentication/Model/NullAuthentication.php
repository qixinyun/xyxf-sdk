<?php
namespace Sdk\Authentication\Model;

use Marmot\Core;
use Marmot\Interfaces\INull;
use Sdk\Common\Model\NullOperatAbleTrait;
use Sdk\Common\Model\NullResubmitAbleTrait;
use Sdk\Common\Model\NullApplyAbleTrait;

class NullAuthentication extends Authentication implements INull
{
    use NullOperatAbleTrait, NullResubmitAbleTrait;

    private static $instance;

    public static function &getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function resourceNotExist(): bool
    {
        Core::setLastError(RESOURCE_NOT_EXIST);
        return false;
    }
}
