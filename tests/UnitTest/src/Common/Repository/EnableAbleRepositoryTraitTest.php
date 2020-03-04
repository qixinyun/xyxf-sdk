<?php
namespace Sdk\Common\Repository;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Sdk\Member\Utils\MockFactory;

use Sdk\Common\Adapter\IEnableAbleAdapter;

class EnableAbleRepositoryTraitTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(TestEnableAbleRepository::class)
            ->setMethods(['getAdapter'])->getMock();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testEnable()
    {
        $news = MockFactory::generateMemberObject(1);

        $adapter = $this->prophesize(IEnableAbleAdapter::class);
        $adapter->enable(Argument::exact($news))->shouldBeCalledTimes(1)->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->enable($news);
        $this->assertTrue($result);
    }

    public function testDisable()
    {
        $news = MockFactory::generateMemberObject(1);

        $adapter = $this->prophesize(IEnableAbleAdapter::class);
        $adapter->disable(Argument::exact($news))->shouldBeCalledTimes(1)->willReturn(true);
        $this->stub->expects($this->exactly(1))
            ->method('getAdapter')
            ->willReturn($adapter->reveal());

        $result = $this->stub->disable($news);
        $this->assertTrue($result);
    }
}
