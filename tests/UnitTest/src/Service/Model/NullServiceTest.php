<?php
namespace Sdk\Service\Model;

use PHPUnit\Framework\TestCase;
use Marmot\Core;

class NullServiceTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = NullService::getInstance();
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function tearDown()
    {
        unset($this->stub);
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function testExtendsService()
    {
        $this->assertInstanceof('Sdk\Service\Model\Service', $this->stub);
    }

    public function testImplementsNull()
    {
        $this->assertInstanceof('Marmot\Interfaces\INull', $this->stub);
    }

    public function testOnShelf()
    {
        $result = $this->stub->onShelf();

        $this->assertFalse($result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }

    public function testOffStock()
    {
        $result = $this->stub->offStock();

        $this->assertFalse($result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }

    public function testRevoke()
    {
        $result = $this->stub->revoke();

        $this->assertFalse($result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }

    public function testClose()
    {
        $result = $this->stub->close();

        $this->assertFalse($result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }

    public function testDeletes()
    {
        $result = $this->stub->deletes();

        $this->assertFalse($result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }
}
