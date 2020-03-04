<?php
namespace Sdk\Common\Adapter;

use Sdk\Common\Model\IModifyStatusAble;

trait ModifyStatusAbleMockAdapterTrait
{
    public function revoke(IModifyStatusAble $modifyStatusAbleObject) : bool
    {
        unset($modifyStatusAbleObject);
        return true;
    }

    public function close(IModifyStatusAble $modifyStatusAbleObject) : bool
    {
        unset($modifyStatusAbleObject);
        return true;
    }

    public function deletes(IModifyStatusAble $modifyStatusAbleObject) : bool
    {
        unset($modifyStatusAbleObject);
        return true;
    }
}
