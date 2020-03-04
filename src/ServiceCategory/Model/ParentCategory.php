<?php
namespace Sdk\ServiceCategory\Model;

use Sdk\Common\Model\IOperatAble;
use Sdk\Common\Model\OperatAbleTrait;
use Sdk\Common\Adapter\IOperatAbleAdapter;

use Marmot\Common\Model\Object;
use Marmot\Common\Model\IObject;

use Sdk\ServiceCategory\Repository\ParentCategoryRepository;

class ParentCategory implements IObject, IOperatAble
{
    use Object, OperatAbleTrait;

    private $id;

    private $name;

    private $repository;

    public function __construct(int $id = 0)
    {
        $this->id = !empty($id) ? $id : 0;
        $this->name = '';
        $this->status = 0;
        $this->createTime = 0;
        $this->updateTime = 0;
        $this->statusTime = 0;
        $this->repository = new ParentCategoryRepository();
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->name);
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

    public function setStatus(int $status) : void
    {
        $this->status = $status;
    }

    protected function getRepository() : ParentCategoryRepository
    {
        return $this->repository;
    }
    /**
     * 新增编辑
     * @return [bool]
     */
    protected function getIOperatAbleAdapter() : IOperatAbleAdapter
    {
        return $this->getRepository();
    }
}
