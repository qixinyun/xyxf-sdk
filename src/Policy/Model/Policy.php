<?php
namespace Sdk\Policy\Model;

use Marmot\Core;
use Marmot\Common\Model\IObject;
use Marmot\Common\Model\Object;

use Sdk\Common\Model\IOperatAble;
use Sdk\Common\Model\IOnShelfAble;
use Sdk\Common\Model\OperatAbleTrait;
use Sdk\Common\Model\OnShelfAbleTrait;
use Sdk\Common\Adapter\IOperatAbleAdapter;
use Sdk\Common\Adapter\IOnShelfAbleAdapter;

use Sdk\Crew\Model\Crew;
use Sdk\Label\Model\Label;
use Sdk\DispatchDepartment\Model\DispatchDepartment;

use Sdk\Policy\Repository\PolicyRepository;

/**
 * 屏蔽类中所有PMD警告
 *
 * @SuppressWarnings(PHPMD)
 */
class Policy implements IObject, IOperatAble, IOnShelfAble
{
    use Object, OperatAbleTrait, OnShelfAbleTrait;

    /**
     * [$id id]
     * @var [int]
     */
    private $id;
    /**
     * [$title 政策标题]
     * @var [string]
     */
    private $title;
    /**
     * [$number 政策编号]
     * @var [string]
     */
    private $number;
    /**
     * [$applicableObjects 适用对象]
     * @var [array]
     */
    private $applicableObjects;
    /**
     * [$dispatchDepartments 发文部门]
     * @var [array]
     */
    private $dispatchDepartments;
    /**
     * [$applicableIndustries 适用行业]
     * @var [array]
     */
    private $applicableIndustries;
    /**
     * [$level 政策级别]
     * @var [int]
     */
    private $level;
    /**
     * [$classifies 政策分类]
     * @var [array]
     */
    private $classifies;
    /**
     * [$detail 政策详情]
     * @var [array]
     */
    private $detail;
    /**
     * [$description 政策描述]
     * @var [string]
     */
    private $description;
    /**
     * [$image 政策封面图]
     * @var [array]
     */
    private $image;
    /**
     * [$attachments 政策附件]
     * @var [array]
     */
    private $attachments;
    /**
     * [$labels 政策标签]
     * @var [array]
     */
    private $labels;
    /**
     * [$admissibleAddress 受理地址]
     * @var [array]
     */
    private $admissibleAddress;
    /**
     * [$processingFlow 办理流程]
     * @var [array]
     */
    private $processingFlow;
    /**
     * [$crew 操作人员]
     * @var [Crew]
     */
    private $crew;

    private $repository;

    public function __construct(int $id = 0)
    {
        $this->id = $id;
        $this->title = '';
        $this->number = '';
        $this->applicableObjects = array();
        $this->dispatchDepartments = array();
        $this->applicableIndustries = array();
        $this->level = NullPolicyCategory::getInstance();
        $this->classifies = array();
        $this->detail = array();
        $this->description = '';
        $this->image = array();
        $this->attachments = array();
        $this->labels = array();
        $this->admissibleAddress = array();
        $this->processingFlow = array();
        $this->crew = Core::$container->has('crew') ? Core::$container->get('crew') : new Crew();
        $this->createTime = 0;
        $this->updateTime = 0;
        $this->status = IOnShelfAble::STATUS['ONSHELF'];
        $this->statusTime = 0;
        $this->repository = new PolicyRepository();
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->title);
        unset($this->number);
        unset($this->applicableObjects);
        unset($this->dispatchDepartments);
        unset($this->applicableIndustries);
        unset($this->level);
        unset($this->classifies);
        unset($this->detail);
        unset($this->description);
        unset($this->image);
        unset($this->attachments);
        unset($this->labels);
        unset($this->admissibleAddress);
        unset($this->processingFlow);
        unset($this->crew);
        unset($this->createTime);
        unset($this->updateTime);
        unset($this->status);
        unset($this->statusTime);
        unset($this->repository);
    }

    public function setId($id) : void
    {
        $this->id = $id;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setTitle(string $title) : void
    {
        $this->title = $title;
    }

    public function getTitle() : string
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

    public function setApplicableObjects(array $applicableObjects) : void
    {
        $this->applicableObjects = $applicableObjects;
    }

    public function getApplicableObjects() : array
    {
        return $this->applicableObjects;
    }

    public function addDispatchDepartment(DispatchDepartment $dispatchDepartment) : void
    {
        $this->dispatchDepartments[] = $dispatchDepartment;
    }

    public function clearDispatchDepartment()
    {
        $this->dispatchDepartments = [];
    }

    public function getDispatchDepartments() : array
    {
        return $this->dispatchDepartments;
    }

    public function setApplicableIndustries(array $applicableIndustries) : void
    {
        $this->applicableIndustries = $applicableIndustries;
    }

    public function getApplicableIndustries() : array
    {
        return $this->applicableIndustries;
    }

    public function setLevel(PolicyCategory $level) : void
    {
        $this->level = $level;
    }

    public function getLevel() : PolicyCategory
    {
        return $this->level;
    }

    public function setClassifies(array $classifies) : void
    {
        $this->classifies = $classifies;
    }

    public function getClassifies() : array
    {
        return $this->classifies;
    }

    public function setDetail(array $detail) : void
    {
        $this->detail = $detail;
    }

    public function getDetail() : array
    {
        return $this->detail;
    }

    public function setDescription(string $description) : void
    {
        $this->description = $description;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setImage(array $image) : void
    {
        $this->image = $image;
    }

    public function getImage() : array
    {
        return $this->image;
    }

    public function setAttachments(array $attachments) : void
    {
        $this->attachments = $attachments;
    }

    public function getAttachments() : array
    {
        return $this->attachments;
    }

    public function addLabel(Label $label) : void
    {
        $this->labels[] = $label;
    }

    public function clearLabel()
    {
        $this->labels = [];
    }

    public function getLabels() : array
    {
        return $this->labels;
    }

    public function setAdmissibleAddress(array $admissibleAddress) : void
    {
        $this->admissibleAddress = $admissibleAddress;
    }

    public function getAdmissibleAddress() : array
    {
        return $this->admissibleAddress;
    }

    public function setProcessingFlow(array $processingFlow) : void
    {
        $this->processingFlow = $processingFlow;
    }

    public function getProcessingFlow() : array
    {
        return $this->processingFlow;
    }

    public function setCrew(Crew $crew) : void
    {
        $this->crew = $crew;
    }

    public function getCrew() : Crew
    {
        return $this->crew;
    }

    protected function getRepository() : PolicyRepository
    {
        return $this->repository;
    }

    protected function getIOperatAbleAdapter() : IOperatAbleAdapter
    {
        return $this->getRepository();
    }

    protected function getIOnShelfAbleAdapter() : IOnShelfAbleAdapter
    {
        return $this->getRepository();
    }
}
