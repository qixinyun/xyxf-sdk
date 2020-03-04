<?php
namespace Sdk\Service\Model;

use Marmot\Core;
use Marmot\Interfaces\INull;

use Sdk\Common\Model\NullApplyAbleTrait;
use Sdk\Common\Model\NullOperatAbleTrait;
use Sdk\Common\Model\NullResubmitAbleTrait;
use Sdk\Common\Model\NullModifyStatusAbleTrait;

class NullService extends Service implements INull
{
    use NullApplyAbleTrait,
        NullOperatAbleTrait,
        NullResubmitAbleTrait,
        NullModifyStatusAbleTrait;

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

    public function onShelf(): bool
    {
        return $this->resourceNotExist();
    }

    public function offStock(): bool
    {
        return $this->resourceNotExist();
    }
}
