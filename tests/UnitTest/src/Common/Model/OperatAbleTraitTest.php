<?php
namespace Sdk\Common\Model;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Sdk\Common\Adapter\IOperatAbleAdapter;

class OperatAbleTraitTest extends TestCase
{
    private $trait;

    public function setUp()
    {
        $this->trait = $this->getMockBuilder(MockOperatAbleTrait::class)
                            ->setMethods(['getIOperatAbleAdapter'])
                            ->getMock();
    }

    public function tearDown()
    {
        unset($this->trait);
    }

    public function testAdd()
    {
        $operatAbleAdapter = $this->prophesize(IOperatAbleAdapter::class);
        $operatAbleAdapter->add(Argument::exact($this->trait))->shouldBeCalledTimes(1)->willReturn(true);
        $this->trait->expects($this->exactly(1))
            ->method('getIOperatAbleAdapter')
            ->willReturn($operatAbleAdapter->reveal());

        $result = $this->trait->add();
        $this->assertTrue($result);
    }

    public function testEdit()
    {
        $operatAbleAdapter = $this->prophesize(IOperatAbleAdapter::class);
        $operatAbleAdapter->edit(Argument::exact($this->trait))->shouldBeCalledTimes(1)->willReturn(true);
        $this->trait->expects($this->exactly(1))
            ->method('getIOperatAbleAdapter')
            ->willReturn($operatAbleAdapter->reveal());

        $result = $this->trait->edit();
        $this->assertTrue($result);
    }
}
