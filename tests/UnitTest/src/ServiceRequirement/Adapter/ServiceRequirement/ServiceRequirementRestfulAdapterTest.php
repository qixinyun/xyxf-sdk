<?php
namespace Sdk\ServiceRequirement\Adapter\ServiceRequirement;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\ServiceRequirement\Model\ServiceRequirement;
use Sdk\ServiceRequirement\Model\NullServiceRequirement;
use Sdk\ServiceRequirement\Utils\MockFactory;
use Sdk\ServiceRequirement\Translator\ServiceRequirementRestfulTranslator;

class ServiceRequirementRestfulAdapterTest extends TestCase
{
    private $stub;

    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(ServiceRequirementRestfulAdapter::class)
            ->setMethods([
                'fetchOneAction',
                'isSuccess',
                'post',
                'patch',
                'translateToObject',
                'getTranslator'
            ])->getMock();

        $this->childStub = new class extends ServiceRequirementRestfulAdapter {
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

    public function testImplementsIServiceRequirementAdapter()
    {
        $this->assertInstanceOf(
            'Sdk\ServiceRequirement\Adapter\ServiceRequirement\IServiceRequirementAdapter',
            $this->stub
        );
    }

    public function testGetResource()
    {
        $this->assertEquals('serviceRequirements', $this->childStub->getResource());
    }

    public function testGetTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\ServiceRequirement\Translator\ServiceRequirementRestfulTranslator',
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
                'OA_SERVICE_REQUIREMENT_LIST',
                ServiceRequirementRestfulAdapter::SCENARIOS['OA_SERVICE_REQUIREMENT_LIST']
            ],
            [
                'PORTAL_SERVICE_REQUIREMENT_LIST',
                ServiceRequirementRestfulAdapter::SCENARIOS['PORTAL_SERVICE_REQUIREMENT_LIST']
            ],
            [
                'SERVICE_REQUIREMENT_FETCH_ONE',
                ServiceRequirementRestfulAdapter::SCENARIOS['SERVICE_REQUIREMENT_FETCH_ONE']
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

        $serviceRequirement = MockFactory::generateServiceRequirementObject($id);

        $this->stub->expects($this->exactly(1))
            ->method('fetchOneAction')
            ->with($id, new NullServiceRequirement())
            ->willReturn($serviceRequirement);

        $result = $this->stub->fetchOne($id);
        $this->assertEquals($serviceRequirement, $result);
    }
    /**
     * 为ServiceRequirementRestfulTranslator建立预言
     * 建立预期状况：objectToArray() 方法将会被调用一次，并以$serviceRequirement，$keys为参数
     * 揭示预言中的getTranslator，并将仿件对象链接到主体上
     */
    private function prepareServiceRequirementTranslator(
        ServiceRequirement $serviceRequirement,
        array $keys,
        array $serviceRequirementArray
    ) {
        $translator = $this->prophesize(ServiceRequirementRestfulTranslator::class);
        $translator->objectToArray(
            Argument::exact($serviceRequirement),
            Argument::exact($keys)
        )->shouldBeCalledTimes(1)
            ->willReturn($serviceRequirementArray);

        $this->stub->expects($this->exactly(1))
            ->method('getTranslator')
            ->willReturn($translator->reveal());
    }

    private function success(ServiceRequirement $serviceRequirement)
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('translateToObject')
            ->with($serviceRequirement);
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
     * 执行prepareServiceRequirementTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行add（）
     * 判断 result 是否为true
     */
    public function testAddSuccess()
    {
        $serviceRequirement = MockFactory::generateServiceRequirementObject(1);
        $serviceRequirementArray = array();

        $this->prepareServiceRequirementTranslator(
            $serviceRequirement,
            array(
                'serviceCategory',
                'title',
                'detail',
                'minPrice',
                'maxPrice',
                'validityStartTime',
                'validityEndTime',
                'contactName',
                'contactPhone',
                'member',
            ),
            $serviceRequirementArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('serviceRequirements', $serviceRequirementArray);

        $this->success($serviceRequirement);

        $result = $this->stub->add($serviceRequirement);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareServiceRequirementTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行add（）
     * 判断 result 是否为false
     */
    public function testAddFailure()
    {
        $serviceRequirement = MockFactory::generateServiceRequirementObject(1);
        $serviceRequirementArray = array();

        $this->prepareServiceRequirementTranslator(
            $serviceRequirement,
            array(
                'serviceCategory',
                'title',
                'detail',
                'minPrice',
                'maxPrice',
                'validityStartTime',
                'validityEndTime',
                'contactName',
                'contactPhone',
                'member',
            ),
            $serviceRequirementArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('serviceRequirements', $serviceRequirementArray);

        $this->failure($serviceRequirement);
        $result = $this->stub->add($serviceRequirement);
        $this->assertFalse($result);
    }
}
