<?php
namespace Sdk\NaturalPerson\Model;

use PHPUnit\Framework\TestCase;

class IdentityInfoTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new IdentityInfo(
            '610528172727382837',
            array('positivePhoto'),
            array('reversePhoto'),
            array('handHeldPhoto')
        );
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testGetCardId()
    {
        $this->assertEquals('610528172727382837', $this->stub->getCardId());
    }

    public function testGetPositivePhoto()
    {
        $this->assertEquals(array('positivePhoto'), $this->stub->getPositivePhoto());
    }

    public function testGetReversePhoto()
    {
        $this->assertEquals(array('reversePhoto'), $this->stub->getReversePhoto());
    }

    public function testGetHandHeldPhoto()
    {
        $this->assertEquals(array('handHeldPhoto'), $this->stub->getHandHeldPhoto());
    }
}
