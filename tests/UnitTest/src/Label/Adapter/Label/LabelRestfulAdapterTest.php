<?php
namespace Sdk\Label\Adapter\Label;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\Label\Model\Label;
use Sdk\Label\Model\NullLabel;
use Sdk\Label\Utils\MockFactory;
use Sdk\Label\Translator\LabelRestfulTranslator;

class LabelRestfulAdapterTest extends TestCase
{
    private $stub;

    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(LabelRestfulAdapter::class)
            ->setMethods([
                'fetchOneAction',
                'isSuccess',
                'post',
                'patch',
                'translateToObject',
                'getTranslator'
            ])->getMock();

        $this->childStub = new class extends LabelRestfulAdapter {
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

    public function testImplementsILabelAdapter()
    {
        $this->assertInstanceOf(
            'Sdk\Label\Adapter\Label\ILabelAdapter',
            $this->stub
        );
    }

    public function testGetResource()
    {
        $this->assertEquals('labels', $this->childStub->getResource());
    }

    public function testGetTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\Label\Translator\LabelRestfulTranslator',
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
                'LABEL_LIST',
                LabelRestfulAdapter::SCENARIOS['LABEL_LIST']
            ],
            [
                'LABEL_FETCH_ONE',
                LabelRestfulAdapter::SCENARIOS['LABEL_FETCH_ONE']
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

        $label = MockFactory::generateLabelObject($id);

        $this->stub->expects($this->exactly(1))
            ->method('fetchOneAction')
            ->with($id, new NullLabel())
            ->willReturn($label);

        $result = $this->stub->fetchOne($id);
        $this->assertEquals($label, $result);
    }
    /**
     * 为LabelRestfulTranslator建立预言
     * 建立预期状况：objectToArray() 方法将会被调用一次，并以$label，$keys为参数
     * 揭示预言中的getTranslator，并将仿件对象链接到主体上
     */
    private function prepareLabelTranslator(
        Label $label,
        array $keys,
        array $labelArray
    ) {
        $translator = $this->prophesize(LabelRestfulTranslator::class);
        $translator->objectToArray(
            Argument::exact($label),
            Argument::exact($keys)
        )->shouldBeCalledTimes(1)
            ->willReturn($labelArray);

        $this->stub->expects($this->exactly(1))
            ->method('getTranslator')
            ->willReturn($translator->reveal());
    }

    private function success(Label $label)
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('translateToObject')
            ->with($label);
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
     * 执行prepareLabelTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行add（）
     * 判断 result 是否为true
     */
    public function testAddSuccess()
    {
        $label = MockFactory::generateLabelObject(1);
        $labelArray = array();

        $this->prepareLabelTranslator(
            $label,
            array(
                'name',
                'icon',
                'category',
                'remark',
                'crew'
            ),
            $labelArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('labels', $labelArray);

        $this->success($label);

        $result = $this->stub->add($label);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareLabelTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行add（）
     * 判断 result 是否为false
     */
    public function testAddFailure()
    {
        $label = MockFactory::generateLabelObject(1);
        $labelArray = array();

        $this->prepareLabelTranslator(
            $label,
            array(
                'name',
                'icon',
                'category',
                'remark',
                'crew'
            ),
            $labelArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('labels', $labelArray);

        $this->failure($label);
        $result = $this->stub->add($label);
        $this->assertFalse($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareLabelTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行edit（）
     * 判断 result 是否为true
     */
    public function testEditSuccess()
    {
        $label = MockFactory::generateLabelObject(1);
        $labelArray = array();

        $this->prepareLabelTranslator(
            $label,
            array(
                'name',
                'icon',
                'category',
                'remark'
            ),
            $labelArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'labels/'.$label->getId(),
                $labelArray
            );

        $this->success($label);

        $result = $this->stub->edit($label);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行preparelabelTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行edit（）
     * 判断 result 是否为false
     */
    public function testEditFailure()
    {
        $label = MockFactory::generateLabelObject(1);
        $labelArray = array();

        $this->preparelabelTranslator(
            $label,
            array(
                'name',
                'icon',
                'category',
                'remark'
            ),
            $labelArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'labels/'.$label->getId(),
                $labelArray
            );

        $this->failure($label);
        $result = $this->stub->edit($label);
        $this->assertFalse($result);
    }
}
