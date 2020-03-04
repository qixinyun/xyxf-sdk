<?php
namespace Sdk\Common\Repository;

use Sdk\Common\Model\IOperatAble;

trait OperatAbleRepositoryTrait
{
    public function add(IOperatAble $operatAbleObject) : bool
    {
        return $this->getAdapter()->add($operatAbleObject);
    }

    public function edit(IOperatAble $operatAbleObject) : bool
    {
        return $this->getAdapter()->edit($operatAbleObject);
    }
}
