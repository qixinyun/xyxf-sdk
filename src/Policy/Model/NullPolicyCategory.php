<?php
namespace Sdk\Policy\Model;

use Marmot\Interfaces\INull;

class NullPolicyCategory extends PolicyCategory implements INull
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
