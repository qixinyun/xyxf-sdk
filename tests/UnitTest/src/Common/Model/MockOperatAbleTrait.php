<?php
namespace Sdk\Common\Model;

use Sdk\Common\Adapter\IOperatAbleAdapter;

class MockOperatAbleTrait implements IOperatAble
{
    use OperatAbleTrait;

    protected function getIOperatAbleAdapter() : IOperatAbleAdapter
    {
        $class = new class implements IOperatAbleAdapter
        {
            public function add() : bool
            {
                return false;
            }
            
            public function edit() : bool
            {
                return false;
            }
        };

        return $class;
    }
}
