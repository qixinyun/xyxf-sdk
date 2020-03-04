<?php
namespace Sdk\NaturalPerson\Model;

use Sdk\NaturalPerson\Repository\NaturalPersonRepository;
use Sdk\NaturalPerson\Repository\NaturalPersonSessionRepository;
use Sdk\NaturalPerson\Model\IdentityInfo;

use Sdk\Common\Adapter\IOperatAbleAdapter;
use Sdk\Common\Adapter\IApplyAbleAdapter;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Core;

use Sdk\Member\Model\Member;

class NaturalPersonTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(NaturalPerson::class)
            ->setMethods(
                [
                'getRepository',
                'IOperatAbleAdapter',
                'IApplyAbleAdapter'
                ]
            )
            ->getMock();

        $this->childStub = new class extends NaturalPerson {
            public function getRepository() : NaturalPersonRepository
            {
                return parent::getRepository();
            }
            public function getIOperatAbleAdapter() : IOperatAbleAdapter
            {
                return parent::getIOperatAbleAdapter();
            }
            public function getIApplyAbleAdapter() : IApplyAbleAdapter
            {
                return parent::getIApplyAbleAdapter();
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
            'Sdk\NaturalPerson\Repository\NaturalPersonRepository',
            $this->childStub->getRepository()
        );
    }

    public function testCorrectImplementsIObject()
    {
        $this->assertInstanceof('Marmot\Common\Model\IObject', $this->stub);
    }

    public function testCorrectImplementsIOperatAble()
    {
        $this->assertInstanceof('Sdk\Common\Model\IOperatAble', $this->stub);
    }

    public function testCorrectImplementsIApplyAble()
    {
        $this->assertInstanceof('Sdk\Common\Model\IApplyAble', $this->stub);
    }

    public function testGetIOperatAble()
    {
        $this->assertInstanceOf(
            'Sdk\Common\Adapter\IOperatAbleAdapter',
            $this->childStub->getIOperatAbleAdapter()
        );
    }

    public function testGetIApplyAbleAdapter()
    {
        $this->assertInstanceOf(
            'Sdk\Common\Adapter\IApplyAbleAdapter',
            $this->childStub->getIApplyAbleAdapter()
        );
    }

    //id 测试 ---------------------------------------------------------- start
    /**
     * 设置 NaturalPerson setId() 正确的传参类型,期望传值正确
     */
    public function testSetIdCorrectType()
    {
        $this->stub->setId(1);
        $this->assertEquals(1, $this->stub->getId());
    }

    /**
     * 设置 NaturalPerson setId() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetIdWrongTypeButNumeric()
    {
        $this->stub->setId('1');
        $this->assertEquals(1, $this->stub->getId());
    }
    //id 测试 ----------------------------------------------------------   end

    //realName 测试 -------------------------------------------------------- start
    /**
     * 设置 NaturalPerson setRealName() 正确的传参类型,期望传值正确
     */
    public function testSetRealNameCorrectType()
    {
        $this->stub->setRealName('realName');
        $this->assertEquals('realName', $this->stub->getRealName());
    }

    /**
     * 设置 NaturalPerson setRealName() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetRealNameWrongType()
    {
        $this->stub->setRealName(array());
    }
    //realName 测试 --------------------------------------------------------   end

    /**
     * 设置 NaturalPerson setIdentityInfo() 正确的传参类型,期望传值正确
     */
    public function testSetIdentifyCardCorrectType()
    {
        $object = new IdentityInfo();
        $this->stub->setIdentityInfo($object);
        $this->assertSame($object, $this->stub->getIdentityInfo());
    }

    /**
     * 设置  setIdentityInfo() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetIdentifyCardType()
    {
        $this->stub->setIdentityInfo(array(1,2,3));
    }

    //member 测试 -------------------------------------------------------- start
    /**
     * 设置 NaturalPerson setMember() 正确的传参类型,期望传值正确
     */
    public function testSetMemberCorrectType()
    {
        $object = new Member();
        $this->stub->setMember($object);
        $this->assertSame($object, $this->stub->getMember());
    }

    /**
     * 设置 NaturalPerson setMember() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetMemberType()
    {
        $this->stub->setMember(array(1,2,3));
    }
    //member 测试 -------------------------------------------------------- end

    //rejectReason 测试 -------------------------------------------------------- start
    /**
     * 设置 NaturalPerson rejectReason() 正确的传参类型,期望传值正确
     */
    public function testSetRejectReasonCorrectType()
    {
        $this->stub->setRejectReason('rejectReason');
        $this->assertEquals('rejectReason', $this->stub->getRejectReason());
    }

    /**
     * 设置 NaturalPerson setReason() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetRejectReasonWrongType()
    {
        $this->stub->setRejectReason(array());
    }
    //rejectReason 测试 --------------------------------------------------------   end
}
