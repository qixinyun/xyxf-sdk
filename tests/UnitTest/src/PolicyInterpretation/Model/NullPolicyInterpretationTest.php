<?php
namespace Sdk\PolicyInterpretation\Model;

use PHPUnit\Framework\TestCase;
use Marmot\Core;

class NullPolicyInterpretationTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = NullPolicyInterpretation::getInstance();
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function tearDown()
    {
        unset($this->stub);
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function testExtendsPolicyInterpretation()
    {
        $this->assertInstanceof('Sdk\PolicyInterpretation\Model\PolicyInterpretation', $this->stub);
    }

    public function testImplementsNull()
    {
        $this->assertInstanceof('Marmot\Interfaces\INull', $this->stub);
    }
}
