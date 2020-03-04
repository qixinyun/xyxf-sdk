<?php
namespace Sdk\NaturalPerson\Model;

use PHPUnit\Framework\TestCase;
use Marmot\Core;

class NullNaturalPersonTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = NullNaturalPerson::getInstance();
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function tearDown()
    {
        unset($this->stub);
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function testExtendsNaturalPerson()
    {
        $this->assertInstanceof('Sdk\NaturalPerson\Model\NaturalPerson', $this->stub);
    }

    public function testImplementsNull()
    {
        $this->assertInstanceof('Marmot\Interfaces\INull', $this->stub);
    }

    public function testAdd()
    {
        $result = $this->stub->add();

        $this->assertFalse($result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }


    public function testEdit()
    {
        $result = $this->stub->edit();

        $this->assertFalse($result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }
}
