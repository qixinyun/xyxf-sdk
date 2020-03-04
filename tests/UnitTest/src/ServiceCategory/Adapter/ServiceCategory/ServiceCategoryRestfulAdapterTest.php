<?php
namespace Sdk\ServiceCategory\Adapter\ServiceCategory;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\ServiceCategory\Model\ServiceCategory;
use Sdk\ServiceCategory\Model\NullServiceCategory;
use Sdk\ServiceCategory\Utils\MockFactory;
use Sdk\ServiceCategory\Translator\ServiceCategoryRestfulTranslator;

class ServiceCategoryRestfulAdapterTest extends TestCase
{
    private $stub;

    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(ServiceCategoryRestfulAdapter::class)
            ->setMethods([
                'fetchOneAction',
                'isSuccess',
                'post',
                'patch',
                'translateToObject',
                'getTranslator'
            ])->getMock();

        $this->childStub = new class extends ServiceCategoryRestfulAdapter {
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

    public function testImplementsIServiceCategoryAdapter()
    {
        $this->assertInstanceOf(
            'Sdk\ServiceCategory\Adapter\ServiceCategory\IServiceCategoryAdapter',
            $this->stub
        );
    }

    public function testGetResource()
    {
        $this->assertEquals('serviceCategories', $this->childStub->getResource());
    }

    public function testGetTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\ServiceCategory\Translator\ServiceCategoryRestfulTranslator',
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
                'SERVICECATEGORY_LIST',
                ServiceCategoryRestfulAdapter::SCENARIOS['SERVICECATEGORY_LIST']
            ],
            [
                'SERVICECATEGORY_FETCH_ONE',
                ServiceCategoryRestfulAdapter::SCENARIOS['SERVICECATEGORY_FETCH_ONE']
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

        $serviceCategoty = MockFactory::generateServiceCategoryObject($id);

        $this->stub->expects($this->exactly(1))
            ->method('fetchOneAction')
            ->with($id, new NullServiceCategory())
            ->willReturn($serviceCategoty);

        $result = $this->stub->fetchOne($id);
        $this->assertEquals($serviceCategoty, $result);
    }
    /**
     * 为ServiceCategoryRestfulTranslator建立预言
     * 建立预期状况：objectToArray() 方法将会被调用一次，并以$serviceCategoty，$keys为参数
     * 揭示预言中的getTranslator，并将仿件对象链接到主体上
     */
    private function prepareServiceCategoryTranslator(
        ServiceCategory $serviceCategoty,
        array $keys,
        array $serviceCategotyArray
    ) {
        $translator = $this->prophesize(ServiceCategoryRestfulTranslator::class);
        $translator->objectToArray(
            Argument::exact($serviceCategoty),
            Argument::exact($keys)
        )->shouldBeCalledTimes(1)
            ->willReturn($serviceCategotyArray);

        $this->stub->expects($this->exactly(1))
            ->method('getTranslator')
            ->willReturn($translator->reveal());
    }

    private function success(ServiceCategory $serviceCategoty)
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('translateToObject')
            ->with($serviceCategoty);
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
     * 执行prepareServiceCategoryTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行add（）
     * 判断 result 是否为true
     */
    public function testAddSuccess()
    {
        $serviceCategoty = MockFactory::generateServiceCategoryObject(1);
        $serviceCategotyArray = array();

        $this->prepareServiceCategoryTranslator(
            $serviceCategoty,
            array(
                'name',
                'parentCategory',
                'isQualification',
                'qualificationName',
                'commission',
                'status'
            ),
            $serviceCategotyArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('serviceCategories', $serviceCategotyArray);

        $this->success($serviceCategoty);

        $result = $this->stub->add($serviceCategoty);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareServiceCategoryTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行add（）
     * 判断 result 是否为false
     */
    public function testAddFailure()
    {
        $serviceCategoty = MockFactory::generateServiceCategoryObject(1);
        $serviceCategotyArray = array();

        $this->prepareServiceCategoryTranslator(
            $serviceCategoty,
            array(
                'name',
                'parentCategory',
                'isQualification',
                'qualificationName',
                'commission',
                'status'
            ),
            $serviceCategotyArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('serviceCategories', $serviceCategotyArray);

        $this->failure($serviceCategoty);
        $result = $this->stub->add($serviceCategoty);
        $this->assertFalse($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareServiceCategoryTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行edit（）
     * 判断 result 是否为true
     */
    public function testEditSuccess()
    {
        $serviceCategoty = MockFactory::generateServiceCategoryObject(1);
        $serviceCategotyArray = array();

        $this->prepareServiceCategoryTranslator(
            $serviceCategoty,
            array(
                'name',
                'isQualification',
                'qualificationName',
                'commission',
                'status'
            ),
            $serviceCategotyArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'serviceCategories/'.$serviceCategoty->getId(),
                $serviceCategotyArray
            );

        $this->success($serviceCategoty);

        $result = $this->stub->edit($serviceCategoty);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareServiceCategoryTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行edit（）
     * 判断 result 是否为false
     */
    public function testEditFailure()
    {
        $serviceCategoty = MockFactory::generateServiceCategoryObject(1);
        $serviceCategotyArray = array();

        $this->prepareServiceCategoryTranslator(
            $serviceCategoty,
            array(
                'name',
                'isQualification',
                'qualificationName',
                'commission',
                'status'
            ),
            $serviceCategotyArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'serviceCategories/'.$serviceCategoty->getId(),
                $serviceCategotyArray
            );

        $this->failure($serviceCategoty);
        $result = $this->stub->edit($serviceCategoty);
        $this->assertFalse($result);
    }
}
