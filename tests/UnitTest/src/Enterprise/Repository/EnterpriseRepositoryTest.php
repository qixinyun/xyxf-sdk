<?php
namespace Sdk\Enterprise\Repository;

use Sdk\Enterprise\Adapter\Enterprise\EnterpriseRestfulAdapter;

use Sdk\Enterprise\Utils\MockFactory;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class EnterpriseRepositoryTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(EnterpriseRepository::class)
            ->setMethods(['getAdapter'])
            ->getMock();

        $this->childStub = new class extends EnterpriseRepository {
            public function getAdapter() : EnterpriseRestfulAdapter
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
            'Sdk\Enterprise\Adapter\Enterprise\EnterpriseRestfulAdapter',
            $this->childStub->getAdapter()
        );
    }
    /**
     * 为EnterpriseRestfulAdapter建立预言
     * 建立预期状况：scenario() 方法将会被调用一次，并以EnterpriseRepository::LIST_MODEL_UN为参数
     * 揭示预言，并将仿件对象链接到主体上。
     * 执行scenario
     * 判断执行的$this->stub和$result是否相等，不相等则抛出异常
     */
    public function testScenario()
    {
        $adapter = $this->prophesize(EnterpriseRestfulAdapter::class);
        $adapter->scenario(Argument::exact(EnterpriseRepository::OA_LIST_MODEL_UN))->shouldBeCalledTimes(1);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());
        $result = $this->stub->scenario(EnterpriseRepository::OA_LIST_MODEL_UN);
        $this->assertEquals($this->stub, $result);
    }
}
