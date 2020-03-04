<?php
namespace Sdk\MemberAccount\Model;

use Marmot\Common\Model\IObject;
use Marmot\Common\Model\Object;

use Sdk\Member\Model\Member;

use Sdk\MemberAccount\Repository\MemberAccountRepository;

class MemberAccount implements IObject
{
    use Object;

    const STATUS = array(
        'ENABLED' => 0 ,
        'DISABLED' => -2
    );

    /**
     * [$id 主键Id]
     * @var [int]
     */
    private $id;
    /**
     * [$accountBalance 主账户余额]
     * @var [string]
     */
    private $accountBalance;
    /**
     * [$frozenAccountBalance 冻结账户余额]
     * @var [string]
     */
    private $frozenAccountBalance;

    private $member;
    /**
     * [$repository]
     * @var [Object]
     */
    private $repository;

    public function __construct(int $id = 0)
    {
        $this->id = $id;
        $this->accountBalance = '';
        $this->frozenAccountBalance = '';
        $this->member = new Member();
        $this->createTime = 0;
        $this->updateTime = 0;
        $this->status = self::STATUS['ENABLED'];
        $this->statusTime = 0;
        $this->repository = new MemberAccountRepository();
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->accountBalance);
        unset($this->frozenAccountBalance);
        unset($this->member);
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

    public function setAccountBalance(string $accountBalance) : void
    {
        $this->accountBalance = is_numeric($accountBalance) ? $accountBalance : '';
    }

    public function getAccountBalance() : string
    {
        return $this->accountBalance;
    }

    public function setFrozenAccountBalance(string $frozenAccountBalance) : void
    {
        $this->frozenAccountBalance = is_numeric($frozenAccountBalance) ? $frozenAccountBalance : '';
    }

    public function getFrozenAccountBalance() : string
    {
        return $this->frozenAccountBalance;
    }

    public function setStatus(int $status)
    {
        $this->status = in_array($status, array_values(self::STATUS)) ? $status : self::STATUS['DISABLED'];
    }

    public function setMember(Member $member): void
    {
        $this->member = $member;
    }

    public function getMember(): Member
    {
        return $this->member;
    }

    protected function getRepository() : MemberAccountRepository
    {
        return $this->repository;
    }
}
