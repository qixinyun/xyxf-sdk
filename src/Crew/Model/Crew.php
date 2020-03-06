<?php
namespace Sdk\Crew\Model;

use Sdk\Crew\Repository\CrewRepository;
use Sdk\User\Model\User;

use Sdk\UserGroup\Model\UserGroup;
use Sdk\UserGroup\Repository\UserGroupRepository;
use Sdk\Common\Adapter\IOperatAbleRepository;

class Crew extends User
{
    /**
     * [$workNumber 工号]
     * @var [string]
     */
    private $workNumber;
    /**
     * [$repository]
     * @var [Object]
     */
    private $repository;
    private $roles;
    private $userGroup;
    /**
     * @var array $passwordUpdateTime 密码修改时间
    */
    private $passwordUpdateTime;

    public function __construct(int $id = 0)
    {
        parent::__construct($id);
        $this->workNumber = '';
        $this->roles = array();
        $this->passwordUpdateTime = 0;
        $this->userGroup = new UserGroup();
        $this->repository = new CrewRepository();
    }

    public function __destruct()
    {
        parent::__destruct();
        unset($this->workNumber);
        unset($this->userGroup);
        unset($this->roles);
        unset($this->passwordUpdateTime);
        unset($this->repository);
    }

    public function setWorkNumber(string $workNumber) : void
    {
        $this->workNumber = $workNumber;
    }

    public function getWorkNumber() : string
    {
        return $this->workNumber;
    }
    
    protected function getRepository() : CrewRepository
    {
        return $this->repository;
    }

    public function addRole(Role $role) : void
    {
        $this->roles[] = $role;
    }

    public function clearRoles() : void
    {
        $this->roles = [];
    }

    public function getRoles() : array
    {
        return $this->roles;
    }

    public function setUserGroup(UserGroup $userGroup) : void
    {
        $this->userGroup = $userGroup;
    }

    public function getUserGroup() : UserGroup
    {
        return $this->userGroup;
    }
    
    /**
     * 设置密码修改时间
     * @param int $passwordUpdateTime 密码修改时间
    */
    public function setPasswordUpdateTime(int $passwordUpdateTime)
    {
        $this->passwordUpdateTime = $passwordUpdateTime;
    }
    /**
     * 获取密码修改时间
     * @return array $passwordUpdateTime 密码修改时间
    */
    public function getPasswordUpdateTime() : int
    {
        return $this->passwordUpdateTime;
    }
}
