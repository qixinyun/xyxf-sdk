<?php
namespace Sdk\Member\Model;

use Sdk\Member\Repository\MemberRepository;

use Sdk\User\Model\User;

class Member extends User
{
    const DEFAULT_BIRTHDAY = '0000-00-00';
    /**
     * [$nickName 昵称]
     * @var [string]
     */
    private $nickName;
    /**
     * [$birthday 出生日期]
     * @var [string]
     */
    private $birthday;
    /**
     * [$area 地区]
     * @var [string]
     */
    private $area;
    /**
     * [$address 详细地址]
     * @var [string]
     */
    private $address;
    /**
     * [$briefIntroduction 简介]
     * @var [string]
     */
    private $briefIntroduction;
    /**
     * [$repository]
     * @var [Object]
     */
    private $repository;

    public function __construct(int $id = 0)
    {
        parent::__construct($id);
        $this->nickName = '';
        $this->birthday = self::DEFAULT_BIRTHDAY;
        $this->area = '';
        $this->address = '';
        $this->briefIntroduction = '';
        $this->repository = new MemberRepository();
    }

    public function __destruct()
    {
        parent::__destruct();
        unset($this->nickName);
        unset($this->birthday);
        unset($this->area);
        unset($this->address);
        unset($this->briefIntroduction);
        unset($this->repository);
    }

    public function setNickName(string $nickName) : void
    {
        $this->nickName = $nickName;
    }

    public function getNickName() : string
    {
        return $this->nickName;
    }

    public function setBirthday(string $birthday) : void
    {
        $this->birthday = $birthday;
    }

    public function getBirthday() : string
    {
        return $this->birthday;
    }

    public function setArea(string $area) : void
    {
        $this->area = $area;
    }

    public function getArea() : string
    {
        return $this->area;
    }

    public function setAddress(string $address) : void
    {
        $this->address = $address;
    }

    public function getAddress() : string
    {
        return $this->address;
    }

    public function setBriefIntroduction(string $briefIntroduction) : void
    {
        $this->briefIntroduction = $briefIntroduction;
    }

    public function getBriefIntroduction() : string
    {
        return $this->briefIntroduction;
    }

    protected function getRepository() : MemberRepository
    {
        return $this->repository;
    }
}
