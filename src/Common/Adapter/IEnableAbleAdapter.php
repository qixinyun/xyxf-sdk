<?php
namespace Sdk\Common\Adapter;

use Sdk\Common\Model\IEnableAble;

interface IEnableAbleAdapter
{
    public function enable(IEnableAble $enableAbleObject) : bool;

    public function disable(IEnableAble $enableAbleObject) : bool;
}
