<?php
namespace Sdk\Common\Adapter;

use Sdk\Common\Model\IApplyAble;

interface IApplyAbleAdapter
{
    public function approve(IApplyAble $applyAbleObject) : bool;

    public function reject(IApplyAble $applyAbleObject) : bool;
}
