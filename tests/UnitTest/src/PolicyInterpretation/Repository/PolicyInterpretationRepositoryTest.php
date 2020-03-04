<?php
namespace Sdk\PolicyInterpretation\Repository;

use Sdk\PolicyInterpretation\Adapter\PolicyInterpretation\PolicyInterpretationRestfulAdapter;

use Sdk\PolicyInterpretation\Utils\MockFactory;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class PolicyInterpretationRepositoryTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(PolicyInterpretationRepository::class)
            ->setMethods(['getAdapter'])
            ->getMock();

        $this->childStub = new class extends PolicyInterpretationRepository {
            public function getAdapter() : PolicyInterpretationRestfulAdapter
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
            'Sdk\PolicyInterpretation\Adapter\PolicyInterpretation\PolicyInterpretationRestfulAdapter',
            $this->childStub->getAdapter()
        );
    }
    /**
     * 为PolicyInterpretationRestfulAdapter建立预言
     * 建立预期状况：scenario() 方法将会被调用一次，并以PolicyInterpretationRepository::LIST_MODEL_UN为参数
     * 揭示预言，并将仿件对象链接到主体上。
     * 执行scenario
     * 判断执行的$this->stub和$result是否相等，不相等则抛出异常
     */
    public function testScenario()
    {
        $adapter = $this->prophesize(PolicyInterpretationRestfulAdapter::class);
        $adapter->scenario(Argument::exact(PolicyInterpretationRepository::LIST_MODEL_UN))->shouldBeCalledTimes(1);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());
        $result = $this->stub->scenario(PolicyInterpretationRepository::LIST_MODEL_UN);
        $this->assertEquals($this->stub, $result);
    }
}
