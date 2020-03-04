<?php
namespace Sdk\ServiceCategory\Model;

use Sdk\Common\Model\IOperatAble;
use Sdk\Common\Model\IEnableAble;
use Sdk\Common\Model\OperatAbleTrait;
use Sdk\Common\Model\EnableAbleTrait;
use Sdk\Common\Adapter\IOperatAbleAdapter;
use Sdk\Common\Adapter\IEnableAbleAdapter;

use Marmot\Common\Model\Object;
use Marmot\Common\Model\IObject;

use Sdk\ServiceCategory\Repository\ServiceCategoryRepository;

class ServiceCategory implements IObject, IOperatAble, IEnableAble
{
    use OperatAbleTrait, EnableAbleTrait, Object;

    const IS_QUALIFICATION = array(
        'NO' => 0,
        'YES' => 2
    );

    private $id;

    private $name;

    private $parentCategory;

    private $isQualification;

    private $qualificationName;

    private $commission;

    private $repository;

    public function __construct(int $id = 0)
    {
        $this->id = !empty($id) ? $id : 0;
        $this->name = '';
        $this->parentCategory = new ParentCategory();
        $this->isQualification = self::IS_QUALIFICATION['NO'];
        $this->qualificationName = '';
        $this->commission = 0.00;
        $this->status = IEnableAble::STATUS['ENABLED'];
        $this->createTime = 0;
        $this->updateTime = 0;
        $this->statusTime = 0;
        $this->repository = new ServiceCategoryRepository();
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->name);
        unset($this->parentCategory);
        unset($this->isQualification);
        unset($this->qualificationName);
        unset($this->commission);
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

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setParentCategory(ParentCategory $parentCategory) : void
    {
        $this->parentCategory = $parentCategory;
    }

    public function getParentCategory() : ParentCategory
    {
        return $this->parentCategory;
    }

    public function setIsQualification(int $isQualification) : void
    {
        $this->isQualification =
            in_array($isQualification, self::IS_QUALIFICATION) ?
            $isQualification : self::IS_QUALIFICATION['NO'];
    }

    public function getIsQualification() : int
    {
        return $this->isQualification;
    }

    public function setQualificationName(string $qualificationName) : void
    {
        $this->qualificationName = $qualificationName;
    }

    public function getQualificationName() : string
    {
        return $this->qualificationName;
    }

    public function setCommission(float $commission) : void
    {
        $this->commission = $commission;
    }

    public function getCommission() : float
    {
        return $this->commission;
    }

    protected function getRepository() : ServiceCategoryRepository
    {
        return $this->repository;
    }

    protected function getIOperatAbleAdapter() : IOperatAbleAdapter
    {
        return $this->getRepository();
    }

    protected function getIEnableAbleAdapter() : IEnableAbleAdapter
    {
        return $this->getRepository();
    }
}
