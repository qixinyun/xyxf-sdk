<?php
namespace Sdk\Authentication\Adapter\Authentication;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\Authentication\Model\Authentication;
use Sdk\Authentication\Model\NullAuthentication;
use Sdk\Authentication\Utils\MockFactory;
use Sdk\Authentication\Translator\AuthenticationRestfulTranslator;

class AuthenticationRestfulAdapterTest extends TestCase
{
    private $stub;

    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(AuthenticationRestfulAdapter::class)
            ->setMethods([
                'fetchOneAction',
                'isSuccess',
                'post',
                'patch',
                'translateToObject',
                'getTranslator'
            ])->getMock();

        $this->childStub = new class extends AuthenticationRestfulAdapter {
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

    public function testImplementsIAuthenticationAdapter()
    {
        $this->assertInstanceOf(
            'Sdk\Authentication\Adapter\Authentication\IAuthenticationAdapter',
            $this->stub
        );
    }

    public function testGetResource()
    {
        $this->assertEquals('authentications', $this->childStub->getResource());
    }

    public function testGetTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\Authentication\Translator\AuthenticationRestfulTranslator',
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
                'AUTHENTICATION_LIST',
                AuthenticationRestfulAdapter::SCENARIOS['AUTHENTICATION_LIST']
            ],
            [
                'AUTHENTICATION_FETCH_ONE',
                AuthenticationRestfulAdapter::SCENARIOS['AUTHENTICATION_FETCH_ONE']
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

        $authentication = MockFactory::generateAuthenticationObject($id);

        $this->stub->expects($this->exactly(1))
            ->method('fetchOneAction')
            ->with($id, new NullAuthentication())
            ->willReturn($authentication);

        $result = $this->stub->fetchOne($id);
        $this->assertEquals($authentication, $result);
    }

    /**
     * 为AuthenticationRestfulTranslator建立预言
     * 建立预期状况：objectToArray() 方法将会被调用一次，并以$authentication，$keys为参数
     * 揭示预言中的getTranslator，并将仿件对象链接到主体上
     */
    private function prepareAuthenticationTranslator(
        Authentication $authentication,
        array $keys,
        array $authenticationArray
    ) {
        $translator = $this->prophesize(AuthenticationRestfulTranslator::class);
        $translator->objectToArray(
            Argument::exact($authentication),
            Argument::exact($keys)
        )->shouldBeCalledTimes(1)
            ->willReturn($authenticationArray);

        $this->stub->expects($this->exactly(1))
            ->method('getTranslator')
            ->willReturn($translator->reveal());
    }

    private function success(Authentication $authentication)
    {
        $this->stub->expects($this->exactly(1))
            ->method('isSuccess')
            ->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('translateToObject')
            ->with($authentication);
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
     * 执行prepareAuthenticationTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行add（）
     * 判断 result 是否为true
     */
    public function testAddSuccess()
    {
        $authentication = MockFactory::generateAuthenticationObject(1);
        $authenticationArray = array();

        $this->prepareAuthenticationTranslator(
            $authentication,
            array(
                'qualifications',
                'enterprise'
            ),
            $authenticationArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('authentications', $authenticationArray);

        $this->success($authentication);

        $result = $this->stub->add($authentication);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareAuthenticationTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行add（）
     * 判断 result 是否为false
     */
    public function testAddFailure()
    {
        $authentication = MockFactory::generateAuthenticationObject(1);
        $authenticationArray = array();

        $this->prepareAuthenticationTranslator(
            $authentication,
            array(
                'qualifications',
                'enterprise'
            ),
            $authenticationArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('post')
            ->with('authentications', $authenticationArray);

        $this->failure($authentication);
        $result = $this->stub->add($authentication);
        $this->assertFalse($result);
    }

    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareAuthenticationTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行success（）
     * 执行edit（）
     * 判断 result 是否为true
     */
    public function testEditSuccess()
    {
        $authentication = MockFactory::generateAuthenticationObject(1);
        $authenticationArray = array();

        $this->prepareAuthenticationTranslator(
            $authentication,
            array(
                'qualificationImage'
            ),
            $authenticationArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'authentications/'.$authentication->getId().'/resubmit',
                $authenticationArray
            );

        $this->success($authentication);

        $result = $this->stub->edit($authentication);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 设置空数组
     * 执行prepareAuthenticationTranslator方法
     * 揭示预言中的post，并将仿件对象链接到主体上
     * 执行failure（）
     * 执行edit（）
     * 判断 result 是否为false
     */
    public function testEditFailure()
    {
        $authentication = MockFactory::generateAuthenticationObject(1);
        $authenticationArray = array();

        $this->prepareAuthenticationTranslator(
            $authentication,
            array(
                'qualificationImage'
            ),
            $authenticationArray
        );

        $this->stub->expects($this->exactly(1))
            ->method('patch')
            ->with(
                'authentications/'.$authentication->getId().'/resubmit',
                $authenticationArray
            );

        $this->failure($authentication);
        $result = $this->stub->edit($authentication);
        $this->assertFalse($result);
    }
}
