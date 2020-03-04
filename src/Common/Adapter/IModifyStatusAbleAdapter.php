<?php
namespace Sdk\Common\Adapter;

use Sdk\Common\Model\IModifyStatusAble;

interface IModifyStatusAbleAdapter
{
    public function revoke(IModifyStatusAble $modifyStatusAbleObject) : bool;

    public function close(IModifyStatusAble $modifyStatusAbleObject) : bool;

    public function deletes(IModifyStatusAble $modifyStatusAbleObject) : bool;
}
