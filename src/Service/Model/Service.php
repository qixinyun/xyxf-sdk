<?php
namespace Sdk\Service\Model;

use Marmot\Core;

use Marmot\Common\Model\IObject;
use Marmot\Common\Model\Object;

use Sdk\Common\Adapter\IApplyAbleAdapter;
use Sdk\Common\Adapter\IOperatAbleAdapter;
use Sdk\Common\Adapter\IResubmitAbleAdapter;
use Sdk\Common\Adapter\IModifyStatusAbleAdapter;
use Sdk\Common\Model\IApplyAble;
use Sdk\Common\Model\IOperatAble;
use Sdk\Common\Model\IResubmitAble;
use Sdk\Common\Model\IModifyStatusAble;
use Sdk\Common\Model\ApplyAbleTrait;
use Sdk\Common\Model\OperatAbleTrait;
use Sdk\Common\Model\ResubmitAbleTrait;
use Sdk\Common\Model\ModifyStatusAbleTrait;

use Sdk\Enterprise\Model\Enterprise;

use Sdk\ServiceCategory\Model\ServiceCategory;
use Sdk\Service\Repository\ServiceRepository;

/**
 * 屏蔽类中所有PMD警告
 *
 * @SuppressWarnings(PHPMD)
 */
class Service implements IObject, IApplyAble, IOperatAble, IResubmitAble, IModifyStatusAble
{
    use Object, ApplyAbleTrait, OperatAbleTrait, ResubmitAbleTrait, ModifyStatusAbleTrait;

    const SERVICE_STATUS = array(
        'ONSHELF' => 0,
        'OFFSTOCK' => -2,
        'REVOKED' => -4,
        'CLOSED' => -6,
        'DELETED' => -8,
    );

    private $id;

    private $number;

    private $serviceCategory;

    private $title;

    private $cover;

    private $price;

    private $minPrice;

    private $maxPrice;

    private $contract;

    private $detail;

    private $serviceObjects;

    private $enterprise;

    private $volume;

    private $attentionDegree;

    private $rejectReason;

    private $snapshots;

    private $repositroy;

    public function __construct(int $id = 0)
    {
        $this->id = !empty($id) ? $id : 0;
        $this->serviceCategory = new ServiceCategory();
        $this->title = '';
        $this->number = '';
        $this->cover = array();
        $this->price = array();
        $this->minPrice = 0.00;
        $this->maxPrice = 0.00;
        $this->contract = array();
        $this->detail = array();
        $this->serviceObjects = array();
        $this->enterprise = new Enterprise();
        $this->volume = 0;
        $this->attentionDegree = 0;
        $this->rejectReason = '';
        $this->snapshots = array();
        $this->applyStatus = IApplyAble::APPLY_STATUS['PENDING'];
        $this->createTime = 0;
        $this->updateTime = 0;
        $this->status = self::SERVICE_STATUS['ONSHELF'];
        $this->statusTime = 0;
        $this->repositroy = new ServiceRepository();
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->number);
        unset($this->serviceCategory);
        unset($this->title);
        unset($this->cover);
        unset($this->price);
        unset($this->minPrice);
        unset($this->maxPrice);
        unset($this->contract);
        unset($this->detail);
        unset($this->serviceObjects);
        unset($this->enterprise);
        unset($this->volume);
        unset($this->attentionDegree);
        unset($this->rejectReason);
        unset($this->snapshots);
        unset($this->applyStatus);
        unset($this->createTime);
        unset($this->updateTime);
        unset($this->status);
        unset($this->statusTime);
        unset($this->repositroy);
    }

    public function setId($id): void
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

    public function setCover(array $cover): void
    {
        $this->cover = $cover;
    }

    public function getCover(): array
    {
        return $this->cover;
    }

    public function setPrice(array $price): void
    {
        $this->price = $price;
    }

    public function getPrice(): array
    {
        return $this->price;
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

    public function setContract(array $contract): void
    {
        $this->contract = $contract;
    }

    public function getContract(): array
    {
        return $this->contract;
    }

    public function setDetail(array $detail): void
    {
        $this->detail = $detail;
    }

    public function getDetail(): array
    {
        return $this->detail;
    }

    public function setServiceObjects(array $serviceObjects): void
    {
        $this->serviceObjects = $serviceObjects;
    }

    public function getServiceObjects(): array
    {
        return $this->serviceObjects;
    }

    public function setEnterprise(Enterprise $enterprise): void
    {
        $this->enterprise = $enterprise;
    }

    public function getEnterprise(): Enterprise
    {
        return $this->enterprise;
    }

    public function setVolume(int $volume): void
    {
        $this->volume = $volume;
    }

    public function getVolume(): int
    {
        return $this->volume;
    }

    public function setAttentionDegree(int $attentionDegree): void
    {
        $this->attentionDegree = $attentionDegree;
    }

    public function getAttentionDegree(): int
    {
        return $this->attentionDegree;
    }

    public function setRejectReason(string $rejectReason): void
    {
        $this->rejectReason = $rejectReason;
    }

    public function getRejectReason(): string
    {
        return $this->rejectReason;
    }

    public function addSnapshot(Snapshot $snapshot): void
    {
        $this->snapshots[] = $snapshot;
    }

    public function clearSnapshot()
    {
        $this->snapshots = [];
    }

    public function getSnapshots(): array
    {
        return $this->snapshots;
    }

    public function setStatus(int $status)
    {
        $this->status = in_array($status, array_values(self::SERVICE_STATUS)) ?
            $status : self::SERVICE_STATUS['DELETED'];
    }

    protected function getRepository(): ServiceRepository
    {
        return $this->repositroy;
    }

    protected function getIOperatAbleAdapter(): IOperatAbleAdapter
    {
        return $this->getRepository();
    }

    protected function getIApplyAbleAdapter(): IApplyAbleAdapter
    {
        return $this->getRepository();
    }

    protected function getIResubmitAbleAdapter(): IResubmitAbleAdapter
    {
        return $this->getRepository();
    }

    protected function getIModifyStatusAbleAdapter(): IModifyStatusAbleAdapter
    {
        return $this->getRepository();
    }

    /**
     * 上架
     * @return bool 是否上架成功
     */
    public function onShelf(): bool
    {
        if (!$this->isOffStock()) {
            return false;
        }

        return $this->getRepository()->onShelf($this);
    }

    /**
     * 下架
     * @return bool 是否下架成功
     */
    public function offStock(): bool
    {
        if (!$this->isOnShelf()) {
            return false;
        }

        return $this->getRepository()->offStock($this);
    }

    /**
     * 关闭
     * @return bool 是否关闭成功
     */
    public function close() : bool
    {
        if (!$this->isApprove() || !$this->isOffStock()) {
            Core::setLastError(RESOURCE_STATUS_NOT_NORMAL);
            return false;
        }
        $modifyStatusAdapter = $this->getIModifyStatusAbleAdapter();
        return $modifyStatusAdapter->close($this);
    }

    public function isOnShelf(): bool
    {
        return $this->getStatus() == self::SERVICE_STATUS['ONSHELF'];
    }

    public function isOffStock(): bool
    {
        return $this->getStatus() == self::SERVICE_STATUS['OFFSTOCK'];
    }

    public function isNormal() : bool
    {
        return $this->getStatus() == self::SERVICE_STATUS['ONSHELF'];
    }

    public function isRevoked() : bool
    {
        return $this->getStatus() == self::SERVICE_STATUS['REVOKED'];
    }

    public function isClosed() : bool
    {
        return $this->getStatus() == self::SERVICE_STATUS['CLOSED'];
    }
}
