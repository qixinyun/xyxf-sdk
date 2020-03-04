<?php
namespace Sdk\ServiceCategory\Model;

use PHPUnit\Framework\TestCase;
use Marmot\Core;

class NullServiceCategoryTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = NullServiceCategory::getInstance();
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function tearDown()
    {
        unset($this->stub);
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function testExtendsServiceCategory()
    {
        $this->assertInstanceof('Sdk\ServiceCategory\Model\ServiceCategory', $this->stub);
    }

    public function testImplementsNull()
    {
        $this->assertInstanceof('Marmot\Interfaces\INull', $this->stub);
    }
}
