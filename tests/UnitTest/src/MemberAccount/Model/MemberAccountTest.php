<?php
namespace Sdk\MemberAccount\Model;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Core;

use Sdk\MemberAccount\Repository\MemberAccountRepository;
use Sdk\Member\Model\Member;

class MemberAccountTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(MemberAccount::class)
            ->setMethods([
                'getRepository'
            ])->getMock();

        $this->childStub = new Class extends MemberAccount{
            public function getRepository() : MemberAccountRepository
            {
                return parent::getRepository();
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function testGetRepository()
    {
        $this->assertInstanceOf(
            'Sdk\MemberAccount\Repository\MemberAccountRepository',
            $this->childStub->getRepository()
        );
    }

    //id 测试 ---------------------------------------------------------- start
    /**
     * 设置 Service setId() 正确的传参类型,期望传值正确
     */
    public function testSetIdCorrectType()
    {
        $this->stub->setId(1);
        $this->assertEquals(1, $this->stub->getId());
    }
    /**
     * 设置 Service setId() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetIdWrongTypeButNumeric()
    {
        $this->stub->setId('1');
        $this->assertEquals(1, $this->stub->getId());
    }
    //id 测试 ----------------------------------------------------------   end

    //accountBalance 测试 ------------------------------------------------ start
    /**
     * 设置 MemberAccount setAccountBalance() 正确的传参类型,期望传值正确
     */
    public function testSetAccountBalanceCorrectType()
    {
        $this->stub->setAccountBalance('200');
        $this->assertEquals('200', $this->stub->getAccountBalance());
    }

    /**
     * 设置 MemberAccount setAccountBalance() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetAccountBalanceWrongType()
    {
        $this->stub->setAccountBalance(array(1, 2, 3));
    }
    //accountBalance 测试 ------------------------------------------------- end

    //frozenAccountBalance 测试 ------------------------------------------- start
    /**
     * 设置 MemberAccount setFrozenAccountBalance() 正确的传参类型,期望传值正确
     */
    public function testSetFrozenAccountBalanceCorrectType()
    {
        $this->stub->setFrozenAccountBalance('200');
        $this->assertEquals('200', $this->stub->getFrozenAccountBalance());
    }

    /**
     * 设置 MemberAccount setFrozenAccountBalance() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetFrozenAccountBalanceWrongType()
    {
        $this->stub->setFrozenAccountBalance(array(1, 2, 3));
    }
    //frozenAccountBalance 测试 ------------------------------------------- end
    
    //member 测试 -------------------------------------------------------- start
    /**
     * 设置 MemberAccount setMember() 正确的传参类型,期望传值正确
     */
    public function testSetMemberCorrectType()
    {
        $object = new Member();
        $this->stub->setMember($object);
        $this->assertSame($object, $this->stub->getMember());
    }

    /**
     * 设置 MemberAccount setMember() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetMemberType()
    {
        $this->stub->setMember('asas');
    }
    //member 测试 -------------------------------------------------------- end
}
