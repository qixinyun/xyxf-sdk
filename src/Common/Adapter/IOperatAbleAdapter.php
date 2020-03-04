<?php
namespace Sdk\Common\Adapter;

use Sdk\Common\Model\IOperatAble;

interface IOperatAbleAdapter
{
    public function add(IOperatAble $operatAbleObject) : bool;

    public function edit(IOperatAble $operatAbleObject) : bool;
}
