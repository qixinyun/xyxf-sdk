<?php
namespace Sdk\DispatchDepartment\Model;

use PHPUnit\Framework\TestCase;
use Marmot\Core;

class NullDispatchDepartmentTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = NullDispatchDepartment::getInstance();
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function tearDown()
    {
        unset($this->stub);
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function testExtendsDispatchDepartment()
    {
        $this->assertInstanceof('Sdk\DispatchDepartment\Model\DispatchDepartment', $this->stub);
    }

    public function testImplementsNull()
    {
        $this->assertInstanceof('Marmot\Interfaces\INull', $this->stub);
    }
}
