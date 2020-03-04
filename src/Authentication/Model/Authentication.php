<?php
namespace Sdk\Authentication\Model;

use Marmot\Common\Model\IObject;
use Marmot\Common\Model\Object;

use Sdk\Authentication\Repository\AuthenticationRepository;

use Sdk\Enterprise\Model\Enterprise;
use Sdk\ServiceCategory\Model\ServiceCategory;

use Sdk\Common\Adapter\IOperatAbleAdapter;
use Sdk\Common\Adapter\IResubmitAbleAdapter;
use Sdk\Common\Adapter\IApplyAbleAdapter;
use Sdk\Common\Model\IOperatAble;
use Sdk\Common\Model\IResubmitAble;
use Sdk\Common\Model\IApplyAble;
use Sdk\Common\Model\OperatAbleTrait;
use Sdk\Common\Model\ResubmitAbleTrait;
use Sdk\Common\Model\ApplyAbleTrait;

class Authentication implements IOperatAble, IObject, IResubmitAble, IApplyAble
{
    use Object, OperatAbleTrait, ResubmitAbleTrait, ApplyAbleTrait;

    private $id;

    private $number;

    private $enterpriseName;

    private $serviceCategory;

    private $qualificationImage;

    private $qualifications;

    private $enterprise;

    private $rejectReason;

    private $repository;

    public function __construct(int $id = 0)
    {
        $this->id = !empty($id) ? $id : 0;
        $this->number = '';
        $this->enterpriseName = '';
        $this->serviceCategory = new ServiceCategory();
        $this->qualifications = array();
        $this->enterprise = new Enterprise();
        $this->rejectReason = '';
        $this->applyStatus = IApplyAble::APPLY_STATUS['PENDING'];
        $this->status = 0;
        $this->createTime = 0;
        $this->updateTime = 0;
        $this->statusTime = 0;
        $this->repository = new AuthenticationRepository();
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->number);
        unset($this->enterpriseName);
        unset($this->serviceCategory);
        unset($this->qualifications);
        unset($this->enterprise);
        unset($this->rejectReason);
        unset($this->applyStatus);
        unset($this->status);
        unset($this->createTime);
        unset($this->updateTime);
        unset($this->statusTime);
        unset($this->repository);
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setNumber(string $number)
    {
        $this->number = $number;
    }

    public function getNumber() : string
    {
        return $this->number;
    }

    public function setEnterpriseName(string $enterpriseName)
    {
        $this->enterpriseName = $enterpriseName;
    }

    public function getEnterpriseName(): string
    {
        return $this->enterpriseName;
    }

    public function setServiceCategory(ServiceCategory $serviceCategory)
    {
        $this->serviceCategory = $serviceCategory;
    }

    public function getServiceCategory()
    {
        return $this->serviceCategory;
    }

    public function setQualificationImage(array $qualificationImage) : void
    {
        $this->qualificationImage = $qualificationImage;
    }

    public function getQualificationImage() : array
    {
        return $this->qualificationImage;
    }

    public function addQualification(Qualification $qualification): void
    {
        $this->qualifications[] = $qualification;
    }

    public function clearQualifications()
    {
        $this->qualifications = [];
    }

    public function getQualifications(): array
    {
        return $this->qualifications;
    }

    public function setEnterprise(Enterprise $enterprise): void
    {
        $this->enterprise = $enterprise;
    }

    public function getEnterprise(): Enterprise
    {
        return $this->enterprise;
    }

    public function setStatus(int $status) : void
    {
        $this->status = $status;
    }

    public function setRejectReason(string $rejectReason) : void
    {
        $this->rejectReason = $rejectReason;
    }

    public function getRejectReason() : string
    {
        return $this->rejectReason;
    }

    protected function getRepository(): AuthenticationRepository
    {
        return $this->repository;
    }

    protected function getIOperatAbleAdapter(): IOperatAbleAdapter
    {
        return $this->getRepository();
    }

    protected function getIResubmitAbleAdapter(): IResubmitAbleAdapter
    {
        return $this->getRepository();
    }

    protected function getIApplyAbleAdapter(): IApplyAbleAdapter
    {
        return $this->getRepository();
    }
}
