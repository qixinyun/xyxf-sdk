<?php
namespace Sdk\Common\Repository;

use Sdk\Common\Model\IModifyStatusAble;

trait ModifyStatusAbleRepositoryTrait
{
    public function revoke(IModifyStatusAble $modifyStatusAbleObject) : bool
    {
        return $this->getAdapter()->revoke($modifyStatusAbleObject);
    }

    public function close(IModifyStatusAble $modifyStatusAbleObject) : bool
    {
        return $this->getAdapter()->close($modifyStatusAbleObject);
    }

    public function deletes(IModifyStatusAble $modifyStatusAbleObject) : bool
    {
        return $this->getAdapter()->deletes($modifyStatusAbleObject);
    }
}
