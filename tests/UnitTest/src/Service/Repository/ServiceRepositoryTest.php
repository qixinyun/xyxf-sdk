<?php
namespace Sdk\Service\Repository;

use Sdk\Service\Adapter\Service\ServiceRestfulAdapter;

use Sdk\Service\Utils\MockFactory;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class ServiceRepositoryTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(ServiceRepository::class)
            ->setMethods(['getAdapter'])
            ->getMock();

        $this->childStub = new class extends ServiceRepository {
            public function getAdapter() : ServiceRestfulAdapter
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
            'Sdk\Service\Adapter\Service\ServiceRestfulAdapter',
            $this->childStub->getAdapter()
        );
    }
    /**
     * 为ServiceRestfulAdapter建立预言
     * 建立预期状况：scenario() 方法将会被调用一次，并以ServiceRepository::LIST_MODEL_UN为参数
     * 揭示预言，并将仿件对象链接到主体上。
     * 执行scenario
     * 判断执行的$this->stub和$result是否相等，不相等则抛出异常
     */
    public function testScenario()
    {
        $adapter = $this->prophesize(ServiceRestfulAdapter::class);
        $adapter->scenario(Argument::exact(ServiceRepository::OA_LIST_MODEL_UN))->shouldBeCalledTimes(1);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());
        $result = $this->stub->scenario(ServiceRepository::OA_LIST_MODEL_UN);
        $this->assertEquals($this->stub, $result);
    }
    /**
     * 获取mock数据
     * 为ServiceRestfulAdapter建立预言
     * 建立预期状况：onShelf() 方法将会被调用一次，并以$service为参数
     * 揭示预言，并将仿件对象链接到主体上。
     * 执行scenario
     * 判断执行的$this->stub和$result是否相等，不相等则抛出异常
     */
    public function testOnShelf()
    {
        $service = \Sdk\Service\Utils\MockFactory::generateServiceObject(1);

        $adapter = $this->prophesize(ServiceRestfulAdapter::class);
        $adapter->onShelf(Argument::exact($service))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->onShelf($service);
        $this->assertTrue($result);
    }
    /**
     * 获取mock数据
     * 为ServiceRestfulAdapter建立预言
     * 建立预期状况：offStock() 方法将会被调用一次，并以$service为参数
     * 揭示预言，并将仿件对象链接到主体上。
     * 执行scenario
     * 判断执行的$this->stub和$result是否相等，不相等则抛出异常
     */
    public function testOffStock()
    {
        $service = \Sdk\Service\Utils\MockFactory::generateServiceObject(1);

        $adapter = $this->prophesize(ServiceRestfulAdapter::class);
        $adapter->offStock(Argument::exact($service))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->offStock($service);
        $this->assertTrue($result);
    }
    /**
     * 获取mock数据
     * 为ServiceRestfulAdapter建立预言
     * 建立预期状况：revoke() 方法将会被调用一次，并以$service为参数
     * 揭示预言，并将仿件对象链接到主体上。
     * 执行scenario
     * 判断执行的$this->stub和$result是否相等，不相等则抛出异常
     */
    public function testRevoke()
    {
        $service = \Sdk\Service\Utils\MockFactory::generateServiceObject(1);

        $adapter = $this->prophesize(ServiceRestfulAdapter::class);
        $adapter->revoke(Argument::exact($service))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->revoke($service);
        $this->assertTrue($result);
    }
    /**
     * 获取mock数据
     * 为ServiceRestfulAdapter建立预言
     * 建立预期状况：close() 方法将会被调用一次，并以$service为参数
     * 揭示预言，并将仿件对象链接到主体上。
     * 执行scenario
     * 判断执行的$this->stub和$result是否相等，不相等则抛出异常
     */
    public function testClose()
    {
        $service = \Sdk\Service\Utils\MockFactory::generateServiceObject(1);

        $adapter = $this->prophesize(ServiceRestfulAdapter::class);
        $adapter->close(Argument::exact($service))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->close($service);
        $this->assertTrue($result);
    }
    /**
     * 获取mock数据
     * 为ServiceRestfulAdapter建立预言
     * 建立预期状况：deletes() 方法将会被调用一次，并以$service为参数
     * 揭示预言，并将仿件对象链接到主体上。
     * 执行scenario
     * 判断执行的$this->stub和$result是否相等，不相等则抛出异常
     */
    public function testDeletes()
    {
        $service = \Sdk\Service\Utils\MockFactory::generateServiceObject(1);

        $adapter = $this->prophesize(ServiceRestfulAdapter::class);
        $adapter->deletes(Argument::exact($service))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->deletes($service);
        $this->assertTrue($result);
    }
}
