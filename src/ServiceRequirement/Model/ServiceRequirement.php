<?php
namespace Sdk\ServiceRequirement\Model;

use Marmot\Common\Model\IObject;
use Marmot\Common\Model\Object;

use Sdk\Common\Adapter\IApplyAbleAdapter;
use Sdk\Common\Adapter\IModifyStatusAbleAdapter;
use Sdk\Common\Adapter\IOperatAbleAdapter;
use Sdk\Common\Model\IApplyAble;
use Sdk\Common\Model\IModifyStatusAble;
use Sdk\Common\Model\IOperatAble;
use Sdk\Common\Model\ApplyAbleTrait;
use Sdk\Common\Model\ModifyStatusAbleTrait;
use Sdk\Common\Model\OperatAbleTrait;

use Sdk\Member\Model\Member;
use Sdk\ServiceRequirement\Repository\ServiceRequirementRepository;
use Sdk\ServiceCategory\Model\ServiceCategory;

use Marmot\Core;

class ServiceRequirement implements IObject, IApplyAble, IModifyStatusAble, IOperatAble
{
    use Object, ApplyAbleTrait, ModifyStatusAbleTrait, OperatAbleTrait;

    private $id;

    private $serviceCategory;

    private $title;

    private $number;

    private $detail;

    private $minPrice;

    private $maxPrice;

    private $validityStartTime;

    private $validityEndTime;

    private $contactName;

    private $contactPhone;

    private $rejectReason;

    private $member;

    private $repository;

    public function __construct(int $id = 0)
    {
        $this->id = !empty($id) ? $id : 0;
        $this->serviceCategory = new ServiceCategory();
        $this->title = '';
        $this->number = '';
        $this->detail = array();
        $this->minPrice = 0.00;
        $this->maxPrice = 0.00;
        $this->validityStartTime = 0;
        $this->validityEndTime = 0;
        $this->contactName = '';
        $this->contactPhone = '';
        $this->rejectReason = '';
        $this->applyStatus = IApplyAble::APPLY_STATUS['PENDING'];
        $this->member =  Core::$container->has('user') ? Core::$container->get('user') : new Member();
        $this->createTime = 0;
        $this->updateTime = 0;
        $this->status = IModifyStatusAble::STATUS['NORMAL'];
        $this->statusTime = 0;
        $this->repository = new ServiceRequirementRepository();
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->serviceCategory);
        unset($this->title);
        unset($this->number);
        unset($this->detail);
        unset($this->minPrice);
        unset($this->maxPrice);
        unset($this->validityStartTime);
        unset($this->validityEndTime);
        unset($this->contactName);
        unset($this->contactPhone);
        unset($this->rejectReason);
        unset($this->applyStatus);
        unset($this->member);
        unset($this->createTime);
        unset($this->updateTime);
        unset($this->status);
        unset($this->statusTime);
        unset($this->repository);
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setServiceCategory(ServiceCategory $serviceCategory): void
    {
        $this->serviceCategory = $serviceCategory;
    }

    public function getServiceCategory(): ServiceCategory
    {
        return $this->serviceCategory;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setNumber(string $number)
    {
        $this->number = $number;
    }

    public function getNumber() : string
    {
        return $this->number;
    }

    public function setDetail(array $detail): void
    {
        $this->detail = $detail;
    }

    public function getDetail(): array
    {
        return $this->detail;
    }

    public function setMinPrice(float $minPrice): void
    {
        $this->minPrice = $minPrice;
    }

    public function getMinPrice(): float
    {
        return $this->minPrice;
    }

    public function setMaxPrice(float $maxPrice): void
    {
        $this->maxPrice = $maxPrice;
    }

    public function getMaxPrice(): float
    {
        return $this->maxPrice;
    }

    public function setValidityStartTime(int $validityStartTime): void
    {
        $this->validityStartTime = $validityStartTime;
    }

    public function getValidityStartTime(): int
    {
        return $this->validityStartTime;
    }

    public function setValidityEndTime(int $validityEndTime): void
    {
        $this->validityEndTime = $validityEndTime;
    }

    public function getValidityEndTime(): int
    {
        return $this->validityEndTime;
    }

    public function setContactName(string $contactName): void
    {
        $this->contactName = $contactName;
    }

    public function getContactName(): string
    {
        return $this->contactName;
    }

    public function setContactPhone(string $contactPhone): void
    {
        $this->contactPhone = $contactPhone;
    }

    public function getContactPhone(): string
    {
        return $this->contactPhone;
    }

    public function setRejectReason(string $rejectReason) : void
    {
        $this->rejectReason = $rejectReason;
    }

    public function getRejectReason() : string
    {
        return $this->rejectReason;
    }

    public function setMember(Member $member): void
    {
        $this->member = $member;
    }

    public function getMember(): Member
    {
        return $this->member;
    }

    protected function getRepository(): ServiceRequirementRepository
    {
        return $this->repository;
    }

    protected function getIOperatAbleAdapter(): IOperatAbleAdapter
    {
        return $this->getRepository();
    }

    protected function getIApplyAbleAdapter(): IApplyAbleAdapter
    {
        return $this->getRepository();
    }

    protected function getIModifyStatusAbleAdapter(): IModifyStatusAbleAdapter
    {
        return $this->getRepository();
    }
}
