<?php
namespace Sdk\MemberAccount\Model;

use Marmot\Core;
use Marmot\Interfaces\INull;

class NullMemberAccount extends MemberAccount implements INull
{
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
