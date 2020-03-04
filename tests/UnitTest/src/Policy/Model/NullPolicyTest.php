<?php
namespace Sdk\Policy\Model;

use PHPUnit\Framework\TestCase;
use Marmot\Core;

class NullPolicyTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = NullPolicy::getInstance();
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function tearDown()
    {
        unset($this->stub);
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function testExtendsPolicy()
    {
        $this->assertInstanceof('Sdk\Policy\Model\Policy', $this->stub);
    }

    public function testImplementsNull()
    {
        $this->assertInstanceof('Marmot\Interfaces\INull', $this->stub);
    }
}
