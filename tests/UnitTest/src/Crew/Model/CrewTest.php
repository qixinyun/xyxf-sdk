<?php
namespace Sdk\Crew\Model;

use Sdk\Crew\Repository\CrewRepository;
use Sdk\Crew\Repository\CrewSessionRepository;

use Sdk\Common\Adapter\IOperatAbleAdapter;
use Sdk\Common\Adapter\IEnableAbleAdapter;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Core;

class CrewTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(Crew::class)
            ->setMethods([
                'getRepository',
                'IOperatAbleAdapter',
                'IEnableAbleAdapter'
            ])->getMock();

        $this->childStub = new Class extends Crew{

            public function getRepository() : CrewRepository
            {
                return parent::getRepository();
            }

            public function getIOperatAbleAdapter() : IOperatAbleAdapter
            {
                return parent::getIOperatAbleAdapter();
            }

            public function getIEnableAbleAdapter() : IEnableAbleAdapter
            {
                return parent::getIEnableAbleAdapter();
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
            'Sdk\Crew\Repository\CrewRepository',
            $this->childStub->getRepository()
        );
    }

    public function testExtendsUser()
    {
        $this->assertInstanceOf('Sdk\User\Model\User', $this->stub);
    }

    public function testCorrectImplementsIObject()
    {
        $this->assertInstanceof('Marmot\Common\Model\IObject', $this->stub);
    }

    public function testCorrectImplementsIOperatAble()
    {
        $this->assertInstanceof('Sdk\Common\Model\IOperatAble', $this->stub);
    }

    public function testCorrectImplementsIEnableAble()
    {
        $this->assertInstanceof('Sdk\Common\Model\IEnableAble', $this->stub);
    }

    public function testGetIOperatAble()
    {
        $this->assertInstanceOf(
            'Sdk\Common\Adapter\IOperatAbleAdapter',
            $this->childStub->getIOperatAbleAdapter()
        );
    }

    public function testGetIEnabledAble()
    {
        $this->assertInstanceOf(
            'Sdk\Common\Adapter\IEnableAbleAdapter',
            $this->childStub->getIEnableAbleAdapter()
        );
    }

    //workNumber 测试 ---------------------------------------------------------- start
    /**
     * 设置 Crew setWorkNumber() 正确的传参类型,期望传值正确
     */
    public function testSetWorkNumberCorrectType()
    {
        $this->stub->setWorkNumber('string');
        $this->assertEquals('string', $this->stub->getWorkNumber());
    }

    /**
     * 设置 Crew setWorkNumber() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetWorkNumberWrongType()
    {
        $this->stub->setWorkNumber(array(1, 2, 3));
    }
    //workNumber 测试 ----------------------------------------------------------   end

    public function signIn()
    {
        if ($this->getRepository()->signIn($this)) {
            return true;
        }

        return false;
    }

    public function testUpdatePassword()
    {
        $repository = $this->prophesize(CrewRepository::class);
        $repository->updatePassword(Argument::exact($this->stub))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getRepository')
            ->willReturn($repository->reveal());

        $result = $this->stub->updatePassword();
        $this->assertTrue($result);
    }
}
