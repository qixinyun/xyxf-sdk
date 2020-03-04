<?php
namespace Sdk\ServiceCategory\Model;

use PHPUnit\Framework\TestCase;
use Marmot\Core;

class NullParentCategoryTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = NullParentCategory::getInstance();
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function tearDown()
    {
        unset($this->stub);
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function testExtendsParentCategory()
    {
        $this->assertInstanceof('Sdk\ServiceCategory\Model\ParentCategory', $this->stub);
    }

    public function testImplementsNull()
    {
        $this->assertInstanceof('Marmot\Interfaces\INull', $this->stub);
    }
}
