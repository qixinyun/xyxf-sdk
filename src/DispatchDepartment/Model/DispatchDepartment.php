<?php
namespace Sdk\DispatchDepartment\Model;

use Marmot\Core;
use Marmot\Common\Model\IObject;
use Marmot\Common\Model\Object;

use Sdk\Common\Model\IOperatAble;
use Sdk\Common\Model\IEnableAble;
use Sdk\Common\Model\OperatAbleTrait;
use Sdk\Common\Model\EnableAbleTrait;
use Sdk\Common\Adapter\IEnableAbleAdapter;
use Sdk\Common\Adapter\IOperatAbleAdapter;

use Sdk\Crew\Model\Crew;

use Sdk\DispatchDepartment\Repository\DispatchDepartmentRepository;

class DispatchDepartment implements IObject, IOperatAble, IEnableAble
{
    use Object, OperatAbleTrait, EnableAbleTrait;

    private $id;

    private $name;

    private $remark;

    private $crew;

    private $repository;

    public function __construct(int $id = 0)
    {
        $this->id = $id;
        $this->name = '';
        $this->remark = '';
        $this->crew = Core::$container->has('crew') ? Core::$container->get('crew') : new Crew();
        $this->status = IEnableAble::STATUS['ENABLED'];
        $this->createTime = 0;
        $this->updateTime = 0;
        $this->statusTime = 0;
        $this->repository = new DispatchDepartmentRepository();
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->name);
        unset($this->remark);
        unset($this->crew);
        unset($this->status);
        unset($this->createTime);
        unset($this->updateTime);
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

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
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

    protected function getRepository() : DispatchDepartmentRepository
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
