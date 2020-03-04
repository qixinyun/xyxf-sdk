<?php
namespace Sdk\MemberAccount\Adapter\MemberAccount;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\MemberAccount\Model\MemberAccount;
use Sdk\MemberAccount\Model\NullMemberAccount;
use Sdk\MemberAccount\Utils\MockFactory;
use Sdk\MemberAccount\Translator\MemberAccountRestfulTranslator;

class MemberAccountRestfulAdapterTest extends TestCase
{
    private $stub;

    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(MemberAccountRestfulAdapter::class)
            ->setMethods([
                'fetchOneAction',
                'getTranslator'
            ])
            ->getMock();
        $this->childStub = new class extends MemberAccountRestfulAdapter {
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

    public function testImplementsIMemberAccountAdapter()
    {
        $this->assertInstanceOf(
            'Sdk\MemberAccount\Adapter\MemberAccount\IMemberAccountAdapter',
            $this->stub
        );
    }

    public function testGetResource()
    {
        $this->assertEquals('memberAccounts', $this->childStub->getResource());
    }

    public function testGetTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\MemberAccount\Translator\MemberAccountRestfulTranslator',
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
                'MEMBER_ACCOUNT_FETCH_ONE',
                MemberAccountRestfulAdapter::SCENARIOS['MEMBER_ACCOUNT_FETCH_ONE']
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

        $memberAccount = MockFactory::generateMemberAccountObject($id);

        $this->stub->expects($this->exactly(1))
            ->method('fetchOneAction')
            ->with($id, new NullMemberAccount())
            ->willReturn($memberAccount);

        $result = $this->stub->fetchOne($id);
        $this->assertEquals($memberAccount, $result);
    }
}
