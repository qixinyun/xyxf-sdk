<?php
namespace Sdk\Common\Repository;

use Sdk\Common\Model\IApplyAble;

trait ApplyAbleRepositoryTrait
{
    public function approve(IApplyAble $applyAbleObject) : bool
    {
        return $this->getAdapter()->approve($applyAbleObject);
    }

    public function reject(IApplyAble $applyAbleObject) : bool
    {
        return $this->getAdapter()->reject($applyAbleObject);
    }
}
