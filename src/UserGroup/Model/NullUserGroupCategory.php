<?php
namespace Sdk\UserGroup\Model;

use Marmot\Interfaces\INull;

class NullUserGroupCategory extends UserGroupCategory implements INull
{
    private static $instance;
    
    public static function &getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self(0, '');
        }
        return self::$instance;
    }
}
