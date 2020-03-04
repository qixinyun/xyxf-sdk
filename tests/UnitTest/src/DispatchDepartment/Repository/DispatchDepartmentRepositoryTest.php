<?php
namespace Sdk\DispatchDepartment\Repository;

use Sdk\DispatchDepartment\Adapter\DispatchDepartment\DispatchDepartmentRestfulAdapter;

use Sdk\DispatchDepartment\Utils\MockFactory;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class DispatchDepartmentRepositoryTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(DispatchDepartmentRepository::class)
            ->setMethods(['getAdapter'])
            ->getMock();

        $this->childStub = new class extends DispatchDepartmentRepository {
            public function getAdapter() : DispatchDepartmentRestfulAdapter
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
            'Sdk\DispatchDepartment\Adapter\DispatchDepartment\DispatchDepartmentRestfulAdapter',
            $this->childStub->getAdapter()
        );
    }
    
    public function testScenario()
    {
        $adapter = $this->prophesize(DispatchDepartmentRestfulAdapter::class);
        $adapter->scenario(Argument::exact(DispatchDepartmentRepository::LIST_MODEL_UN))->shouldBeCalledTimes(1);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());
        $result = $this->stub->scenario(DispatchDepartmentRepository::LIST_MODEL_UN);
        $this->assertEquals($this->stub, $result);
    }
}
