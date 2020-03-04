<?php
namespace Sdk\Enterprise\Adapter\Enterprise;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\Enterprise\Model\UnAuditedEnterprise;
use Sdk\Enterprise\Model\NullUnAuditedEnterprise;
use Sdk\Enterprise\Utils\UnAuditedEnterpriseMockFactory;
use Sdk\Enterprise\Translator\UnAuditedEnterpriseRestfulTranslator;

class UnAuditedEnterpriseRestfulAdapterTest extends TestCase
{
    private $stub;

    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(UnAuditedEnterpriseRestfulAdapter::class)
            ->setMethods([
                'fetchOneAction',
                'isSuccess',
                'post',
                'patch',
                'translateToObject',
                'getTranslator'
            ])->getMock();

        $this->childStub = new class extends UnAuditedEnterpriseRestfulAdapter {
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

    public function testImplementsIEnterprisedapter()
    {
        $this->assertInstanceOf(
            'Sdk\Enterprise\Adapter\Enterprise\IUnAuditedEnterpriseAdapter',
            $this->stub
        );
    }

    public function testGetResource()
    {
        $this->assertEquals('unAuditedEnterprises', $this->childStub->getResource());
    }

    public function testGetTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\Enterprise\Translator\UnAuditedEnterpriseRestfulTranslator',
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
                'OA_UNAUDITEDENTERPRISE_LIST',
                UnAuditedEnterpriseRestfulAdapter::SCENARIOS['OA_UNAUDITEDENTERPRISE_LIST']
            ],
            [
                'PORTAL_UNAUDITEDENTERPRISE_LIST',
                UnAuditedEnterpriseRestfulAdapter::SCENARIOS['PORTAL_UNAUDITEDENTERPRISE_LIST']
            ],
            [
                'UNAUDITEDENTERPRISE_FETCH_ONE',
                UnAuditedEnterpriseRestfulAdapter::SCENARIOS['UNAUDITEDENTERPRISE_FETCH_ONE']
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

        $unAuditedEnterprise = UnAuditedEnterpriseMockFactory::generateUnAuditedEnterpriseObject($id);

        $this->stub->expects($this->exactly(1))
            ->method('fetchOneAction')
            ->with($id, new NullUnAuditedEnterprise())
            ->willReturn($unAuditedEnterprise);

        $result = $this->stub->fetchOne($id);
        $this->assertEquals($unAuditedEnterprise, $result);
    }
    /**
     * 为unAuditedEnterpriseRestfulTranslator建立预言
     * 建立预期状况：objectToArray() 方法将会被调用一次，并以$unAuditedEnterprise,$keys为参数
     * 揭示预言中的getTranslator，并将仿件对象链接到主体上
     */
    private function prepareUnAuditedEnterpriseTranslator(
        UnAuditedEnterprise $unAuditedEnterprise,
        array $keys,
        array $unAuditedEnterpriseArray
    ) {
        $translator = $this->prophesize(UnAuditedEnterpriseRestfulTranslator::class);
        $translator->objectToArray(
            Argument::exact($unAuditedEnterprise),
            Argument::exact($keys)
        )->shouldBeCalledTimes(1)
            ->willReturn($unAuditedEnterpriseArray);

        $this->stub->expects($this->exactly(1))
            ->method('getTranslator')
            ->willReturn($translator->reveal());
    }

    private function success(UnAuditedEnterprise $unAuditedEnterprise)
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('translateToObject')
            ->with($unAuditedEnterprise);
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
     * 执行prepareUnAuditedEnterpriseTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行Resubmit（）
     * 判断 result 是否为true
     */
    public function testResubmitSuccess()
    {
        $unAuditedEnterprise = UnAuditedEnterpriseMockFactory::generateUnAuditedEnterpriseObject(1);
        $unAuditedEnterpriseArray = array();

        $this->prepareUnAuditedEnterpriseTranslator(
            $unAuditedEnterprise,
            array(
                'name',
                'unifiedSocialCreditCode',
                'logo',
                'businessLicense',
                'powerAttorney',
                'contactsName',
                'contactsCellphone',
                'contactsArea',
                'contactsAddress',
                'legalPersonName',
                'legalPersonCardId',
                'legalPersonPositivePhoto',
                'legalPersonReversePhoto',
                'legalPersonHandheldPhoto',
            ),
            $unAuditedEnterpriseArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'unAuditedEnterprises/'.$unAuditedEnterprise->getId().'/resubmit',
                $unAuditedEnterpriseArray
            );

        $this->success($unAuditedEnterprise);

        $result = $this->stub->resubmit($unAuditedEnterprise);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareUnAuditedEnterpriseTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行Resubmit（）
     * 判断 result 是否为false
     */
    public function testResubmitFailure()
    {
        $unAuditedEnterprise = UnAuditedEnterpriseMockFactory::generateUnAuditedEnterpriseObject(1);
        $unAuditedEnterpriseArray = array();

        $this->prepareUnAuditedEnterpriseTranslator(
            $unAuditedEnterprise,
            array(
                'name',
                'unifiedSocialCreditCode',
                'logo',
                'businessLicense',
                'powerAttorney',
                'contactsName',
                'contactsCellphone',
                'contactsArea',
                'contactsAddress',
                'legalPersonName',
                'legalPersonCardId',
                'legalPersonPositivePhoto',
                'legalPersonReversePhoto',
                'legalPersonHandheldPhoto',
            ),
            $unAuditedEnterpriseArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'unAuditedEnterprises/'.$unAuditedEnterprise->getId().'/resubmit',
                $unAuditedEnterpriseArray
            );

        $this->failure($unAuditedEnterprise);
        $result = $this->stub->resubmit($unAuditedEnterprise);
        $this->assertFalse($result);
    }
}
