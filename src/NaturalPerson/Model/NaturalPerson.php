<?php
namespace Sdk\NaturalPerson\Model;

use Marmot\Core;
use Marmot\Common\Model\Object;
use Marmot\Common\Model\IObject;

use Sdk\Common\Model\IOperatAble;
use Sdk\Common\Model\OperatAbleTrait;
use Sdk\Common\Model\IApplyAble;
use Sdk\Common\Model\ApplyAbleTrait;
use Sdk\Common\Adapter\IOperatAbleAdapter;
use Sdk\Common\Adapter\IApplyAbleAdapter;

use Sdk\Member\Model\Member;

use Sdk\NaturalPerson\Repository\NaturalPersonRepository;

class NaturalPerson implements IOperatAble, IApplyAble, IObject
{
    use OperatAbleTrait, ApplyAbleTrait, Object;

    private $id;

    private $realName;

    private $identityInfo;

    private $rejectReason;

    private $member;

    private $repository;

    public function __construct(int $id = 0)
    {
        $this->id = !empty($id) ? $id : 0;
        $this->realName = '';
        $this->identityInfo = new IdentityInfo();
        $this->member = Core::$container->has('user') ? Core::$container->get('user') : new Member();
        $this->rejectReason = '';
        $this->applyStatus = IApplyAble::APPLY_STATUS['PENDING'];
        $this->statusTime = 0;
        $this->createTime = 0;
        $this->updateTime = 0;
        $this->status = 0;
        $this->repository = new NaturalPersonRepository();
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->realName);
        unset($this->identityInfo);
        unset($this->member);
        unset($this->rejectReason);
        unset($this->statusTime);
        unset($this->createTime);
        unset($this->updateTime);
        unset($this->status);
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

    public function setRealName(string $realName) : void
    {
        $this->realName = $realName;
    }

    public function getRealName() : string
    {
        return $this->realName;
    }

    public function setIdentityInfo(IdentityInfo $identityInfo) : void
    {
        $this->identityInfo = $identityInfo;
    }

    public function getIdentityInfo() : IdentityInfo
    {
        return $this->identityInfo;
    }

    public function setMember(Member $member) : void
    {
        $this->member = $member;
    }

    public function getMember() : Member
    {
        return $this->member;
    }

    public function setRejectReason(string $rejectReason) : void
    {
        $this->rejectReason = $rejectReason;
    }

    public function getRejectReason() : string
    {
        return $this->rejectReason;
    }

    public function setStatus(int $status) : void
    {
        $this->status = $status;
    }

    protected function getRepository() : NaturalPersonRepository
    {
        return $this->repository;
    }

    protected function getIOperatAbleAdapter() : IOperatAbleAdapter
    {
        return $this->getRepository();
    }

    protected function getIApplyAbleAdapter() : IApplyAbleAdapter
    {
        return $this->getRepository();
    }
}
