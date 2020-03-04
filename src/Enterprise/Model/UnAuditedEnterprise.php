<?php
namespace Sdk\Enterprise\Model;

use Sdk\Common\Model\IApplyAble;
use Sdk\Common\Model\IResubmitAble;
use Sdk\Common\Model\ApplyAbleTrait;
use Sdk\Common\Model\ResubmitAbleTrait;
use Sdk\Common\Adapter\IApplyAbleAdapter;
use Sdk\Common\Adapter\IResubmitAbleAdapter;

use Sdk\Enterprise\Repository\UnAuditedEnterpriseRepository;

class UnAuditedEnterprise extends Enterprise implements IApplyAble, IResubmitAble
{
    use ApplyAbleTrait, ResubmitAbleTrait;
    /**
     * [$rejectReason 驳回原因]
     * @var [string]
     */
    private $rejectReason;

    private $repository;

    public function __construct(int $id = 0)
    {
        parent::__construct($id);
        $this->rejectReason = '';
        $this->applyStatus = IApplyAble::APPLY_STATUS['PENDING'];
        $this->repository = new UnAuditedEnterpriseRepository();
    }

    public function __destruct()
    {
        parent::__destruct();
        unset($this->rejectReason);
        unset($this->applyStatus);
        unset($this->repository);
    }

    public function setRejectReason(string $rejectReason) : void
    {
        $this->rejectReason = $rejectReason;
    }

    public function getRejectReason() : string
    {
        return $this->rejectReason;
    }

    protected function getRepository()
    {
        return $this->repository;
    }

    protected function getIApplyAbleAdapter() : IApplyAbleAdapter
    {
        return $this->getRepository();
    }

    protected function getIResubmitAbleAdapter() : IResubmitAbleAdapter
    {
        return $this->getRepository();
    }
}
