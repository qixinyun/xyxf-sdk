<?php
namespace Sdk\ServiceCategory\Adapter\ServiceCategory;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\ServiceCategory\Model\ParentCategory;
use Sdk\ServiceCategory\Model\NullParentCategory;
use Sdk\ServiceCategory\Utils\MockFactory;
use Sdk\ServiceCategory\Translator\ParentCategoryRestfulTranslator;

class ParentCategoryRestfulAdapterTest extends TestCase
{
    private $stub;

    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(ParentCategoryRestfulAdapter::class)
            ->setMethods([
                'fetchOneAction',
                'isSuccess',
                'post',
                'patch',
                'translateToObject',
                'getTranslator'
            ])->getMock();

        $this->childStub = new class extends ParentCategoryRestfulAdapter {
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

    public function testImplementsIParentCategoryAdapter()
    {
        $this->assertInstanceOf(
            'Sdk\ServiceCategory\Adapter\ServiceCategory\IParentCategoryAdapter',
            $this->stub
        );
    }

    public function testGetResource()
    {
        $this->assertEquals('parentCategories', $this->childStub->getResource());
    }

    public function testGetTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\ServiceCategory\Translator\ParentCategoryRestfulTranslator',
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
                'PARENTCATEGORY_LIST',
                ParentCategoryRestfulAdapter::SCENARIOS['PARENTCATEGORY_LIST']
            ],
            [
                'PARENTCATEGORY_FETCH_ONE',
                ParentCategoryRestfulAdapter::SCENARIOS['PARENTCATEGORY_FETCH_ONE']
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

        $parentCategory = MockFactory::generateParentCategoryObject($id);

        $this->stub->expects($this->exactly(1))
            ->method('fetchOneAction')
            ->with($id, new NullParentCategory())
            ->willReturn($parentCategory);

        $result = $this->stub->fetchOne($id);
        $this->assertEquals($parentCategory, $result);
    }
    /**
     * 为ParentCategoryRestfulTranslator建立预言
     * 建立预期状况：objectToArray() 方法将会被调用一次，并以$parentCategory，$keys为参数
     * 揭示预言中的getTranslator，并将仿件对象链接到主体上
     */
    private function prepareParentCategoryTranslator(
        ParentCategory $parentCategory,
        array $keys,
        array $parentCategoryArray
    ) {
        $translator = $this->prophesize(ParentCategoryRestfulTranslator::class);
        $translator->objectToArray(
            Argument::exact($parentCategory),
            Argument::exact($keys)
        )->shouldBeCalledTimes(1)
            ->willReturn($parentCategoryArray);

        $this->stub->expects($this->exactly(1))
            ->method('getTranslator')
            ->willReturn($translator->reveal());
    }

    private function success(ParentCategory $parentCategory)
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('translateToObject')
            ->with($parentCategory);
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
     * 执行prepareParentCategoryTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行add（）
     * 判断 result 是否为true
     */
    public function testAddSuccess()
    {
        $parentCategory = MockFactory::generateParentCategoryObject(1);
        $parentCategoryArray = array();

        $this->prepareParentCategoryTranslator(
            $parentCategory,
            array(
                'name'
            ),
            $parentCategoryArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('parentCategories', $parentCategoryArray);

        $this->success($parentCategory);

        $result = $this->stub->add($parentCategory);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareParentCategoryTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行add（）
     * 判断 result 是否为false
     */
    public function testAddFailure()
    {
        $parentCategory = MockFactory::generateParentCategoryObject(1);
        $parentCategoryArray = array();

        $this->prepareParentCategoryTranslator(
            $parentCategory,
            array(
                'name'
            ),
            $parentCategoryArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('parentCategories', $parentCategoryArray);

        $this->failure($parentCategory);
        $result = $this->stub->add($parentCategory);
        $this->assertFalse($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareParentCategoryTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行edit（）
     * 判断 result 是否为true
     */
    public function testEditSuccess()
    {
        $parentCategory = MockFactory::generateParentCategoryObject(1);
        $parentCategoryArray = array();

        $this->prepareParentCategoryTranslator(
            $parentCategory,
            array(
                'name'
            ),
            $parentCategoryArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'parentCategories/'.$parentCategory->getId(),
                $parentCategoryArray
            );

        $this->success($parentCategory);

        $result = $this->stub->edit($parentCategory);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareParentCategoryTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行edit（）
     * 判断 result 是否为false
     */
    public function testEditFailure()
    {
        $parentCategory = MockFactory::generateParentCategoryObject(1);
        $parentCategoryArray = array();

        $this->prepareParentCategoryTranslator(
            $parentCategory,
            array(
                'name'
            ),
            $parentCategoryArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'parentCategories/'.$parentCategory->getId(),
                $parentCategoryArray
            );

        $this->failure($parentCategory);
        $result = $this->stub->edit($parentCategory);
        $this->assertFalse($result);
    }
}
