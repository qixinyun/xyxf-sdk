<?php
namespace Sdk\Common\Model;

use Sdk\Common\Adapter\IEnableAbleAdapter;

class MockEnableAbleTrait implements IEnableAble
{
    use EnableAbleTrait;

    private $status;

    public function getStatus() : int
    {
        return $this->status;
    }

    protected function getIEnableAbleAdapter() : IEnableAbleAdapter
    {
        $class = new class implements IEnableAbleAdapter
        {
            public function enable(IEnableAble $enableAbleObject) : bool
            {
                return false;
            }
            
            public function disable(IEnableAble $enableAbleObject) : bool
            {
                return false;
            }
        };

        return $class;
    }
}
