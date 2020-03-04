<?php
namespace Sdk\Common\Adapter;

use Sdk\Common\Model\IEnableAble;

trait EnableAbleRestfulAdapterTrait
{
    abstract protected function getResource() : string;

    public function enable(IEnableAble $enableAbleObject) : bool
    {
        return $this->enableAction($enableAbleObject);
    }

    protected function enableAction(IEnableAble $enableAbleObject) : bool
    {
        $this->patch(
            $this->getResource().'/'.$enableAbleObject->getId().'/enable'
        );
        if ($this->isSuccess()) {
            $this->translateToObject($enableAbleObject);
            return true;
        }
        return false;
    }

    public function disable(IEnableAble $enableAbleObject) : bool
    {
        return $this->disableAction($enableAbleObject);
    }

    protected function disableAction(IEnableAble $enableAbleObject) : bool
    {
        $this->patch(
            $this->getResource().'/'.$enableAbleObject->getId().'/disable'
        );

        if ($this->isSuccess()) {
            $this->translateToObject($enableAbleObject);
            return true;
        }
        return false;
    }
}
