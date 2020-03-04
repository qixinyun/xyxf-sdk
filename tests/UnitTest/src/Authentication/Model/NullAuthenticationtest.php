<?php
namespace Sdk\Authentication\Model;

use PHPUnit\Framework\TestCase;
use Marmot\Core;

class NullAuthenticationTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = NullAuthentication::getInstance();
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function tearDown()
    {
        unset($this->stub);
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function testExtendsAuthentication()
    {
        $this->assertInstanceof('Sdk\Authentication\Model\Authentication', $this->stub);
    }

    public function testImplementsNull()
    {
        $this->assertInstanceof('Marmot\Interfaces\INull', $this->stub);
    }
}
