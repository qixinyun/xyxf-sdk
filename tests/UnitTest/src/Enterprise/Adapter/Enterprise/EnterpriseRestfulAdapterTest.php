<?php
namespace Sdk\Enterprise\Adapter\Enterprise;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\Enterprise\Model\Enterprise;
use Sdk\Enterprise\Model\NullEnterprise;
use Sdk\Enterprise\Utils\EnterpriseMockFactory;
use Sdk\Enterprise\Translator\EnterpriseRestfulTranslator;

class EnterpriseRestfulAdapterTest extends TestCase
{
    private $stub;

    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(EnterpriseRestfulAdapter::class)
            ->setMethods([
                'fetchOneAction',
                'isSuccess',
                'post',
                'patch',
                'translateToObject',
                'getTranslator'
            ])->getMock();

        $this->childStub = new class extends EnterpriseRestfulAdapter {
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
            'Sdk\Enterprise\Adapter\Enterprise\IEnterpriseAdapter',
            $this->stub
        );
    }

    public function testGetResource()
    {
        $this->assertEquals('enterprises', $this->childStub->getResource());
    }

    public function testGetTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\Enterprise\Translator\EnterpriseRestfulTranslator',
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
                'OA_ENTERPRISE_LIST',
                EnterpriseRestfulAdapter::SCENARIOS['OA_ENTERPRISE_LIST']
            ],
            [
                'PORTAL_ENTERPRISE_LIST',
                EnterpriseRestfulAdapter::SCENARIOS['PORTAL_ENTERPRISE_LIST']
            ],
            [
                'ENTERPRISE_FETCH_ONE',
                EnterpriseRestfulAdapter::SCENARIOS['ENTERPRISE_FETCH_ONE']
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

        $enterprise = EnterpriseMockFactory::generateEnterpriseObject(new Enterprise(), $id);

        $this->stub->expects($this->exactly(1))
            ->method('fetchOneAction')
            ->with($id, new NullEnterprise())
            ->willReturn($enterprise);

        $result = $this->stub->fetchOne($id);
        $this->assertEquals($enterprise, $result);
    }
    /**
     * 为enterpriseRestfulTranslator建立预言
     * 建立预期状况：objectToArray() 方法将会被调用一次，并以$enterprise，$keys为参数
     * 揭示预言中的getTranslator，并将仿件对象链接到主体上
     */
    private function prepareEnterpriseTranslator(
        Enterprise $enterprise,
        array $keys,
        array $enterpriseArray
    ) {
        $translator = $this->prophesize(EnterpriseRestfulTranslator::class);
        $translator->objectToArray(
            Argument::exact($enterprise),
            Argument::exact($keys)
        )->shouldBeCalledTimes(1)
            ->willReturn($enterpriseArray);

        $this->stub->expects($this->exactly(1))
            ->method('getTranslator')
            ->willReturn($translator->reveal());
    }

    private function success(Enterprise $enterprise)
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('translateToObject')
            ->with($enterprise);
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
     * 执行prepareEnterpriseTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行add（）
     * 判断 result 是否为true
     */
    public function testAddSuccess()
    {
        $enterprise = EnterpriseMockFactory::generateEnterpriseObject(new Enterprise(), 1);
        $enterpriseArray = array();

        $this->prepareEnterpriseTranslator(
            $enterprise,
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
                'member'
            ),
            $enterpriseArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('enterprises', $enterpriseArray);

        $this->success($enterprise);

        $result = $this->stub->add($enterprise);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareEnterpriseTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行add（）
     * 判断 result 是否为false
     */
    public function testAddFailure()
    {
        $enterprise = EnterpriseMockFactory::generateEnterpriseObject(new Enterprise(), 1);
        $enterpriseArray = array();

        $this->prepareEnterpriseTranslator(
            $enterprise,
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
                'member'
            ),
            $enterpriseArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('enterprises', $enterpriseArray);

        $this->failure($enterprise);
        $result = $this->stub->add($enterprise);
        $this->assertFalse($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareEnterpriseTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行edit（）
     * 判断 result 是否为true
     */
    public function testEditSuccess()
    {
        $enterprise = EnterpriseMockFactory::generateEnterpriseObject(new Enterprise(), 1);
        $enterpriseArray = array();

        $this->prepareEnterpriseTranslator(
            $enterprise,
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
            $enterpriseArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'enterprises/'.$enterprise->getId(),
                $enterpriseArray
            );

        $this->success($enterprise);

        $result = $this->stub->edit($enterprise);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareEnterpriseTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行edit（）
     * 判断 result 是否为false
     */
    public function testEditFailure()
    {
        $enterprise = EnterpriseMockFactory::generateEnterpriseObject(new Enterprise(), 1);
        $enterpriseArray = array();

        $this->prepareEnterpriseTranslator(
            $enterprise,
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
            $enterpriseArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'enterprises/'.$enterprise->getId(),
                $enterpriseArray
            );

        $this->failure($enterprise);
        $result = $this->stub->edit($enterprise);
        $this->assertFalse($result);
    }
}
