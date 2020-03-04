<?php
namespace Sdk\Policy\Repository;

use Sdk\Policy\Adapter\Policy\PolicyRestfulAdapter;

use Sdk\Policy\Utils\MockFactory;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class PolicyRepositoryTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(PolicyRepository::class)
            ->setMethods(['getAdapter'])
            ->getMock();

        $this->childStub = new class extends PolicyRepository {
            public function getAdapter() : PolicyRestfulAdapter
            {
                return parent::getAdapter();
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function testGetAdapter()
    {
        $this->assertInstanceOf(
            'Sdk\Policy\Adapter\Policy\PolicyRestfulAdapter',
            $this->childStub->getAdapter()
        );
    }
    /**
     * 为PolicyRestfulAdapter建立预言
     * 建立预期状况：scenario() 方法将会被调用一次，并以PolicyRepository::OA_LIST_MODEL_UN为参数
     * 揭示预言，并将仿件对象链接到主体上。
     * 执行scenario
     * 判断执行的$this->stub和$result是否相等，不相等则抛出异常
     */
    public function testScenario()
    {
        $adapter = $this->prophesize(PolicyRestfulAdapter::class);
        $adapter->scenario(Argument::exact(PolicyRepository::OA_LIST_MODEL_UN))->shouldBeCalledTimes(1);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());
        $result = $this->stub->scenario(PolicyRepository::OA_LIST_MODEL_UN);
        $this->assertEquals($this->stub, $result);
    }
}
