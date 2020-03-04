<?php
namespace Sdk\Common\Model;

use PHPUnit\Framework\TestCase;

class NullEnableAbleTraitTest extends TestCase
{
    private $trait;

    public function setUp()
    {
        $this->trait = $this->getMockBuilder(MockNullEnableAbleTrait::class)
                            ->setMethods(['resourceNotExist'])
                            ->getMock();
    }

    public function tearDown()
    {
        unset($this->trait);
    }

    public function testEnable()
    {
        $this->mockResourceNotExist();

        $result = $this->trait->enable();
        $this->assertFalse($result);
    }

    public function testDsiable()
    {
        $this->mockResourceNotExist();

        $result = $this->trait->disable();
        $this->assertFalse($result);
    }

    public function testIsEnabled()
    {
        $this->mockResourceNotExist();

        $result = $this->trait->isEnabled();
        $this->assertFalse($result);
    }

    public function testIsDisabled()
    {
        $this->mockResourceNotExist();
        
        $result = $this->trait->isDisabled();
        $this->assertFalse($result);
    }

    private function mockResourceNotExist()
    {
        $this->trait->expects($this->exactly(1))
                    ->method('resourceNotExist')
                    ->willReturn(false);
    }
}
