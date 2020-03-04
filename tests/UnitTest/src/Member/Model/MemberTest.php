<?php
namespace Sdk\Member\Model;

use Sdk\Member\Repository\MemberRepository;
use Sdk\Member\Repository\MemberSessionRepository;

use Sdk\Common\Model\IEnableAble;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

//use Marmot\Framework\Classes\Cookie;
use Marmot\Core;

class MemberTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(Member::class)
            ->setMethods([
                'getRepository',
                'getSessionRepository'
            ])->getMock();

        $this->childStub = new Class extends Member{
            public function getRepository() : MemberRepository
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
            'Sdk\Member\Repository\MemberRepository',
            $this->childStub->getRepository()
        );
    }

    public function testExtendsUser()
    {
        $this->assertInstanceOf('Sdk\User\Model\User', $this->stub);
    }

    //nickName 测试 ---------------------------------------------------------- start
    /**
     * 设置 User setNickName() 正确的传参类型,期望传值正确
     */
    public function testSetNickNameCorrectType()
    {
        $this->stub->setNickName('string');
        $this->assertEquals('string', $this->stub->getNickName());
    }

    /**
     * 设置 User setNickName() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetNickNameWrongType()
    {
        $this->stub->setNickName(array(1, 2, 3));
    }
    //nickName 测试 ----------------------------------------------------------   end

    //birthday 测试 ---------------------------------------------------------- start
    /**
     * 设置 User setBirthday() 正确的传参类型,期望传值正确
     */
    public function testSetBirthdayCorrectType()
    {
        $this->stub->setBirthday('2019-10-30');
        $this->assertEquals('2019-10-30', $this->stub->getBirthday());
    }

    /**
     * 设置 User setBirthday() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetBirthdayWrongType()
    {
        $this->stub->setBirthday(array(1, 2, 3));
    }
    //birthday 测试 ----------------------------------------------------------   end

    //area 测试 ---------------------------------------------------------- start
    /**
     * 设置 User setArea() 正确的传参类型,期望传值正确
     */
    public function testSetAreaCorrectType()
    {
        $this->stub->setArea('string');
        $this->assertEquals('string', $this->stub->getArea());
    }

    /**
     * 设置 User setArea() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetAreaWrongType()
    {
        $this->stub->setArea(array(1, 2, 3));
    }
    //area 测试 ----------------------------------------------------------   end

    //address 测试 ---------------------------------------------------------- start
    /**
     * 设置 User setAddress() 正确的传参类型,期望传值正确
     */
    public function testSetAddressCorrectType()
    {
        $this->stub->setAddress('string');
        $this->assertEquals('string', $this->stub->getAddress());
    }

    /**
     * 设置 User setAddress() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetAddressWrongType()
    {
        $this->stub->setAddress(array(1, 2, 3));
    }
    //address 测试 ----------------------------------------------------------   end

    //briefIntroduction 测试 ---------------------------------------------------------- start
    /**
     * 设置 User setBriefIntroduction() 正确的传参类型,期望传值正确
     */
    public function testSetBriefIntroductionCorrectType()
    {
        $this->stub->setBriefIntroduction('string');
        $this->assertEquals('string', $this->stub->getBriefIntroduction());
    }

    /**
     * 设置 User setBriefIntroduction() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetBriefIntroductionWrongType()
    {
        $this->stub->setBriefIntroduction(array(1, 2, 3));
    }
    //briefIntroduction 测试 ----------------------------------------------------------   end

    public function signIn()
    {
        $repository = $this->prophesize(MemberRepository::class);
        $repository->signIn(Argument::exact($this->stub))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))->method('getRepository')->willReturn($repository->reveal());
        $result = $this->stub->signIn();
        $this->assertTrue($result);
    }

    public function testSignUp()
    {
        $repository = $this->prophesize(MemberRepository::class);
        $repository->signUp(Argument::exact($this->stub))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))->method('getRepository')->willReturn($repository->reveal());
        $result = $this->stub->signUp();
        $this->assertTrue($result);
    }

    public function testResetPassword()
    {
        $repository = $this->prophesize(MemberRepository::class);
        $repository->resetPassword(Argument::exact($this->stub))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getRepository')
            ->willReturn($repository->reveal());

        $result = $this->stub->resetPassword();
        $this->assertTrue($result);
    }

    public function testUpdatePassword()
    {
        $repository = $this->prophesize(MemberRepository::class);
        $repository->updatePassword(Argument::exact($this->stub))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getRepository')
            ->willReturn($repository->reveal());

        $result = $this->stub->updatePassword();
        $this->assertTrue($result);
    }

    public function testUpdateCellphone()
    {
        $repository = $this->prophesize(MemberRepository::class);
        $repository->updateCellphone(Argument::exact($this->stub))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getRepository')
            ->willReturn($repository->reveal());

        $result = $this->stub->updateCellphone();
        $this->assertTrue($result);
    }
}
