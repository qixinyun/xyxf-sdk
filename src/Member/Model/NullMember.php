<?php
namespace Sdk\Member\Model;

use Marmot\Core;
use Marmot\Interfaces\INull;

use Sdk\Common\Model\NullEnableAbleTrait;
use Sdk\Common\Model\NullOperatAbleTrait;

class NullMember extends Member implements INull
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

    public function signIn() : bool
    {
        return $this->resourceNotExist();
    }

    public function signUp() : bool
    {
        return $this->resourceNotExist();
    }

    public function resetPassword() : bool
    {
        return $this->resourceNotExist();
    }

    public function updatePassword() : bool
    {
        return $this->resourceNotExist();
    }

    public function updateCellphone() : bool
    {
        return $this->resourceNotExist();
    }
}
