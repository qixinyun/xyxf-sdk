<?php
namespace Sdk\Common\Adapter;

use Sdk\Common\Model\IModifyStatusAble;

trait ModifyStatusAbleRestfulAdapterTrait
{
    abstract protected function getResource() : string;

    public function revoke(IModifyStatusAble $modifyStatusAbleObject) : bool
    {
        return $this->revokeAction($modifyStatusAbleObject);
    }

    protected function revokeAction(IModifyStatusAble $modifyStatusAbleObject) : bool
    {
        $this->patch(
            $this->getResource().'/'.$modifyStatusAbleObject->getId().'/revoke'
        );
        if ($this->isSuccess()) {
            $this->translateToObject($modifyStatusAbleObject);
            return true;
        }
        return false;
    }

    public function close(IModifyStatusAble $modifyStatusAbleObject) : bool
    {
        return $this->closeAction($modifyStatusAbleObject);
    }

    protected function closeAction(IModifyStatusAble $modifyStatusAbleObject) : bool
    {
        $this->patch(
            $this->getResource().'/'.$modifyStatusAbleObject->getId().'/close'
        );

        if ($this->isSuccess()) {
            $this->translateToObject($modifyStatusAbleObject);
            return true;
        }
        return false;
    }

    public function deletes(IModifyStatusAble $modifyStatusAbleObject) : bool
    {
        return $this->deletesAction($modifyStatusAbleObject);
    }

    protected function deletesAction(IModifyStatusAble $modifyStatusAbleObject) : bool
    {
        $this->patch(
            $this->getResource().'/'.$modifyStatusAbleObject->getId().'/delete'
        );

        if ($this->isSuccess()) {
            $this->translateToObject($modifyStatusAbleObject);
            return true;
        }
        return false;
    }
}
