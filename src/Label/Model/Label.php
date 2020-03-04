<?php
namespace Sdk\Label\Model;

use Marmot\Core;
use Marmot\Common\Model\IObject;
use Marmot\Common\Model\Object;

use Sdk\Common\Model\IOperatAble;
use Sdk\Common\Model\OperatAbleTrait;
use Sdk\Common\Adapter\IOperatAbleAdapter;

use Sdk\Crew\Model\Crew;

use Sdk\Label\Repository\LabelRepository;

class Label implements IObject, IOperatAble
{
    use Object, OperatAbleTrait;

    const CATEAGORY_LABEL = array(
        'COMMON' => 0, //公共
        'POLICY' => 1, //政策标签
        'SERVICE' => 2, //服务标签
    );
    /**
     * [$id 主键Id]
     * @var [int]
     */
    private $id;
    /**
     * [$name 标签名]
     * @var [string]
     */
    private $name;
    /**
     * [$icon 图标]
     * @var [array]
     */
    private $icon;
    /**
     * [$category 分类]
     * @var [int]
     */
    private $category;
    /**
     * [$remark 备注]
     * @var [string]
     */
    private $remark;
    /**
     * [$crew 操作人员]
     * @var [Crew]
     */
    private $crew;

    private $repository;

    public function __construct(int $id = 0)
    {
        $this->id = $id;
        $this->name = '';
        $this->icon = array();
        $this->category = self::CATEAGORY_LABEL['COMMON'];
        $this->remark = '';
        $this->crew = Core::$container->has('crew') ? Core::$container->get('crew') : new Crew();
        $this->createTime = 0;
        $this->updateTime = 0;
        $this->status = 0;
        $this->statusTime = 0;
        $this->repository = new LabelRepository();
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->name);
        unset($this->icon);
        unset($this->category);
        unset($this->remark);
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

    public function setIcon(array $icon) : void
    {
        $this->icon = $icon;
    }

    public function getIcon() : array
    {
        return $this->icon;
    }

    public function setCategory(int $category) : void
    {
        $this->category = in_array(
            $category,
            self::CATEAGORY_LABEL
        ) ? $category : self::CATEAGORY_LABEL['COMMON'];
    }

    public function getCategory() : int
    {
        return $this->category;
    }

    public function setRemark(string $remark) : void
    {
        $this->remark = $remark;
    }

    public function getRemark() : string
    {
        return $this->remark;
    }

    public function setCrew(Crew $crew) : void
    {
        $this->crew = $crew;
    }

    public function getCrew() : Crew
    {
        return $this->crew;
    }

    public function setStatus(int $status) : void
    {
        $this->status = $status;
    }

    protected function getRepository() : LabelRepository
    {
        return $this->repository;
    }

    protected function getIOperatAbleAdapter() : IOperatAbleAdapter
    {
        return $this->getRepository();
    }
}
