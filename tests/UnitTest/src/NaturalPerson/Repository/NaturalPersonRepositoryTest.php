<?php
namespace Sdk\NaturalPerson\Repository;

use Sdk\NaturalPerson\Adapter\NaturalPerson\NaturalPersonRestfulAdapter;

use PHPUnit\Framework\TestCase;

use Prophecy\Argument;

class NaturalPerson extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(NaturalPersonRepository::class)
            ->setMethods(['getAdapter'])
            ->getMock();

        $this->childStub = new class extends NaturalPersonRepository {
            public function getAdapter() : NaturalPersonRestfulAdapter
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
            'Sdk\NaturalPerson\Adapter\NaturalPerson\NaturalPersonRestfulAdapter',
            $this->childStub->getAdapter()
        );
    }
    /**
     * 为NaturalPersonRestfulAdapter建立预言
     * 建立预期状况：scenario() 方法将会被调用一次，并以NaturalPersonRepository::LIST_MODEL_UN为参数
     * 揭示预言，并将仿件对象链接到主体上。
     * 执行scenario
     * 判断执行的$this->stub和$result是否相等，不相等则抛出异常
     */
    public function testScenario()
    {
        $adapter = $this->prophesize(NaturalPersonRestfulAdapter::class);
        $adapter->scenario(Argument::exact(NaturalPersonRepository::FETCH_ONE_MODEL_UN))->shouldBeCalledTimes(1);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());
        $result = $this->stub->scenario(NaturalPersonRepository::FETCH_ONE_MODEL_UN);
        $this->assertEquals($this->stub, $result);
    }
    /**
     * 生成模拟数据，传参为1
     * 为NaturalPersonRestfulAdapter建立预言
     * 建立预期状况：add() 方法将会被调用一次，并以模拟数据为参数，期望返回true
     * 揭示预言中的getAdapter，并将仿件对象链接到主体上
     * 执行add（）
     * 判断 result 是否为true
     */
    public function testAdd()
    {
        $naturalPerson = \Sdk\NaturalPerson\Utils\MockFactory::generateNaturalPersonObject(1);

        $adapter = $this->prophesize(NaturalPersonRestfulAdapter::class);
        $adapter->add(Argument::exact($naturalPerson))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->add($naturalPerson);
        $this->assertTrue($result);
    }
    /**
     * 生成模拟数据，传参为1
     * 为NaturalPersonRestfulAdapter建立预言
     * 建立预期状况：edit() 方法将会被调用一次，并以模拟数据为参数，期望返回true
     * 揭示预言中的getAdapter，并将仿件对象链接到主体上
     * 执行edit（）
     * 判断 result 是否为true
     */
    public function testEdit()
    {
        $naturalPerson = \Sdk\NaturalPerson\Utils\MockFactory::generateNaturalPersonObject(1);

        $adapter = $this->prophesize(NaturalPersonRestfulAdapter::class);
        $adapter->edit(Argument::exact($naturalPerson))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->edit($naturalPerson);
        $this->assertTrue($result);
    }
}
