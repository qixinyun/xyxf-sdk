<?php
namespace Sdk\Common\Adapter;

use Sdk\Common\Model\IResubmitAble;

trait ResubmitAbleRestfulAdapterTrait
{
    abstract protected function resubmitAction(IResubmitAble $resubmitAbleObject) : bool;

    public function resubmit(IResubmitAble $resubmitAbleObject) : bool
    {
        return $this->resubmitAction($resubmitAbleObject);
    }
}
