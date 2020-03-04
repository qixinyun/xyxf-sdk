<?php
namespace Sdk\PolicyInterpretation\Model;

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
use Sdk\Policy\Model\Policy;

use Sdk\PolicyInterpretation\Repository\PolicyInterpretationRepository;

class PolicyInterpretation implements IObject, IOperatAble, IOnShelfAble
{
    use Object,
        OperatAbleTrait,
        OnShelfAbleTrait;

    /**
     * [$id id]
     * @var [int]
     */
    private $id;
    /**
     * [$policy 关联政策]
     * @var [Policy]
     */
    private $policy;
    /**
     * [$cover 政策描述封面图]
     * @var [array]
     */
    private $cover;
    /**
     * [$title 政策解读标题]
     * @var [string]
     */
    private $title;
    /**
     * [$detail 政策解读详情]
     * @var [array]
     */
    private $detail;
    /**
     * [$description 政策解读描述]
     * @var [string]
     */
    private $description;
    /**
     * [$attachments 政策附件]
     * @var [array]
     */
    private $attachments;
    /**
     * [$crew 操作人员]
     * @var [Crew]
     */
    private $crew;

    private $repository;

    public function __construct(int $id = 0)
    {
        $this->id = $id;
        $this->policy = new Policy();
        $this->cover = array();
        $this->title = '';
        $this->detail = array();
        $this->description = '';
        $this->attachments = array();
        $this->crew = Core::$container->has('crew') ? Core::$container->get('crew') : new Crew();
        $this->createTime = 0;
        $this->updateTime = 0;
        $this->status = IOnShelfAble::STATUS['ONSHELF'];
        $this->statusTime = 0;
        $this->repository = new PolicyInterpretationRepository();
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->policy);
        unset($this->cover);
        unset($this->title);
        unset($this->detail);
        unset($this->description);
        unset($this->attachments);
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

    public function setPolicy(Policy $policy) : void
    {
        $this->policy = $policy;
    }

    public function getPolicy() : Policy
    {
        return $this->policy;
    }

    public function setCover(array $cover) : void
    {
        $this->cover = $cover;
    }

    public function getCover() : array
    {
        return $this->cover;
    }

    public function setTitle(string $title) : void
    {
        $this->title = $title;
    }

    public function getTitle() : string
    {
        return $this->title;
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

    public function setAttachments(array $attachments) : void
    {
        $this->attachments = $attachments;
    }

    public function getAttachments() : array
    {
        return $this->attachments;
    }

    public function setCrew(Crew $crew) : void
    {
        $this->crew = $crew;
    }

    public function getCrew() : Crew
    {
        return $this->crew;
    }

    protected function getRepository() : PolicyInterpretationRepository
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
