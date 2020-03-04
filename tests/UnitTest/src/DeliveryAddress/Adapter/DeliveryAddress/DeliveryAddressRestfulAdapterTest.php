<?php
namespace Sdk\DeliveryAddress\Adapter\DeliveryAddress;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\DeliveryAddress\Model\DeliveryAddress;
use Sdk\DeliveryAddress\Model\NullDeliveryAddress;
use Sdk\DeliveryAddress\Utils\MockFactory;
use Sdk\DeliveryAddress\Translator\DeliveryAddressRestfulTranslator;

class DeliveryAddressRestfulAdapterTest extends TestCase
{
    private $stub;

    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(DeliveryAddressRestfulAdapter::class)
            ->setMethods([
                'fetchOneAction',
                'isSuccess',
                'post',
                'patch',
                'translateToObject',
                'getTranslator'
            ])->getMock();

        $this->childStub = new class extends DeliveryAddressRestfulAdapter {
            public function getResource() : string
            {
                return parent::getResource();
            }

            public function getTranslator() : IRestfulTranslator
            {
                return parent::getTranslator();
            }

            public function getScenario() : array
            {
                return parent::getScenario();
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function testImplementsIDeliveryAddressAdapter()
    {
        $this->assertInstanceOf(
            'Sdk\DeliveryAddress\Adapter\DeliveryAddress\IDeliveryAddressAdapter',
            $this->stub
        );
    }

    public function testGetResource()
    {
        $this->assertEquals('deliveryAddress', $this->childStub->getResource());
    }

    public function testGetTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\DeliveryAddress\Translator\DeliveryAddressRestfulTranslator',
            $this->childStub->getTranslator()
        );
    }

    /**
     * 循环测试 scenario() 是否符合预定范围
     *
     * @dataProvider scenarioDataProvider
     */
    public function testScenario($expect, $actual)
    {
        $this->childStub->scenario($expect);
        $this->assertEquals($actual, $this->childStub->getScenario());
    }
     /**
     * 循环测试 testScenario() 数据构建器
     */
    public function scenarioDataProvider()
    {
        return [
            [
                'DELIVERY_ADDRESS_LIST',
                DeliveryAddressRestfulAdapter::SCENARIOS['DELIVERY_ADDRESS_LIST']
            ],
            [
                'DELIVERY_ADDRESS_FETCH_ONE',
                DeliveryAddressRestfulAdapter::SCENARIOS['DELIVERY_ADDRESS_FETCH_ONE']
            ],
            ['NULL', array()]
        ];
    }
    /**
     * 设置ID
     * 根据ID生成模拟数据
     * 揭示fetchOneAction，期望返回模拟的数据
     * 执行fetchOne（）方法
     * 判断result是否和模拟数据相等，不相等则抛出异常
     */
    public function testFetchOne()
    {
        $id = 1;

        $deliveryAddress = MockFactory::generateDeliveryAddressObject($id);

        $this->stub->expects($this->exactly(1))
            ->method('fetchOneAction')
            ->with($id, new NullDeliveryAddress())
            ->willReturn($deliveryAddress);

        $result = $this->stub->fetchOne($id);
        $this->assertEquals($deliveryAddress, $result);
    }
    /**
     * 为DeliveryAddressRestfulTranslator建立预言
     * 建立预期状况：objectToArray() 方法将会被调用一次，并以$DeliveryAddress$keys为参数
     * 揭示预言中的getTranslator，并将仿件对象链接到主体上
     */
    private function prepareDeliveryAddressTranslator(
        DeliveryAddress $deliveryAddress,
        array $keys,
        array $deliveryAddressArray
    ) {
        $translator = $this->prophesize(DeliveryAddressRestfulTranslator::class);
        $translator->objectToArray(
            Argument::exact($deliveryAddress),
            Argument::exact($keys)
        )->shouldBeCalledTimes(1)
            ->willReturn($deliveryAddressArray);

        $this->stub->expects($this->exactly(1))
            ->method('getTranslator')
            ->willReturn($translator->reveal());
    }

    private function success(DeliveryAddress $deliveryAddress)
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('translateToObject')
            ->with($deliveryAddress);
    }

    private function failure()
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(false);
        $this->stub->expects($this->exactly(0))
            ->method('translateToObject');
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareDeliveryAddressTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行add（）
     * 判断 result 是否为true
     */
    public function testAddSuccess()
    {
        $deliveryAddress = MockFactory::generateDeliveryAddressObject(1);
        $deliveryAddressArray = array();

        $this->prepareDeliveryAddressTranslator(
            $deliveryAddress,
            array(
                'area',
                'address',
                'postalCode',
                'realName',
                'cellphone',
                'isDefaultAddress',
                'member'
            ),
            $deliveryAddressArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('deliveryAddress', $deliveryAddressArray);

        $this->success($deliveryAddress);

        $result = $this->stub->add($deliveryAddress);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareDeliveryAddressTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行add（）
     * 判断 result 是否为false
     */
    public function testAddFailure()
    {
        $deliveryAddress = MockFactory::generateDeliveryAddressObject(1);
        $deliveryAddressArray = array();

        $this->prepareDeliveryAddressTranslator(
            $deliveryAddress,
            array(
                'area',
                'address',
                'postalCode',
                'realName',
                'cellphone',
                'isDefaultAddress',
                'member'
            ),
            $deliveryAddressArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('deliveryAddress', $deliveryAddressArray);

        $this->failure($deliveryAddress);
        $result = $this->stub->add($deliveryAddress);
        $this->assertFalse($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareDeliveryAddressTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行edit（）
     * 判断 result 是否为true
     */
    public function testEditSuccess()
    {
        $deliveryAddress = MockFactory::generateDeliveryAddressObject(1);
        $deliveryAddressArray = array();

        $this->prepareDeliveryAddressTranslator(
            $deliveryAddress,
            array(
                'area',
                'address',
                'postalCode',
                'realName',
                'cellphone',
                'isDefaultAddress'
            ),
            $deliveryAddressArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'deliveryAddress/'.$deliveryAddress->getId(),
                $deliveryAddressArray
            );

        $this->success($deliveryAddress);

        $result = $this->stub->edit($deliveryAddress);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareDeliveryAddressTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行edit（）
     * 判断 result 是否为false
     */
    public function testEditFailure()
    {
        $deliveryAddress = MockFactory::generateDeliveryAddressObject(1);
        $deliveryAddressArray = array();

        $this->prepareDeliveryAddressTranslator(
            $deliveryAddress,
            array(
                'area',
                'address',
                'postalCode',
                'realName',
                'cellphone',
                'isDefaultAddress'
            ),
            $deliveryAddressArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'deliveryAddress/'.$deliveryAddress->getId(),
                $deliveryAddressArray
            );

        $this->failure($deliveryAddress);
        $result = $this->stub->edit($deliveryAddress);
        $this->assertFalse($result);
    }
}
