<?php
namespace Sdk\Common\Adapter;

use Sdk\Common\Model\IResubmitAble;

trait ResubmitAbleMockAdapterTrait
{
    public function resubmit(IResubmitAble $resubmitAbleObject) : bool
    {
        unset($resubmitAbleObject);
        return true;
    }
}
