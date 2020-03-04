<?php
namespace Sdk\Common\Adapter;

use Sdk\Common\Model\IApplyAble;

trait ApplyAbleMockAdapterTrait
{
    public function approve(IApplyAble $applyAbleObject) : bool
    {
        unset($applyAbleObject);
        return true;
    }

    public function reject(IApplyAble $applyAbleObject) : bool
    {
        unset($applyAbleObject);
        return true;
    }
}
