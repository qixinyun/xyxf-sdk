<?php
namespace Sdk\Member\Repository;

use Sdk\Member\Adapter\Member\MemberRestfulAdapter;

use Sdk\Member\Utils\MockFactory;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class MemberRepositoryTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(MemberRepository::class)
            ->setMethods(['getAdapter'])
            ->getMock();

        $this->childStub = new class extends MemberRepository {
            public function getAdapter() : MemberRestfulAdapter
            {
                return parent::getAdapter();
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function testGetAdapter()
    {
        $this->assertInstanceOf(
            'Sdk\Member\Adapter\Member\MemberRestfulAdapter',
            $this->childStub->getAdapter()
        );
    }
    
    public function testScenario()
    {
        $adapter = $this->prophesize(MemberRestfulAdapter::class);
        $adapter->scenario(Argument::exact(MemberRepository::LIST_MODEL_UN))->shouldBeCalledTimes(1);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());
        $result = $this->stub->scenario(MemberRepository::LIST_MODEL_UN);
        $this->assertEquals($this->stub, $result);
    }

    public function testSignIn()
    {
        $member = MockFactory::generateMemberObject(1);

        $adapter = $this->prophesize(MemberRestfulAdapter::class);
        $adapter->signIn(Argument::exact($member))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->signIn($member);
        $this->assertTrue($result);
    }

    public function testUpdatePassword()
    {
        $member = MockFactory::generateMemberObject(1);

        $adapter = $this->prophesize(MemberRestfulAdapter::class);
        $adapter->updatePassword(Argument::exact($member))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->updatePassword($member);
        $this->assertTrue($result);
    }

    public function testSignUp()
    {
        $member = MockFactory::generateMemberObject(1);

        $adapter = $this->prophesize(MemberRestfulAdapter::class);
        $adapter->signUp(Argument::exact($member))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->signUp($member);
        $this->assertTrue($result);
    }

    public function testResetPassword()
    {
        $member = MockFactory::generateMemberObject(1);

        $adapter = $this->prophesize(MemberRestfulAdapter::class);
        $adapter->resetPassword(Argument::exact($member))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->resetPassword($member);
        $this->assertTrue($result);
    }

    public function testEdit()
    {
        $member = MockFactory::generateMemberObject(1);

        $adapter = $this->prophesize(MemberRestfulAdapter::class);
        $adapter->edit(Argument::exact($member))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->edit($member);
        $this->assertTrue($result);
    }

    public function testUpdateCellphone()
    {
        $member = MockFactory::generateMemberObject(1);

        $adapter = $this->prophesize(MemberRestfulAdapter::class);
        $adapter->updateCellphone(Argument::exact($member))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->updateCellphone($member);
        $this->assertTrue($result);
    }
}
