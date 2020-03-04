<?php
namespace Sdk\Common\Model;

use Marmot\Core;

use Sdk\Common\Adapter\IApplyAbleAdapter;

trait ApplyAbleTrait
{
    protected $applyStatus;

    public function setApplyStatus(int $applyStatus)
    {
        $this->applyStatus = in_array($applyStatus, array_values(self::APPLY_STATUS)) ?
            $applyStatus : self::APPLY_STATUS['PENDING'];
    }

    public function getApplyStatus() : int
    {
        return in_array($this->applyStatus, self::APPLY_STATUS) ? $this->applyStatus : self::APPLY_STATUS['PENDING'];
    }

    public function approve() : bool
    {
        $applyAdapter = $this->getIApplyAbleAdapter();

        return $applyAdapter->approve($this);
    }

    public function reject() : bool
    {
        $applyAdapter = $this->getIApplyAbleAdapter();
        return $applyAdapter->reject($this);
    }

    abstract protected function getIApplyAbleAdapter() : IApplyAbleAdapter;
}
