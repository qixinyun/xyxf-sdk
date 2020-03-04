<?php
namespace Sdk\Crew\Repository;

use Sdk\Crew\Adapter\Crew\CrewRestfulAdapter;

use Sdk\Crew\Utils\MockFactory;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class CrewRepositoryTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(CrewRepository::class)
            ->setMethods(['getAdapter'])
            ->getMock();

        $this->childStub = new class extends CrewRepository {
            public function getAdapter() : CrewRestfulAdapter
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
            'Sdk\Crew\Adapter\Crew\CrewRestfulAdapter',
            $this->childStub->getAdapter()
        );
    }

    public function testScenario()
    {
        $adapter = $this->prophesize(CrewRestfulAdapter::class);
        $adapter->scenario(Argument::exact(CrewRepository::LIST_MODEL_UN))->shouldBeCalledTimes(1);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());
        $result = $this->stub->scenario(CrewRepository::LIST_MODEL_UN);
        $this->assertEquals($this->stub, $result);
    }

    public function testSignIn()
    {
        $crew = MockFactory::generateCrewObject(1);
        $adapter = $this->prophesize(CrewRestfulAdapter::class);
        $adapter->signIn(Argument::exact($crew))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->signIn($crew);
        $this->assertTrue($result);
    }

    public function testUpdatePassword()
    {
        $crew = MockFactory::generateCrewObject(1);

        $adapter = $this->prophesize(CrewRestfulAdapter::class);
        $adapter->updatePassword(Argument::exact($crew))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->updatePassword($crew);
        $this->assertTrue($result);
    }
}
