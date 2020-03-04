<?php
namespace Sdk\Common\Adapter;

use Sdk\Common\Model\IApplyAble;

trait ApplyAbleRestfulAdapterTrait
{
    abstract protected function getResource() : string;

    public function approve(IApplyAble $applyAbleObject) : bool
    {
        return $this->approveAction($applyAbleObject);
    }

    protected function approveAction(IApplyAble $applyAbleObject) : bool
    {
        $this->patch(
            $this->getResource().'/'.$applyAbleObject->getId().'/approve'
        );
       
        if ($this->isSuccess()) {
            $this->translateToObject($applyAbleObject);
            return true;
        }
        return false;
    }

    public function reject(IApplyAble $applyAbleObject) : bool
    {
        return $this->rejectAction($applyAbleObject);
    }

    protected function rejectAction(IApplyAble $applyAbleObject) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $applyAbleObject,
            array(
                'rejectReason'
            )
        );
        
        $this->patch(
            $this->getResource().'/'.$applyAbleObject->getId().'/reject',
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($applyAbleObject);
            return true;
        }
        return false;
    }
}
