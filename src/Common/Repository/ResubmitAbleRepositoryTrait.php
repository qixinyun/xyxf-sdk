<?php
namespace Sdk\Common\Repository;

use Sdk\Common\Model\IResubmitAble;

trait ResubmitAbleRepositoryTrait
{
    public function resubmit(IResubmitAble $resubmitAbleObject) : bool
    {
        return $this->getAdapter()->resubmit($resubmitAbleObject);
    }
}
