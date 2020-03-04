<?php
namespace Sdk\Common\Model;

use PHPUnit\Framework\TestCase;

class NullOperatAbleTraitTest extends TestCase
{
    private $trait;

    public function setUp()
    {
        $this->trait = $this->getMockBuilder(MockNullOperatAbleTrait::class)
                            ->setMethods(['resourceNotExist'])
                            ->getMock();
    }

    public function tearDown()
    {
        unset($this->trait);
    }

    public function testAdd()
    {
        $this->mockResourceNotExist();

        $result = $this->trait->add();
        $this->assertFalse($result);
    }

    public function testEdit()
    {
        $this->mockResourceNotExist();
        
        $result = $this->trait->edit();
        $this->assertFalse($result);
    }

    private function mockResourceNotExist()
    {
        $this->trait->expects($this->exactly(1))
                    ->method('resourceNotExist')
                    ->willReturn(false);
    }
}
