<?php
namespace Sdk\PolicyInterpretation\Adapter\PolicyInterpretation;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\PolicyInterpretation\Model\PolicyInterpretation;
use Sdk\PolicyInterpretation\Model\NullPolicyInterpretation;
use Sdk\PolicyInterpretation\Utils\MockFactory;
use Sdk\PolicyInterpretation\Translator\PolicyInterpretationRestfulTranslator;

class PolicyInterpretationRestfulAdapterTest extends TestCase
{
    private $stub;

    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(PolicyInterpretationRestfulAdapter::class)
            ->setMethods([
                'fetchOneAction',
                'isSuccess',
                'post',
                'patch',
                'translateToObject',
                'getTranslator'
            ])->getMock();

        $this->childStub = new class extends PolicyInterpretationRestfulAdapter {
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

    public function testImplementsIPolicyInterpretationAdapter()
    {
        $this->assertInstanceOf(
            'Sdk\PolicyInterpretation\Adapter\PolicyInterpretation\IPolicyInterpretationAdapter',
            $this->stub
        );
    }

    public function testGetResource()
    {
        $this->assertEquals('policyInterpretations', $this->childStub->getResource());
    }

    public function testGetTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\PolicyInterpretation\Translator\PolicyInterpretationRestfulTranslator',
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
                'POLICYINTERPRETATION_LIST',
                PolicyInterpretationRestfulAdapter::SCENARIOS['POLICYINTERPRETATION_LIST']
            ],
            [
                'POLICYINTERPRETATION_FETCH_ONE',
                PolicyInterpretationRestfulAdapter::SCENARIOS['POLICYINTERPRETATION_FETCH_ONE']
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

        $policyInterpretation = MockFactory::generatePolicyInterpretationObject($id);

        $this->stub->expects($this->exactly(1))
            ->method('fetchOneAction')
            ->with($id, new NullPolicyInterpretation())
            ->willReturn($policyInterpretation);

        $result = $this->stub->fetchOne($id);
        $this->assertEquals($policyInterpretation, $result);
    }
    /**
     * 为PolicyInterpretationRestfulTranslator建立预言
     * 建立预期状况：objectToArray() 方法将会被调用一次，并以$policyInterpretation，$keys为参数
     * 揭示预言中的getTranslator，并将仿件对象链接到主体上
     */
    private function preparePolicyInterpretationTranslator(
        PolicyInterpretation $policyInterpretation,
        array $keys,
        array $policyInterpretationArray
    ) {
        $translator = $this->prophesize(PolicyInterpretationRestfulTranslator::class);
        $translator->objectToArray(
            Argument::exact($policyInterpretation),
            Argument::exact($keys)
        )->shouldBeCalledTimes(1)
            ->willReturn($policyInterpretationArray);

        $this->stub->expects($this->exactly(1))
            ->method('getTranslator')
            ->willReturn($translator->reveal());
    }

    private function success(PolicyInterpretation $policyInterpretation)
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('translateToObject')
            ->with($policyInterpretation);
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
     * 执行preparePolicyInterpretationTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行add（）
     * 判断 result 是否为true
     */
    public function testAddSuccess()
    {
        $policyInterpretation = MockFactory::generatePolicyInterpretationObject(1);
        $policyInterpretationArray = array();

        $this->preparePolicyInterpretationTranslator(
            $policyInterpretation,
            array(
                'policy',
                'cover',
                'title',
                'detail',
                'description',
                'attachments',
                'crew'
            ),
            $policyInterpretationArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('policyInterpretations', $policyInterpretationArray);

        $this->success($policyInterpretation);

        $result = $this->stub->add($policyInterpretation);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行preparePolicyInterpretationTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行add（）
     * 判断 result 是否为false
     */
    public function testAddFailure()
    {
        $policyInterpretation = MockFactory::generatePolicyInterpretationObject(1);
        $policyInterpretationArray = array();

        $this->preparePolicyInterpretationTranslator(
            $policyInterpretation,
            array(
                'policy',
                'cover',
                'title',
                'detail',
                'description',
                'attachments',
                'crew'
            ),
            $policyInterpretationArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('policyInterpretations', $policyInterpretationArray);

        $this->failure($policyInterpretation);
        $result = $this->stub->add($policyInterpretation);
        $this->assertFalse($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行preparePolicyInterpretationTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行edit（）
     * 判断 result 是否为true
     */
    public function testEditSuccess()
    {
        $policyInterpretation = MockFactory::generatePolicyInterpretationObject(1);
        $policyInterpretationArray = array();

        $this->preparePolicyInterpretationTranslator(
            $policyInterpretation,
            array(
                'policy',
                'cover',
                'title',
                'detail',
                'description',
                'attachments'
            ),
            $policyInterpretationArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'policyInterpretations/'.$policyInterpretation->getId(),
                $policyInterpretationArray
            );

        $this->success($policyInterpretation);

        $result = $this->stub->edit($policyInterpretation);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行preparePolicyInterpretationTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行edit（）
     * 判断 result 是否为false
     */
    public function testEditFailure()
    {
        $policyInterpretation = MockFactory::generatePolicyInterpretationObject(1);
        $policyInterpretationArray = array();

        $this->preparePolicyInterpretationTranslator(
            $policyInterpretation,
            array(
                'policy',
                'cover',
                'title',
                'detail',
                'description',
                'attachments'
            ),
            $policyInterpretationArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'policyInterpretations/'.$policyInterpretation->getId(),
                $policyInterpretationArray
            );

        $this->failure($policyInterpretation);
        $result = $this->stub->edit($policyInterpretation);
        $this->assertFalse($result);
    }
}
