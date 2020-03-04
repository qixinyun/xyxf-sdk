<?php
namespace Sdk\Common\Adapter;

use Sdk\Common\Model\IResubmitAble;

interface IResubmitAbleAdapter
{
    public function resubmit(IResubmitAble $resubmitAbleObject) : bool;
}
