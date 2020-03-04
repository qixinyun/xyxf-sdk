<?php
namespace Sdk\DeliveryAddress\Repository;

use Sdk\DeliveryAddress\Adapter\DeliveryAddress\DeliveryAddressRestfulAdapter;

use PHPUnit\Framework\TestCase;

use Prophecy\Argument;

class DeliveryAddress extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(DeliveryAddressRepository::class)
            ->setMethods(['getAdapter'])
            ->getMock();

        $this->childStub = new class extends DeliveryAddressRepository {
            public function getAdapter() : DeliveryAddressRestfulAdapter
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
            'Sdk\DeliveryAddress\Adapter\DeliveryAddress\DeliveryAddressRestfulAdapter',
            $this->childStub->getAdapter()
        );
    }
    /**
     * 为DeliveryAddressRestfulAdapter建立预言
     * 建立预期状况：scenario() 方法将会被调用一次，并以DeliveryAddressRepository::LIST_MODEL_UN为参数
     * 揭示预言，并将仿件对象链接到主体上。
     * 执行scenario
     * 判断执行的$this->stub和$result是否相等，不相等则抛出异常
     */
    public function testScenario()
    {
        $adapter = $this->prophesize(DeliveryAddressRestfulAdapter::class);
        $adapter->scenario(Argument::exact(DeliveryAddressRepository::FETCH_ONE_MODEL_UN))->shouldBeCalledTimes(1);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());
        $result = $this->stub->scenario(DeliveryAddressRepository::FETCH_ONE_MODEL_UN);
        $this->assertEquals($this->stub, $result);
    }
    /**
     * 生成模拟数据，传参为1
     * 为DeliveryAddressRestfulAdapter建立预言
     * 建立预期状况：setDefault() 方法将会被调用一次，并以模拟数据为参数，期望返回true
     * 揭示预言中的getAdapter，并将仿件对象链接到主体上
     * 执行add（）
     * 判断 result 是否为true
     */
    public function testSetDefault()
    {
        $deliveryAddress = \Sdk\DeliveryAddress\Utils\MockFactory::generateDeliveryAddressObject(1);

        $adapter = $this->prophesize(DeliveryAddressRestfulAdapter::class);
        $adapter->setDefault(Argument::exact($deliveryAddress))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->setDefault($deliveryAddress);
        $this->assertTrue($result);
    }
}
