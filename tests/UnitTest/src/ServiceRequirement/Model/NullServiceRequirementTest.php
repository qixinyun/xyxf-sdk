<?php
namespace Sdk\ServiceRequirement\Model;

use PHPUnit\Framework\TestCase;
use Marmot\Core;

class NullServiceRequirementTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = NullServiceRequirement::getInstance();
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function tearDown()
    {
        unset($this->stub);
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function testExtendsServiceRequirement()
    {
        $this->assertInstanceof('Sdk\ServiceRequirement\Model\ServiceRequirement', $this->stub);
    }

    public function testImplementsNull()
    {
        $this->assertInstanceof('Marmot\Interfaces\INull', $this->stub);
    }
}
