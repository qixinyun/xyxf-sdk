<?php
namespace Sdk\Common\Model;

use Sdk\Common\Adapter\IResubmitAbleAdapter;

trait ResubmitAbleTrait
{
    public function resubmit() : bool
    {
        $repository = $this->getIResubmitAbleAdapter();

        return $repository->resubmit($this);
    }

    abstract protected function getIResubmitAbleAdapter() : IResubmitAbleAdapter;
}
