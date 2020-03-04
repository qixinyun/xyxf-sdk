<?php
namespace Sdk\Common\Adapter;

use PHPUnit\Framework\TestCase;

use Sdk\Member\Utils\MockFactory;

class OperatAbleRestfulAdapterTraitTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = $this->getMockForTrait(OperatAbleRestfulAdapterTrait::class);
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testAdd()
    {
        $member = MockFactory::generateMemberObject(1);

        $this->stub->expects($this->any())
             ->method('addAction')
             ->with($member)
             ->will($this->returnValue(true));

        $this->assertTrue($this->stub->add($member));
    }

    public function testEdit()
    {
        $member = MockFactory::generateMemberObject(1);

        $this->stub->expects($this->any())
             ->method('editAction')
             ->with($member)
             ->will($this->returnValue(true));

        $this->assertTrue($this->stub->edit($member));
    }
}
