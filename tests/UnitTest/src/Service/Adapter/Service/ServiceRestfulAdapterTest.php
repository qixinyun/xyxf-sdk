<?php
namespace Sdk\Service\Adapter\Service;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\Service\Model\Service;
use Sdk\Service\Model\NullService;
use Sdk\Service\Utils\MockFactory;
use Sdk\Service\Translator\ServiceRestfulTranslator;

class ServiceRestfulAdapterTest extends TestCase
{
    private $stub;

    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(ServiceRestfulAdapter::class)
            ->setMethods([
                'fetchOneAction',
                'isSuccess',
                'post',
                'patch',
                'translateToObject',
                'getTranslator'
            ])->getMock();

        $this->childStub = new class extends ServiceRestfulAdapter {
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

    public function testImplementsIServiceAdapter()
    {
        $this->assertInstanceOf(
            'Sdk\Service\Adapter\Service\IServiceAdapter',
            $this->stub
        );
    }

    public function testGetResource()
    {
        $this->assertEquals('services', $this->childStub->getResource());
    }

    public function testGetTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\Service\Translator\ServiceRestfulTranslator',
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
                'OA_SERVICE_LIST',
                ServiceRestfulAdapter::SCENARIOS['OA_SERVICE_LIST']
            ],
            [
                'PORTAL_SERVICE_LIST',
                ServiceRestfulAdapter::SCENARIOS['PORTAL_SERVICE_LIST']
            ],
            [
                'SERVICE_FETCH_ONE',
                ServiceRestfulAdapter::SCENARIOS['SERVICE_FETCH_ONE']
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

        $service = MockFactory::generateServiceObject($id);

        $this->stub->expects($this->exactly(1))
            ->method('fetchOneAction')
            ->with($id, new NullService())
            ->willReturn($service);

        $result = $this->stub->fetchOne($id);
        $this->assertEquals($service, $result);
    }
    /**
     * 为ServiceRestfulTranslator建立预言
     * 建立预期状况：objectToArray() 方法将会被调用一次，并以$service，$keys为参数
     * 揭示预言中的getTranslator，并将仿件对象链接到主体上
     */
    private function prepareServiceTranslator(
        Service $service,
        array $keys,
        array $serviceArray
    ) {
        $translator = $this->prophesize(ServiceRestfulTranslator::class);
        $translator->objectToArray(
            Argument::exact($service),
            Argument::exact($keys)
        )->shouldBeCalledTimes(1)
            ->willReturn($serviceArray);

        $this->stub->expects($this->exactly(1))
            ->method('getTranslator')
            ->willReturn($translator->reveal());
    }

    private function success(Service $service)
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('translateToObject')
            ->with($service);
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
     * 执行prepareServiceTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行add（）
     * 判断 result 是否为true
     */
    public function testAddSuccess()
    {
        $service = MockFactory::generateServiceObject(1);
        $serviceArray = array();

        $this->prepareServiceTranslator(
            $service,
            array(
                'serviceCategory',
                'title',
                'cover',
                'price',
                'contract',
                'detail',
                'serviceObjects',
                'enterprise',
            ),
            $serviceArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('services', $serviceArray);

        $this->success($service);

        $result = $this->stub->add($service);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareServiceTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行add（）
     * 判断 result 是否为false
     */
    public function testAddFailure()
    {
        $service = MockFactory::generateServiceObject(1);
        $serviceArray = array();

        $this->prepareServiceTranslator(
            $service,
            array(
                'serviceCategory',
                'title',
                'cover',
                'price',
                'contract',
                'detail',
                'serviceObjects',
                'enterprise',
            ),
            $serviceArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('services', $serviceArray);

        $this->failure($service);
        $result = $this->stub->add($service);
        $this->assertFalse($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareServiceTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行edit（）
     * 判断 result 是否为true
     */
    public function testEditSuccess()
    {
        $service = MockFactory::generateServiceObject(1);
        $serviceArray = array();

        $this->prepareServiceTranslator(
            $service,
            array(
                'serviceCategory',
                'title',
                'cover',
                'price',
                'contract',
                'detail',
                'serviceObjects',
            ),
            $serviceArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'services/'.$service->getId(),
                $serviceArray
            );

        $this->success($service);

        $result = $this->stub->edit($service);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareServiceTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行edit（）
     * 判断 result 是否为false
     */
    public function testEditFailure()
    {
        $service = MockFactory::generateServiceObject(1);
        $serviceArray = array();

        $this->prepareServiceTranslator(
            $service,
            array(
                'serviceCategory',
                'title',
                'cover',
                'price',
                'contract',
                'detail',
                'serviceObjects',
            ),
            $serviceArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'services/'.$service->getId(),
                $serviceArray
            );

        $this->failure($service);
        $result = $this->stub->edit($service);
        $this->assertFalse($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareServiceTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行resubmit（）
     * 判断 result 是否为true
     */
    public function testResubmitSuccess()
    {
        $service = MockFactory::generateServiceObject(1);
        $serviceArray = array();

        $this->prepareServiceTranslator(
            $service,
            array(
                'serviceCategory',
                'title',
                'cover',
                'price',
                'contract',
                'detail',
                'serviceObjects',
            ),
            $serviceArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'services/'.$service->getId().'/resubmit',
                $serviceArray
            );

        $this->success($service);

        $result = $this->stub->resubmit($service);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareServiceTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行resubmit（）
     * 判断 result 是否为false
     */
    public function testResubmitFailure()
    {
        $service = MockFactory::generateServiceObject(1);
        $serviceArray = array();

        $this->prepareServiceTranslator(
            $service,
            array(
                'serviceCategory',
                'title',
                'cover',
                'price',
                'contract',
                'detail',
                'serviceObjects',
            ),
            $serviceArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'services/'.$service->getId().'/resubmit',
                $serviceArray
            );

        $this->failure($service);
        $result = $this->stub->resubmit($service);
        $this->assertFalse($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareServiceTranslator方法
     * 揭示预言中的patch，并将仿件对象链接到主体上
     * 执行success（）
     * 执行resubmit（）
     * 判断 result 是否为true
     */
    public function testOnShelfSuccess()
    {
        $service = MockFactory::generateServiceObject(1);

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'services/'.$service->getId().'/onShelf'
            );

        $this->success($service);

        $result = $this->stub->onShelf($service);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareServiceTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行resubmit（）
     * 判断 result 是否为false
     */
    public function testOnShelfFailure()
    {
        $service = MockFactory::generateServiceObject(1);

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'services/'.$service->getId().'/onShelf'
            );

        $this->failure($service);
        $result = $this->stub->onShelf($service);
        $this->assertFalse($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareServiceTranslator方法
     * 揭示预言中的patch，并将仿件对象链接到主体上
     * 执行success（）
     * 执行resubmit（）
     * 判断 result 是否为true
     */
    public function testOffStockSuccess()
    {
        $service = MockFactory::generateServiceObject(1);

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'services/'.$service->getId().'/offStock'
            );

        $this->success($service);

        $result = $this->stub->offStock($service);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareServiceTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行resubmit（）
     * 判断 result 是否为false
     */
    public function testOffStockFailure()
    {
        $service = MockFactory::generateServiceObject(1);

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'services/'.$service->getId().'/offStock'
            );

        $this->failure($service);
        $result = $this->stub->offStock($service);
        $this->assertFalse($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareServiceTranslator方法
     * 揭示预言中的patch，并将仿件对象链接到主体上
     * 执行success（）
     * 执行resubmit（）
     * 判断 result 是否为true
     */
    public function testRevokeSuccess()
    {
        $service = MockFactory::generateServiceObject(1);

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'services/'.$service->getId().'/revoke'
            );

        $this->success($service);

        $result = $this->stub->revoke($service);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareServiceTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行resubmit（）
     * 判断 result 是否为false
     */
    public function testRevokeFailure()
    {
        $service = MockFactory::generateServiceObject(1);

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'services/'.$service->getId().'/revoke'
            );

        $this->failure($service);
        $result = $this->stub->revoke($service);
        $this->assertFalse($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareServiceTranslator方法
     * 揭示预言中的patch，并将仿件对象链接到主体上
     * 执行success（）
     * 执行resubmit（）
     * 判断 result 是否为true
     */
    public function testCloseSuccess()
    {
        $service = MockFactory::generateServiceObject(1);

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'services/'.$service->getId().'/close'
            );

        $this->success($service);

        $result = $this->stub->close($service);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareServiceTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行resubmit（）
     * 判断 result 是否为false
     */
    public function testCloseFailure()
    {
        $service = MockFactory::generateServiceObject(1);

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'services/'.$service->getId().'/close'
            );

        $this->failure($service);
        $result = $this->stub->close($service);
        $this->assertFalse($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareServiceTranslator方法
     * 揭示预言中的patch，并将仿件对象链接到主体上
     * 执行success（）
     * 执行resubmit（）
     * 判断 result 是否为true
     */
    public function testDeletesSuccess()
    {
        $service = MockFactory::generateServiceObject(1);

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'services/'.$service->getId().'/delete'
            );

        $this->success($service);

        $result = $this->stub->deletes($service);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareServiceTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行resubmit（）
     * 判断 result 是否为false
     */
    public function testDeletesFailure()
    {
        $service = MockFactory::generateServiceObject(1);

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'services/'.$service->getId().'/delete'
            );

        $this->failure($service);
        $result = $this->stub->deletes($service);
        $this->assertFalse($result);
    }
}
