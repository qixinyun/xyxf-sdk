<?php
namespace Sdk\Common\Adapter;

use Sdk\Common\Model\IEnableAble;

trait EnableAbleMockAdapterTrait
{
    public function enable(IEnableAble $enableAbleObject) : bool
    {
        unset($enableAbleObject);
        return true;
    }

    public function disable(IEnableAble $enableAbleObject) : bool
    {
        unset($enableAbleObject);
        return true;
    }
}
