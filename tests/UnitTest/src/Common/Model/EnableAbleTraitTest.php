<?php
namespace Sdk\Common\Model;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Sdk\Common\Adapter\IEnableAbleAdapter;

class EnableAbleTraitTest extends TestCase
{
    private $trait;

    public function setUp()
    {
        $this->trait = $this->getMockBuilder(MockEnableAbleTrait::class)
                            ->setMethods(['getIEnableAbleAdapter'])
                            ->getMock();
    }

    public function tearDown()
    {
        unset($this->trait);
    }

    /**
     * @dataProvider statusDataProvider
     */
    public function testSetStatus($actural, $expected)
    {
        $this->trait->setStatus($actural);

        $result = $this->trait->getStatus();
        $this->assertEquals($expected, $result);
    }

    public function statusDataProvider()
    {
        return [
            [IEnableAble::STATUS['ENABLED'], IEnableAble::STATUS['ENABLED']],
            [IEnableAble::STATUS['DISABLED'], IEnableAble::STATUS['DISABLED']],
            [999, IEnableAble::STATUS['DISABLED']]
        ];
    }

    public function testEnableSuccess()
    {
        $this->trait->setStatus(IEnableAble::STATUS['DISABLED']);

        $enableAdapter = $this->prophesize(IEnableAbleAdapter::class);
        $enableAdapter->enable(Argument::exact($this->trait))->shouldBeCalledTimes(1)->willReturn(true);
        $this->trait->expects($this->exactly(1))
            ->method('getIEnableAbleAdapter')
            ->willReturn($enableAdapter->reveal());

        $result = $this->trait->enable();
        $this->assertTrue($result);
    }

    public function testEnableFail()
    {
        $this->trait->setStatus(IEnableAble::STATUS['ENABLED']);

        $result = $this->trait->enable();
        $this->assertFalse($result);
    }

    public function testDisableSuccess()
    {
        $this->trait->setStatus(IEnableAble::STATUS['ENABLED']);

        $enableAdapter = $this->prophesize(IEnableAbleAdapter::class);
        $enableAdapter->disable(Argument::exact($this->trait))->shouldBeCalledTimes(1)->willReturn(true);
        $this->trait->expects($this->exactly(1))
            ->method('getIEnableAbleAdapter')
            ->willReturn($enableAdapter->reveal());

        $result = $this->trait->disable();
        $this->assertTrue($result);
    }

    public function testDisableFail()
    {
        $this->trait->setStatus(IEnableAble::STATUS['DISABLED']);

        $result = $this->trait->disable();
        $this->assertFalse($result);
    }
}
