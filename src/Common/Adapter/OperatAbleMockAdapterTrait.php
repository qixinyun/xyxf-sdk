<?php
namespace Sdk\Common\Adapter;

use Sdk\Common\Model\IOperatAble;

trait OperatAbleMockAdapterTrait
{
    public function add(IOperatAble $operatAbleObject) : bool
    {
        unset($operatAbleObject);
        return true;
    }

    public function edit(IOperatAble $operatAbleObject) : bool
    {
        unset($operatAbleObject);
        return true;
    }
}
