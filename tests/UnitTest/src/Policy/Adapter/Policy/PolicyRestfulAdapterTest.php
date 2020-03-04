<?php
namespace Sdk\Policy\Adapter\Policy;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\Policy\Model\Policy;
use Sdk\Policy\Model\NullPolicy;
use Sdk\Policy\Utils\MockFactory;
use Sdk\Policy\Translator\PolicyRestfulTranslator;

class PolicyRestfulAdapterTest extends TestCase
{
    private $stub;

    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(PolicyRestfulAdapter::class)
            ->setMethods([
                'fetchOneAction',
                'isSuccess',
                'post',
                'patch',
                'translateToObject',
                'getTranslator'
            ])->getMock();

        $this->childStub = new class extends PolicyRestfulAdapter {
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

    public function testImplementsIPolicyAdapter()
    {
        $this->assertInstanceOf(
            'Sdk\Policy\Adapter\Policy\IPolicyAdapter',
            $this->stub
        );
    }

    public function testGetResource()
    {
        $this->assertEquals('policies', $this->childStub->getResource());
    }

    public function testGetTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\Policy\Translator\PolicyRestfulTranslator',
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
                'OA_POLICY_LIST',
                PolicyRestfulAdapter::SCENARIOS['OA_POLICY_LIST']
            ],
            [
                'PORTAL_POLICY_LIST',
                PolicyRestfulAdapter::SCENARIOS['PORTAL_POLICY_LIST']
            ],
            [
                'POLICY_FETCH_ONE',
                PolicyRestfulAdapter::SCENARIOS['POLICY_FETCH_ONE']
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

        $policy = MockFactory::generatePolicyObject($id);

        $this->stub->expects($this->exactly(1))
            ->method('fetchOneAction')
            ->with($id, new NullPolicy())
            ->willReturn($policy);

        $result = $this->stub->fetchOne($id);
        $this->assertEquals($policy, $result);
    }
    /**
     * 为PolicyRestfulTranslator建立预言
     * 建立预期状况：objectToArray() 方法将会被调用一次，并以$policy，$keys为参数
     * 揭示预言中的getTranslator，并将仿件对象链接到主体上
     */
    private function preparePolicyTranslator(
        Policy $policy,
        array $keys,
        array $policyArray
    ) {
        $translator = $this->prophesize(PolicyRestfulTranslator::class);
        $translator->objectToArray(
            Argument::exact($policy),
            Argument::exact($keys)
        )->shouldBeCalledTimes(1)
            ->willReturn($policyArray);

        $this->stub->expects($this->exactly(1))
            ->method('getTranslator')
            ->willReturn($translator->reveal());
    }

    private function success(Policy $policy)
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('translateToObject')
            ->with($policy);
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
     * 执行preparePolicyTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行add（）
     * 判断 result 是否为true
     */
    public function testAddSuccess()
    {
        $policy = MockFactory::generatePolicyObject(1);
        $policyArray = array();

        $this->preparePolicyTranslator(
            $policy,
            array(
                'title',
                'applicableObjects',
                'dispatchDepartments',
                'applicableIndustries',
                'level',
                'classifies',
                'detail',
                'description',
                'image',
                'attachments',
                'labels',
                'processingFlow',
                'admissibleAddress',
                'crew'
            ),
            $policyArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('policies', $policyArray);

        $this->success($policy);

        $result = $this->stub->add($policy);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行preparePolicyTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行add（）
     * 判断 result 是否为false
     */
    public function testAddFailure()
    {
        $policy = MockFactory::generatePolicyObject(1);
        $policyArray = array();

        $this->preparePolicyTranslator(
            $policy,
            array(
                'title',
                'applicableObjects',
                'dispatchDepartments',
                'applicableIndustries',
                'level',
                'classifies',
                'detail',
                'description',
                'image',
                'attachments',
                'labels',
                'processingFlow',
                'admissibleAddress',
                'crew'
            ),
            $policyArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('policies', $policyArray);

        $this->failure($policy);
        $result = $this->stub->add($policy);
        $this->assertFalse($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行preparePolicyTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行edit（）
     * 判断 result 是否为true
     */
    public function testEditSuccess()
    {
        $policy = MockFactory::generatePolicyObject(1);
        $policyArray = array();

        $this->preparePolicyTranslator(
            $policy,
            array(
                'title',
                'applicableObjects',
                'dispatchDepartments',
                'applicableIndustries',
                'level',
                'classifies',
                'detail',
                'description',
                'image',
                'attachments',
                'labels',
                'processingFlow',
                'admissibleAddress'
            ),
            $policyArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'policies/'.$policy->getId(),
                $policyArray
            );

        $this->success($policy);

        $result = $this->stub->edit($policy);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行preparePolicyTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行edit（）
     * 判断 result 是否为false
     */
    public function testEditFailure()
    {
        $policy = MockFactory::generatePolicyObject(1);
        $policyArray = array();

        $this->preparePolicyTranslator(
            $policy,
            array(
                'title',
                'applicableObjects',
                'dispatchDepartments',
                'applicableIndustries',
                'level',
                'classifies',
                'detail',
                'description',
                'image',
                'attachments',
                'labels',
                'processingFlow',
                'admissibleAddress'
            ),
            $policyArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'policies/'.$policy->getId(),
                $policyArray
            );

        $this->failure($policy);
        $result = $this->stub->edit($policy);
        $this->assertFalse($result);
    }
}
